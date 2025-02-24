<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\EmployerAdvertisementFactory;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear empleador de prueba
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
        EmployerAdvertisementFactory::new()->count(1)->create(['user_id' => $employer->id]);

        // Crear empleadores aleatorios
        User::factory()->employer()->count(20)->create()->each(function ($user) {
            EmployerAdvertisementFactory::new()->count(rand(1, 3))->create(['user_id' => $user->id]);
        });
    }
}
