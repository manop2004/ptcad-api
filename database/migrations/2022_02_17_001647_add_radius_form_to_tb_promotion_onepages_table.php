<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRadiusFormToTbPromotionOnepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_onepages_setting', function (Blueprint $table) {
            $table->string('radiusForm')->nullable()->after('fontColor');
            $table->integer('radiusTopright')->default(2)->after('radiusForm');
            $table->integer('radiusBottomright')->default(2)->after('radiusTopright');
            $table->integer('radiusTopleft')->default(2)->after('radiusBottomright');
            $table->integer('radiusBottomleft')->default(2)->after('radiusTopleft');
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
