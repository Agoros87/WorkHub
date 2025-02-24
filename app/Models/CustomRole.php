<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class CustomRole extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'description'];
}
