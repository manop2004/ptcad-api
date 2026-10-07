<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryChangeDisplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_change_display', function (Blueprint $table) {
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('displayname_new')->nullable();
            $table->string('displayname_old')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('history_change_display');
    }
}
