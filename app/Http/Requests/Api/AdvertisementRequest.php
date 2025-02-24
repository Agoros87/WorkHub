<?php

namespace App\Http\Requests\Api;

/**
 * @group Requests
 *
 * Request para validación de anuncios de trabajo en hostelería
 */
use App\Rules\ValidAdvertisement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvertisementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para anuncios
     *
     * @return array<string, array<int, string|Rule|ValidAdvertisement>>
     */
    public function rules(): array
    {
        return [
            'title' => [new ValidAdvertisement, 'required', 'string', 'max:255'],
            'description' => [new ValidAdvertisement, 'required', 'string'],
            'location' => [new ValidAdvertisement, 'required', 'string', 'max:255'],
            'skills' => [new ValidAdvertisement, 'required', 'array'],
            'skills.*' => [new ValidAdvertisement, 'string', 'max:255'],
            'experience' => [new ValidAdvertisement, 'required', 'string', 'max:255'],
            'schedule' => [new ValidAdvertisement, 'string', 'max:255'],
            'contract_type' => [new ValidAdvertisement, 'string', 'max:255'],
            'availability' => [new ValidAdvertisement, 'string', 'max:255'],
            'salary' => [new ValidAdvertisement, 'numeric', 'min:0'],
            'salary_expectation' => [new ValidAdvertisement, 'numeric', 'min:0'],
        ];
    }

    /**
     * Mensajes de error personalizados para las reglas de validación
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.max' => 'El título no puede tener más de 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'location.required' => 'La ubicación es obligatoria',
            'location.in' => 'La ubicación debe ser una ubicación válida',
            'skills.required' => 'Las habilidades son obligatorias',
            'skills.array' => 'Las habilidades deben ser un array',
            'skills.*.in' => 'Todas las habilidades deben ser válidas',
            'experience.max' => 'La experiencia no puede tener más de 255 caracteres',
            'schedule.max' => 'El horario no puede tener más de 255 caracteres',
            'contract_type.max' => 'El tipo de contrato no puede tener más de 255 caracteres',
            'salary.numeric' => 'El salario debe ser un número',
            'salary.min' => 'El salario debe ser mayor o igual a 0',
            'availability.max' => 'La disponibilidad no puede tener más de 255 caracteres',
            'salary_expectation.numeric' => 'La expectativa salarial debe ser un número',
            'salary_expectation.min' => 'La expectativa salarial debe ser mayor o igual a 0',
        ];
    }
}
