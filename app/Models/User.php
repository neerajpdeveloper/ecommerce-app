<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($slug)
{
    if (!$this->role) {
        return false;
    }

    // 🔥 Admin bypass (optional but recommended)
    if ($this->role->slug === 'admin') {
        return true;
    }

    return $this->role->permissions
        ->contains('slug', $slug);
}
}