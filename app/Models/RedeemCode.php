<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class RedeemCode extends Model
{
    protected $table = 'redeem_codes';

    protected $fillable = [
        'code',
        'amount',
        'is_used',
        'used_at',
        'used_by_customer_id',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function customer()
    {
        // Link redeemed code to the customer who used it.
        return $this->belongsTo(Customer::class, 'used_by_customer_id', 'customer_id');
    }
}
