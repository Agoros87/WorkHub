<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, User $targetUser)
    {
        // Un admin puede eliminar cualquier usuario excepto otros admins
        return $user->hasRole('admin') && !$targetUser->hasRole('admin');
    }
}
