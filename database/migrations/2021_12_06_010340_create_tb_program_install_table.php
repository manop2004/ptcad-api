<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProgramInstallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_program_install', function (Blueprint $table) {
            $table->id();
            $table->string('install_name')->nullable();
            $table->string('install_file')->nullable();
            $table->bigInteger('programId')->unsigned()->index()->nullable(true);
            $table->foreign('programId')->references('id')->on('tb_program')->onDelete('cascade');
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
        Schema::dropIfExists('tb_program_install');
    }
}
