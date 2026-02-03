<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'productID';
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'costPrice',
        'sellPrice',
        'currentQuantity',
        'reorderLevel',
        'reorderQuantity',
        'image',
    ];
}
