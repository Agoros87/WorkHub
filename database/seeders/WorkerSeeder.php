<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Advertisement;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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


        User::factory()->worker()->count(30)->create()->each(function ($user) {
            $user->assignRole('creator');
            Advertisement::factory()->worker()->count(rand(1, 2))->create(['user_id' => $user->id]);
        });
    }
}
