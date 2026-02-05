<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReorderNotice extends Model
{
    protected $table = 'reorder_notices';

    protected $fillable = [
        'productID',
        'productName',
        'reorderQuantity',
        'currentQuantity',
        'isResolved',
    ];

    protected $casts = [
        'isResolved' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}
