<?php

namespace App\Services;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;

class CustomerService
{
    /**
     * Create and persist a new customer from validated data.
     */
    public function createNewCustomer(StoreCustomerRequest $request, Customer $customer): Customer
    {
        $customer->fill($request->validatedSnake());
        $customer->save();
        return $customer;
    }
}
