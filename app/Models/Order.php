<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'orderID';
    protected $fillable = [
        'customerID',
        'totalPrice',
        'dueDate',
        'orderStatus',
        'isPaid',
    ];
    protected $casts = [
        'orderStatus' => OrderStatus::class,
        'isPaid' => 'boolean',
    ];

    public function customer()
    {
        // Link order to its owning customer.
        return $this->belongsTo(Customer::class, 'customerID', 'customerID');
    }

    public function items()
    {
        // Link order to its line items.
        return $this->hasMany(OrderItem::class, 'orderID', 'orderID');
    }
}
