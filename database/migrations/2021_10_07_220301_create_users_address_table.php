<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('tel')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('province')->unsigned()->index()->nullable(true);
            $table->foreign('province')->references('id')->on('tb_setting_provinces')->onDelete('cascade');
            $table->bigInteger('amphures')->unsigned()->index()->nullable(true);
            $table->foreign('amphures')->references('id')->on('tb_setting_amphures')->onDelete('cascade');
            $table->bigInteger('district')->unsigned()->index()->nullable(true);
            $table->foreign('district')->references('id')->on('tb_setting_districts')->onDelete('cascade');
            $table->string('zipcode')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('users_address');
    }
}
