<?php

namespace App\Services\Payment;

class QrCodeGenerator
{
    protected PaymentSettingsProvider $settings;

    public function __construct(PaymentSettingsProvider $settings)
    {
        $this->settings = $settings;
    }

    public function generate(float $amount, string $message): string
    {
        $upiUrl = "upi://pay?" . http_build_query([
            'pa' => $this->settings->getUpiId(),
            'pn' => $this->settings->getMerchantName(),
            'am' => number_format($amount, 2, '.', ''),
            'cu' => 'INR',
            'tn' => $message,
        ]);

        return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($upiUrl);
    }
}
