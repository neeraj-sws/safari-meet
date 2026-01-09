<?php

namespace App\Services\Payment;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    public function apply(string $code, float $amount): array
    {
        $coupon = Coupon::where('coupon_code', $code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Invalid coupon code',
            ];
        }

        if ($coupon->start_date && Carbon::now()->lt(
            Carbon::parse($coupon->start_date)->startOfDay()
        )) {
            return [
                'valid' => false,
                'message' => 'Coupon is not active yet',
            ];
        }
        if ($coupon->end_date && Carbon::now()->gt(
            Carbon::parse($coupon->end_date)->endOfDay()
        )) {
            return [
                'valid' => false,
                'message' => 'Coupon expired',
            ];
        }

        // if ($amount < $coupon->min_amount) {
        //     return [
        //         'valid' => false,
        //         'message' => 'Coupon not applicable for this amount',
        //     ];
        // }

        $discount = $coupon->amount;

        return [
            'valid' => true,
            'discount' => $discount,
            'message' => 'Coupon applied successfully',
        ];
    }
}
