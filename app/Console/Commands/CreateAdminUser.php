<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
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

        if ($password !== $confirmPassword) {
            $this->error('Las contraseñas deben de ser iguales');
            return 1;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $user->assignRole($adminRole);
            }

            $this->info('Usuario administrador creado exitosamente');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error al crear el usuario: ' . $e->getMessage());
            return 1;
        }
    }
}
