<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function approve(User $admin, User $user)
    {
        return $admin->isAdmin() && $user->isRecruiter();
    }
}