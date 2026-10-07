<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSettingPopupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_popup', function (Blueprint $table) {
            $table->id();
            $table->integer('popup_type')->default(2);
            $table->longText('popup_detail')->nullable();
            $table->string('popup_img')->nullable();
            $table->integer('sizeModel')->default(1);
            $table->integer('popup_show')->default(2);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('tb_setting_popup');
    }
}
