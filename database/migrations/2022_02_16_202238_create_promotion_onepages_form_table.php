<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionOnepagesFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_promotion_onepages_form', function (Blueprint $table) {
            $table->id();
            $table->string('field')->nullable();
            $table->string('col')->nullable();
            $table->string('sort')->default(1);
            $table->bigInteger('onepageId')->unsigned()->index()->nullable(true);
            $table->foreign('onepageId')->references('id')->on('tb_promotion_onepages')->onDelete('cascade');
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
        Schema::dropIfExists('tb_promotion_onepages_form');
    }
}
