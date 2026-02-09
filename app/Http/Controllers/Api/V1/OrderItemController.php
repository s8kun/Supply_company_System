<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\DeliveryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use App\Services\OrderItemService;
use Illuminate\Http\JsonResponse;

class OrderItemController extends Controller
{
    /**
     * Inject order item service for delivery workflows.
     */
    public function __construct(private OrderItemService $orderItemService)
    {
    }

    /**
     * List order items with related order and product.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => OrderItemResource::collection(
                OrderItem::with(['order', 'product'])->latest()->paginate(10)
            ),
        ], 200);
    }

    /**
     * Show a single order item with its relations.
     */
    public function show(OrderItem $orderItem): JsonResponse
    {
        $orderItem->load(['order', 'product']);
        return response()->json([
            'status' => 'success',
            'data' => new OrderItemResource($orderItem),
        ], 200);
    }

    /**
     * Update delivery status for an order item.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem): JsonResponse
    {
        $status = DeliveryStatus::from($request->validatedSnake()['delivery_status']);
        $orderItem = $this->orderItemService->updateDeliveryStatus($orderItem, $status);

        return response()->json([
            'status' => 'success',
            'data' => new OrderItemResource($orderItem),
        ], 200);
    }
}
