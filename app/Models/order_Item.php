<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_Item extends Model
{
    use HasFactory;
    protected $table = 'order_item';
    protected $fillable = [
      'order_id',
      'product_id',
      'quantity',
    ];
}
