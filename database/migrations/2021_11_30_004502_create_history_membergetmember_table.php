<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryMembergetmemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_membergetmember', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('getmemberId')->unsigned()->index()->nullable(true);
            $table->foreign('getmemberId')->references('id')->on('user_getmember')->onDelete('cascade');
            $table->string('remark')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('history_membergetmember');
    }
}
