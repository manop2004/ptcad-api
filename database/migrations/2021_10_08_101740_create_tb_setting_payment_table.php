<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSettingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_transfer_status')->default(2);
            $table->integer('credit_card_status')->default(2);
            $table->integer('installment_status')->default(2);
            $table->integer('omise_status')->default(2);
            $table->string('omise_public_key_for_live')->nullable();
            $table->string('omise_secret_key_for_live')->nullable();
            $table->string('omise_public_key_for_test')->nullable();
            $table->string('omise_secret_key_for_test')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('tb_setting_payment');
    }
}
