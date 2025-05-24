<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // For database transactions
use Illuminate\Support\Facades\Log;


class TransactionController extends Controller
{
    /**
     * Store a new transaction and handle balance updates and referral commissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'amount'      => 'required|numeric|gt:0', // Amount must be greater than 0
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
        // All operations (user balance update, transaction record, referral commissions)
        // must succeed together, or all must fail.
        DB::beginTransaction();

        try {
            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore; // Initialize

            // 2. Update user balance based on transaction type
            if ($type === 'credit') {
                $balanceAfter = $balanceBefore + $amount;
            } elseif ($type === 'debit') {
                // Ensure sufficient balance for debit transactions
                if ($balanceBefore < $amount) {
                    DB::rollBack(); // Rollback any changes made so far
                    return back()->with('error', 'Insufficient balance for this debit transaction.');
                }
                $balanceAfter = $balanceBefore - $amount;
            }

            // Update user's balance
            $user->balance = $balanceAfter;
            $user->save();

            // 3. Record the main transaction
            Transaction::create([
                'user_id'        => $user->id,
                'type'           => $type,
                'amount'         => $amount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $balanceAfter,
                'description'    => $description,
            ]);

            // 4. Handle referral commissions for 'credit' transactions (deposits)
            if ($type === 'credit') {
                $this->distributeReferralCommissions($user, $amount);
            }

            DB::commit(); // Commit all changes if everything went well

            return back()->with('success', 'Transaction processed and balance updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback all changes if any error occurred
            // Log the error for debugging
            Log::error("Transaction processing failed: " . $e->getMessage());
            return back()->with('error', 'Transaction failed: ' . $e->getMessage());
        }
    }

    /**
     * Distributes referral commissions up the referrer chain.
     *
     * @param \App\Models\User $referredUser The user who made the qualifying deposit.
     * @param float $depositAmount The amount of the deposit.
     * @return void
     */
    protected function distributeReferralCommissions(User $referredUser, float $depositAmount)
    {
        // Fetch all active referral levels and their percentages, ordered by level
        $referralLevels = Referral::where('status', 1)->orderBy('level')->get();

        // Get the initial referrer (Level 1 referrer)
        $currentReferrer = $referredUser->referrer; // Assuming a 'referrer' relationship in User model

        $level = 1;

        // Loop through the referral chain and distribute commissions
        while ($currentReferrer && $level <= $referralLevels->count()) {
            // Find the commission percentage for the current level
            $referralSetting = $referralLevels->where('level', $level)->first();

            if ($referralSetting && $referralSetting->percent > 0) {
                $commissionAmount = ($depositAmount * $referralSetting->percent) / 100;

                // Update referrer's balance
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
                    'description'    => "Referral Commission from Level {$level} user: {$referredUser->username}",
                ]);

            }

            // Move up to the next level in the referral chain
            $currentReferrer = $currentReferrer->referrer; // Go to the current referrer's referrer
            $level++;

        }
    }
}
