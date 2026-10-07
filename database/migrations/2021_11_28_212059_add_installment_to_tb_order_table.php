<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstallmentToTbOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_order', function (Blueprint $table) {
            $table->string('chargeId')->nullable()->after('payment_type');
            $table->string('installmentType')->nullable()->after('chargeId');
            $table->string('installmentTerm')->nullable()->after('installmentType');
            $table->string('statusCode')->nullable()->after('installmentTerm');
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
