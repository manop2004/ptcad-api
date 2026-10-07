<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorToTbPromotionOnepagesSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_onepages_setting', function (Blueprint $table) {
            $table->string('bgColor')->nullable()->after('checkpdpa');
            $table->string('pdpaColor')->nullable()->after('bgColor');
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
