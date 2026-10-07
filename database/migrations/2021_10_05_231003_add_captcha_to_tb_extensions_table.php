<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaptchaToTbExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_extensions', function (Blueprint $table) {
            $table->integer('ext_captcha_status')->after('ext_histats')->default(2);
            $table->string('ext_captcha')->after('ext_captcha_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_extensions', function (Blueprint $table) {
            //
        });
    }
}
