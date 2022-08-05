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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_no')->autoIncrement();
            $table->date('order_date');
            $table->date('ship_date');
            $table->date('required_date');
            $table->string('sales_tax');
            $table->string('timestamp');
            $table->string('transaction_status');
            $table->integer('order_status');
            $table->integer('vendor_id');
            $table->integer('total_order');
            $table->integer('discount_applied');
            $table->integer('total_discount');
            $table->json('delivery_address');
            $table->string('discount_type');
            $table->integer('order_otp');
            $table->integer('status');
            $table->string('order_type');
            $table->json('order_details');
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
        Schema::dropIfExists('orders');
    }
};
