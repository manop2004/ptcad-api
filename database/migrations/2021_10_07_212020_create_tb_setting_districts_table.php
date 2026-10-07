<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSettingDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_districts', function (Blueprint $table) {
            $table->id();
            $table->integer('dis_code')->default(1);
            $table->string('dis_name_th')->nullable();
            $table->string('dis_name_en')->nullable();
            $table->bigInteger('amphure_id')->unsigned()->index()->nullable(true);
            $table->foreign('amphure_id')->references('id')->on('tb_setting_amphures')->onDelete('cascade');
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
        Schema::dropIfExists('tb_setting_districts');
    }
}
