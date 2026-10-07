<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatandtaxToTbQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_quotation_setting', function (Blueprint $table) {
            $table->string('company_vat')->nullable()->after('company_fax');
            $table->string('company_withheld')->nullable()->after('company_vat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_quotation_setting', function (Blueprint $table) {
            //
        });
    }
}
