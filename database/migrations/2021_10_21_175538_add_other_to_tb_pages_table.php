<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherToTbPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_pages', function (Blueprint $table) {
            $table->integer('pages_type')->default(1)->after('id');
            $table->text('pages_keyword')->nullable()->after('page_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_pages', function (Blueprint $table) {
            //
        });
    }
}
