<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_software', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('serial_number')->nullable();
            $table->string('date_exp')->nullable();
            $table->text('note')->nullable();
            $table->integer('show')->default(2);
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
        Schema::dropIfExists('tb_software');
    }
}
