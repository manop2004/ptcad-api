<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('displayname')->nullable();
            $table->string('img')->nullable();
            $table->string('tel')->nullable();
            $table->integer('status')->default(1);
            $table->string('lastlogin')->nullable();
            $table->string('update_by')->nullable();
            $table->string('crate_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

        });
    }
}
