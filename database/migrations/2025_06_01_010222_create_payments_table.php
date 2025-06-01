<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('payment_id')->unique();
            $table->string('purchase_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('payment_status')->default('waiting');
            $table->decimal('price_amount', 15, 8);
            $table->string('price_currency', 10);
            $table->decimal('pay_amount', 15, 8);
            $table->string('pay_currency', 10);
            $table->decimal('amount_received', 15, 8)->default(0);
            $table->string('pay_address')->nullable();
            $table->string('network')->nullable();
            $table->timestamp('payment_created_at')->nullable();
            $table->timestamp('payment_updated_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }

    
};
