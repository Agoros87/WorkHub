<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    public function view(User $user, JobApplication $jobApplication): bool
    {
        // El usuario puede ver la aplicación si es el aplicante o el dueño del anuncio
        return $user->id === $jobApplication->user_id || 
               $user->id === $jobApplication->advertisement->user_id;
    }

    public function update(User $user, JobApplication $jobApplication): bool
    {
        // Solo el aplicante puede actualizar su aplicación
        return $user->id === $jobApplication->user_id;
    }

    public function delete(User $user, JobApplication $jobApplication): bool
    {
        // Solo el aplicante puede eliminar su aplicación
        return $user->id === $jobApplication->user_id;
    }
}
