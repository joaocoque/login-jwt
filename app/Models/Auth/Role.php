<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'guard_name'
    ];

    public function scopeByUser($query, $currentUser)
    {
        $query->orderBy('id', 'ASC');

        if(!$currentUser->hasRole('root')) {
            $query->whereNotIn('name', ['root']);
        }

        return $query;
    }
}
