<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
        'salary',
        'employment_type',
        'company_id',
        'category_id',
        'location_id',
        'is_featured',
        'is_remote',
        'application_deadline',
        'experience_level',
    ];

    protected $casts = [
        'salary' => 'integer',
        'is_featured' => 'boolean',
        'is_remote' => 'boolean',
        'application_deadline' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(CompanyProfile::class, 'company_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRemote($query)
    {
        return $query->where('is_remote', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    public function scopeByEmploymentType($query, $type)
    {
        return $query->where('employment_type', $type);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', "%{$searchTerm}%")
            ->orWhereHas('company', fn ($q) => $q->where('company_name', 'like', "%{$searchTerm}%"));
    }
}
