<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherToUsersLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_level', function (Blueprint $table) {
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
        Schema::table('users_level', function (Blueprint $table) {
            //
        });
    }
}
