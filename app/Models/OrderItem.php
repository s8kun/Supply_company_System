<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $casts = [
        'deliveryStatus' => deliveryStatus::class,
    ];
}
