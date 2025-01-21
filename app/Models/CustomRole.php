<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class CustomRole extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'description'];
}