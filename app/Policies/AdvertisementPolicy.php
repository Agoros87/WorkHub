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
        return $user->hasRole('admin') || ($user->id === $advertisement->user_id && $user->hasRole('creator'));
    }

    public function delete(User $user, Advertisement $advertisement)
    {
        return $user->hasRole('admin') || ($user->id === $advertisement->user_id && $user->hasRole('creator'));
    }

    public function apply(User $user, Advertisement $advertisement, bool $hasApplied)
    {
        if (!$user->hasRole('creator')) {
            return false;
        }

        if ($hasApplied) {
            return false;
        }

        if ($advertisement->type === 'employer') {
            return $user->type === 'worker' && $user->id !== $advertisement->user_id;
        } else {
            return $user->type === 'employer' && $user->id !== $advertisement->user_id;
        }
    }
}

