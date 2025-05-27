<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInvestment;
use App\Models\GameSetting;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

// Import the TransactionController to use its methods
use App\Http\Controllers\Admin\TransactionController;

class UserInvestmentsController extends Controller
{
    public function index()
    {
        $investments = UserInvestment::with('user', 'gameSetting')->latest()->paginate(10);
        return view('admin.dashbord.game.investments', compact('investments'));
    }


    // In App\Http\Controllers\Admin\UserInvestmentsController.php

    public function completeInvestment(UserInvestment $userInvestment)
    {
        DB::beginTransaction();
        try {
            // --- Common Checks (re-use from existing methods) ---
            $gameSetting = GameSetting::first();
            if (!$gameSetting || !$gameSetting->payout_enabled) {
                DB::rollBack();
                return back()->with('error', 'Payouts are currently disabled by the admin.');
            }

            if ($userInvestment->status !== 'active') {
                DB::rollBack();
                return back()->with('error', 'Investment is not active for completion.');
            }
            if ($userInvestment->principal_returned) { // If principal already returned, it's already "completed" in essence
                DB::rollBack();
                return back()->with('info', 'Principal has already been returned for this investment. It is already completed.');
            }

            $user = $userInvestment->user;
            if (!$user) {
                DB::rollBack();
                return back()->with('error', 'User not found for this investment.');
            }

            // --- 1. Process any outstanding DAILY PROFIT for today (if applicable) ---
            $today = now()->toDateString();
            $profitPayoutHappened = false;
            if ($userInvestment->next_payout_eligible_date && $userInvestment->next_payout_eligible_date->lte($today)) {
                $payoutAmount = $userInvestment->daily_profit_amount;

                // Credit user's balance with the final daily profit
                $balanceBeforeProfit = $user->balance;
                $user->balance += $payoutAmount;
                $user->save();

                // Update investment record for profit
                $userInvestment->total_profit_paid_out += $payoutAmount;
                // We don't set next_payout_eligible_date as the investment is completing
                $userInvestment->save();

                // Record transaction for the final daily profit payout
                Transaction::create([
                    'user_id'        => $user->id,
                    'type'           => 'credit',
                    'amount'         => $payoutAmount,
                    'balance_before' => $balanceBeforeProfit,
                    'balance_after'  => $user->balance,
                    'description'    => "Final Daily Profit Payout before completion for Investment ID: {$userInvestment->id}",
                ]);

                // Distribute referral commissions for this final profit
                $transactionController = new TransactionController();
                $transactionController->distributeReferralCommissions($user, $payoutAmount);
                $profitPayoutHappened = true;
            }

            // --- 2. Return Principal ---
            $principalAmount = $userInvestment->amount;
            $balanceBeforePrincipal = $user->balance; // Get current balance after potential profit payout
            $user->balance += $principalAmount;
            $user->save();

            // Update investment record for principal return and completion
            $userInvestment->principal_returned = true;
            $userInvestment->status = 'completed';
            $userInvestment->save();

            // Record transaction for principal return
            Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'credit',
                'amount'         => $principalAmount,
                'balance_before' => $balanceBeforePrincipal,
                'balance_after'  => $user->balance,
                'description'    => "Principal Return for Investment ID: {$userInvestment->id}",
            ]);

            DB::commit();

            $message = 'Investment completed successfully!';
            if ($profitPayoutHappened) {
                $message .= ' Final daily profit credited and referral commissions distributed.';
            }
            $message .= ' Principal returned.';

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to complete investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to complete investment: ' . $e->getMessage());
        }
    }
    /**
     * Method to process manual daily profit payout for an investment and distribute referral commissions.
     *
     * @param UserInvestment $userInvestment
     * @return \Illuminate\Http\Response
     */
    public function payoutProfit(UserInvestment $userInvestment)
    {
        DB::beginTransaction();
        try {
            // 1. Check global payout status from GameSetting
            $gameSetting = GameSetting::first(); // Assuming you have one active game setting
            if (!$gameSetting || !$gameSetting->payout_enabled) {
                DB::rollBack();
                return back()->with('error', 'Daily profit payouts are currently disabled by the admin.');
            }

            // 2. Investment must be active
            if ($userInvestment->status !== 'active') {
                DB::rollBack();
                return back()->with('error', 'Investment is not active for payouts.');
            }

            // 3. Check if it's eligible for today's payout

            $today = now()->toDateString();
            if ($userInvestment->next_payout_eligible_date && $userInvestment->next_payout_eligible_date->gt($today)) {
                DB::rollBack();
                return back()->with('info', 'This investment is not yet eligible for a payout today. Next eligible date: ' . $userInvestment->next_payout_eligible_date->format('Y-m-d'));
            }

            $user = $userInvestment->user;

            if (!$user) {
                DB::rollBack();
                return back()->with('error', 'User not found for this investment.');
            }


            $payoutAmount = $userInvestment->daily_profit_amount;

            // 4. Credit user's balance with the daily profit
            $balanceBefore = $user->balance;
            $user->balance += $payoutAmount;
            $user->save();

            // 5. Update investment record
            $userInvestment->total_profit_paid_out += $payoutAmount;
            $userInvestment->next_payout_eligible_date = now()->addDay()->toDateString();
            $userInvestment->save();

            // 6. Record transaction for the payout
            Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'credit',
                'amount'         => $payoutAmount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $user->balance,
                'description'    => "Daily Profit Payout for trade",

            ]);

            // 7. Distribute referral commissions based on this payout amount
            // Instantiate TransactionController to access its method
            $transactionController = new TransactionController();
            $transactionController->distributeReferralCommissions($user, $payoutAmount);


            DB::commit();
            return back()->with('success', 'Daily profit payout processed and referral commissions distributed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to process manual profit payout for investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to process payout: ' . $e->getMessage());
        }
    }

    /**
     * Method to return principal and complete the investment.
     *
     * @param UserInvestment $userInvestment
     * @return \Illuminate\Http\Response
     */
    public function returnPrincipal(UserInvestment $userInvestment)
    {
        DB::beginTransaction();
        try {
            // 1. Check if ANY payouts (including principal) are globally enabled by the admin
            $gameSetting = GameSetting::first(); // Assuming a single GameSetting record
            if (!$gameSetting || !$gameSetting->payout_enabled) { // Now checks payout_enabled
                DB::rollBack();
                // Changed message to be more general since it covers both profit and principal
                return back()->with('error', 'Payouts (including principal returns) are currently disabled by the admin.');
            }

            // 2. Investment must be active and principal not already returned
            if ($userInvestment->status !== 'active') {
                DB::rollBack();
                return back()->with('error', 'Investment is not active for principal return.');
            }
            if ($userInvestment->principal_returned) {
                DB::rollBack();
                return back()->with('info', 'Principal has already been returned for this investment.');
            }

            $user = $userInvestment->user;
            if (!$user) {
                DB::rollBack();
                return back()->with('error', 'User not found for this investment.');
            }

            $principalAmount = $userInvestment->amount;

            // 3. Credit user's balance with principal
            $balanceBefore = $user->balance;
            $user->balance += $principalAmount;
            $user->save();

            // 4. Update investment record
            $userInvestment->principal_returned = true;
            $userInvestment->status = 'completed'; // Mark as completed
            $userInvestment->save();

            // 5. Record transaction for principal return
            Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'credit',
                'amount'         => $principalAmount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $user->balance,
                'description'    => "Principal Return for Investment ID: {$userInvestment->id}",
            ]);

            DB::commit();
            return back()->with('success', 'Principal returned and investment completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to return principal for investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to return principal: ' . $e->getMessage());
        }
    }

    /**
     * Optional: Method to manually cancel an investment (e.g., if user requests early withdrawal, no principal/profit return).
     *
     * @param UserInvestment $userInvestment
     * @return \Illuminate\Http\Response
     */
    public function cancelInvestment(UserInvestment $userInvestment)
    {
        DB::beginTransaction();
        try {
            if ($userInvestment->status !== 'active') {
                DB::rollBack();
                return back()->with('error', 'Investment is not active for cancellation.');
            }

            // IMPORTANT: Define your policy for cancellation.
            // Option 1: No return of principal or profit on cancellation
            $userInvestment->status = 'cancelled';
            $userInvestment->save();

            Log::info("Investment ID {$userInvestment->id} manually cancelled by admin.");

            DB::commit();
            return back()->with('success', 'Investment cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to cancel investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to cancel investment: ' . $e->getMessage());
        }
    }
}
