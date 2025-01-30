<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'city' => 'Test City',
            'date_of_birth' => '1990-01-01',
            'gender' => 'other',
        ]);

        $this->call(RoleSeeder::class);
    }
}
