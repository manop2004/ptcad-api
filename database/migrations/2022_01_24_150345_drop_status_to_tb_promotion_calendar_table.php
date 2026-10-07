<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStatusToTbPromotionCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_calendar', function (Blueprint $table) {
            $table->dropColumn('promo_start_date_status_1');
            $table->dropColumn('promo_end_date_status_1');
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
