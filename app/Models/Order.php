<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = [
      'user_id',
      'order_no',
      'order_date',
      'ship_date',
      'required_date',
      'sales_tax',
      'timestamp',
      'transaction_status',
      'order_status',
      'vendor_id',
      'total_order',
      'discount_applied',
      'total_discount',
      'delivery_address',
      'discount_type',
      'order_otp',
      'status',
      'order_type',
      'order_details',
    ];
}
