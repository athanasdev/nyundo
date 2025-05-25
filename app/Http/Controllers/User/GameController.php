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
        // --- 1. Authenticate and type-hint the user immediately ---
        /** @var \App\Models\User $user */
        $user = Auth::user(); // <-- Updated to use Auth::user()

        // Check if user is authenticated. This is crucial before accessing user properties.
        if (!$user) {
            return back()->with('error', 'You must be logged in to make an investment.');
        }

        // --- 2. Validate the request with the user's actual balance ---
        $request->validate([
            'amount' => 'required|numeric|min:10|max:' . $user->balance, // Use $user->balance here
        ]);

        $amount = $request->amount;

        $now = now();
        $currentTime = $now->format('H:i:s');
        $today = $now->toDateString();

        // Check if a game setting is active and within the time window
        $gameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();

        if (!$gameSetting) {
            return back()->with('error', 'The game is currently closed or not active for investment.');
        }

        // Check if user has sufficient balance
        if ($user->balance < $amount) {
            return back()->with('error', 'Insufficient balance to make this investment.');
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

            // Create the UserInvestment record
            UserInvestment::create([
                'user_id' => $user->id,
                'game_setting_id' => $gameSetting->id,
                'investment_date' => $today,
                'amount' => $amount, // Principal invested
                'daily_profit_amount' => $dailyProfit, // Daily profit
                'status' => 'active',
                'next_payout_eligible_date' => $now->addDay()->toDateString(), // Eligible for first payout tomorrow
                'total_profit_paid_out' => 0,
                'principal_returned' => false,
            ]);

            // Record a debit transaction for the investment of the principal
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => "Investment in Game Round (ID: {$gameSetting->id}) - Principal",
            ]);

            DB::commit(); // Commit all changes if successful
            return back()->with('success', 'Your investment has been placed!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if any error occurs
            Log::error("Investment failed for user {$user->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to place investment. Please try again.');
        }

    }

    

}
