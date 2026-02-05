<?php

namespace App\Models;

use App\Enums\DeliveryStatus;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'orderItemID';
    protected $fillable = [
        'orderID',
        'productID',
        'quantity',
        'itemTotalPrice',
        'deliveryStatus',
    ];
    protected $casts = [
        'deliveryStatus' => DeliveryStatus::class,
    ];

    public function order()
    {
        // Link item to its parent order.
        return $this->belongsTo(Order::class, 'orderID', 'orderID');
    }

    public function product()
    {
        // Link item to its product.
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}
