<?php

namespace Database\Seeders;

use App\Enums\DeliveryStatus;
use App\Models\Customer;
use App\Models\Product;
use App\Services\OrderItemService;
use App\Services\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Seed orders, items, and delivery status for testing.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $orderService = app(OrderService::class);
        $orderItemService = app(OrderItemService::class);

        if (Customer::query()->count() === 0 || Product::query()->count() === 0) {
            return;
        }

        for ($i = 0; $i < 15; $i++) {
            $customer = Customer::query()
                ->where('credit_limit', '>=', 50)
                ->inRandomOrder()
                ->first();

            if (!$customer) {
                break;
            }

            $items = [];
            $products = Product::query()->inRandomOrder()->take($faker->numberBetween(1, 3))->get();

            foreach ($products as $product) {
                $maxQty = (int) $product->currentQuantity;
                if ($maxQty < 1) {
                    continue;
                }
                $qty = $faker->numberBetween(1, min(5, $maxQty));
                $items[] = [
                    'productID' => $product->productID,
                    'quantity' => $qty,
                ];
            }

            if (count($items) === 0) {
                continue;
            }

            try {
                $order = $orderService->placeOrder([
                    'customerID' => $customer->customerID,
                    'dueDate' => now()->addDays($faker->numberBetween(1, 14))->toDateString(),
                    'items' => $items,
                ]);
            } catch (ValidationException) {
                continue;
            }

            if ($faker->boolean(25)) {
                try {
                    $orderService->cancelOrder($order);
                } catch (ValidationException) {
                    // ignore
                }
                continue;
            }

            if ($faker->boolean(35)) {
                $order->load('items');
                foreach ($order->items as $item) {
                    try {
                        $orderItemService->updateDeliveryStatus($item, DeliveryStatus::DELIVERED);
                    } catch (ValidationException) {
                        // ignore
                    }
                }
            }
        }
    }
}
