<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_order', function (Blueprint $table) {
            $table->id();
            $table->string('orderNumber')->nullable();
            $table->string('userCode')->nullable();
            $table->string('residence_name')->nullable();
            $table->string('residence_lastname')->nullable();
            $table->string('residence_tel')->nullable();
            $table->string('residence_address')->nullable();
            $table->bigInteger('residence_province')->unsigned()->index()->nullable(true);
            $table->foreign('residence_province')->references('id')->on('tb_setting_provinces')->onDelete('cascade');
            $table->bigInteger('residence_amphures')->unsigned()->index()->nullable(true);
            $table->foreign('residence_amphures')->references('id')->on('tb_setting_amphures')->onDelete('cascade');
            $table->bigInteger('residence_district')->unsigned()->index()->nullable(true);
            $table->foreign('residence_district')->references('id')->on('tb_setting_districts')->onDelete('cascade');
            $table->string('residence_zipcode')->nullable();
            $table->string('residence_massage')->nullable();
            $table->integer('statusReceipts')->nullable();
            $table->string('receipt_type')->nullable();
            $table->string('receipt_tax')->nullable();
            $table->string('receipt_company')->nullable();
            $table->string('receipt_branch')->nullable();
            $table->string('receipt_name')->nullable();
            $table->string('receipt_lastname')->nullable();
            $table->string('receipt_tel')->nullable();
            $table->string('receipt_address')->nullable();
            $table->bigInteger('receipt_province')->unsigned()->index()->nullable(true);
            $table->foreign('receipt_province')->references('id')->on('tb_setting_provinces')->onDelete('cascade');
            $table->bigInteger('receipt_amphures')->unsigned()->index()->nullable(true);
            $table->foreign('receipt_amphures')->references('id')->on('tb_setting_amphures')->onDelete('cascade');
            $table->bigInteger('receipt_district')->unsigned()->index()->nullable(true);
            $table->foreign('receipt_district')->references('id')->on('tb_setting_districts')->onDelete('cascade');
            $table->string('receipt_zipcode')->nullable();
            $table->string('priceVAT')->nullable();
            $table->string('priceWithholding')->nullable();
            $table->string('conditionType')->nullable();
            $table->string('conditionValue')->nullable();
            $table->string('totalCart')->nullable();
            $table->integer('payment_type')->nullable();
            $table->bigInteger('payment_status')->unsigned()->index()->nullable(true);
            $table->foreign('payment_status')->references('id')->on('tb_setting_payment_status')->onDelete('cascade');
            $table->string('payment_massage')->nullable();
            $table->string('payment_slip')->nullable();
            $table->string('payment_updated_at')->nullable();
            $table->string('payment_updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_order');
    }
}
