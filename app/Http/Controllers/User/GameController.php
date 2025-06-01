<?php

namespace App\Http\Controllers\User; // Assuming this is the correct namespace for your GameController

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
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
            // This check might be redundant if your middleware('auth') handles it,
            // but doesn't hurt as a safeguard.
            return redirect()->route('login')->with('error', 'Please log in to view this page.');
        }

        $now = Carbon::now();
        $activeGameSetting = GameSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->orderBy('start_time', 'desc')
            ->first();


        $activeUserInvestment = null;
        if ($activeGameSetting && $user) { // Ensure user is available
            $activeUserInvestment = UserInvestment::where('user_id', $user->id)
                ->where('game_setting_id', $activeGameSetting->id)
                ->where('investment_result', 'pending')
                ->get();
        }

        // Placeholder data for bot stats - you should fetch/calculate these
        // These should ideally come from a service or another model, not hardcoded.
        $bot_profit_24h = 0.00;
        $bot_trades_24h = 0;
        $bot_success_rate = 0.0;
        $bot_uptime_seconds = 0;
        $is_bot_globally_active = true; // This should be a system setting

        return view('user.layouts.bot', compact( // Ensure this view path is correct
            'user',
            'activeGameSetting',
            'activeUserInvestment',
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
    public function placeTrade(Request $request)
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $now = Carbon::now();

        $validatedData = $request->validate([
            // 'game_setting_id' => 'required|exists:game_settings,id',
            'crypto_category' => ['required', Rule::in(['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])],
            'trade_type' => ['required', Rule::in(['buy', 'sell'])],
            'amount' => 'required|numeric|min:1|max:' . $user->balance,
        ], [
            'amount.max' => 'Insufficient balance for this trade amount.',
            'amount.min' => 'Minimum trade amount is $1.'
        ]);

        // $gameSetting = GameSetting::find($validatedData['game_setting_id']);

        // $gameSetting = GameSetting::where('is_active', true)
        //     ->where('start_time', '<=', $now)
        //     ->where('end_time', '>=', $now)
        //     ->first();

        $gameSetting = \App\Models\GameSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->orderBy('start_time', 'desc')
            ->first();


        if (!$gameSetting || !$gameSetting->is_active || $now->lt($gameSetting->start_time) || $now->gt($gameSetting->end_time)) {
            return redirect()->back()->with('error', 'The selected siginal is not currently active or has expired.')->withInput();
        }

        $existingInvestment = UserInvestment::where('user_id', $user->id)
            ->where('game_setting_id', $gameSetting->id)
            ->whereNull('investment_result')
            ->first();

        if ($existingInvestment) {
            return redirect()->back()->with('error', 'You already have an active trade in this siginal.')->withInput();
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

            // Transaction::create([...]); // Log transaction
            DB::commit();
            return redirect()->route('bot.control')->with('success', 'Trade placed successfully! Waiting for siginal to end.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error placing trade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not place trade. Please try again.')->withInput();
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

                $this->distributeReferralCommissions($user, $profitAmount, $investment->id);
            } else {
                $investment->investment_result = 'lose';
                $investment->daily_profit_amount = 0;
                $investment->total_profit_paid_out = 0;
                $investment->principal_returned = false; // Principal is lost
                // Balance was already debited. No change for loss of principal itself.
                // Transaction::create([... 'type' => 'trade_loss', ...]);
            }

            $investment->game_end_time = $now; // Mark actual close time
            $investment->save();

            DB::commit();
            return redirect()->route('bot.control')->with('success', 'Trade closed. Result: ' . strtoupper($investment->investment_result) . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error closing trade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not close trade. Please try again.');
        }
    }

    /**
     * Distribute referral commissions based on a user's profit from a specific investment.
     */
    protected function distributeReferralCommissions(User $referredUser, float $profitAmount, int $investmentId)
    {
        if ($profitAmount <= 0) {
            return;
        }

        $currentReferrer = $referredUser->referrer;
        $level = 1;
        $maxLevels = 3;

        while ($currentReferrer && $level <= $maxLevels) {
            $referralSetting = ReferralSetting::where('level', $level)->first();

            if ($referralSetting && $referralSetting->commission_percentage > 0) {
                $commission = $profitAmount * ($referralSetting->commission_percentage / 100);

                if ($commission > 0) {
                    DB::beginTransaction(); // Start a new transaction for each commission
                    try {
                        $currentReferrer->balance += $commission;
                        $currentReferrer->save();

                        // Transaction::create([...]); // Log commission
                        DB::commit();
                        Log::info("Awarded Level {$level} commission of {$commission} to user {$currentReferrer->username} from profit of user {$referredUser->username} (Inv: {$investmentId})");
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("Failed to award Level {$level} commission to user {$currentReferrer->username}: " . $e->getMessage());
                        // Potentially stop or continue to next level referrer
                    }
                }
            }

            if (!$currentReferrer->referrer_id) break; // No more upline referrers
            $currentReferrer = User::find($currentReferrer->referrer_id); // Fetch the next referrer model
            $level++;
        }
    }
}
