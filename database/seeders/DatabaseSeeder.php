<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Advertisement;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminUserSeeder::class);

        // Usuario trabajador para pruebas
        $worker = User::factory()->worker()->create([
            'name' => 'Pepe',
            'lastname' => 'User',
            'email' => 'pepe@mail.es',
            'phone' => '12345678',
            'location' => 'Murcia',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $worker->assignRole('creator');
        Advertisement::factory()->worker()->create(['user_id' => $worker->id]);

        // Usuario empleador para pruebas
        $employer = User::factory()->employer()->create([
            'company_name' => 'Pepitos SL',
            'email' => 'pepito@mail.es',
            'phone' => '12345678',
            'location' => 'Murcia',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'tax_id' => '12345678A',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $employer->assignRole('creator');
        Advertisement::factory()->employer()->create(['user_id' => $employer->id]);

        // Crear usuarios empleadores y sus anuncios
        User::factory()->employer()->count(20)->create()
            ->each(function ($user) {
                $user->assignRole('creator');
                Advertisement::factory()->employer()
                    ->count(rand(1, 3))
                    ->create(['user_id' => $user->id]);
            });

        // Crear usuarios trabajadores y sus anuncios
        User::factory()->worker()->count(30)->create()
            ->each(function ($user) {
                $user->assignRole('creator');
                Advertisement::factory()->worker()
                    ->count(rand(1, 2))
                    ->create(['user_id' => $user->id]);
            });
    }
}
