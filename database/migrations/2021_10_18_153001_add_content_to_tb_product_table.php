<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentToTbProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_product', function (Blueprint $table) {
            $table->longText('pro_highlight')->nullable()->after('pro_codition');
            $table->longText('pro_content')->nullable()->after('pro_highlight');
            $table->longText('pro_feature')->nullable()->after('pro_content');
            $table->longText('pro_gift')->nullable()->after('pro_feature');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_product', function (Blueprint $table) {
            //
        });
    }
}
