<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ReorderNotice;

class ReorderNoticeService
{
    /**
     * Create a reorder notice if stock is at or below the reorder level.
     */
    public function createIfNeeded(Product $product): ?ReorderNotice
    {
        if ($product->current_quantity > $product->reorder_level) {
            return null;
        }

        $existingNotice = ReorderNotice::query()
            ->where('product_id', $product->product_id)
            ->where('is_resolved', false)
            ->first();

        if ($existingNotice) {
            return $existingNotice;
        }

        return ReorderNotice::query()->create([
            'product_id' => $product->product_id,
            'product_name' => $product->name,
            'reorder_quantity' => $product->reorder_quantity,
            'current_quantity' => $product->current_quantity,
            'is_resolved' => false,
        ]);
    }
}
