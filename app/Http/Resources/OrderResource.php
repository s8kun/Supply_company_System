<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'orderID' => $this->orderID,
            'customerID' => $this->customerID,
            'totalPrice' => $this->totalPrice,
            'dueDate' => $this->dueDate,
            'orderStatus' => $this->orderStatus,
            'isPaid' => $this->isPaid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
