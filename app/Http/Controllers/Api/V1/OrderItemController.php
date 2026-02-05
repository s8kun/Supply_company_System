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
    public function __construct(private OrderItemService $orderItemService)
    {
    }

    /**
     * Display a listing of the resource.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem): JsonResponse
    {
        $status = DeliveryStatus::from($request->validated()['deliveryStatus']);
        $orderItem = $this->orderItemService->updateDeliveryStatus($orderItem, $status);

        return response()->json([
            'status' => 'success',
            'data' => new OrderItemResource($orderItem),
        ], 200);
    }
}
