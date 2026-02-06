<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customerID';
    protected $table = 'customers';
    protected $fillable = ['first_name', 'middle_name', 'last_name',
        'house_no', 'street_name', 'city', 'zip_code',
        'phone', 'credit_limit', 'user_id'];

    public function user()
    {
        // Link customer to their login user.
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        // Link customer to their orders.
        return $this->hasMany(Order::class, 'customerID', 'customerID');
    }
}
