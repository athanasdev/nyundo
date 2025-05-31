<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInvestment;
use App\Models\GameSetting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserInvestmentsController extends Controller
{
    public function index()
    {
        $investments = UserInvestment::with('user')->latest()->paginate(10);
        return view('admin.dashbord.game.investments', compact('investments'));
    }


    public function completeInvestment(UserInvestment $userInvestment)
    {
        DB::beginTransaction();

        try {
            $gameSetting = GameSetting::first();
            if (!$gameSetting || !$gameSetting->payout_enabled) {
                return back()->with('error', 'Payouts are currently disabled by the admin.');
            }

         

            $user = $userInvestment->user;
            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            $profitPayoutHappened = false;
            $today = now()->toDateString();

            if ($userInvestment->next_payout_eligible_date && $userInvestment->next_payout_eligible_date->lte($today)) {
                $payoutAmount = $userInvestment->daily_profit_amount;
                $balanceBeforeProfit = $user->balance;

                $user->balance += $payoutAmount;
                $user->save();

                $userInvestment->total_profit_paid_out += $payoutAmount;
                $userInvestment->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'amount' => $payoutAmount,
                    'balance_before' => $balanceBeforeProfit,
                    'balance_after' => $user->balance,
                    'description' => "Final Daily Profit Payout for Investment ID: {$userInvestment->id}",
                ]);

                $profitPayoutHappened = true;


            }

            $balanceBeforePrincipal = $user->balance;
            $principalAmount = $userInvestment->amount;

            $user->balance += $principalAmount;
            $user->save();

            $userInvestment->principal_returned = true;
            $userInvestment->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $principalAmount,
                'balance_before' => $balanceBeforePrincipal,
                'balance_after' => $user->balance,
                'description' => "Principal Return for Investment ID: {$userInvestment->id}",
            ]);

            DB::commit();

            $message = 'Investment completed successfully!';
            if ($profitPayoutHappened) {
                $message .= ' Final daily profit credited.';
            }
            $message .= ' Principal returned.';

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error completing investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to complete investment: ' . $e->getMessage());
        }
    }

    public function payoutProfit(UserInvestment $userInvestment)
    {
        DB::beginTransaction();

        try {
            $gameSetting = GameSetting::first();
            if (!$gameSetting || !$gameSetting->payout_enabled) {
                return back()->with('error', 'Daily profit payouts are currently disabled.');
            }



            $today = now()->toDateString();
            if ($userInvestment->next_payout_eligible_date && $userInvestment->next_payout_eligible_date->gt($today)) {
                return back()->with('info', 'This investment is not yet eligible for today’s payout.');
            }

            $user = $userInvestment->user;
            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            $payoutAmount = $userInvestment->daily_profit_amount;
            $balanceBefore = $user->balance;

            $user->balance += $payoutAmount;
            $user->save();

            $userInvestment->total_profit_paid_out += $payoutAmount;
            $userInvestment->next_payout_eligible_date = now()->addDay()->toDateString();
            $userInvestment->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $payoutAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => "Daily Profit Payout for trade",
            ]);

            DB::commit();
            return back()->with('success', 'Daily profit payout processed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error processing profit payout for investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to process payout: ' . $e->getMessage());
        }
    }

    public function returnPrincipal(UserInvestment $userInvestment)
    {
        DB::beginTransaction();

        try {
            $gameSetting = GameSetting::first();
            if (!$gameSetting || !$gameSetting->payout_enabled) {
                return back()->with('error', 'Payouts are currently disabled by the admin.');
            }


            $user = $userInvestment->user;
            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            $principalAmount = $userInvestment->amount;
            $balanceBefore = $user->balance;

            $user->balance += $principalAmount;
            $user->save();

            $userInvestment->principal_returned = true;

            $userInvestment->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $principalAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => "Principal Return for Investment ID: {$userInvestment->id}",
            ]);

            DB::commit();
            return back()->with('success', 'Principal returned and investment completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error returning principal for investment ID {$userInvestment->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to return principal: ' . $e->getMessage());
        }
    }

    public function cancelInvestment(UserInvestment $userInvestment)
    {
        DB::beginTransaction();

    }
}
