<?php

namespace App\Http\Resources;

/**
 * @group Resources
 *
 * @property int $id ID del anuncio
 * @property string $type Tipo de anuncio (employer/worker)
 * @property string $title Título del anuncio
 * @property string $description Descripción del anuncio
 * @property string $slug Slug único del anuncio
 * @property array $skills Lista de habilidades requeridas
 * @property string $experience Experiencia requerida
 * @property string|null $schedule Horario de trabajo
 * @property string|null $contract_type Tipo de contrato
 * @property float|null $salary Salario ofrecido (para empleadores)
 * @property string|null $availability Disponibilidad
 * @property float|null $salary_expectation Expectativa salarial (para trabajadores)
 * @property string $location Ubicación del trabajo
 * @property int $user_id ID del usuario que creó el anuncio
 * @property \App\Models\User $user Usuario que creó el anuncio
 * @property \Carbon\Carbon $created_at Fecha de creación
 * @property \Carbon\Carbon $updated_at Fecha de última actualización
 */
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'skills' => $this->skills,
            'experience' => $this->experience,
            'schedule' => $this->schedule,
            'contract_type' => $this->contract_type,
            'salary' => $this->salary,
            'availability' => $this->availability,
            'salary_expectation' => $this->salary_expectation,
            'location' => $this->location,
            'user_id' => $this->user_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
