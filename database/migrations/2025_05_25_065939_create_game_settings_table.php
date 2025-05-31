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
            $table->dateTime('start_time')->nullable(); // datetime to allow date + time
            $table->dateTime('end_time')->nullable();
            $table->decimal('earning_percentage', 5, 2)->comment('e.g., 4.00 for 4% daily profit');
            $table->boolean('is_active')->default(false)->comment('Global switch: true to allow new investments');
            $table->boolean('payout_enabled')->default(false)->comment('Global switch: true to allow manual daily payouts/principal returns');
            $table->enum('type', ['buy', 'sell'])->nullable()->comment('Type of game setting');
            $table->enum('crypto_category', ['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])->nullable()->comment('Cryptocurrency category');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_settings');
    }


};

