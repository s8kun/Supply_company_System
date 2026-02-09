<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'customer_id',
        'total_price',
        'due_date',
        'order_status',
        'is_paid',
    ];
    protected $casts = [
        'order_status' => OrderStatus::class,
        'is_paid' => 'boolean',
    ];

    public function customer()
    {
        // Link order to its owning customer.
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function items()
    {
        // Link order to its line items.
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
