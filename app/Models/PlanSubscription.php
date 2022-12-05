<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends Model
{
    use HasFactory;
    protected $table = 'plan_subscriptions';
    protected $fillable = [
        'plan_id',
      'plan_type',
      'vendor_id',
      'validity',
      'status',
      'plan_type',
      'purchase_date',
    ];
}
