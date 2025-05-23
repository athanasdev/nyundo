<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {

            $table->string('username')->nullable()->after('email');
            $table->string('unique_id')->nullable()->after('username');
            $table->string('code')->nullable()->after('unique_id');

        });
    }

    public function down()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropColumn(['username', 'unique_id','code']);
        });

    }



};

