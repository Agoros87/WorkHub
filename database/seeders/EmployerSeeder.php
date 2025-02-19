<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Advertisement;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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


        User::factory()->employer()->count(20)->create()->each(function ($user) {
            $user->assignRole('creator');
            Advertisement::factory()->employer()->count(rand(1, 3))->create(['user_id' => $user->id]);
        });
    }
}
