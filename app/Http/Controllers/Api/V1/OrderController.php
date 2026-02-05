<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    /**
     * List orders with related customer and items.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Order::with(['customer', 'items.product'])->latest()->paginate(5),
        ],
            200);
    }

    /**
     * Place a new order using validated items and credit checks.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->placeOrder($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ], 201);
    }

    /**
     * Show a single order with related customer and items.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);
        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ], 200);
    }

    /**
     * Update order fields such as due date or payment flag.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        $order->load(['customer', 'items.product']);
        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ], 200);
    }

    /**
     * Cancel an order before delivery and restore customer credit.
     */
    public function cancel(Order $order): JsonResponse
    {
        $order = $this->orderService->cancelOrder($order);

        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ], 200);
    }

    /**
     * Delete an order record.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully',
        ], 200);
    }
}
