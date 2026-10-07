<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameExtToTbExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_extensions', function (Blueprint $table) {
            $table->renameColumn('google_analytics', 'ext_googleAnalytics');
            $table->renameColumn('google_adsense', 'ext_googleAdsense');
            $table->renameColumn('histats', 'ext_histats');
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
