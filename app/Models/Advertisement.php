<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'slug',
        'skills',
        'experience',
        'schedule',
        'contract_type',
        'salary',
        'availability',
        'salary_expectation',
        'location'
    ];

    protected $casts = [
        'skills' => 'array',
        'salary' => 'decimal:2',
        'salary_expectation' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeInLocation($query, string $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeWithSkills($query, array $skills)
    {
        return $query->where(function ($query) use ($skills) {
            foreach ($skills as $skill) {
                $query->whereJsonContains('skills', $skill);
            }
        });
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
