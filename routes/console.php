<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Product;
use App\Services\ReorderNoticeService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Generate reorder notices for products at or below reorder level.
Artisan::command('reorder:generate', function (ReorderNoticeService $reorderNoticeService) {
    Product::query()
        ->whereColumn('current_quantity', '<=', 'reorder_level')
        ->orderBy('product_id')
        ->chunkById(200, function ($products) use ($reorderNoticeService) {
            foreach ($products as $product) {
                $reorderNoticeService->createIfNeeded($product);
            }
        }, 'product_id');
})->purpose('Generate reorder notices for low stock products');

// Run reorder notice generation on a schedule.
Schedule::command('reorder:generate')->hourly();
