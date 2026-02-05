<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    /**
     * Inject customer service for create workflows.
     */
    public function __construct(private CustomerService $customerService)
    {
    }

    /**
     * List customers with pagination.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => CustomerResource::collection(Customer::query()->paginate(10))
        ], 200);
    }

    /**
     * Create a new customer.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->createNewCustomer($request, new Customer());
        return response()->json([
            'status' => 'success',
            'data' => new CustomerResource($customer)
        ], 201);
    }

    /**
     * Show a single customer.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new CustomerResource($customer)
        ], 200);
    }

    /**
     * Update customer details.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new CustomerResource($customer)
        ], 200);
    }

    /**
     * Delete a customer record.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'status' => 'success',
            'data' => null
        ], 204);
    }
}
