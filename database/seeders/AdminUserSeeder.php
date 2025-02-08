<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Crear el rol si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear usuario admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]
        );

        // Asignarle el rol de admin
        $admin->assignRole($adminRole);
    }
}
