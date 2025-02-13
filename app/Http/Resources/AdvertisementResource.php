<?php

namespace App\Http\Resources;

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
