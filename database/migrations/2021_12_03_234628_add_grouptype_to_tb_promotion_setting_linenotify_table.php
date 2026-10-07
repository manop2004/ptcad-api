<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrouptypeToTbPromotionSettingLinenotifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_setting_linenotify', function (Blueprint $table) {
            $table->integer('grouptype1')->default(2)->after('token_linenotify');
            $table->integer('grouptype2')->default(2)->after('grouptype1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_promotion_setting_linenotify', function (Blueprint $table) {
            //
        });
    }
}
