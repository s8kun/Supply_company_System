<?php

namespace App\Services;

class PricingService
{
    public function calculateItemTotal(float $sellPrice, int $quantity): float
    {
        return round($sellPrice * $quantity, 2);
    }
}
