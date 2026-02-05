<?php

namespace App\Services;

use App\Models\Customer;

class CreditService
{
    /**
     * Decrease customer credit balance by the given amount.
     */
    public function debitCustomer(Customer $customer, float $amount): void
    {
        $customer->credit_limit = round(((float) $customer->credit_limit) - $amount, 2);
        $customer->save();
    }

    /**
     * Increase customer credit balance by the given amount.
     */
    public function creditCustomer(Customer $customer, float $amount): void
    {
        $customer->credit_limit = round(((float) $customer->credit_limit) + $amount, 2);
        $customer->save();
    }
}
