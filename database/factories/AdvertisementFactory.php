<?php

namespace Database\Factories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement(['employer', 'worker']),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'slug' => $this->faker->slug,
            'location' => $this->faker->city,
            'skills' => $this->faker->randomElements(['inglés', 'coctelería', 'vinos', 'cocina', 'atención al cliente'], 2),
            'experience' => $this->faker->randomElement(['Sin experiencia', '1 año', '2 años', '3 años', '5+ años']),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function employer(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'employer',
                'schedule' => $this->faker->randomElement(['Jornada completa', 'Media jornada', 'Fines de semana']),
                'contract_type' => $this->faker->randomElement(['Indefinido', 'Temporal', 'Prácticas']),
                'salary' => $this->faker->randomFloat(2, 1000, 3000),
            ];
        });
    }

    public function worker(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'worker',
                'availability' => $this->faker->randomElement(['Inmediata', 'En 15 días', 'En 1 mes']),
                'salary_expectation' => $this->faker->randomFloat(2, 1000, 3000),
            ];
        });
    }
}
