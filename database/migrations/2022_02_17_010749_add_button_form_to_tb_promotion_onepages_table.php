<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddButtonFormToTbPromotionOnepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_promotion_onepages_setting', function (Blueprint $table) {
            $table->string('bgButton')->nullable()->after('radiusBottomleft');
            $table->string('wordButton')->nullable()->after('bgButton');
            $table->string('widthButton')->nullable()->after('wordButton');
            $table->string('imageButton')->nullable()->after('widthButton');
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
