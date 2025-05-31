<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_setting_id')->nullable()->constrained('game_settings')->onDelete('set null');
            $table->date('investment_date'); // Date the investment was made
            $table->decimal('amount', 20, 6)->comment('Principal amount invested by the user');
            $table->decimal('daily_profit_amount', 20, 6)->comment('Daily profit calculated based on earning_percentage');

            // Removed 'status' and 'next_payout_eligible_date'

            $table->enum('investment_result', ['lose', 'gain', 'pending'])->default('pending')->comment('Investment result outcome');
            $table->enum('crypto_category', ['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])->comment('Cryptocurrency category');

            $table->decimal('total_profit_paid_out', 20, 6)->default(0.00)->comment('Total profit paid out for this investment');
            $table->boolean('principal_returned')->default(false)->comment('Whether the principal amount has been returned to the user');

            $table->dateTime('game_start_time')->nullable()->comment('Start time of the game');
            $table->dateTime('game_end_time')->nullable()->comment('End time of the game');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};
