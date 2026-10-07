<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryCalandarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_calandar', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('promotionId')->unsigned()->index()->nullable(true);
            $table->foreign('promotionId')->references('id')->on('tb_promotion_calendar')->onDelete('cascade');
            $table->string('token_notify');
            $table->string('send_message')->nullable();
            $table->integer('send_status')->default(2);
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
        Schema::dropIfExists('history_calandar');
    }
}
