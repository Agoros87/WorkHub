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

    public function scopeOfType($query, ?string $type)
    {
        if (!empty($type)) {
            return $query->where('type', $type);
        }
        return $query;
    }

    public function scopeInLocation($query, ?string $location)
    {
        if (!empty($location)) {
            return $query->where('location', 'like', "%{$location}%");
        }
        return $query;
    }

    public function scopeWithSkills($query, array $skills)
    {
        if (!empty($skills)) {
            foreach ($skills as $skill) {
                $query->whereJsonContains('skills', trim($skill));
            }
        }
        return $query;
    }

    public function scopeSearchKeyword($query, ?string $keyword)
    {
        if (!empty($keyword)) {
            $keyword = '%' . trim($keyword) . '%';
            return $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', $keyword)
                    ->orWhere('description', 'like', $keyword);
            });
        }
        return $query;
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
