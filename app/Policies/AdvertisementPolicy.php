<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;

class AdvertisementPolicy
{
    public function create(User $user)
    {
        return true; // Cualquier usuario autenticado puede crear anuncios
    }

    public function update(User $user, Advertisement $advertisement)
    {
        return $user->hasRole('admin') || $user->id === $advertisement->user_id;
    }

    public function delete(User $user, Advertisement $advertisement)
    {
        return $user->hasRole('admin') || $user->id === $advertisement->user_id;
    }

    public function apply(User $user, Advertisement $advertisement)
    {
        if ($advertisement->type === 'employer') {
            return $user->type === 'worker' && $user->id !== $advertisement->user_id;
        } else {
            return $user->type === 'employer' && $user->id !== $advertisement->user_id;
        }
    }
}
