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

        Schema::table('users', function (Blueprint $table) {
            // Add after an existing column, e.g., after 'status' or 'balance'
            // Adjust 'after' based on your preference for column order
            $table->string('withdrawal_address')->nullable()->after('balance');
            $table->string('withdrawal_pin_hash')->nullable()->after('withdrawal_address');
            $table->timestamp('withdrawal_pin_set_at')->nullable()->after('withdrawal_pin_hash');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'withdrawal_address',
                'withdrawal_pin_hash',
                'withdrawal_pin_set_at'
            ]);
        });
    }


};

