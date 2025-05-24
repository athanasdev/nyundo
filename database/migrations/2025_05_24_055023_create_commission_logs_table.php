<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('who')->default(0);
            $table->string('level', 40)->nullable();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('main_amo', 28, 8)->default(0);
            $table->string('title', 40)->nullable();
            $table->string('trx', 40)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_logs');
    }
    
};
