<?php

namespace App\Services;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;

class CustomerService
{
    public function createNewCustomer(StoreCustomerRequest $request, Customer $customer): Customer
    {
        $customer->fill($request->validated());
        $customer->save();
        return $customer;
    }
}
