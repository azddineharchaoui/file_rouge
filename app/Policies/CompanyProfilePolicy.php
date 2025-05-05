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

            return $user->isRecruiter();
        }

        return $user->isRecruiter() && $companyProfile->user_id === $user->id;
    }
}