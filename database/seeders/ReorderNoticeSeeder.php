<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\ReorderNoticeService;
use Illuminate\Database\Seeder;

class ReorderNoticeSeeder extends Seeder
{
    /**
     * Seed reorder notices for products below the reorder level.
     */
    public function run(): void
    {
        $reorderNoticeService = app(ReorderNoticeService::class);

        Product::query()
            ->whereColumn('current_quantity', '<=', 'reorder_level')
            ->orderBy('product_id')
            ->chunkById(200, function ($products) use ($reorderNoticeService) {
                foreach ($products as $product) {
                    $reorderNoticeService->createIfNeeded($product);
                }
            }, 'product_id');
    }
}
