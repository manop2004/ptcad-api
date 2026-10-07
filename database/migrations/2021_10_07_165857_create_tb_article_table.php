<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_article', function (Blueprint $table) {
            $table->id();
            $table->string('art_name')->nullable();
            $table->text('art_keyword')->nullable();
            $table->longText('art_detail')->nullable();
            $table->integer('art_author')->default(1);
            $table->string('art_seo_detail')->nullable();
            $table->string('art_parmalink')->nullable();
            $table->string('art_thumb')->nullable();
            $table->integer('art_show')->default(1);
            $table->integer('art_recommend')->default(2);
            $table->integer('art_view')->default(0);
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
        Schema::dropIfExists('tb_article');
    }
}
