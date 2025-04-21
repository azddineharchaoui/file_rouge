<?php

namespace App\Policies;

use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidateProfilePolicy
{
    use HandlesAuthorization;

    public function update(User $user, CandidateProfile $candidateProfile)
    {
        return $user->isCandidate() && $candidateProfile->user_id === $user->id;
    }
}