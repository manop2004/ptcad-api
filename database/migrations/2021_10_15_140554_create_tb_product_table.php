<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_option')->default(1);
            $table->string('pro_name')->nullable();
            $table->string('pro_permalink')->nullable();
            $table->string('pro_keyword')->nullable();
            $table->string('pro_seo_detail')->nullable();
            $table->bigInteger('pro_brand')->unsigned()->index()->nullable(true);
            $table->foreign('pro_brand')->references('id')->on('tb_brand')->onDelete('cascade');
            $table->bigInteger('pro_type')->unsigned()->index()->nullable(true);
            $table->foreign('pro_type')->references('id')->on('tb_product_type')->onDelete('cascade');
            $table->bigInteger('pro_catId')->unsigned()->index()->nullable(true);
            $table->foreign('pro_catId')->references('id')->on('tb_category')->onDelete('cascade');
            $table->bigInteger('pro_catsubId')->unsigned()->index()->nullable(true);
            $table->foreign('pro_catsubId')->references('id')->on('tb_category_sub')->onDelete('cascade');
            $table->string('pro_download')->nullable();
            $table->string('pro_free_trial')->nullable();
            $table->string('pro_codition')->nullable();
            $table->integer('pro_show')->default(2);
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
        Schema::dropIfExists('tb_product');
    }
}
