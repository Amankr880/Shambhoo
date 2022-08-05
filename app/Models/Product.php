<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
      'SKU',
      'product_name',
      'product_desc',
      'attributes',
      'category_id',
      'unit_price',
      'MSRP',
      'status',
      'vendor_id',
      'unit_weight',
      'unit_stock',
      'unit_in_order',
      'discount',
      'product_available',
      'discount_available',
      'ranking',
      'picture',
    ];
}
