<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingLogoWebMobileToTbSettingMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_setting', function (Blueprint $table) {
            $table->string('setting_logoWeb_mobile')->nullable()->after('setting_logoWeb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_setting', function (Blueprint $table) {
            //
        });
    }
}
