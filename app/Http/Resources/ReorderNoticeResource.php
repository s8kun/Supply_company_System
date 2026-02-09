<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReorderNoticeResource extends JsonResource
{
    /**
     * Shape the reorder notice payload for API responses.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'reorderNoticeId' => $this->id,
            'productId' => $this->product_id,
            'productName' => $this->product_name,
            'reorderQuantity' => $this->reorder_quantity,
            'currentQuantity' => $this->current_quantity,
            'isResolved' => $this->is_resolved,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
