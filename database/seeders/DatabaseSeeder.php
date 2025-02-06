<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        User::factory()->create([
            'name' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'city' => 'Test City',
            'date_of_birth' => '1990-01-01',
            'gender' => 'other',
        ]);
    }
}
