<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\RedeemCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RedeemCodeService
{
    /**
     * Inject credit service for balance top-ups.
     */
    public function __construct(private CreditService $creditService)
    {
    }

    /**
     * Create a redeem code with a fixed amount.
     */
    public function createCode(float $amount, ?string $code = null): RedeemCode
    {
        $codeValue = $code ?: $this->generateUniqueCode();

        return RedeemCode::query()->create([
            'code' => $codeValue,
            'amount' => $amount,
        ]);
    }

    /**
     * Redeem a single-use code and add its amount to customer credit.
     */
    public function redeemCode(Customer $customer, string $code): RedeemCode
    {
        return DB::transaction(function () use ($customer, $code): RedeemCode {
            $redeemCode = RedeemCode::query()
                ->where('code', $code)
                ->lockForUpdate()
                ->first();

            if (!$redeemCode) {
                throw ValidationException::withMessages([
                    'code' => ['Invalid redeem code.'],
                ]);
            }

            if ($redeemCode->isUsed) {
                throw ValidationException::withMessages([
                    'code' => ['Redeem code already used.'],
                ]);
            }

            $customer = Customer::query()
                ->where('customerID', $customer->customerID)
                ->lockForUpdate()
                ->firstOrFail();

            $redeemCode->isUsed = true;
            $redeemCode->usedAt = now();
            $redeemCode->usedByCustomerID = $customer->customerID;
            $redeemCode->save();

            $this->creditService->creditCustomer($customer, (float) $redeemCode->amount);

            return $redeemCode->fresh();
        });
    }

    /**
     * Generate a short unique code for vouchers.
     */
    private function generateUniqueCode(): string
    {
        $attempts = 0;
        do {
            $attempts++;
            $code = Str::upper(Str::random(12));
            $exists = RedeemCode::query()->where('code', $code)->exists();
        } while ($exists && $attempts < 5);

        if ($exists) {
            throw ValidationException::withMessages([
                'code' => ['Failed to generate a unique code.'],
            ]);
        }

        return $code;
    }
}
