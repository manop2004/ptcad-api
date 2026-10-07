<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFontcolorToTbPromotionOnepagesSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_onepages_setting', function (Blueprint $table) {
            $table->string('fontColor')->nullable()->after('pdpaColor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_promotion_onepages_setting', function (Blueprint $table) {
            //
        });
    }
}
