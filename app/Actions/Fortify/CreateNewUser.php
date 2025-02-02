<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        // Validar los datos de entrada
        $this->validateInput($input);

        return $this->createUser($input);
    }

    protected function validateInput(array $input): void
    {
        $rules = [
            'type' => ['required', 'string', 'in:worker,employer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
        ];

        // Reglas específicas según el tipo de usuario
        if ($input['type'] === 'worker') {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['lastname'] = ['required', 'string', 'max:255'];
            $rules['date_of_birth'] = ['required', 'date', 'before_or_equal:' . now()->subYears(16)->toDateString()];
            $rules['gender'] = ['required', 'string', 'in:male,female,other'];
        } else {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['tax_id'] = ['required', 'string', 'max:20'];
        }

        Validator::make($input, $rules)->validate();
    }

    protected function createUser(array $input): User
    {
        $userData = [
            'type' => $input['type'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'city' => $input['city'],
        ];

        if ($input['type'] === 'worker') {
            $userData['name'] = $input['name'];
            $userData['lastname'] = $input['lastname'];
            $userData['date_of_birth'] = $input['date_of_birth'];
            $userData['gender'] = $input['gender'];
        } else {
            $userData['company_name'] = $input['company_name'];
            $userData['tax_id'] = $input['tax_id'];
        }

        $user = User::create($userData);
        
        // Asignar rol creator directamente
        $role = Role::where('name', 'creator')->firstOrFail();
        $user->assignRole($role);

        return $user;
    }
}
