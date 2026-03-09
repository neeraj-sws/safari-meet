<?php

namespace App\Services\Payment;

class AmountCalculator
{
    public function calculate(float $amount, float $discount): float
    {
        return max($amount - $discount, 0);
    }
}
