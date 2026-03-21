<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'admin_level',
        'permissions',
        'department'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check if user is an admin (always true for Admin model)
     */
    public function isAdmin(): bool
    {
        return true;
    }
}
