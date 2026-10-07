<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffToTbOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_order', function (Blueprint $table) {
            $table->bigInteger('staffOf')->unsigned()->index()->nullable(true);
            $table->foreign('staffOf')->references('id')->on('users')->onDelete('cascade');
            $table->string('staff_updated_by')->nullable()->after('staffOf');
            $table->string('staff_updated_at')->nullable()->after('staff_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_order', function (Blueprint $table) {
            //
        });
    }
}
