<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusEndToHistoryCalandarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_calandar', function (Blueprint $table) {
            $table->string('send_message_EndDate')->nullable()->after('send_status_startDate');
            $table->integer('send_status_EndDate')->default(1)->after('send_message_EndDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_calandar', function (Blueprint $table) {
            //
        });
    }
}
