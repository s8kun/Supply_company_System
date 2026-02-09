<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'sell_price',
        'current_quantity',
        'reorder_level',
        'reorder_quantity',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function reorderNotices()
    {
        // Link product to its reorder notices.
        return $this->hasMany(ReorderNotice::class, 'product_id', 'product_id');
    }
}
