<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployerAdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        $user = User::factory()->employer()->create();
        $skill = $this->faker->randomElement($this->availableSkills());
        $title = "Se busca $skill con experiencia";

        return [
            'user_id' => $user->id,
            'type' => 'employer',
            'title' => $title,
            'description' => $this->generateDescription($skill),
            'slug' => Str::slug($title.'-'.Str::random(6)),
            'location' => fake()->randomElement(config('locations')),
            'skills' => [$skill],
            'experience' => $this->faker->randomElement(['Sin experiencia', '1 año', '2 años', '3 años', '+5 años']),
            'schedule' => $this->faker->randomElement(['Jornada completa', 'Media jornada', 'Fines de semana']),
            'contract_type' => $this->faker->randomElement(['Indefinido', 'Temporal 6 meses', 'Temporal 3 meses']),
            'salary' => $this->faker->randomFloat(2, 1100, 2200),
            'expiration_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    private function generateDescription(string $skill): string
    {
        $descriptions = $this->skillDescriptions();
        $baseDesc = $descriptions[$skill] ?? 'Descripción no disponible.';

        return "Importante establecimiento de hostelería necesita incorporar $skill. $baseDesc";
    }

    private function availableSkills(): array
    {
        return [
            'Camarero de barra', 'Camarero de sala', 'Ayudante de camarero',
            'Barman / Coctelero', 'Camarero de eventos', 'Barista',
            'Encargado de sala', 'Personal de catering',
        ];
    }

    private function skillDescriptions(): array
    {
        return [
            'Camarero de barra' => 'Experiencia en preparación de bebidas, manejo de TPV y atención al cliente desde barra. Capacidad para trabajar en equipo y en momentos de alta presión.',
            'Camarero de sala' => 'Experiencia en servicio de mesas, protocolo de servicio, y atención personalizada al cliente. Buena presencia y habilidades comunicativas.',
            'Ayudante de camarero' => 'Apoyo en el servicio de sala y barra, mantenimiento del área de trabajo, preparación de mise en place.',
            'Barman / Coctelero' => 'Especialista en preparación de cócteles clásicos y creativos, conocimiento de destilados y servicio de bebidas premium.',
            'Camarero de eventos' => 'Experiencia en bodas, eventos corporativos y celebraciones. Capacidad de adaptación y trabajo en equipo.',
            'Barista' => 'Especialista en preparación de café, conocimiento de diferentes métodos de extracción y presentación.',
            'Encargado de sala' => 'Gestión de equipo, organización de turnos, control de stock y atención al cliente. Capacidad de liderazgo.',
            'Personal de catering' => 'Experiencia en montaje de buffets, servicio de banquetes y eventos especiales.',
        ];
    }
}
