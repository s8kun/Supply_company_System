<?php

namespace App\Services;

use App\Enums\DeliveryStatus;
use App\Enums\OrderStatus;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderItemService
{
    public function __construct(private ReorderNoticeService $reorderNoticeService)
    {
    }

    public function updateDeliveryStatus(OrderItem $orderItem, DeliveryStatus $status): OrderItem
    {
        return DB::transaction(function () use ($orderItem, $status): OrderItem {
            $orderItem->refresh();

            if ($orderItem->order && $orderItem->order->orderStatus === OrderStatus::CANCELLED) {
                throw ValidationException::withMessages([
                    'deliveryStatus' => ['Cannot deliver items for a cancelled order.'],
                ]);
            }

            if ($orderItem->deliveryStatus === DeliveryStatus::DELIVERED) {
                throw ValidationException::withMessages([
                    'deliveryStatus' => ['Order item is already delivered.'],
                ]);
            }

            if ($status !== DeliveryStatus::DELIVERED) {
                throw ValidationException::withMessages([
                    'deliveryStatus' => ['Only transition to delivered is allowed.'],
                ]);
            }

            $product = Product::query()
                ->where('productID', $orderItem->productID)
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->currentQuantity < $orderItem->quantity) {
                throw ValidationException::withMessages([
                    'deliveryStatus' => ['Not enough stock to deliver this item.'],
                ]);
            }

            $product->currentQuantity = $product->currentQuantity - $orderItem->quantity;
            $product->save();
            $this->reorderNoticeService->createIfNeeded($product);

            $orderItem->deliveryStatus = $status;
            $orderItem->save();

            $order = $orderItem->order()->lockForUpdate()->first();
            if ($order) {
                $hasPending = $order->items()
                    ->where('deliveryStatus', '!=', DeliveryStatus::DELIVERED->value)
                    ->exists();

                if (!$hasPending) {
                    $order->orderStatus = OrderStatus::COMPLETED;
                    $order->save();
                }
            }

            return $orderItem->load(['order', 'product']);
        });
    }
}
