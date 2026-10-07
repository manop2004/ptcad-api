<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_level', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('UserId')->unsigned()->index()->nullable(true);
            $table->foreign('UserId')->references('id')->on('users')->onDelete('cascade');
            $table->integer('l_artlicle')->default(0);
            $table->integer('l_category')->default(0);
            $table->integer('l_customcode')->default(0);
            $table->integer('l_setting')->default(0);
            $table->integer('l_user')->default(0);
            $table->string('update_by')->nullable();
            $table->string('crate_by')->nullable();
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
        Schema::dropIfExists('users_level');
    }
}
