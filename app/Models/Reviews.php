<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
      'user_id',
      'vendor_id',
      'product_id',
      'description',
      'product_rating',
      'images',
      'is_approved',
      'delivery_rating',
      'vendor_rating',
    ];
}
