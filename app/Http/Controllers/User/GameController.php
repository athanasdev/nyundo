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

        // Fetches a game setting that is currently active (start_time <= nowUTC < end_time)
        // Using '>' for end_time is generally preferred to mean "active until, but not including, the end_time"
        $activeGameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $nowUTC)
            ->where('end_time', '>', $nowUTC) // Changed from '>=' to '>'
            ->orderBy('start_time', 'desc') // Gets the most recently started game if multiple overlap
            ->first();

        // Optional: If you want to show a countdown for the *next* upcoming game if none is active:
        if (!$activeGameSetting) {
            $activeGameSetting = GameSetting::where('is_active', true)
                ->where('start_time', '>', $nowUTC) // Game starts in the future
                ->orderBy('start_time', 'asc')     // Get the soonest upcoming game
                ->first();
        }

        $activeUserInvestment = collect(); // Initialize as empty Laravel collection
        if ($activeGameSetting && $user) {
            $activeUserInvestment = UserInvestment::where('user_id', $user->id)
                // Assuming game_setting_id links UserInvestment to GameSetting
                // Add this if you have such a link and want trades for *this specific* game
                ->where('game_setting_id', $activeGameSetting->id)
                ->where('investment_result', 'pending') // Or your equivalent for active/ongoing trades
                // Ensure UserInvestment also has a concept of its own end_time if not strictly tied to game_setting_id
                // For example, if UserInvestment has its own 'ends_at' field:
                // ->where('ends_at', '>', $nowUTC)
                ->get();
        }

        // Bot statistics (replace with your actual data retrieval logic)
        $bot_profit_24h = 0.00; // Example: $user->getBotProfit24h();
        $bot_trades_24h = 0;    // Example: $user->getBotTrades24h();
        $bot_success_rate = 0.0; // Example: $user->getBotSuccessRate();
        $bot_uptime_seconds = 0; // Example: $user->getBotUptimeSeconds();

        // This was hardcoded to true. Fetch from a reliable source (e.g., user setting or global app setting)
        $is_bot_globally_active = $user->is_trading_bot_enabled ?? true; // Example from user model

        return view('user.layouts.bot', compact( // Ensure 'user.layouts.bot' is the correct path to your Blade file
            'user', // The authenticated user model
            'activeGameSetting',
            'activeUserInvestment', // Pass the collection with this name as per your original compact
            'bot_profit_24h',
            'bot_trades_24h',
            'bot_success_rate',
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
    // In app/Http/Controllers/User/GameController.php




    // public function placeTrade(Request $request)
    // {
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();

    //     // Using your app's local timezone as requested
    //     $now = Carbon::now();

    //     $validatedData = $request->validate([
    //         'crypto_category' => ['required', Rule::in(['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])],
    //         'trade_type' => ['required', Rule::in(['buy', 'sell'])],
    //         'amount' => 'required|numeric|min:1|max:' . $user->balance,
    //     ], [
    //         'amount.max' => 'Insufficient balance for this trade amount.',
    //         'amount.min' => 'Minimum trade amount is $1.'
    //     ]);

    //     $gameSetting = GameSetting::where('is_active', true)
    //         ->where('start_time', '<=', $now)
    //         ->where('end_time', '>', $now)
    //         ->orderBy('start_time', 'desc')
    //         ->first();

    //     if (!$gameSetting) {
    //         return redirect()->back()->with('error', 'The trading signal is not active or has just expired.')->withInput();
    //     }

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

    //         UserInvestment::create([
    //             'user_id' => $user->id,
    //             'game_setting_id' => $gameSetting->id,
    //             'investment_date' => $now->toDateString(),
    //             'amount' => $validatedData['amount'],
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

    //         // THIS WILL NOW RUN AND SHOW YOU THE EXACT DATABASE ERROR
    //         // Please copy the entire message it displays.
    //         dd('An exception was caught:', $e->getMessage());
    //     }
    // }

    public function placeTrade(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Using your app's local timezone as configured in .env
        $now = Carbon::now();

        $validatedData = $request->validate([
            'crypto_category' => ['required', Rule::in(['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])],
            'trade_type' => ['required', Rule::in(['buy', 'sell'])],
            'amount' => 'required|numeric|min:1|max:' . $user->balance,
        ], [
            'amount.max' => 'Insufficient balance for this trade amount.',
            'amount.min' => 'Minimum trade amount is $1.'
        ]);

        $gameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>', $now)
            ->orderBy('start_time', 'desc')
            ->first();

        if (!$gameSetting) {
            return redirect()->back()->with('error', 'The trading signal is not active or has just expired.')->withInput();
        }

        $existingInvestment = UserInvestment::where('user_id', $user->id)
            ->where('game_setting_id', $gameSetting->id)
            ->where('investment_result', 'pending')
            ->first();

        if ($existingInvestment) {
            return redirect()->back()->with('error', 'You already have an active trade in this signal.')->withInput();
        }

        DB::beginTransaction();
        try {
            $user->balance -= $validatedData['amount'];
            $user->save();

            UserInvestment::create([
                'user_id' => $user->id,
                'game_setting_id' => $gameSetting->id,
                'investment_date' => $now->toDateString(),
                'amount' => $validatedData['amount'],
                'daily_profit_amount' => 0,
                'total_profit_paid_out' => 0,
                'principal_returned' => false,
                'game_start_time' => $gameSetting->start_time,
                'game_end_time' => $gameSetting->end_time,
                'type' => $validatedData['trade_type'],
                'crypto_category' => $validatedData['crypto_category'],
                'investment_result' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('ai-trading')->with('success', 'Trade placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for your records and return a friendly message to the user
            Log::error('Error placing trade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'A server error occurred. Please try again.')->withInput();
        }
    }
    /**
     * Close an active trade and determine result.
     */
    public function closeTrade(Request $request)
    {

        Log::info("CLOSW TRADE FOR THE CLIENT", ['Data' => $request->all()]);
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

        $gameSetting = \App\Models\GameSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->orderBy('start_time', 'desc')
            ->first();

        if (!$gameSetting || !$gameSetting->is_active || $now->lt($gameSetting->start_time) || $now->gt($gameSetting->end_time)) {
            return redirect()->back()->with('error', 'Out of  siginal closing.')->withInput();
        }



        if (!$gameSetting) {
            // Handle missing game setting, perhaps return principal
            DB::beginTransaction();
            try {
                $investment->investment_result = 'lose'; // Or a special status like 'error' or 'refunded'
                $investment->daily_profit_amount = 0;
                $investment->principal_returned = true; // Return principal
                $investment->game_end_time = $now; // Mark as closed now
                $investment->save();

                $user->balance += $investment->amount;
                $user->save();
                // Transaction::create([... 'type' => 'trade_refund_no_game', ...]);
                // Record the deposit bonus transaction
                // Transaction::create([
                //     'user_id'        => $user->id,
                //     'type'           => 'debit', // Bonus is also a credit
                //     'amount'         => $investment->amount,
                //     'balance_before' => $user->balalnce, // Balance after deposit, before bonus
                //     'status'=>'lose', // Final balance after bonus
                //     'description'    => 'siginal lose',
                // ]);

                DB::commit();
                return redirect()->route('bot.control')->with('error', 'Associated siginal data not found. Your investment principal has been returned.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error during refund for missing siginal setting: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while processing your trade closure.');
            }
        }

        $isWin = ($investment->type === $gameSetting->type && $investment->crypto_category === $gameSetting->crypto_category);

        DB::beginTransaction();
        try {
            $profitAmount = 0;
            if ($isWin) {
                $investment->investment_result = 'gain';
                $profitAmount = $investment->amount * ($gameSetting->earning_percentage / 100);
                $investment->daily_profit_amount = $profitAmount;
                $investment->total_profit_paid_out = $profitAmount;
                $investment->principal_returned = true;

                $user->balance += $investment->amount + $profitAmount; // Return principal + profit
                $user->save();

                // Transaction::create([... 'type' => 'trade_profit', ...]);
                // Transaction::create([... 'type' => 'principal_return', ...]);
                Transaction::create([
                    'user_id'        => $user->id,
                    'type'           => 'credit', // Bonus is also a credit
                    'amount'         => $profitAmount,
                    'balance_before' => $user->balance, // Balance after deposit, before bonus
                    'balance_after'  => $user->balance,
                    'status' => 'gain', // Final balance after bonus
                    'description'    => 'trade gain',
                ]);

                $this->distributeReferralCommissions($user, $profitAmount, $investment->id);
            } else {
                $investment->investment_result = 'lose';
                $investment->daily_profit_amount = 0;
                $investment->total_profit_paid_out = 0;
                $investment->principal_returned = false; // Principal is lost
                // Balance was already debited. No change for loss of principal itself.
                // Transaction::create([... 'type' => 'trade_loss', ...]);
                Transaction::create([
                    'user_id'        => $user->id,
                    'type'           => 'debit', // Bonus is also a credit
                    'amount'         => $investment->amount,
                    'balance_before' => $user->balance, // Balance after deposit, before bonus
                    'balance_after'  => $user->balance,
                    'status' => 'lose', // Final balance after bonus
                    'description'    => 'trading lose',
                ]);
            }

            $investment->game_end_time = $now; // Mark actual close time
            $investment->save();

            DB::commit();
            return redirect()->route('ai-trading')->with('success', 'Trade closed. Result: ' . strtoupper($investment->investment_result) . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error closing trade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not close trade. Please try again.');
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
