<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialiteToTbExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_extensions', function (Blueprint $table) {
            $table->integer('ext_google_status')->default(2)->after('ext_lineNotify');
            $table->string('ext_google_clientId')->nullable()->after('ext_google_status');
            $table->string('ext_google_clientSecret')->nullable()->after('ext_google_clientId');
            $table->integer('ext_facebook_status')->default(2)->after('ext_google_clientSecret');
            $table->string('ext_facebook_clientId')->nullable()->after('ext_facebook_status');
            $table->string('ext_facebook_clientSecret')->nullable()->after('ext_facebook_clientId');
            //
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
