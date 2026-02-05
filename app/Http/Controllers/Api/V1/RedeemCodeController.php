<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedeemCodeRequest;
use App\Http\Requests\StoreRedeemCodeRequest;
use App\Models\Customer;
use App\Services\RedeemCodeService;
use Illuminate\Http\JsonResponse;

class RedeemCodeController extends Controller
{
    public function __construct(private RedeemCodeService $redeemCodeService)
    {
    }

    /**
     * Store a newly created redeem code.
     */
    public function store(StoreRedeemCodeRequest $request): JsonResponse
    {
        $data = $request->validated();
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
     * Redeem a code to increase customer credit.
     */
    public function redeem(RedeemCodeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $customer = Customer::query()->findOrFail($data['customerID']);
        $redeemCode = $this->redeemCodeService->redeemCode($customer, $data['code']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'code' => $redeemCode->code,
                'amount' => $redeemCode->amount,
                'usedAt' => $redeemCode->usedAt,
                'usedByCustomerID' => $redeemCode->usedByCustomerID,
            ],
        ], 200);
    }
}
