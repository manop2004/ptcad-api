<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_order_payment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orderId')->unsigned()->index()->nullable(true);
            $table->foreign('orderId')->references('id')->on('tb_order')->onDelete('cascade');
            $table->string('payment_slip')->nullable();
            $table->bigInteger('payment_bank')->unsigned()->index()->nullable(true);
            $table->foreign('payment_bank')->references('id')->on('tb_setting_bank')->onDelete('cascade');
            $table->string('payment_bank_number')->nullable();
            $table->string('payment_bank_name')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_time')->nullable();
            $table->string('payment_total')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('tb_order_payment');
    }
}
