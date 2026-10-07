<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSettingProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_provinces', function (Blueprint $table) {
            $table->id();
            $table->integer('prov_code')->default(1);
            $table->string('prov_name_th')->nullable();
            $table->string('prov_name_en')->nullable();
            $table->bigInteger('geography_id')->unsigned()->index()->nullable(true);
            $table->foreign('geography_id')->references('id')->on('tb_setting_geographies')->onDelete('cascade');
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
        Schema::dropIfExists('tb_setting_provinces');
    }
}
