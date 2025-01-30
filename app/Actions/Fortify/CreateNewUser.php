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

        // Verificar que el rol exista y no sea "admin"
        $this->validateRole($input['role']);

        // Crear el usuario
        $user = $this->createUser($input);

        // Asignar el rol al usuario
        $this->assignRole($user, $input['role']);
        return $user;
    }

    protected function validateInput(array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(16)->toDateString()],
            'gender' => ['required', 'string', 'in:male,female,other'],
            'role' => ['required', 'string'],
        ])->validate();
    }

    protected function validateRole(string $roleName): void
    {
        // Verificar que el rol exista
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            throw ValidationException::withMessages([
                'role' => 'El rol especificado no existe.',
            ]);
        }

        // Verificar que el rol no sea "admin"
        if ($roleName === 'admin') {
            throw ValidationException::withMessages([
                'role' => 'No se permite asignar el rol de admin.',
            ]);
        }
    }

    protected function createUser(array $input): User
    {
        return User::create([
            'name' => $input['name'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'city' => $input['city'],
            'date_of_birth' => $input['date_of_birth'],
            'gender' => $input['gender'],
        ]);
    }

    protected function assignRole(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $user->assignRole($role);
    }
}
