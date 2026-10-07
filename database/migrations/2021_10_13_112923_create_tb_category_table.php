<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->nullable();
            $table->string('category_permalink')->nullable();
            $table->bigInteger('category_type')->unsigned()->index()->nullable(true);
            $table->foreign('category_type')->references('id')->on('tb_type')->onDelete('cascade');
            $table->text('category_note')->nullable();
            $table->string('category_sort')->nullable();
            $table->integer('category_show')->default(2);
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
        Schema::dropIfExists('tb_category');
    }
}
