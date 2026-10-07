<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_order_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orderId')->unsigned()->index()->nullable(true);
            $table->foreign('orderId')->references('id')->on('tb_order')->onDelete('cascade');
            $table->string('product_sku')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_detail')->nullable();
            $table->text('product_img')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_price_sale')->nullable();
            $table->integer('product_unit')->nullable();
            $table->string('product_price_total')->nullable();
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
        Schema::dropIfExists('tb_order_detail');
    }
}
