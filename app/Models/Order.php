<?php

namespace App\Models;

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
        return $this->belongsTo(Customer::class, 'customerID', 'customerID');
    }
}
