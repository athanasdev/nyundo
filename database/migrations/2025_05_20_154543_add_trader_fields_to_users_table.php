<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance', 15, 2)->default(0)->after('email');
            $table->string('status')->default('active')->after('balance');
            $table->decimal('withdraw_amount', 15, 2)->default(0)->after('status');
             $table->string('country')->nullable()->after('withdraw_amount');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['balance', 'status', 'withdraw_amount','amount']);
        });
    }


};


