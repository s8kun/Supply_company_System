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
            'orderItemID' => $this->orderItemID,
            'orderID' => $this->orderID,
            'productID' => $this->productID,
            'quantity' => $this->quantity,
            'itemTotalPrice' => $this->itemTotalPrice,
            'deliveryStatus' => $this->deliveryStatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
