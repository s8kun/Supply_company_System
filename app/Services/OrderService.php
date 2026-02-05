<?php

namespace App\Services;

use App\Enums\DeliveryStatus;
use App\Enums\OrderStatus;
use App\Events\OrderCancelled;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        private PricingService $pricingService,
        private CreditService $creditService
    )
    {
    }

    public function createOrder(array $data): Order
    {
        return $this->placeOrder($data);
    }

    public function placeOrder(array $data): Order
    {
        return DB::transaction(function () use ($data): Order {
            $customer = Customer::query()
                ->where('customerID', $data['customerID'])
                ->lockForUpdate()
                ->firstOrFail();
            $items = $data['items'];

            $productIds = collect($items)->pluck('productID')->unique()->values();
            $products = Product::query()
                ->whereIn('productID', $productIds)
                ->get()
                ->keyBy('productID');

            $orderTotal = 0.0;
            $itemsToCreate = [];

            foreach ($items as $item) {
                $product = $products->get($item['productID']);
                if (!$product) {
                    throw ValidationException::withMessages([
                        'items' => ['Invalid product selected.'],
                    ]);
                }

                $quantity = (int) $item['quantity'];
                if ($product->currentQuantity < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Product {$product->productID} does not have enough stock."],
                    ]);
                }

                $itemTotal = $this->pricingService->calculateItemTotal((float) $product->sellPrice, $quantity);
                $orderTotal += $itemTotal;

                $itemsToCreate[] = [
                    'productID' => $product->productID,
                    'quantity' => $quantity,
                    'itemTotalPrice' => $itemTotal,
                    'deliveryStatus' => DeliveryStatus::PENDING,
                ];
            }

            if ($orderTotal > (float) $customer->credit_limit) {
                throw ValidationException::withMessages([
                    'customerID' => ['Credit limit exceeded for this order.'],
                ]);
            }

            $order = Order::query()->create([
                'customerID' => $customer->customerID,
                'totalPrice' => $orderTotal,
                'dueDate' => $data['dueDate'],
                'orderStatus' => OrderStatus::PENDING,
                'isPaid' => false,
            ]);

            $order->items()->createMany($itemsToCreate);
            $this->creditService->debitCustomer($customer, $orderTotal);

            return $order->load(['customer', 'items.product']);
        });
    }

    public function cancelOrder(Order $order): Order
    {
        return DB::transaction(function () use ($order): Order {
            $order = Order::query()
                ->where('orderID', $order->orderID)
                ->lockForUpdate()
                ->firstOrFail();

            if ($order->orderStatus === OrderStatus::CANCELLED) {
                throw ValidationException::withMessages([
                    'orderStatus' => ['Order is already cancelled.'],
                ]);
            }

            $hasDelivered = $order->items()
                ->where('deliveryStatus', DeliveryStatus::DELIVERED->value)
                ->exists();

            if ($hasDelivered) {
                throw ValidationException::withMessages([
                    'orderStatus' => ['Delivered orders cannot be cancelled.'],
                ]);
            }

            $order->orderStatus = OrderStatus::CANCELLED;
            $order->save();

            event(new OrderCancelled($order));

            return $order->load(['customer', 'items.product']);
        });
    }
}
