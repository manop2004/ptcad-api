<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStatusToHistoryCalandarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_calandar', function (Blueprint $table) {
            $table->renameColumn('send_message', 'send_message_startDate');
            $table->renameColumn('send_status', 'send_status_startDate');
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
