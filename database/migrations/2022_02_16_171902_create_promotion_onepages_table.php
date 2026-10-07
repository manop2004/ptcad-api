<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionOnepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_promotion_onepages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('campaignid')->nullable();
            $table->string('parmalink')->nullable();
            $table->string('mailtoteam')->nullable();
            $table->string('regis_type')->nullable();
            $table->string('checkemail')->nullable();
            $table->text('og_keywords')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->integer('show')->default(2);
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
        Schema::dropIfExists('tb_promotion_onepages');
    }
}
