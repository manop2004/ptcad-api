<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proId')->unsigned()->index()->nullable(true);
            $table->foreign('proId')->references('id')->on('tb_product')->onDelete('cascade');
            $table->string('detail_sku')->nullable();
            $table->string('detail_name')->nullable();
            $table->bigInteger('detail_status')->unsigned()->index()->nullable(true);
            $table->foreign('detail_status')->references('id')->on('tb_product_status')->onDelete('cascade');
            $table->string('detail_preorder_day')->nullable();
            $table->string('detail_product_weight')->nullable();
            $table->string('detail_product_wide')->nullable();
            $table->string('detail_product_long')->nullable();
            $table->string('detail_product_high')->nullable();
            $table->integer('detail_product_contact_sale_status')->default(2);
            $table->string('detail_price')->nullable();
            $table->integer('detail_price_sale_status')->default(2);
            $table->string('detail_price_sale')->nullable();
            $table->integer('detail_price_sale_status_date')->default(2);
            $table->string('detail_sale_date_start')->nullable();
            $table->string('detail_sale_date_end')->nullable();
            $table->integer('detail_show')->default(2);
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
        Schema::dropIfExists('tb_product_detail');
    }
}
