<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'resume_path',
        'cover_letter_path',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}