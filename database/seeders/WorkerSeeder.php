<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Factories\WorkerAdvertisementFactory;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario worker de prueba
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
        WorkerAdvertisementFactory::new()->count(1)->create(['user_id' => $worker->id]);

        // Crear workers aleatorios
        User::factory()->worker()->count(30)->create()->each(function ($user) {
            WorkerAdvertisementFactory::new()->count(rand(1, 2))->create(['user_id' => $user->id]);
        });
    }
}
