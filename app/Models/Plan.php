<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
      'plan_type',
      'cost',
      'limitations',
      'duration',
      'description',
    ];
}
