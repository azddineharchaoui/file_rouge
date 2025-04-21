<?php

namespace App\Policies;

use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidateProfilePolicy
{
    use HandlesAuthorization;


    public function update(User $user, ?CandidateProfile $candidateProfile = null)
    {
        if ($candidateProfile === null) {
            return $user->role === 'candidate';
        }

        return $user->id === $candidateProfile->user_id;
    }

    public function view(User $user, CandidateProfile $candidateProfile)
    {
        return $user->id === $candidateProfile->user_id || $user->role === 'recruiter';
    }
}