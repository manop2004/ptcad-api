<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinenotifyToTbPromotionCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_calendar', function (Blueprint $table) {
            $table->integer('line_notify_group1')->default(2)->after('promo_img');
            $table->integer('line_notify_group2')->default(2)->after('line_notify_group1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_promotion_calendar', function (Blueprint $table) {
            //
        });
    }
}
