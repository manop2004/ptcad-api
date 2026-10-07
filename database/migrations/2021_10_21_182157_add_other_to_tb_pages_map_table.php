<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherToTbPagesMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_pages_map', function (Blueprint $table) {
            $table->integer('pages_check_delivery')->nullable()->after('page_howto_register');
            $table->integer('pages_contact_support')->nullable()->after('pages_check_delivery');
            $table->integer('pages_payment')->nullable()->after('pages_contact_support');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_pages_map', function (Blueprint $table) {
            //
        });
    }
}
