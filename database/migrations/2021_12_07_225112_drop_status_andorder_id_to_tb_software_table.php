<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStatusAndorderIdToTbSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_software', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropForeign(['orderId']);
            $table->dropColumn('orderId');
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
