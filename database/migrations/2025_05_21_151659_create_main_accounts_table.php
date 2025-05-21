<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('main_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('deposit_address');
            $table->string('password');
            $table->string('currency');
            $table->unsignedBigInteger('admin_id')->unique(); // Must be unique, one-to-one
            $table->timestamps();

            $table->foreign('admin_id')
                  ->references('id')->on('admins')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('main_accounts');
    }

    
}

