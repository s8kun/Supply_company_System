<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\ReorderNoticeService;
use Illuminate\Database\Seeder;

class ReorderNoticeSeeder extends Seeder
{
    public function run(): void
    {
        $reorderNoticeService = app(ReorderNoticeService::class);

        Product::query()
            ->whereColumn('currentQuantity', '<=', 'reorderLevel')
            ->orderBy('productID')
            ->chunkById(200, function ($products) use ($reorderNoticeService) {
                foreach ($products as $product) {
                    $reorderNoticeService->createIfNeeded($product);
                }
            }, 'productID');
    }
}
