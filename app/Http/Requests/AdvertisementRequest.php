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

            // Campos condicionales para empleador
            'schedule' => 'required_if:type,employer|string|max:255|nullable',
            'contract_type' => 'required_if:type,employer|string|max:255|nullable',
            'salary' => 'nullable|numeric|min:0|prohibited_if:type,worker',

            // Campos condicionales para trabajador
            'availability' => 'required_if:type,worker|string|max:255|nullable',
            'salary_expectation' => 'nullable|numeric|min:0|prohibited_if:type,employer',
        ];

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
