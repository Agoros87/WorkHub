<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'phone',
        'location',
        'date_of_birth',
        'gender',
        'company_name',
        'tax_id',
        'type',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'datetime',
        ];
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'user_id');
    }

    public function receivedApplications()
    {
        return $this->hasManyThrough(
            JobApplication::class,
            Advertisement::class,
            'user_id',
            'advertisement_id'
        );
    }

    public function favoriteAdvertisements(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'favorites')
            ->withPivot(['notes', 'priority'])
            ->orderByRaw("FIELD(favorites.priority, 'high', 'medium', 'low')");
    }
}
