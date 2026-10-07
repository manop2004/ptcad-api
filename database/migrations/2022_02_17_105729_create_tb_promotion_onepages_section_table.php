<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPromotionOnepagesSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_promotion_onepages_section', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('onepageId')->unsigned()->index()->nullable(true);
            $table->foreign('onepageId')->references('id')->on('tb_promotion_onepages')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('bgColor')->nullable();
            $table->string('section')->nullable();
            $table->string('sort')->nullable();
            $table->text('detail')->nullable();
            $table->integer('show')->default(1);
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
        Schema::dropIfExists('tb_promotion_onepages_section');
    }
}
