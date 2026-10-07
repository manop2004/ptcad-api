<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToTbPagesMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pages_map', function (Blueprint $table) {
            $table->id();
            $table->integer('page_about')->nullable();
            $table->integer('page_privacy_policy')->nullable();
            $table->integer('page_business_policy')->nullable();
            $table->integer('page_refund_policy')->nullable();
            $table->integer('page_return_policy')->nullable();
            $table->integer('page_warranty_policy')->nullable();
            $table->integer('page_howto_shopping')->nullable();
            $table->integer('page_howto_register')->nullable();
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
        Schema::dropIfExists('tb_pages_map');
    }
}
