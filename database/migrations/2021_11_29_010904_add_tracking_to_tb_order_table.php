<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackingToTbOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_order', function (Blueprint $table) {
            $table->bigInteger('transportId')->unsigned()->index()->nullable(true);
            $table->foreign('transportId')->references('id')->on('tb_setting_transport')->onDelete('cascade');
            $table->string('tracking')->nullable()->after('transportId');
            $table->string('transport_link')->nullable()->after('tracking');
            $table->string('tracking_remark')->nullable()->after('transport_link');
            $table->string('tracking_updated_by')->nullable()->after('tracking_remark');
            $table->string('tracking_updated_at')->nullable()->after('tracking_updated_by');
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
