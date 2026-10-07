<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftwareToUsersLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_level', function (Blueprint $table) {
            $table->integer('l_software')->default(2)->after('l_promotion');
            $table->integer('l_program')->default(2)->after('l_software');
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
