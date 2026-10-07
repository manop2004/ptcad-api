<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceOtherToTbOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_order', function (Blueprint $table) {
            $table->string('subtotal')->nullable()->after('receipt_zipcode');
            $table->string('priceNettotal')->nullable()->after('priceWithholding');
            $table->string('totaldiscount')->nullable()->after('conditionValue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_order', function (Blueprint $table) {
            //
        });
    }
}
