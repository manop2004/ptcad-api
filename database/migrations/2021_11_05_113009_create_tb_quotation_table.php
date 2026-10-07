<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_quotation', function (Blueprint $table) {
            $table->id();
            $table->string('quotationNumber')->nullable();
            $table->string('quotationDate')->nullable();
            $table->string('quotationDateExp')->nullable();
            $table->integer('type')->default(1);
            $table->string('user_code')->nullable();
            $table->bigInteger('userId')->unsigned()->index()->nullable(true);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('company')->nullable();
            $table->string('tax')->nullable();
            $table->string('address')->nullable();
            $table->integer('province')->default(2);
            $table->integer('amphures')->default(2);
            $table->integer('district')->default(2);
            $table->string('zipcode')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->text('message')->nullable();
            $table->integer('productTax')->default(2);
            $table->integer('productVat')->default(2);
            $table->text('productSku')->nullable();
            $table->text('productName')->nullable();
            $table->text('productDetail')->nullable();
            $table->text('productImg')->nullable();
            $table->text('productPrice')->nullable();
            $table->text('productPricesale')->nullable();
            $table->text('productUnit')->nullable();
            $table->text('productTotal')->nullable();
            $table->integer('pdpa_news')->default(2);
            $table->integer('pdpa_article')->default(2);
            $table->integer('pdpa_product')->default(2);
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
        Schema::dropIfExists('tb_quotation');
    }
}
