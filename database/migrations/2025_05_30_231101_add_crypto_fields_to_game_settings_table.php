<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCryptoFieldsToGameSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->enum('type', ['buy', 'sell'])->after('payout_enabled');
            $table->enum('crypto_category', ['XRP', 'BTC', 'ETH', 'SOLANA', 'PI'])->after('type');
        });
    }

    public function down()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('crypto_category');
        });
    }

    
}
