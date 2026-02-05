<?php

namespace App\Services;

class PricingService
{
    /**
     * Calculate total price for a line item.
     */
    public function calculateItemTotal(float $sellPrice, int $quantity): float
    {
        return round($sellPrice * $quantity, 2);
    }
}
