<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameExtGoogleWebmasterToTbExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_extensions', function (Blueprint $table) {
            $table->renameColumn('google_webmastwe', 'ext_googleWebmaster');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_extensions', function (Blueprint $table) {
            //
        });
    }
}
