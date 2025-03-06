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
        'location',
        'expiration_date'
    ];

    protected $casts = [
        'skills' => 'array',
        'salary' => 'decimal:2',
        'salary_expectation' => 'decimal:2',
        'expiration_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //laravel pasa $query automaticamente como primer parametro
    public function scopeOfType($query, ?string $type) //? Puede ser null o string uso en api
    { // Busca/devuelve el tipo que le pasamos
        if (!empty($type)) {
            return $query->where('type', $type);
        }
        return $query;
    }
        //Busca/devuelve el tipo contrario al que le pasamos
    public function scopeReturnOppositeType($query, ?string $type)
    {
        if (!empty($type)) {
            $oppositeType = $type === 'employer' ? 'worker' : 'employer';
            return $query->where('type', $oppositeType);
        }

        return $query;
    }


    public function scopeInLocation($query, ?string $location) // Busca/devuelve la localización que le pasamos
    {
        if (!empty($location)) {
            return $query->where('location', 'like', "%{$location}%");
        }
        return $query;
    }

    public function scopeWithSkills($query, array $skills)
    {  // Busca/devuelve las habilidades que le pasamos en un array de habilidades separadas por comas en la base de datos en formato JSON
        if (!empty($skills)) {
            foreach ($skills as $skill) {
                $query->whereJsonContains('skills', trim($skill));
            }
        }
        return $query;
    }

    public function scopeSearchKeyword($query, ?string $keyword)
    { // Busca/devuelve el keyword que le pasamos en el título o descripción
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(fn($q) =>
        $q->where('title', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
        );
    }

    public function scopeLatest($query) // Ordena los anuncios por fecha de creación de forma descendente
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function favoritedBy(): BelongsToMany // saca los usuarios que han marcado como favorito un anuncio no lo uso
    {
        return $this->belongsToMany(User::class, 'favorites')
                    ->withPivot(['notes', 'priority']);
    }
}
