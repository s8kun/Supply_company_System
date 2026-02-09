<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Shape the order item payload for API responses.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'orderItemId' => $this->order_item_id,
            'orderId' => $this->order_id,
            'productId' => $this->product_id,
            'quantity' => $this->quantity,
            'itemTotalPrice' => $this->item_total_price,
            'deliveryStatus' => $this->delivery_status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
