<?php

namespace App\Services;

use App\Models\Customer;

class CreditService
{
    public function debitCustomer(Customer $customer, float $amount): void
    {
        $customer->credit_limit = round(((float) $customer->credit_limit) - $amount, 2);
        $customer->save();
    }

    public function creditCustomer(Customer $customer, float $amount): void
    {
        $customer->credit_limit = round(((float) $customer->credit_limit) + $amount, 2);
        $customer->save();
    }
}
