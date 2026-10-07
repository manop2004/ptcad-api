<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToTbSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_software', function (Blueprint $table) {
            $table->bigInteger('orderId')->unsigned()->index()->nullable(true);
            $table->foreign('orderId')->references('id')->on('tb_order')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_software', function (Blueprint $table) {
            //
        });
    }
}
