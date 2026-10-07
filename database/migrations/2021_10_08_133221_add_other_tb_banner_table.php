<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherTbBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_banner', function (Blueprint $table) {
            $table->string('banner_note')->nullable()->after('banner_link');
            $table->string('banner_start_date')->nullable()->after('banner_note');
            $table->string('banner_end_date')->nullable()->after('banner_start_date');
            $table->string('banner_img_desktop')->nullable()->after('banner_end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_banner', function (Blueprint $table) {

        });
    }
}
