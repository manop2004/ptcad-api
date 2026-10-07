<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPdpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_pdpa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('fullname')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->integer('pdpa_news')->default(2);
            $table->integer('pdpa_article')->default(2);
            $table->integer('pdpa_product')->default(2);
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
        Schema::dropIfExists('history_pdpa');
    }
}
