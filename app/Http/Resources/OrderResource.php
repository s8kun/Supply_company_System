<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Shape the order payload for API responses.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'orderId' => $this->order_id,
            'customerId' => $this->customer_id,
            'totalPrice' => $this->total_price,
            'dueDate' => $this->due_date,
            'orderStatus' => $this->order_status,
            'isPaid' => $this->is_paid,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
