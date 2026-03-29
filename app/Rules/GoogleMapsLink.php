<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GoogleMapsLink implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $link = preg_match('/^https?:\/\/(www\.)?(google\.com\/maps|maps\.app\.goo\.gl)\/.+$/i', $value);

        if(!$link) $fail('Invalid Google Maps URL.');
    }
}
