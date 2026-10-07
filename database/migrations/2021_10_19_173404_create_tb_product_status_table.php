<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_status', function (Blueprint $table) {
            $table->id();
            $table->string('stu_name')->nullable();
            $table->integer('stu_preorder')->default(2);
            $table->string('stu_color')->nullable();
            $table->integer('stu_show')->default(2);
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
        Schema::dropIfExists('tb_product_status');
    }
}
