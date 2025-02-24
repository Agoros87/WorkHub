<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'advertisement_id',
        'notes',
        'priority',
    ];

    protected $casts = [
        'priority' => 'string',
    ];
}
