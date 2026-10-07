<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductSpecificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_specification', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proId')->unsigned()->index()->nullable(true);
            $table->foreign('proId')->references('id')->on('tb_product')->onDelete('cascade');
            $table->string('spec_name')->nullable();
            $table->text('spec_detail')->nullable();
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
        Schema::dropIfExists('tb_product_specification');
    }
}
