<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFavoriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notes' => 'nullable|string|max:150',
            'priority' => 'nullable|in:high,medium,low',
        ];
    }

    public function messages(): array
    {
        return [
            'notes.string' => 'Las notas deben ser texto',
            'notes.max' => 'Las notas no pueden exceder los 150 caracteres',
            'priority.in' => 'La prioridad debe ser alta, media o baja',
        ];
    }
}
