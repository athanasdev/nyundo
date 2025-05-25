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
            $table->foreignId('game_setting_id')->nullable()->constrained('game_settings')->onDelete('set null'); // Nullable if GameSetting can be deleted
            $table->date('investment_date'); // Date the investment was made
            $table->decimal('amount', 20, 6)->comment('Principal amount invested by the user');
            $table->decimal('daily_profit_amount', 20, 6)->comment('Daily profit calculated based on earning_percentage');
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->date('next_payout_eligible_date')->nullable()->comment('Date on which the next manual payout can be triggered');
            $table->decimal('total_profit_paid_out', 20, 6)->default(0.00)->comment('Total profit paid out for this investment');
            $table->boolean('principal_returned')->default(false)->comment('Whether the principal amount has been returned to the user');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }


};

