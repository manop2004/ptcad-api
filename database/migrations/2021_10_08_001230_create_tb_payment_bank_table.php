<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPaymentBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_payment_bank', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bankId')->unsigned()->index()->nullable(true);
            $table->foreign('bankId')->references('id')->on('tb_setting_bank')->onDelete('cascade');
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_branch')->nullable();
            $table->integer('bank_show')->default(1);
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
        Schema::dropIfExists('tb_payment_bank');
    }
}
