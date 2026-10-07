<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablenameGetmemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setting_getmember', function (Blueprint $table) {
            $table->id();
            $table->string('getmember_thumb')->nullable();
            $table->integer('getmember_ref_type')->default(2);
            $table->string('getmember_ref_detail')->nullable();
            $table->string('getmember_ref_coupon')->nullable();
            $table->integer('getmember_recommender_type')->default(2);
            $table->string('getmember_recommender_detail')->nullable();
            $table->string('getmember_recommender_coupon')->nullable();
            $table->integer('getmember_show')->default(2);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('tb_setting_getmember');
    }
}
