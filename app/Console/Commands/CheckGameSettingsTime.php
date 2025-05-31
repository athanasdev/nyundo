<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GameSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckGameSettingsTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-game-settings-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check active game settings where current time is within start and end time, and run logic';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $now = Carbon::now();

    //     $activeGames = GameSetting::where('is_active', 1)
    //         ->where('start_time', '<=', $now)
    //         ->where('end_time', '>=', $now)
    //         ->get();

    //     foreach ($activeGames as $game) {
    //         // Replace with your real logic
    //         // Example: payout, update status, trigger controller, etc.
    //         $this->info("Running logic for GameSetting ID: {$game->id}");

    //         // Example: you could call a service or controller here
    //         // \App\Http\Controllers\GameLogicController::handleGame($game);
    //     }

    //     if ($activeGames->isEmpty()) {
    //         Log::info("there is no active games");
    //         $this->info("No active games found for current time: $now");
    //     }
    // }


    public function handle()
    {
        $now = now();

        $activeGames = GameSetting::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->where('is_active', 1)
            ->get();

        foreach ($activeGames as $game) {
            // You can trigger your controller, service, or logic here
            Log::info("Game ID {$game->id} is active during scheduled time.");

            // Example logic: deactivate game after end_time
            if ($now->greaterThan($game->end_time)) {
                $game->update(['is_active' => 0]);
                Log::info("Game ID {$game->id} has ended and is now deactivated.");
            }
        }
    }
}
