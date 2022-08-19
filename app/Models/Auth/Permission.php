<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'guard_name'
    ];

}
