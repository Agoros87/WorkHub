<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['employer', 'worker']);
        $skill= $this->faker->randomElement($this->availableSkill());
        $title = $this->generateTitle($type, $skill);
        $description = $this->generateDescription($type, $skill);

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'slug' => $this->generateSlug($title),
            'location' => fake()->randomElement(config('locations')),
            'skills' => [$skill],
            'experience' => $this->faker->randomElement(['Sin experiencia', '1 año', '2 años', '3 años', '+5 años']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function generateTitle(string $type, string $skill): string
    {
        return $type === 'employer'
            ? "Se busca $skill con experiencia"
            : "Disponible como $skill";
    }

    private function generateDescription(string $type, string $skill): string
    {
        $descriptions = $this->skillsAndDescriptions();
        $baseDesc = $descriptions[$skill] ?? 'Descripción no disponible.';

        return $type === 'employer'
            ? "Importante establecimiento de hostelería necesita incorporar $skill. $baseDesc"
            : "Profesional con experiencia como $skill. $baseDesc";
    }

    private function generateSlug(string $title): string
    {
        return Str::slug($title . '-' . Str::random(6));
    }

    private function availableSkill(): array
    {
        return [
            'Camarero de barra', 'Camarero de sala', 'Ayudante de camarero',
            'Barman / Coctelero', 'Camarero de eventos', 'Barista',
            'Encargado de sala', 'Personal de catering'
        ];
    }

    private function skillsAndDescriptions(): array
    {
        return [
            'Camarero de barra' => 'Experiencia en preparación de bebidas, manejo de TPV y atención al cliente desde barra. Capacidad para trabajar en equipo y en momentos de alta presión.',
            'Camarero de sala' => 'Experiencia en servicio de mesas, protocolo de servicio, y atención personalizada al cliente. Buena presencia y habilidades comunicativas.',
            'Ayudante de camarero' => 'Apoyo en el servicio de sala y barra, mantenimiento del área de trabajo, preparación de mise en place.',
            'Barman / Coctelero' => 'Especialista en preparación de cócteles clásicos y creativos, conocimiento de destilados y servicio de bebidas premium.',
            'Camarero de eventos' => 'Experiencia en bodas, eventos corporativos y celebraciones. Capacidad de adaptación y trabajo en equipo.',
            'Barista' => 'Especialista en preparación de café, conocimiento de diferentes métodos de extracción y presentación.',
            'Encargado de sala' => 'Gestión de equipo, organización de turnos, control de stock y atención al cliente. Capacidad de liderazgo.',
            'Personal de catering' => 'Experiencia en montaje de buffets, servicio de banquetes y eventos especiales.'
        ];
    }

    public function employer(): static
    {
        return $this->state(fn () => [
            'type' => 'employer',
            'schedule' => $this->faker->randomElement(['Jornada completa', 'Media jornada', 'Fines de semana']),
            'contract_type' => $this->faker->randomElement(['Indefinido', 'Temporal 6 meses', 'Temporal 3 meses']),
            'salary' => $this->faker->randomFloat(2, 1100, 2200),
        ]);
    }

    public function worker(): static
    {
        return $this->state(fn () => [
            'type' => 'worker',
            'availability' => $this->faker->randomElement(['Inmediata', 'En 15 días', 'En 1 mes']),
            'salary_expectation' => $this->faker->randomFloat(2, 1100, 2200),
        ]);
    }
}
