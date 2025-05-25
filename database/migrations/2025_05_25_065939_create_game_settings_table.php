<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_settings', function (Blueprint $table) {
            $table->id();
            $table->time('start_time'); // Example: '08:00:00'
            $table->time('end_time');   // Example: '10:00:00'
            $table->decimal('earning_percentage', 5, 2)->comment('e.g., 4.00 for 4% daily profit');
            $table->boolean('is_active')->default(false)->comment('Global switch: true to allow new investments');
            $table->boolean('payout_enabled')->default(false)->comment('Global switch: true to allow manual daily payouts/principal returns');
            $table->timestamps();
        });
        

        // Optional: Seed an initial setting if you want to always have one row
        // Schema::table('game_settings', function (Blueprint $table) {
        //     DB::table('game_settings')->insert([
        //         'start_time' => '08:00:00',
        //         'end_time' => '10:00:00',
        //         'earning_percentage' => 4.00,
        //         'is_active' => false,
        //         'payout_enabled' => false,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // });

    }

    public function down(): void
    {
        Schema::dropIfExists('game_settings');
    }



};
