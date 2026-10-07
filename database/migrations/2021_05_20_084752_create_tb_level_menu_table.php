<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLevelMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_level_menu', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('level')->unsigned()->index()->nullable(true);
            $table->foreign('level')->references('id')->on('tb_level')->onDelete('cascade');
            $table->integer('l_artlicle')->default(0);
            $table->integer('l_category')->default(0);
            $table->integer('l_customcode')->default(0);
            $table->integer('l_setting')->default(0);
            $table->integer('l_user')->default(0);
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
        Schema::dropIfExists('tb_level_menu');
    }
}
