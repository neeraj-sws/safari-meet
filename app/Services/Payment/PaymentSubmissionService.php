<?php

namespace App\Services\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageUploadHelper;

class PaymentSubmissionService
{
    public function submit(
        object $payable,
        string $type,
        float $amount,
        ?string $utr,
        $screenshot,
        ?float $discounted_amount,
        float $final_amount,
        ?string $coupon_code,
    ): Payment {
        $path = $screenshot
            ? ImageUploadHelper::upload($screenshot, 'uploads/payments')
            : null;

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'payable_type' => get_class($payable),
            'payable_id' => $payable->id,
            'amount' => $amount,
            'utr' => $utr,
            'screenshot' => $path,
            'discounted_amount' => $discounted_amount,
            'final_amount' => $final_amount,
            'coupon_code' => $coupon_code,
        ]);

        $payable->update(['is_paid' => 1]);

        return $payment;
    }
}
