<?php

namespace App\Http\Resources;

use App\Http\Requests\StoreCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'customerID' => $this->customerID,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'address' => [
                'house_no' => $this->house_no,
                'street_name' => $this->street_name,
                'city' => $this->city,
                'zip_code' => $this->zip_code,
            ],
            'phone' => $this->phone,
            'credit_limit' => $this->credit_limit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
