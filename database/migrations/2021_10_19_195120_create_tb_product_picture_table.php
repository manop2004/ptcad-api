<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_picture', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proId')->unsigned()->index()->nullable(true);
            $table->foreign('proId')->references('id')->on('tb_product')->onDelete('cascade');
            $table->bigInteger('detailId')->unsigned()->index()->nullable(true);
            $table->foreign('detailId')->references('id')->on('tb_product_detail')->onDelete('cascade');
            $table->string('picture_name')->nullable();
            $table->integer('picture_status')->default(2);
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
        Schema::dropIfExists('tb_product_picture');
    }
}
