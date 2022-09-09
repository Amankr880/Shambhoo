<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_category extends Model
{
    use HasFactory;
    protected $table = 'vendor_category';
    protected $fillable = [
      'vendor_id',
      'category_id',
      'parent_category',
    ];
}
