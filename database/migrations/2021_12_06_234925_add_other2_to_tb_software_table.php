<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOther2ToTbSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_software', function (Blueprint $table) {
            $table->renameColumn('name', 'productCode');
            $table->string('price')->nullable()->after('date_exp');
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
