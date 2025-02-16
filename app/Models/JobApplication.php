<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Events\ApplicationStatusNotification;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'advertisement_id',
        'cv_path',
        'status'
    ];

    protected static function booted()
    {
        static::updating(function ($jobApplication) {
            if ($jobApplication->isDirty('status')) {
                event(new ApplicationStatusNotification(
                    $jobApplication,
                    $jobApplication->getOriginal('status'),
                    $jobApplication->status
                ));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
