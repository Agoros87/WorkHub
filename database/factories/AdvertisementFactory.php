<?php

namespace Database\Factories;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['employer', 'worker']),
            'title' => function (array $attributes) {
                $puestos = [
                    'Camarero de barra', 'Camarero de sala', 'Ayudante de camarero',
                    'Barman / Coctelero', 'Camarero de eventos', 'Barista',
                    'Encargado de sala', 'Personal de catering'
                ];
                $puesto = $this->faker->randomElement($puestos);
                return $attributes['type'] === 'employer'
                    ? "Se busca $puesto con experiencia"
                    : "Disponible como $puesto";
            },
            'description' => function (array $attributes) {
                $puestos = [
                    'Camarero de barra' => 'Experiencia en preparación de bebidas, manejo de TPV y atención al cliente desde barra. Capacidad para trabajar en equipo y en momentos de alta presión.',
                    'Camarero de sala' => 'Experiencia en servicio de mesas, protocolo de servicio, y atención personalizada al cliente. Buena presencia y habilidades comunicativas.',
                    'Ayudante de camarero' => 'Apoyo en el servicio de sala y barra, mantenimiento del área de trabajo, preparación de mise en place.',
                    'Barman / Coctelero' => 'Especialista en preparación de cócteles clásicos y creativos, conocimiento de destilados y servicio de bebidas premium.',
                    'Camarero de eventos' => 'Experiencia en bodas, eventos corporativos y celebraciones. Capacidad de adaptación y trabajo en equipo.',
                    'Barista' => 'Especialista en preparación de café, conocimiento de diferentes métodos de extracción y presentación.',
                    'Encargado de sala' => 'Gestión de equipo, organización de turnos, control de stock y atención al cliente. Capacidad de liderazgo.',
                    'Personal de catering' => 'Experiencia en montaje de buffets, servicio de banquetes y eventos especiales.'
                ];
                $puesto = explode(' con experiencia', $attributes['title'])[0];
                $puesto = explode('Disponible como ', $puesto)[0];
                $puesto = trim($puesto);
                $baseDesc = $puestos[$puesto] ?? '';

                return $attributes['type'] === 'employer'
                    ? "Importante establecimiento de hostelería necesita incorporar $puesto. $baseDesc"
                    : "Profesional con experiencia como $puesto. $baseDesc";
            },
            'slug' => $this->faker->slug,
            'location' => function (array $attributes) {
                $user = User::find($attributes['user_id']);
                return $user ? $user->city : fake()->randomElement(config('locations'));
            },
            'skills' => [$this->faker->randomElement([
                'Camarero de barra', 'Camarero de sala', 'Ayudante de camarero',
                'Barman / Coctelero', 'Camarero de eventos', 'Barista',
                'Encargado de sala', 'Personal de catering'
            ])],
            'experience' => $this->faker->randomElement(['Sin experiencia', '1 año', '2 años', '3 años', '+5 años']),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function employer(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'employer',
                'schedule' => $this->faker->randomElement(['Jornada completa', 'Media jornada', 'Fines de semana', 'Turnos rotativos', 'Turno de mañana', 'Turno de tarde', 'Turno de noche']),
                'contract_type' => $this->faker->randomElement(['Indefinido', 'Temporal 6 meses', 'Temporal 3 meses', 'Temporal 1 año', 'Fines de semana', 'Días sueltos']),
                'salary' => $this->faker->randomFloat(2, 1100, 2200),
            ];
        });
    }

    public function worker(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'worker',
                'availability' => $this->faker->randomElement(['Inmediata', 'En 15 días', 'En 1 mes', 'Fines de semana', 'Turnos rotativos', 'Solo mañanas', 'Solo tardes', 'Solo noches']),
                'salary_expectation' => $this->faker->randomFloat(2, 1100, 2200),
            ];
        });
    }
}
