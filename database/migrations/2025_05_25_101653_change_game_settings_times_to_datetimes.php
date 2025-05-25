<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon; // Make sure Carbon is imported

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('game_settings', function (Blueprint $table) {
            // Add new DATETIME columns
            $table->dateTime('new_start_time')->nullable()->after('start_time');
            $table->dateTime('new_end_time')->nullable()->after('end_time');
        });

        // Step 2: Migrate existing data (if any)
        // IMPORTANT: We need to assign a date to the existing TIME values.
        // For game settings, typically the date doesn't matter for the start/end *time*
        // itself, so we'll pick a arbitrary base date, like 2000-01-01, or today's date
        // in your application's default timezone (which should be UTC).
        // Let's use an arbitrary date for consistency, converted to UTC.

        // Get the current application timezone (should be 'UTC' as per config/app.php)
        $appTimezone = config('app.timezone');

        // Define a base date to combine with your existing TIME values
        // This date itself is arbitrary as long as the time is consistent in UTC
        $baseDate = Carbon::parse('2000-01-01', $appTimezone)->startOfDay();

        // Loop through existing records to convert and update
        \App\Models\GameSetting::cursor()->each(function ($setting) use ($appTimezone, $baseDate) {
            // Combine the base date with the existing time string,
            // assuming the existing TIME was implicitly in the application's default timezone (UTC)
            // or the server's local time if it was saved directly.
            // If your existing times were in a *different* timezone, you need to adjust parsing here.
            $setting->new_start_time = $baseDate->copy()->setTimeFromTimeString($setting->start_time);
            $setting->new_end_time = $baseDate->copy()->setTimeFromTimeString($setting->end_time);
            $setting->save();
        });

        Schema::table('game_settings', function (Blueprint $table) {
            // Drop the old TIME columns
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');

            // Rename the new DATETIME columns to the original names
            $table->renameColumn('new_start_time', 'start_time');
            $table->renameColumn('new_end_time', 'end_time');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_settings', function (Blueprint $table) {
            // Reverse: Add back old TIME columns temporarily
            $table->time('old_start_time')->nullable()->after('start_time');
            $table->time('old_end_time')->nullable()->after('end_time');
        });

        // Reverse: Migrate data back (if necessary for rollback)
        \App\Models\GameSetting::cursor()->each(function ($setting) {
            // Convert DATETIME back to TIME string (will lose date and timezone info)
            $setting->old_start_time = Carbon::parse($setting->start_time)->format('H:i:s');
            $setting->old_end_time = Carbon::parse($setting->end_time)->format('H:i:s');
            $setting->save();
        });

        Schema::table('game_settings', function (Blueprint $table) {
            // Drop the DATETIME columns
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');

            // Rename the old TIME columns back
            $table->renameColumn('old_start_time', 'start_time');
            $table->renameColumn('old_end_time', 'end_time');
        });
    }


};
