<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^(\+20|0)1[0125]\d{8}$/';
        if (!preg_match($pattern, $value)) {
            $fail('The ' . $attribute . ' must be a valid Egyptian phone number.');
        }
    }
}
