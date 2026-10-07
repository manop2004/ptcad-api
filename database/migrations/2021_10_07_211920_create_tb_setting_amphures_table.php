<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSettingAmphuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_amphures', function (Blueprint $table) {
            $table->id();
            $table->integer('amp_code')->default(1);
            $table->string('amp_name_th')->nullable();
            $table->string('amp_name_en')->nullable();
            $table->bigInteger('province_id')->unsigned()->index()->nullable(true);
            $table->foreign('province_id')->references('id')->on('tb_setting_provinces')->onDelete('cascade');
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
        Schema::dropIfExists('tb_setting_amphures');
    }
}
