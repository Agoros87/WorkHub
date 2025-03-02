<?php

namespace App\Actions\Fortify;

use App\Http\Requests\CreateNewUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User //No admite form request porque no recibe la solicitud HTTP completa sino solo los datos del formulario
    {                                               //Funcion global para acceder al contenedor de servicios de Laravel
        $request = app(CreateNewUserRequest::class); // Uso el contenedor de servicios de Laravel para inyectar
                                                            // las dependencias necesarias como el validador, el traductor, etc.
        $request->replace($input); // Le proprociono manualmente los datos que se validarían como si vinieran de una solicitud HTTP real.
        $request->validateResolved(); // Valido los datos manualmente con el validador de Laravel.

        return $this->createUser($request->validated()); // Creo el usuario con los datos validados.
    }

    protected function createUser(array $input): User
    {
        $userData = $this->buildUserData($input);
        $user = User::create($userData);

        $this->assignCreatorRole($user);

        $user->sendEmailVerificationNotification();

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
