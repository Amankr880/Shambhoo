<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('SKU');
            $table->string('product_name');
            $table->longText('product_desc');
            $table->json('attributes');
            $table->integer('category_id');
            $table->string('unit_price');
            $table->string('MSRP');
            $table->integer('status')->default('0');
            $table->integer('vendor_id');
            $table->string('unit_weight');
            $table->string('unit_stock');
            $table->string('unit_in_order');
            $table->integer('discount');
            $table->string('product_available');
            $table->string('discount_available');
            $table->integer('ranking');
            $table->string('picture');
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
        Schema::dropIfExists('products');
    }
};
