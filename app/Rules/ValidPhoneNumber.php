<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhoneNumber implements ValidationRule
{
    /**
     * Validate the given attribute.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        
        if (!preg_match('/^[789]\d{9}$/', $value)) {
            $fail('The :attribute must be a valid 10-digit Indian mobile number.');
        }
    }
}
