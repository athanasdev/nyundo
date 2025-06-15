<?php

namespace App\Http\Controllers\User; // Assuming this is the correct namespace for your GameController

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
use App\Models\Referral;
use App\Models\ReferralSetting; // Make sure this model exists if used in distributeReferralCommissions
use App\Models\UserInvestment;
use App\Models\Transaction; // Uncomment if you implement Transaction logging
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class GameController extends Controller
{




    public function aitrading()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view this page.');
        }

        // Use Carbon::now('UTC') for correct comparison with UTC database timestamps
        $nowUTC = Carbon::now('UTC');

        // Fetches a game setting that is currently active
        $activeGameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $nowUTC)
            ->where('end_time', '>', $nowUTC)
            ->orderBy('start_time', 'desc')
            ->first();

        // If no game is active, find the next upcoming one
        if (!$activeGameSetting) {
            $activeGameSetting = GameSetting::where('is_active', true)
                ->where('start_time', '>', $nowUTC)
                ->orderBy('start_time', 'asc')
                ->first();
        }

        // Fetch user's pending investments for the active game
        $activeUserInvestment = collect();
        if ($activeGameSetting) {
            $activeUserInvestment = UserInvestment::where('user_id', $user->id)
                ->where('game_setting_id', $activeGameSetting->id)
                ->where('investment_result', 'pending')
                ->get();
        }

        // --- Bot Statistics ---

        // The corrected query to SUM the profit from all 'gain' trades in the last 24 hours
        $bot_profit_24h = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'gain')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->sum('daily_profit_amount');

        // 2. Calculate Trades and Success Rate in the last 24h
        $trades_in_24h_query = UserInvestment::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDay());

        $bot_trades_24h = (clone $trades_in_24h_query)->count();
        $successful_trades_24h = (clone $trades_in_24h_query)->where('investment_result', 'gain')->count();

        if ($bot_trades_24h > 0) {
            $success_rate = ($successful_trades_24h / $bot_trades_24h) * 100;
        } else {
            $success_rate = 0;
        }
        // This is the variable holding the calculated percentage, e.g., 85.7
        $bot_success_rate = number_format($success_rate, 1);


        // 3. Calculate Bot Uptime
        $first_investment = UserInvestment::where('user_id', $user->id)->oldest()->first();
        $bot_uptime_seconds = 0;
        if ($first_investment) {
            // Calculate difference in seconds between the first investment and now
            $bot_uptime_seconds = $first_investment->created_at->diffInSeconds(Carbon::now());
        }

        // 4. Check if the bot is globally active (e.g., from a user setting)
        $is_bot_globally_active = $user->is_trading_bot_enabled ?? false;

        // Pass all calculated variables to the view
        return view('user.layouts.bot', compact(
            'user',
            'activeGameSetting',
            'activeUserInvestment',
            'bot_profit_24h',
            'bot_trades_24h',
            'bot_success_rate', // Correctly passing the calculated rate
            'bot_uptime_seconds',
            'is_bot_globally_active'
        ));
    }


    /**
     * Place a new trade (UserInvestment).
     */

    /**
     * Place a new trade for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    //  only one trade for day
    // public function placeTrade(Request $request)
    // {
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();
    //     $now = Carbon::now();

    //     $validatedData = $request->validate([
    //         'crypto_category' => ['required', Rule::in(['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])],
    //         'trade_type' => ['required', Rule::in(['buy', 'sell'])],
    //         'amount' => 'required|numeric|min:1|max:' . $user->balance,
    //     ], [
    //         'amount.max' => 'Insufficient balance for this trade amount.',
    //         'amount.min' => 'Minimum trade amount is $1.'
    //     ]);

    //     // =================================================================
    //     //  NEW: 24-Hour Trading Cooldown Check
    //     // =================================================================
    //     $tradeWithin24Hours = UserInvestment::where('user_id', $user->id)
    //         ->where('created_at', '>=', Carbon::now()->subHours(24))
    //         ->exists();

    //     if ($tradeWithin24Hours) {
    //         return redirect()->back()
    //             ->with('error', 'You can only place one trade every 24 hours. Please try again later.')
    //             ->withInput();
    //     }
    //     // =================================================================

    //     $gameSetting = GameSetting::where('is_active', true)
    //         ->where('start_time', '<=', $now)
    //         ->where('end_time', '>', $now)
    //         ->orderBy('start_time', 'desc')
    //         ->first();

    //     if (!$gameSetting) {
    //         return redirect()->back()->with('error', 'The trading signal is not active or has just expired.')->withInput();
    //     }

    //     // This existing check is still useful to prevent multiple trades in the same signal round
    //     $existingInvestment = UserInvestment::where('user_id', $user->id)
    //         ->where('game_setting_id', $gameSetting->id)
    //         ->where('investment_result', 'pending')
    //         ->first();

    //     if ($existingInvestment) {
    //         return redirect()->back()->with('error', 'You already have an active trade in this signal.')->withInput();
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $user->balance -= $validatedData['amount'];
    //         $user->save();

    //         // NOTE: We discussed adding 'entry_price' before for the PNL.
    //         // You would fetch the live price here and add it to the create() array.
    //         UserInvestment::create([
    //             'user_id' => $user->id,
    //             'game_setting_id' => $gameSetting->id,
    //             'investment_date' => $now->toDateString(),
    //             'amount' => $validatedData['amount'],
    //             // 'entry_price' => $live_price_here, // Example
    //             'daily_profit_amount' => 0,
    //             'total_profit_paid_out' => 0,
    //             'principal_returned' => false,
    //             'game_start_time' => $gameSetting->start_time,
    //             'game_end_time' => $gameSetting->end_time,
    //             'type' => $validatedData['trade_type'],
    //             'crypto_category' => $validatedData['crypto_category'],
    //             'investment_result' => 'pending',
    //         ]);

    //         DB::commit();
    //         return redirect()->route('ai-trading')->with('success', 'Trade placed successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // It's good practice to log the error
    //         Log::error('Trade placement failed: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'An unexpected error occurred while placing your trade.')->withInput();
    //     }
    // }


    // public function placeTrade(Request $request)
    // {
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();

    //     // Get the current time in UTC. This will be the single source of truth for time in this request.
    //     $nowUtc = Carbon::now()->utc();

    //     $validatedData = $request->validate([
    //         'crypto_category' => ['required', Rule::in(['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])],
    //         'trade_type' => ['required', Rule::in(['buy', 'sell'])],
    //         'amount' => 'required|numeric|min:10|max:' . $user->balance,
    //     ], [
    //         'amount.max' => 'Insufficient balance for this trade amount.',
    //         'amount.min' => 'The minimum trade amount is $10.'
    //     ]);

    //     // 24-Hour Cooldown Check (using the UTC time for consistency)
    //     $tradeWithin24Hours = UserInvestment::where('user_id', $user->id)
    //         ->where('created_at', '>=', $nowUtc->copy()->subHours(24))
    //         ->exists();

    //     if ($tradeWithin24Hours) {
    //         return redirect()->back()
    //             ->with('error', 'You can only place one trade every 24 hours.')
    //             ->withInput();
    //     }

    //     // Find the currently active signal by comparing UTC time against UTC columns.
    //     $gameSetting = GameSetting::where('is_active', true)
    //         ->where('start_time', '<=', $nowUtc)
    //         ->where('end_time', '>', $nowUtc)
    //         ->orderBy('start_time', 'desc')
    //         ->first();

    //     if (!$gameSetting) {
    //         return redirect()->back()->with('error', 'The trading signal is not active or has expired.')->withInput();
    //     }

    //     // Prevent user from placing two trades in the same signal window
    //     $existingInvestment = UserInvestment::where('user_id', $user->id)
    //         ->where('game_setting_id', $gameSetting->id)
    //         ->exists(); // Using exists() is slightly more efficient

    //     if ($existingInvestment) {
    //         return redirect()->back()->with('error', 'You already have an active trade in this signal.')->withInput();
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $user->balance -= $validatedData['amount'];
    //         $user->save();

    //         UserInvestment::create([
    //             'user_id' => $user->id,
    //             'game_setting_id' => $gameSetting->id,
    //             'investment_date' => $nowUtc->toDateString(),
    //             'amount' => $validatedData['amount'],
    //             'game_start_time' => $gameSetting->start_time,
    //             'game_end_time' => $gameSetting->end_time,
    //             'type' => $validatedData['trade_type'],
    //             'crypto_category' => $validatedData['crypto_category'],
    //             'investment_result' => 'pending',
    //             'daily_profit_amount' => 0,
    //             'total_profit_paid_out' => 0,
    //             'principal_returned' => false,
    //         ]);

    //         DB::commit();
    //         return redirect()->route('ai-trading')->with('success', 'Your trade has been placed successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Trade placement failed for user ' . $user->id . ': ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'An unexpected server error occurred. Please try again.')->withInput();
    //     }
    // }


    public function placeTrade(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Use the application's local timezone (from config/app.php) for all comparisons.
        $nowLocal = Carbon::now();

        // 1. Validate the incoming request data.
        $validatedData = $request->validate([
            'crypto_category' => ['required', Rule::in(['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])],
            'trade_type' => ['required', Rule::in(['buy', 'sell'])],
            'amount' => 'required|numeric|min:10|max:' . $user->balance,
        ], [
            'amount.max' => 'Insufficient balance for this trade amount.',
            'amount.min' => 'The minimum trade amount is $10.'
        ]);

        // 2. Check if the user has traded in the last 1 minute.
        $tradeWithinLastMinute = UserInvestment::where('user_id', $user->id)
            ->where('created_at', '>=', $nowLocal->copy()->subMinute())
            ->exists();

        if ($tradeWithinLastMinute) {
            return redirect()->back()
                ->with('error', 'Please wait at least 1 minute before placing another trade.')
                ->withInput();
        }

        // 3. Find the active signal by comparing the current local time with the local times in the database.
        $gameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $nowLocal)
            ->where('end_time', '>', $nowLocal)
            ->orderBy('start_time', 'desc')
            ->first();

        if (!$gameSetting) {
            return redirect()->back()->with('error', 'The trading signal is not active or has expired.')->withInput();
        }

        // 4. Check if the user has already placed a trade for this specific signal.
        $existingPendingInvestment = UserInvestment::where('user_id', $user->id)
            ->where('game_setting_id', $gameSetting->id)
            ->where('investment_result', 'pending')
            ->exists();

        if ($existingPendingInvestment) {
            return redirect()->back()->with('error', 'You already have an active trade in this signal.')->withInput();
        }


        // 5. Use a database transaction to safely place the trade.
        DB::beginTransaction();
        try {
            // Deduct balance from the user.
            $user->balance -= $validatedData['amount'];
            $user->save();

            // Create the investment record.
            UserInvestment::create([
                'user_id' => $user->id,
                'game_setting_id' => $gameSetting->id,
                'investment_date' => $nowLocal->toDateString(),
                'amount' => $validatedData['amount'],
                'game_start_time' => $gameSetting->start_time,
                'game_end_time' => $gameSetting->end_time,
                'type' => $validatedData['trade_type'],
                'crypto_category' => $validatedData['crypto_category'],
                'investment_result' => 'pending',
                'daily_profit_amount' => 0,
                'total_profit_paid_out' => 0,
                'principal_returned' => false,
            ]);

            DB::commit();
            return redirect()->route('ai-trading')->with('success', 'Your trade has been placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Trade placement failed for user ' . $user->id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected server error occurred. Please try again.')->withInput();
        }
    }

    /**
     * Close an active trade and determine result.
     */
    // public function closeTrade(Request $request)
    // {

    //     Log::info("CLOSW TRADE FOR THE CLIENT", ['Data' => $request->all()]);
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();
    //     $now = Carbon::now();

    //     $validatedData = $request->validate([
    //         'user_investment_id' => 'required|exists:user_investments,id',
    //     ]);


    //     $investment = UserInvestment::where('id', $validatedData['user_investment_id'])
    //         ->where('user_id', $user->id)
    //         ->where('investment_result', 'pending')
    //         ->first();

    //     $gameSetting = \App\Models\GameSetting::where('is_active', true)
    //         ->where('start_time', '<=', $now)
    //         ->where('end_time', '>=', $now)
    //         ->orderBy('start_time', 'desc')
    //         ->first();

    //     if (!$gameSetting || !$gameSetting->is_active || $now->lt($gameSetting->start_time) || $now->gt($gameSetting->end_time)) {
    //         return redirect()->back()->with('error', 'Out of  siginal closing.')->withInput();
    //     }



    //     if (!$gameSetting) {
    //         // Handle missing game setting, perhaps return principal
    //         DB::beginTransaction();
    //         try {
    //             $investment->investment_result = 'lose'; // Or a special status like 'error' or 'refunded'
    //             $investment->daily_profit_amount = 0;
    //             $investment->principal_returned = true; // Return principal
    //             $investment->game_end_time = $now; // Mark as closed now
    //             $investment->save();

    //             $user->balance += $investment->amount;
    //             $user->save();
    //             // Transaction::create([... 'type' => 'trade_refund_no_game', ...]);
    //             // Record the deposit bonus transaction
    //             // Transaction::create([
    //             //     'user_id'        => $user->id,
    //             //     'type'           => 'debit', // Bonus is also a credit
    //             //     'amount'         => $investment->amount,
    //             //     'balance_before' => $user->balalnce, // Balance after deposit, before bonus
    //             //     'status'=>'lose', // Final balance after bonus
    //             //     'description'    => 'siginal lose',
    //             // ]);

    //             DB::commit();
    //             return redirect()->route('bot.control')->with('error', 'Associated siginal data not found. Your investment principal has been returned.');
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             Log::error('Error during refund for missing siginal setting: ' . $e->getMessage());
    //             return redirect()->back()->with('error', 'An error occurred while processing your trade closure.');
    //         }
    //     }

    //     $isWin = ($investment->type === $gameSetting->type && $investment->crypto_category === $gameSetting->crypto_category);

    //     DB::beginTransaction();
    //     try {
    //         $profitAmount = 0;
    //         if ($isWin) {
    //             $investment->investment_result = 'gain';
    //             $profitAmount = $investment->amount * ($gameSetting->earning_percentage / 100);
    //             $investment->daily_profit_amount = $profitAmount;
    //             $investment->total_profit_paid_out = $profitAmount;
    //             $investment->principal_returned = true;

    //             $user->balance += $investment->amount + $profitAmount; // Return principal + profit
    //             $user->save();

    //             // Transaction::create([... 'type' => 'trade_profit', ...]);
    //             // Transaction::create([... 'type' => 'principal_return', ...]);
    //             Transaction::create([
    //                 'user_id'        => $user->id,
    //                 'type'           => 'credit', // Bonus is also a credit
    //                 'amount'         => $profitAmount,
    //                 'balance_before' => $user->balance, // Balance after deposit, before bonus
    //                 'balance_after'  => $user->balance,
    //                 'status' => 'gain', // Final balance after bonus
    //                 'description'    => 'trade gain',
    //             ]);

    //             $this->distributeReferralCommissions($user, $profitAmount, $investment->id);
    //         } else {
    //             $investment->investment_result = 'lose';
    //             $investment->daily_profit_amount = 0;
    //             $investment->total_profit_paid_out = 0;
    //             $investment->principal_returned = false; // Principal is lost
    //             // Balance was already debited. No change for loss of principal itself.
    //             // Transaction::create([... 'type' => 'trade_loss', ...]);
    //             Transaction::create([
    //                 'user_id'        => $user->id,
    //                 'type'           => 'debit', // Bonus is also a credit
    //                 'amount'         => $investment->amount,
    //                 'balance_before' => $user->balance, // Balance after deposit, before bonus
    //                 'balance_after'  => $user->balance,
    //                 'status' => 'lose', // Final balance after bonus
    //                 'description'    => 'trading lose',
    //             ]);
    //         }

    //         $investment->game_end_time = $now; // Mark actual close time
    //         $investment->save();

    //         DB::commit();
    //         return redirect()->route('ai-trading')->with('success', 'Trade closed. Result: ' . strtoupper($investment->investment_result) . '.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error closing trade: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Could not close trade. Please try again.');
    //     }
    // }

    public function closeTrade(Request $request)
    {
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $now = Carbon::now();

        $validatedData = $request->validate([
            'user_investment_id' => 'required|exists:user_investments,id',
        ]);

        $investment = UserInvestment::where('id', $validatedData['user_investment_id'])
            ->where('user_id', $user->id)
            ->where('investment_result', 'pending')
            ->first();

        if (!$investment) {
            return redirect()->back()->with('error', 'Invalid or already processed investment.');
        }

        DB::beginTransaction();
        try {
            $investment->investment_result = 'gain';
            $investment->daily_profit_amount = 0;
            $investment->total_profit_paid_out = 0;
            $investment->principal_returned = true;
            $investment->game_end_time = $now;
            $investment->save();

            $user->balance += $investment->amount;
            $user->save();

            Transaction::create([
                'user_id'        => $user->id,
                'type'           => 'credit',
                'amount'         => $investment->amount,
                'balance_before' => $user->balance - $investment->amount,
                'balance_after'  => $user->balance,
                'status'         => 'refunded',
                'description'    => 'Trade cancelled...',
            ]);

            DB::commit();
            return redirect()->route('ai-trading')->with('success', 'Trade cancelled. Your investment has been refunded.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling trade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not cancel trade. Please try again.');
        }
    }


    /**
     * Distribute referral commissions based on a user's profit from a specific investment.
     */

    protected function distributeReferralCommissions(User $referredUser, float $profitAmount)
    {
        if ($profitAmount <= 0) {
            return;
        }

        $currentReferrer = $referredUser->referrer;
        $level = 1;
        $maxLevels = 3; // Max referral levels to pay commission

        while ($currentReferrer && $level <= $maxLevels) {
            $referralSetting = ReferralSetting::where('level', $level)->first();

            if ($referralSetting && $referralSetting->commission_percentage > 0) {
                $commission = $profitAmount * ($referralSetting->commission_percentage / 100);

                if ($commission > 0) {
                    $currentReferrer->balance += $commission;
                    $currentReferrer->save();


                    Transaction::create([
                        'user_id' => $currentReferrer->id,
                        'type' => 'credit',
                        'amount' => $commission,
                        'balance_before' => $currentReferrer->balance,
                        'balance_after' => $currentReferrer->balance + $commission,
                        'status' => 'gain',
                        'description' => "Level {$level} commission from user {$referredUser->username}'s trade profit.",

                    ]);
                    Log::info("Awarded Level {$level} commission of {$commission} to user {$currentReferrer->username} from profit of user {$referredUser->username}");
                }
            }

            // Move to the next level referrer
            if (!$currentReferrer->referrer) break; // No more upline referrers
            $currentReferrer = $currentReferrer->referrer;
            $level++;
        }
    }
}
