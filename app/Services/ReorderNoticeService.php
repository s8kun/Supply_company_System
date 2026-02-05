<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ReorderNotice;

class ReorderNoticeService
{
    public function createIfNeeded(Product $product): ?ReorderNotice
    {
        if ($product->currentQuantity > $product->reorderLevel) {
            return null;
        }

        $existingNotice = ReorderNotice::query()
            ->where('productID', $product->productID)
            ->where('isResolved', false)
            ->first();

        if ($existingNotice) {
            return $existingNotice;
        }

        return ReorderNotice::query()->create([
            'productID' => $product->productID,
            'productName' => $product->name,
            'reorderQuantity' => $product->reorderQuantity,
            'currentQuantity' => $product->currentQuantity,
            'isResolved' => false,
        ]);
    }
}
