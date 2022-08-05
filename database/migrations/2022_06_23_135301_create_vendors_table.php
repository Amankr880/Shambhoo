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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('shopName');
            $table->integer('user_id');
            $table->string('address');
            $table->string('location');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('phone_no');
            $table->string('email_id');
            $table->string('id_proof_type');
            $table->string('id_proof_no');
            $table->binary('id_proof_photo');
            $table->string('pancard_no');
            $table->binary('pancard_photo');
            $table->string('gst_no')->nullable();
            $table->string('business_doc_type');
            $table->string('business_doc_no');
            $table->binary('business_doc_photo');
            $table->longText('about');
            $table->binary('logo_image');
            $table->binary('header_image');
            $table->json('gallery');
            $table->json('delivery_slot');
            $table->integer('status');            
            $table->integer('visibility');
            $table->longText('policy');            
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
        Schema::dropIfExists('vendors');
    }
};
