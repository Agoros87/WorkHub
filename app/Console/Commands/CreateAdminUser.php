<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Crea un nuevo usuario administrador';

    public function handle()
    {
        $name = $this->ask('Nombre del administrador');
        $email = $this->ask('Email del administrador');
        $password = $this->secret('Contraseña');
        $confirmPassword = $this->secret('Confirmar contraseña');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($password !== $confirmPassword) {
            $this->error('Las contraseñas deben de ser iguales');

            return 1;
        }

        if ($validator->fails()) {
            $this->error('Errores de validación:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $adminRole = Role::firstOrCreate(['name' => 'admin']);

            $user->assignRole($adminRole);

            $this->info('Usuario administrador creado exitosamente');

            return 0;
        } catch (\Exception $e) {
            $this->error('Error al crear el usuario: '.$e->getMessage());

            return 1;
        }
    }
}
