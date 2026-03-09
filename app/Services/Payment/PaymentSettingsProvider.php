<?php

namespace App\Services\Payment;

use App\Helpers\SettingHelper;

class PaymentSettingsProvider
{
    public function getUpiId(): string
    {
        return SettingHelper::get('UPI_ID');
    }

    public function getMerchantName(): string
    {
        return SettingHelper::get('UPI_MERCHANT_NAME');
    }
}
