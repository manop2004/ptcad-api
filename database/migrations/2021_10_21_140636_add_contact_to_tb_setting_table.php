<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactToTbSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_setting', function (Blueprint $table) {
            $table->string('setting_address')->nullable()->after('setting_keyword');
            $table->string('setting_companyTime')->nullable()->after('setting_address');
            $table->string('setting_websiteTime')->nullable()->after('setting_companyTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_setting', function (Blueprint $table) {
            //
        });
    }
}
