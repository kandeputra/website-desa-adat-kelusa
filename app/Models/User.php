<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public const ROLES = ['super_admin' => 'Super Admin', 'admin' => 'Admin'];

    protected $fillable = ['name', 'email', 'password', 'role', 'jabatan', 'is_active', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'last_login_at' => 'datetime', 'password' => 'hashed', 'is_active' => 'boolean'];
    }

    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function roleLabel(): string { return self::ROLES[$this->role] ?? $this->role; }
    public function posts() { return $this->hasMany(Post::class); }
}
