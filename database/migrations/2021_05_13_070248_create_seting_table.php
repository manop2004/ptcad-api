<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting', function (Blueprint $table) {
            $table->id();
            $table->string('setting_logoWeb')->nullable();
            $table->string('setting_iconWeb')->nullable();
            $table->string('setting_nameWeb')->nullable();
            $table->text('setting_detail')->nullable();
            $table->string('setting_keyword')->nullable();
            $table->string('setting_keyword')->nullable();
            $table->string('setting_faxContact')->nullable();
            $table->string('setting_emailContact')->nullable();
            $table->string('setting_idLine')->nullable();
            $table->string('setting_LinkYoutube')->nullable();
            $table->string('setting_LinkTwitter')->nullable();
            $table->string('setting_LinkInstagram')->nullable();
            $table->string('setting_LinkFacebook')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('seting');
    }
}
