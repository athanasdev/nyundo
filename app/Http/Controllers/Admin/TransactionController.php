<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Referral;
use App\Models\Deposit; // Assuming Deposit model is for tracking actual deposits
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Store a new transaction and handle balance updates and deposit bonus.
     * Referral commissions are NOT distributed here.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'amount'      => 'required|numeric|gt:0',
            'type'        => 'required|in:credit,debit',
            'description' => 'nullable|string|max:255',
        ]);

        $user = User::find($request->user_id);
        $amount = $request->amount;
        $type = $request->type;
        $description = $request->description;

        // Ensure the user exists
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Use a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore; // Initialize

            // 2. Update user balance based on transaction type
            if ($type === 'credit') {
                $balanceAfter = $balanceBefore + $amount;

                // Calculate and apply 1% deposit bonus
                $depositBonusRate = 0.01; // 1%
                $bonusAmount = $amount * $depositBonusRate;
                $balanceAfter += $bonusAmount; // Add bonus to the balance

                // Update user's balance
                $user->balance = $balanceAfter;
                $user->save();

                // Record the main deposit transaction
                Transaction::create([
                    'user_id'        => $user->id,
                    'type'           => $type,
                    'amount'         => $amount,
                    'balance_before' => $balanceBefore, // This is before the initial deposit
                    'balance_after'  => $balanceBefore + $amount, // This is after the initial deposit but before bonus
                    'description'    => $description ?: 'Deposit',
                ]);

                // Record the deposit bonus transaction
                Transaction::create([
                    'user_id'        => $user->id,
                    'type'           => 'credit', // Bonus is also a credit
                    'amount'         => $bonusAmount,
                    'balance_before' => $balanceBefore + $amount, // Balance after deposit, before bonus
                    'balance_after'  => $balanceAfter, // Final balance after bonus
                    'description'    => '1% Deposit Bonus',
                ]);

                // Record the deposit in the 'deposits' table
                Deposit::create([
                    'user_id'         => $user->id,
                    'network'         => 'Manual',
                    'deposit_address' => 'Admin Adjusted Balance',
                    'amount'          => $amount,
                    'status'          => 'completed', // Changed to completed as it's an admin-approved deposit
                    'currency'        => $user->currency ?? 'USD',
                    'type'            => 'manual',
                ]);
            } elseif ($type === 'debit') {
                // Ensure sufficient balance for debit transactions
                if ($balanceBefore < $amount) {
                    DB::rollBack();
                    return back()->with('error', 'Insufficient balance for this debit transaction.');
                }

                $balanceAfter = $balanceBefore - $amount;
                $user->balance = $balanceAfter;
                $user->save();

                // Record the main debit transaction
                Transaction::create([
                    'user_id'        => $user->id,
                    'type'           => $type,
                    'amount'         => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after'  => $balanceAfter,
                    'description'    => $description ?: 'Debit',
                ]);
            }

            // --- IMPORTANT: Referral commissions are NO LONGER handled here. ---
            // They should be triggered by 'daily activity' earnings as per your new requirement.
            // You will need a separate mechanism (e.g., a cron job or another method)
            // to call distributeReferralCommissions when daily activity earnings are processed.

            DB::commit(); // Commit all changes if everything went well

            return back()->with('success', 'Transaction processed, balance updated, and 1% bonus added successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback all changes if any error occurred
            Log::error("Transaction processing failed: " . $e->getMessage());
            return back()->with('error', 'Transaction failed: ' . $e->getMessage());
        }
    }

    /**
     * Distributes referral commissions up the referrer chain.
     * This method is now intended to be called when users earn daily activity.
     *
     * @param \App\Models\User $referredUser The user who made the qualifying action (e.g., daily activity earnings).
     * @param float $qualifyingAmount The amount on which commission is calculated (e.g., daily activity earnings).
     * @return void
     */
    public function distributeReferralCommissions(User $referredUser, float $qualifyingAmount)
    {
        // Fetch all active referral levels and their percentages, ordered by level
        $referralLevels = Referral::where('status', 1)->orderBy('level')->get();

        // Get the initial referrer (Level 1 referrer)
        // Ensure you have a 'referrer' relationship defined in your User model
        // e.g., public function referrer() { return $this->belongsTo(User::class, 'referred_by'); }
        $currentReferrer = $referredUser->referrer;

        $level = 1;

        // Loop through the referral chain and distribute commissions
        while ($currentReferrer && $level <= $referralLevels->count()) {
            // Find the commission percentage for the current level
            $referralSetting = $referralLevels->where('level', $level)->first();

            if ($referralSetting && $referralSetting->percent > 0) {
                $commissionAmount = ($qualifyingAmount * $referralSetting->percent) / 100;

                // Ensure balance update and transaction logging for commission are atomic
                DB::transaction(function () use ($currentReferrer, $commissionAmount, $level, $referredUser) {
                    $referrerBalanceBefore = $currentReferrer->balance;
                    $currentReferrer->balance += $commissionAmount;
                    $currentReferrer->save();

                    // Record the commission transaction for the referrer
                    Transaction::create([
                        'user_id'        => $currentReferrer->id,
                        'type'           => 'credit',
                        'amount'         => $commissionAmount,
                        'balance_before' => $referrerBalanceBefore,
                        'balance_after'  => $currentReferrer->balance,
                        'description'    => "Referral Commission (Level {$level}) from {$referredUser->username}'s activity",
                    ]);
                });
            }

            // Move up to the next level in the referral chain
            $currentReferrer = $currentReferrer->referrer; // Go to the current referrer's referrer
            $level++;
        }
    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all payments, ordered by the newest, and paginate the results
        $payments = Payment::latest()->paginate(20);

        // Return the view and pass the payments data to it
        return view('admin.dashbord.pages.payment', compact('payments'));
    }

    /**
     * Update the specified payment to be processed.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */

    public function process(Payment $payment)
    {
        // 1. Update the is_processed flag to 1 (true)
        $payment->is_processed = 1;

        // 2. NEW: Update the payment_status to 'finished'
        $payment->payment_status = 'finished';

        // 3. Save both changes to the database
        $payment->save();

        // 4. Redirect back to the payments list with an updated success message
        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment ID ' . $payment->id . ' was processed and status set to Finished!');
    }


    
}
