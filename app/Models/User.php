<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
        'is_active' => 'boolean',
    ];

    
    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function isCandidate()
    {
        return $this->role === 'candidate';
    }

    public function isRecruiter()
    {
        return $this->role === 'recruiter';
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApproved()
    {
        return $this->is_approved;
    }
    public function applications()
    {
        return $this->candidateProfile ? $this->candidateProfile->applications() : Application::where('candidate_profile_id', 0);
    }

    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }
}