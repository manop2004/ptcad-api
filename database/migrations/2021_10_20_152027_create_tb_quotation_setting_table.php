<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbQuotationSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_quotation_setting', function (Blueprint $table) {
            $table->id();
            $table->string('tax_id')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_tel')->nullable();
            $table->string('company_fax')->nullable();
            $table->text('quotation_note')->nullable();
            $table->text('quotation_transfer')->nullable();
            $table->text('quotation_payment')->nullable();
            $table->string('logo_company')->nullable();
            $table->integer('show')->default(2);
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('tb_quotation_setting');
    }
}
