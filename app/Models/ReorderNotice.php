<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReorderNotice extends Model
{
    protected $table = 'reorder_notices';

    protected $fillable = [
        'product_id',
        'product_name',
        'reorder_quantity',
        'current_quantity',
        'is_resolved',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];

    public function product()
    {
        // Link notice to its product.
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
