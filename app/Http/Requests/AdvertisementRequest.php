<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        if ($this->has('skills')) {
            $skills = $this->input('skills');
            if (is_string($skills)) {
                $skills = array_map('trim', explode(',', $skills));
            }
            $this->merge(['skills' => $skills]);
        }
    }
    public function rules(): array
    {
        $isAdmin = auth()->user()->hasRole('admin');
        $type = $this->input('type');

        $rules = [
            'type' => 'required|in:employer,worker',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
            'experience' => 'nullable|string|max:255',
        ];

        if ($isAdmin) {
            $rules += [
                'schedule' => 'nullable|string|max:255',
                'contract_type' => 'nullable|string|max:255',
                'salary' => 'nullable|numeric|min:0',
                'availability' => 'nullable|string|max:255',
                'salary_expectation' => 'nullable|numeric|min:0',
            ];
        } else {
            if ($type === 'employer') {
                $rules += [
                    'schedule' => 'required|string|max:255',
                    'contract_type' => 'required|string|max:255',
                    'salary' => 'nullable|numeric|min:0',
                ];
            } else {
                $rules += [
                    'availability' => 'required|string|max:255',
                    'salary_expectation' => 'nullable|numeric|min:0',
                ];
            }
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
