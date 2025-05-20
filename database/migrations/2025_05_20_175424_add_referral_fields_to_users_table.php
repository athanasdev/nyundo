<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'unique_id')) {
                $table->string('unique_id')->unique()->after('id'); // like "8008275162"
            }

            if (!Schema::hasColumn('users', 'referral_code')) {
                $table->string('referral_code')->unique()->after('unique_id'); // like "ABC123"
            }

            if (!Schema::hasColumn('users', 'referrer_id')) {
                $table->foreignId('referrer_id')->nullable()->constrained('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'referrer_id')) {
                $table->dropForeign(['referrer_id']);
                $table->dropColumn('referrer_id');
            }

            if (Schema::hasColumn('users', 'referral_code')) {
                $table->dropColumn('referral_code');
            }

            if (Schema::hasColumn('users', 'unique_id')) {
                $table->dropUnique(['unique_id']);
                $table->dropColumn('unique_id');
            }
        });
    }

    
};

