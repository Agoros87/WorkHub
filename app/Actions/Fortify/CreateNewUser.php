<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateNewUserRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        $request = app(CreateNewUserRequest::class); // Uso el contenedor de servicios de Laravel para inyectar las dependencias necesarias como el validador, el traductor, etc.
        $request->replace($input);
        $request->validateResolved();

        return $this->createUser($request->validated());
    }

    protected function createUser(array $input): User
    {
        $userData = $this->buildUserData($input);
        $user = User::create($userData);

        $this->assignCreatorRole($user);

        return $user;
    }

    private function buildUserData(array $input): array
    {
        $userData = [
            'type' => $input['type'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'location' => $input['location'],
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

        return $userData;
    }

    public function assignCreatorRole(User $user): void
    {
        // Asignar rol creator directamente
        $role = Role::where('name', 'creator')->firstOrFail();
        $user->assignRole($role);

    }
}
