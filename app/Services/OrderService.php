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
    /**
     * Inject pricing and credit services for order workflows.
     */
    public function __construct(
        private PricingService $pricingService,
        private CreditService  $creditService
    )
    {
    }

    /**
     * Backward-compatible alias for placing a new order.
     */
    public function createOrder(array $data): Order
    {
        return $this->placeOrder($data);
    }

    /**
     * Create an order, compute totals, and debit customer credit.
     */
    public function placeOrder(array $data): Order
    {
        return DB::transaction(function () use ($data): Order {
            $customer = Customer::query()
                ->where('customer_id', $data['customer_id'])
                ->lockForUpdate()
                ->firstOrFail();
            $items = $data['items'];

            $productIds = collect($items)->pluck('product_id')->unique()->values();
            $products = Product::query()
                ->whereIn('product_id', $productIds)
                ->get()
                ->keyBy('product_id');

            $orderTotal = 0.0;
            $itemsToCreate = [];

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                if (!$product) {
                    throw ValidationException::withMessages([
                        'items' => ['Invalid product selected.'],
                    ]);
                }

                $quantity = (int)$item['quantity'];
                if ($product->current_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Product {$product->product_id} does not have enough stock."],
                    ]);
                }

                $itemTotal = $this->pricingService->calculateItemTotal((float)$product->sell_price, $quantity);
                $orderTotal += $itemTotal;

                $itemsToCreate[] = [
                    'product_id' => $product->product_id,
                    'quantity' => $quantity,
                    'item_total_price' => $itemTotal,
                    'delivery_status' => DeliveryStatus::PENDING,
                ];
            }

            if ($orderTotal > (float)$customer->credit_limit) {
                throw ValidationException::withMessages([
                    'customer_id' => ['Credit limit exceeded for this order.'],
                ]);
            }

            $order = Order::query()->create([
                'customer_id' => $customer->customer_id,
                'total_price' => $orderTotal,
                'due_date' => $data['due_date'],
                'order_status' => OrderStatus::PENDING,
                'is_paid' => false,
            ]);

            $order->items()->createMany($itemsToCreate);
            $this->creditService->debitCustomer($customer, $orderTotal);

            return $order->load(['customer', 'items.product']);
        });
    }

    /**
     * Cancel an order before delivery and restore customer credit.
     */
    public function cancelOrder(Order $order): Order
    {
        return DB::transaction(function () use ($order): Order {
            $order = Order::query()
                ->where('order_id', $order->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($order->order_status === OrderStatus::CANCELLED) {
                throw ValidationException::withMessages([
                    'order_status' => ['Order is already cancelled.'],
                ]);
            }

            $hasDelivered = $order->items()
                ->where('delivery_status', DeliveryStatus::DELIVERED->value)
                ->exists();

            if ($hasDelivered) {
                throw ValidationException::withMessages([
                    'order_status' => ['Delivered orders cannot be cancelled.'],
                ]);
            }

            $order->order_status = OrderStatus::CANCELLED;
            $order->save();

            event(new OrderCancelled($order));

            return $order->load(['customer', 'items.product']);
        });
    }
}
