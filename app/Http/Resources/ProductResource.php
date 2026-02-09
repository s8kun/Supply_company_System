<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Shape the product payload for API responses.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $images = collect($this->images ?? [])
            ->map(fn($path) => Storage::url($path))
            ->values();

        return [
            'productId' => $this->product_id,
            'name' => $this->name,
            'description' => $this->description,
            'costPrice' => $this->cost_price,
            'sellPrice' => $this->sell_price,
            'currentQuantity' => $this->current_quantity,
            'reorderLevel' => $this->reorder_level,
            'reorderQuantity' => $this->reorder_quantity,
            'images' => $images,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
