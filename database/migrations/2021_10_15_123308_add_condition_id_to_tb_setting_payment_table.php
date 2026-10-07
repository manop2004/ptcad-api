<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionIdToTbSettingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_setting_payment', function (Blueprint $table) {
            $table->bigInteger('conditionId')->unsigned()->index()->nullable(true)->after('installment_status');
            $table->foreign('conditionId')->references('id')->on('tb_product_condition')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_setting_payment', function (Blueprint $table) {
            //
        });
    }
}
