<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_coupon', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->nullable();
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->integer('coupon_use')->nullable();
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
        Schema::dropIfExists('users_coupon');
    }
}
