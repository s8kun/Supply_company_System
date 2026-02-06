<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\OrderItemController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\RedeemCodeController;
use App\Http\Controllers\Api\V1\ReorderNoticeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me', [AuthController::class, 'me']);

        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{product}', [ProductController::class, 'show']);
        Route::post('products', [ProductController::class, 'store'])->middleware('role:admin,supervisor');
        Route::match(['put', 'patch'], 'products/{product}', [ProductController::class, 'update'])
            ->middleware('role:admin');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->middleware('role:admin');

        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::post('orders', [OrderController::class, 'store'])->middleware('role:customer');
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->middleware('role:customer');
        Route::match(['put', 'patch'], 'orders/{order}', [OrderController::class, 'update'])
            ->middleware('role:admin,supervisor');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->middleware('role:admin');

        Route::apiResource('order-items', OrderItemController::class)
            ->only(['index', 'show', 'update'])
            ->middleware('role:admin,supervisor');

        Route::post('redeem-codes', [RedeemCodeController::class, 'store'])
            ->middleware('role:admin,supervisor');
        Route::post('redeem-codes/redeem', [RedeemCodeController::class, 'redeem'])
            ->middleware('role:customer');

        Route::apiResource('customers', CustomerController::class)->middleware('role:admin');

        Route::get('reorder-notices', [ReorderNoticeController::class, 'index'])->middleware('role:admin');
        Route::get('reorder-notices/{reorderNotice}', [ReorderNoticeController::class, 'show'])->middleware('role:admin');
    });
});
