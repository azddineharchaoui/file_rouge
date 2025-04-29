<?php

namespace App\Policies;

use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyProfilePolicy
{
    use HandlesAuthorization;

    public function update(User $user, ?CompanyProfile $companyProfile = null)
    {
        if ($companyProfile === null) {
            // Si aucune instance n'est fournie (comme lors de l'appel de CompanyProfile::class),
            // vérifie seulement si l'utilisateur est un recruteur
            return $user->isRecruiter();
        }

        // Si une instance est fournie, vérifie si l'utilisateur est le propriétaire du profil
        return $user->isRecruiter() && $companyProfile->user_id === $user->id;
    }
}