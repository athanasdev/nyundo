<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserInvestment;
use App\Models\User;
use App\Models\GameSetting;
use App\Models\Transaction;
use App\Models\ReferralSetting; // <-- Add this
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClosePendingTrades extends Command
{
    protected $signature = 'trades:close-pending';
    protected $description = 'Find all pending trades whose game time has expired and close them';

    public function handle()
    {
        $this->info("Checking for pending trades to close...");
        $now = Carbon::now();

        // Get all trades that are still pending.
        $pendingTrades = UserInvestment::where('investment_result', 'pending')->get();

        if ($pendingTrades->isEmpty()) {
            $this->info("No pending trades to process.");
            return 0;
        }

        foreach ($pendingTrades as $investment) {
            // LOGICAL CORRECTION: For EACH trade, find the GameSetting that was active
            // when the trade was created using its start time.
            $gameSetting = GameSetting::where('start_time', '<=', $investment->game_start_time)
                ->where('end_time', '>=', $investment->game_start_time)
                ->first();

            // If no valid game setting is found for when this trade was made, log it and skip.
            if (!$gameSetting) {
                Log::warning("No valid GameSetting found for historical trade ID {$investment->id}");
                continue;
            }

            // Now, check if that game's end time has passed. If not, skip this trade.
            if ($now->lt($gameSetting->end_time)) {
                $this->line("Skipping Trade ID {$investment->id} - Its game is still active.");
                continue;
            }

            // --- The game has ended, proceed with closing the trade ---
            $user = User::find($investment->user_id);
            if (!$user) continue;

            DB::beginTransaction();
            try {
                $isWin = ($investment->type === $gameSetting->type);

                if ($isWin) {
                    $investment->investment_result = 'gain';
                    $profitAmount = $investment->amount * ($gameSetting->earning_percentage / 100);
                    $investment->daily_profit_amount = $profitAmount;

                    $user->balance += $investment->amount + $profitAmount; // Return principal + profit
                    $user->save();

                    // Transaction for the profit
                    Transaction::create([
                        'user_id'        => $user->id,
                        'type'           => 'credit', // Bonus is also a credit
                        'amount'         => $profitAmount,
                        'balance_before' => $user->balance, // Balance after deposit, before bonus
                        'balance_after'  => $user->balance,
                        'status' => 'gain', // Final balance after bonus
                        'description'    => 'trade gain',
                    ]);

                    // THE MISSING PIECE: Call the commission function on profit
                    $this->distributeReferralCommissions($user, $profitAmount);
                } else {
                    $investment->investment_result = 'lose';
                    // ... your loss logic here ...
                }

                $investment->game_end_time = $now;
                $investment->save();

                DB::commit();
                $this->info("Trade ID {$investment->id} closed: " . strtoupper($investment->investment_result));
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error auto-closing trade ID {$investment->id}: " . $e->getMessage());
                $this->error("Failed to close trade ID {$investment->id}");
            }
        }

        $this->info("Finished processing pending trades.");
        return 0;
    }

    /**
     * The referral commission function, now part of the command.
     */
    protected function distributeReferralCommissions(User $referredUser, float $profitAmount)
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
                    $balanceBefore = $currentReferrer->balance;
                    $currentReferrer->balance += $commission;
                    $currentReferrer->save();

                    Transaction::create([
                        'user_id' => $currentReferrer->id,
                        'type' => 'credit',
                        'amount' => $commission,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $currentReferrer->balance,
                        'status' => 'gain',
                        'description' => "Level {$level} commission from user {$referredUser->username}'s trade.",
                    ]);
                }
            }

            if (!$currentReferrer->referrer) break;
            $currentReferrer = $currentReferrer->referrer;
            $level++;
        }
    }
}
