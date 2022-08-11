<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = 'vendors';
    protected $fillable = [
      'shopName',
      'user_id',
      'address',
      'location',
      'city',
      'state',
      'pincode',
      'phone_no',
      'email_id',
      'id_proof_type',
      'id_proof_no',
      'id_proof_photo',
      'pancard_no',
      'pancard_photo',
      'gst_no',
      'business_doc_type',
      'business_doc_no',
      'business_doc_photo',
      'about',
      'logo_image',
      'header_image',
      'gallery',
      'delivery_slot',
      'status',
      'visibility',
      'policy',
    ];
}
