<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryQuotationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_quotation_status', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quotationId')->unsigned()->index()->nullable(true);
            $table->foreign('quotationId')->references('id')->on('tb_quotation')->onDelete('cascade');
            $table->string('remark')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_quotation_status');
    }
}
