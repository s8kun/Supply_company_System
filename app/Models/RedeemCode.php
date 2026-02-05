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
        'isUsed',
        'usedAt',
        'usedByCustomerID',
    ];

    protected $casts = [
        'isUsed' => 'boolean',
        'usedAt' => 'datetime',
    ];

    public function customer()
    {
        // Link redeemed code to the customer who used it.
        return $this->belongsTo(Customer::class, 'usedByCustomerID', 'customerID');
    }
}
