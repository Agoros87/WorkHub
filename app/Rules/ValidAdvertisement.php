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
                                //in_array($value, $array); le pasas el valor y el array
        if ($type === 'employer') {  //comprueba si esta el campo del request en el array y si es null

            if (in_array($attribute, ['contract_type', 'salary', 'schedule']) && $value === null) {
                $fail('El campo '.$attribute.' es requerido para empleadores.');
            }
        }

        if ($type === 'worker') {
            if (in_array($attribute, ['salary_expectation', 'availability']) && $value === null) {
                $fail('El campo '.$attribute.' es requerido para trabajadores.');
            }
        }
    }
}
