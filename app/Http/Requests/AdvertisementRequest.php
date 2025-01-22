<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'type' => 'required|in:employer,worker',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
            'experience' => 'nullable|string|max:255',
        ];

        // Reglas específicas para anuncios de empleador
        if ($this->type === 'employer') {
            $rules = array_merge($rules, [
                'schedule' => 'required|string|max:255',
                'contract_type' => 'required|string|max:255',
                'salary' => 'nullable|numeric|min:0',
            ]);
        }

        // Reglas específicas para anuncios de trabajador
        if ($this->type === 'worker') {
            $rules = array_merge($rules, [
                'availability' => 'required|string|max:255',
                'salary_expectation' => 'nullable|numeric|min:0',
            ]);
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
