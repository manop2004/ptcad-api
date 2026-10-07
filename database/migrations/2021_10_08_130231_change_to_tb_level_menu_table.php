<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeToTbLevelMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_level_menu', function (Blueprint $table) {
            $table->integer('l_artlicle')->default(2)->change();
            $table->integer('l_banner')->default(2)->change();
            $table->integer('l_page')->default(2)->change();
            $table->integer('l_category')->default(2)->change();
            $table->integer('l_customcode')->default(2)->change();
            $table->integer('l_setting')->default(2)->change();
            $table->integer('l_user')->default(2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_level_menu', function (Blueprint $table) {
            //
        });
    }
}
