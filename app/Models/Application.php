<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_offer_id',
        'user_id',
        'candidate_profile_id',
        'resume_path',
        'cover_letter_path',
        'status',
        'cover_note',
        'applied_at',
    ];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function candidateProfile()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
    public function job()
    {
        return $this->jobOffer();
    }

    public function user()
    {
        return $this->candidateProfile->user();
    }
}
