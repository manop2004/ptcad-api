<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSettingTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_transport', function (Blueprint $table) {
            $table->id();
            $table->string('transport_img')->nullable();
            $table->string('transport_name')->nullable();
            $table->string('transport_link')->nullable();
            $table->string('transport_value')->nullable();
            $table->integer('transport_show')->default(2);
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
        Schema::dropIfExists('tb_setting_transport');
    }
}
