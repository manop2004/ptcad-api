<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->nullable()->after('name');
            $table->string('hbd_day')->nullable()->after('tel');
            $table->string('hbd_month')->nullable()->after('hbd_day');
            $table->string('hbd_year')->nullable()->after('hbd_month');
            $table->string('sex')->nullable()->after('lastname');
            $table->string('type_user')->nullable()->after('status');
            $table->integer('pdpa_news')->default(2)->after('type_user');
            $table->integer('pdpa_article')->default(2)->after('pdpa_news');
            $table->integer('pdpa_product')->default(2)->after('pdpa_article');
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
            //
        });
    }
}
