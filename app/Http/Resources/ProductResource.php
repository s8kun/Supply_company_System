<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'productID' => $this->productID,
            'name' => $this->name,
            'description' => $this->description,
            'costPrice' => $this->costPrice,
            'sellPrice' => $this->sellPrice,
            'currentQuantity' => $this->currentQuantity,
            'reorderLevel' => $this->reorderLevel,
            'reorderQuantity' => $this->reorderQuantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
