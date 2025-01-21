<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'description' => 'Administrador con permisos completos',
            ],
            [
                'name' => 'creator',
                'guard_name' => 'web',
                'description' => 'Creador con permisos limitados',
            ],
            [
                'name' => 'guest',
                'guard_name' => 'web',
                'description' => 'Invitado con acceso solo de lectura',
            ],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'guard_name' => $role['guard_name'],
                'description' => $role['description'],
            ]);
        }
    }
}
