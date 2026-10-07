<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPromotionCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_promotion_coupon', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_name')->nullable();
            $table->string('coupon_img')->nullable();
            $table->string('coupon_des')->nullable();
            $table->integer('coupon_type')->default(1);
            $table->string('coupon_discount')->nullable();
            $table->string('coupon_date_exp')->nullable();
            $table->string('min_order_amount')->nullable();
            $table->string('max_order_amount')->nullable();
            $table->integer('status_product_not_sale')->default(2);
            $table->string('participating_products')->nullable();
            $table->string('non_participating_products')->nullable();
            $table->integer('participating_categorie_type')->default(1);
            $table->string('participating_categorie')->nullable();
            $table->integer('non_participating_categorie_type')->default(1);
            $table->string('non_participating_categorie')->nullable();
            $table->string('coupon_limit')->nullable();
            $table->string('coupon_limit_people')->nullable();
            $table->integer('show')->default(1);
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
        Schema::dropIfExists('tb_promotion_coupon');
    }
}
