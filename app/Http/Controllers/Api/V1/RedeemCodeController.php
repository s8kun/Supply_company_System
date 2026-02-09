<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedeemCodeRequest;
use App\Http\Requests\StoreRedeemCodeRequest;
use App\Models\Customer;
use App\Models\User;
use App\Services\RedeemCodeService;
use Illuminate\Http\JsonResponse;

class RedeemCodeController extends Controller
{
    /**
     * Inject redeem code service for voucher workflows.
     */
    public function __construct(private RedeemCodeService $redeemCodeService)
    {
    }

    /**
     * Create a new redeem code with a fixed amount.
     */
    public function store(StoreRedeemCodeRequest $request): JsonResponse
    {
        $data = $request->validatedSnake();
        $redeemCode = $this->redeemCodeService->createCode(
            (float) $data['amount'],
            $data['code'] ?? null
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'code' => $redeemCode->code,
                'amount' => $redeemCode->amount,
            ],
        ], 201);
    }

    /**
     * Redeem a code and top up customer credit.
     */
    public function redeem(RedeemCodeRequest $request): JsonResponse
    {
        $data = $request->validatedSnake();
        $user = $request->user();

        if ($user && $user->role === User::ROLE_CUSTOMER) {
            if (!$user->customer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No customer profile linked to this account.',
                ], 403);
            }
            $customer = $user->customer;
        } else {
            $customer = Customer::query()->findOrFail($data['customer_id']);
        }

        $redeemCode = $this->redeemCodeService->redeemCode($customer, $data['code']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'code' => $redeemCode->code,
                'amount' => $redeemCode->amount,
                'usedAt' => $redeemCode->used_at,
                'usedByCustomerId' => $redeemCode->used_by_customer_id,
            ],
        ], 200);
    }
}
