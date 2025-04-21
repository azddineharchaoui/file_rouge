<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'scheduled_at',
        'duration_minutes',
        'location',
        'meeting_link',
        'interview_type', // in-person, video, phone
        'status', // scheduled, confirmed, completed, no-show, canceled, reschedule_requested
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
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