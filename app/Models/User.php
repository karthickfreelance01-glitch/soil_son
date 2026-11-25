<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Login accounts — the same `user` table and columns as gh.hms-society.com:
 * id, role (admin|staff), name, email, password, status (1 active / 0 inactive),
 * created_at, updated_at.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'status' => 'integer',
    ];

    /** The `user` table has no remember_token column (same as gh.hms). */
    protected $rememberTokenName = '';

    public const ROLES = ['admin' => 'Admin', 'staff' => 'Staff'];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isActive(): bool
    {
        return (int) $this->status === 1;
    }
}
