<?php

namespace App\Policies;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isRecruiter() && $user->companyProfile !== null;
    }

    public function apply(User $user, JobOffer $job)
    {
        return $user->isCandidate() && 
               $user->candidateProfile !== null && 
               !$job->applications()->where('candidate_profile_id', $user->candidateProfile->id)->exists();
    }
}