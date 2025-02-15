<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Jetstream\Jetstream;
use App\Actions\Fortify\PasswordValidationRules;

class CreateNewUserRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'type' => ['required', 'string', 'in:worker,employer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'phone' => ['required', 'string', 'max:20'],
            'location' => ['required'],
        ];

        // Reglas específicas según el tipo de usuario
        if ($this->input('type') === 'worker') {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['lastname'] = ['required', 'string', 'max:255'];
            $rules['date_of_birth'] = ['required', 'date', 'before_or_equal:' . now()->subYears(16)->toDateString()];
            $rules['gender'] = ['required', 'string', 'in:male,female,other'];
        } else {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['tax_id'] = ['required', 'string', 'max:20'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'El tipo de usuario es requerido.',
            'type.in' => 'El tipo de usuario debe ser trabajador o empleador.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es requerida.',
            'terms.accepted' => 'Debes aceptar los términos y condiciones.',
            'phone.required' => 'El teléfono es requerido.',
            'phone.max' => 'El teléfono no puede tener más de :max caracteres.',
            'location.required' => 'La ubicación es requerida.',
            'name.required' => 'El nombre es requerido.',
            'lastname.required' => 'El apellido es requerido.',
            'date_of_birth.required' => 'La fecha de nacimiento es requerida.',
            'date_of_birth.before_or_equal' => 'Debes tener al menos 16 años.',
            'gender.required' => 'El género es requerido.',
            'gender.in' => 'El género seleccionado no es válido.',
            'company_name.required' => 'El nombre de la empresa es requerido.',
            'tax_id.required' => 'El identificador fiscal es requerido.',
            'tax_id.max' => 'El identificador fiscal no puede tener más de :max caracteres.',
        ];
    }
}
