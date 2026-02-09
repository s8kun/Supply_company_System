<?php

namespace App\Models;

use App\Enums\DeliveryStatus;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'item_total_price',
        'delivery_status',
    ];
    protected $casts = [
        'delivery_status' => DeliveryStatus::class,
    ];

    public function order()
    {
        // Link item to its parent order.
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product()
    {
        // Link item to its product.
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
