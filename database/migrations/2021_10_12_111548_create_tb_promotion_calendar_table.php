<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPromotionCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_promotion_calendar', function (Blueprint $table) {
            $table->id();
            $table->string('promo_name')->nullable();
            $table->string('promo_link')->nullable();
            $table->text('promo_note')->nullable();
            $table->string('promo_color')->nullable();
            $table->string('promo_start_date')->nullable();
            $table->string('promo_end_date')->nullable();
            $table->string('promo_img')->nullable();
            $table->integer('promo_show')->default(2);
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
        Schema::dropIfExists('tb_promotion_calendar');
    }
}
