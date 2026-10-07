<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbRecommendProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_recommend_product_category', function (Blueprint $table) {
            $table->id();
            $table->integer('option_type')->default(1);
            $table->integer('categoryId')->default(1);
            $table->string('recommend_product')->nullable();
            $table->string('thumb')->nullable();
            $table->integer('show')->default(1);
            $table->integer('sort')->default(1);
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
        Schema::dropIfExists('tb_recommend_product_category');
    }
}
