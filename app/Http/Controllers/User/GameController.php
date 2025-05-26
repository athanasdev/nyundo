<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
use App\Models\UserInvestment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class GameController extends Controller
{
    public function showInvestmentForm()
    {
        $now = now();
        $currentTime = $now->format('H:i:s');

        // Get the current active game setting for today (if any)
        $activeGameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();

        /** @var \App\Models\User $user */ // This DocBlock is still helpful for static analysis
        $user = Auth::user(); // <-- Using the Auth facade here

        // It's crucial to check if a user is actually logged in before proceeding.
        // If not, auth()->user() would return null, leading to an error.
        if (!$user) {
            // Redirect to login or show an error if the user is not authenticated.
            return redirect()->route('login')->with('error', 'Please log in to view your investments.');
        }

        $userInvestments = $user->investments()->where('status', 'active')->get();

        return view('user.game.invest', compact('activeGameSetting', 'userInvestments'));
    }


    public function invest(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'You must be logged in for trade.');
        }

        // --- 1. Get the active game setting ---
        $gameSetting = GameSetting::where('is_active', true)->first();

        // If no active game setting is found, the game is closed.
        if (!$gameSetting) {
            return back()->with('error', 'The signal is currently closed or not active for trade');
        }

        // --- 2. Implement the robust timezone-aware window check ---

        // Get the admin's configured timezone (from .env)
        $adminTimezone = GameSetting::getAdminTimezone(); // This will be 'Africa/Nairobi'

        // Get the current time on the server, in the admin's configured timezone
        $currentTimeInAdminTimezone = Carbon::now($adminTimezone);

        // Retrieve start_time and end_time from the database (they are Carbon instances, default UTC)
        $dbStartTimeUTC = $gameSetting->start_time->setTimezone('UTC');
        $dbEndTimeUTC = $gameSetting->end_time->setTimezone('UTC');

        // Create Carbon objects for the window, anchored to the *current date*
        // in the admin's timezone. This is the **KEY FIX**.
        $windowStartForComparison = $currentTimeInAdminTimezone->copy()
            ->setTime($dbStartTimeUTC->hour, $dbStartTimeUTC->minute, $dbStartTimeUTC->second);

        $windowEndForComparison = $currentTimeInAdminTimezone->copy()
            ->setTime($dbEndTimeUTC->hour, $dbEndTimeUTC->minute, $dbEndTimeUTC->second);

        // Handle cross-midnight windows (e.g., 23:00 - 01:00)
        if ($windowEndForComparison->lt($windowStartForComparison)) {
            $windowEndForComparison->addDay();
        }

        // Now, perform the comparison
        $isInvestmentWindowOpen = $currentTimeInAdminTimezone->between($windowStartForComparison, $windowEndForComparison, true);

        if (!$isInvestmentWindowOpen) {
            // OPTIONAL: Add debug info to the error message for temporary troubleshooting
            $errorMsg = 'The siginal is currently closed or not active for trading. ';
            $errorMsg .= 'Current Time (' . $adminTimezone . '): ' . $currentTimeInAdminTimezone->format('Y-m-d H:i:s T') . '. ';
            $errorMsg .= 'Window (' . $adminTimezone . '): ' . $windowStartForComparison->format('Y-m-d H:i:s T') . ' - ' . $windowEndForComparison->format('Y-m-d H:i:s T') . '.';

            return back()->with('error', $errorMsg);
        }

        // --- 3. Validate the request with the user's actual balance (moved after window check) ---
        $request->validate([
            'amount' => 'required|numeric|min:10|max:' . $user->balance,
        ]);

        $amount = $request->amount;

        // Check if user has sufficient balance (redundant with max validation, but harmless)
        if ($user->balance < $amount) {
            return back()->with('error', 'Insufficient balance to make this trading.');
        }

        // Use a database transaction for atomicity
        DB::beginTransaction();
        try {
            // Deduct amount from user's balance
            $balanceBefore = $user->balance;
            $user->balance -= $amount;
            $user->save();

            // Calculate daily profit amount based on the game setting's percentage
            $dailyProfit = ($amount * $gameSetting->earning_percentage) / 100;

            // Use Carbon::today() in the admin timezone for investment_date
            $investmentDate = Carbon::today($adminTimezone)->toDateString();

            // Create the UserInvestment record
            UserInvestment::create([
                'user_id' => $user->id,
                'game_setting_id' => $gameSetting->id,
                'investment_date' => $investmentDate, // Now correctly based on admin_timezone
                'amount' => $amount,
                'daily_profit_amount' => $dailyProfit,
                'status' => 'active',
                // next_payout_eligible_date should also be based on the admin_timezone for consistency
                'next_payout_eligible_date' => Carbon::now($adminTimezone)->addDay()->toDateString(),
                'total_profit_paid_out' => 0,
                'principal_returned' => false,
            ]);

            // Record a debit transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => "Trading in siginal Round (ID: {$gameSetting->id}) - Principal",
            ]);

            DB::commit();
            return back()->with('success', 'Your order has been placed..!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Investment failed for user {$user->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

}
