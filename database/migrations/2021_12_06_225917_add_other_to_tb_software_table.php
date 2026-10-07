<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherToTbSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_software', function (Blueprint $table) {
            $table->string('name')->nullable()->after('serial_number');
            $table->date('date_start')->nullable()->after('name');
            $table->date('date_exp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_software', function (Blueprint $table) {
            //
        });
    }
}
