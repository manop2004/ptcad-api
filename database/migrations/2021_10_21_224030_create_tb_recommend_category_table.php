<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbRecommendCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_recommend_category', function (Blueprint $table) {
            $table->id();
            $table->text('recommend_link')->nullable();
            $table->text('recommend_note')->nullable();
            $table->string('recommend_thumb')->nullable();
            $table->string('recommend_sort')->nullable();
            $table->integer('show')->default(2);
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
        Schema::dropIfExists('tb_recommend_category');
    }
}
