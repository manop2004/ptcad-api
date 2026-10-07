<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusNotifyToTbPromotionCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_calendar', function (Blueprint $table) {
            $table->integer('promo_start_date_status')->default(2)->after('promo_start_date');
            $table->integer('promo_end_date_status')->default(2)->after('promo_end_date');
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
