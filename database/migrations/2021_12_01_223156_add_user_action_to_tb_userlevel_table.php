<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserActionToTbUserlevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_level', function (Blueprint $table) {
            $table->integer('l_user_Action')->default(2)->after('l_user');
            $table->integer('l_user_staff_Action')->default(2)->after('l_user_Action');
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
