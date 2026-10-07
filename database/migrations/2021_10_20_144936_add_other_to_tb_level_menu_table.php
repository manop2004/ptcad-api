<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherToTbLevelMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_level_menu', function (Blueprint $table) {
            $table->integer('l_membergetmember')->default(2)->after('l_bank');
            $table->integer('l_membergetmember_setting')->default(2)->after('l_membergetmember');
            $table->integer('l_quotation')->default(2)->after('l_membergetmember_setting');
            $table->integer('l_quotation_setting')->default(2)->after('l_quotation');
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
