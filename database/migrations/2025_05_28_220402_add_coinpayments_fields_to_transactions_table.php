<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoinpaymentsFieldsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('txn_id')->nullable()->after('description');
            $table->string('currency', 10)->nullable()->after('txn_id');
            $table->string('status')->nullable()->after('currency');
            $table->string('checkout_url')->nullable()->after('status');
            $table->string('buyer_email')->nullable()->after('checkout_url');
            $table->string('item_name')->nullable()->after('buyer_email');
            $table->boolean('is_manual')->default(false)->after('item_name');
        });
        
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([

                'txn_id',
                'currency',
                'status',
                'checkout_url',
                'buyer_email',
                'item_name',
                'is_manual',
            ]);

        });

    }


}

