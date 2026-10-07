<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSoftwareNotifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_software_notify', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('softwareId')->unsigned()->index()->nullable(true);
            $table->foreign('softwareId')->references('id')->on('tb_software')->onDelete('cascade');
            $table->bigInteger('orderId')->unsigned()->index()->nullable(true);
            $table->foreign('orderId')->references('id')->on('tb_order')->onDelete('cascade');
            $table->string('serial_number')->nullable();
            $table->string('productCode')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_exp')->nullable();
            $table->string('price')->nullable();
            $table->text('note')->nullable();
            $table->integer('show')->default(2);
            $table->integer('status')->default(2);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('tb_software_notify');
    }
}
