<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Application $application)
    {
        return $user->isRecruiter() && 
               $application->jobOffer->company_id === $user->companyProfile->id;
    }
}