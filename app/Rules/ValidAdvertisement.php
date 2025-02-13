<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAdvertisement implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return;
        }

        $type = $user->type;

        if ($type === 'employer') {
            if (in_array($attribute, ['contract_type', 'salary', 'schedule']) && $value === null) {
                $fail('El campo ' . $attribute . ' es requerido para empleadores.');
            }
        }

        if ($type === 'worker') {
            if (in_array($attribute, ['salary_expectation', 'availability']) && $value === null) {
                $fail('El campo ' . $attribute . ' es requerido para trabajadores.');
            }
        }
    }
}
