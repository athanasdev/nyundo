<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Schedule $schedule): void
    {
        $schedule->command('trades:close-pending')->everyMinute();
        // $schedule->command('trades:close-pending')->everyMinute()
        // ->before(function () {
        //     Log::info('Starting trade closure schedule...');
        // })->after(function () {
        //     Log::info('Finished trade closure schedule.');
        // });
    }

}
