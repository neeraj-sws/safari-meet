<?php

namespace App\Helpers;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", now()->addHours(1), function () use ($key) {
            return SiteSetting::where('key', $key)->value('value');
        }) ?? $default;
    }
    
    
    public static function formatPrice($amount, $format = 'comma_dot', $decimals = 2)
    {
        $amount = floatval($amount);

        switch ($format) {
            case 'comma_dot':     // 1,234,567.89
                return number_format($amount, $decimals, '.', ',');
            case 'dot_comma':     // 1.234.567,89
                return number_format($amount, $decimals, ',', '.');
            case 'space_comma':   // 1 234 567,89
                return number_format($amount, $decimals, ',', ' ');
            case 'none_dot':      // 1234567.89
                return number_format($amount, $decimals, '.', '');
            case 'none_comma':    // 1234567,89
                return number_format($amount, $decimals, ',', '');
            default:
                return number_format($amount, $decimals, '.', ','); // fallback
        }
    }
}