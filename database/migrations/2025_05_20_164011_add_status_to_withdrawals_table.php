<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('withdraw_password');
            $table->decimal('amount', 15, 2)->default(0)->after('status');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
             $table->dropColumn(['status','amount']);
        });
    }
};
