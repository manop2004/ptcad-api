<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('license_stock', function (Blueprint $table) {
            $table->id();
            $table->string('product', 20);
            $table->string('periodcode', 10);
            $table->string('serial_number', 100)->unique();
            $table->string('status', 20)->default('available');
            $table->string('used_for_order', 50)->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
            $table->index(['product', 'periodcode', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('license_stock');
    }
};