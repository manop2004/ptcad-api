<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPromotionOnepagesSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_promotion_onepages_setting', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('onepageId')->unsigned()->index()->nullable(true);
            $table->foreign('onepageId')->references('id')->on('tb_promotion_onepages')->onDelete('cascade');
            $table->string('formName')->nullable();
            $table->integer('checklabel')->default(1);
            $table->text('formDetail')->nullable();
            $table->text('formPDPA')->nullable();
            $table->integer('checkpdpa')->default(1);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('tb_promotion_onepages_setting');
    }
}
