<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Advertisement extends Model
{
    use HasFactory;

    public function getRouteKeyName() // Me ahorro poner en las rutas {modelo:slug} para que sea por slug en lugar de id
    {
        return 'slug';
    }

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

    public function scopereturnOppositeType($query, ?string $type)
    {
        if (!empty($type)) {
            $oppositeType = $type === 'employer' ? 'worker' : 'employer';
            return $query->where('type', $oppositeType);
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

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
                    ->withPivot(['notes', 'priority']);
    }
}
