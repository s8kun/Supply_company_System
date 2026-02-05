<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Product;
use App\Services\ReorderNoticeService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reorder:generate', function (ReorderNoticeService $reorderNoticeService) {
    Product::query()
        ->whereColumn('currentQuantity', '<=', 'reorderLevel')
        ->orderBy('productID')
        ->chunkById(200, function ($products) use ($reorderNoticeService) {
            foreach ($products as $product) {
                $reorderNoticeService->createIfNeeded($product);
            }
        }, 'productID');
})->purpose('Generate reorder notices for low stock products');

Schedule::command('reorder:generate')->hourly();
