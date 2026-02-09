<?php

namespace App\Http\Resources;

use App\Http\Requests\StoreCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Shape the customer payload for API responses.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'customerId' => $this->customer_id,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'address' => [
                'houseNo' => $this->house_no,
                'streetName' => $this->street_name,
                'city' => $this->city,
                'zipCode' => $this->zip_code,
            ],
            'phone' => $this->phone,
            'creditLimit' => $this->credit_limit,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

    }
}
