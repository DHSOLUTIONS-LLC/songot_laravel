<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Comment this line agar Sanctum install nahi hai
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Comment HasApiTokens agar install nahi hai
    // use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;
    
    protected $table = 'users';
    
    protected $fillable = [
        'name', 'email', 'password_hash', 'google_id',
        'role', 'status', 'plan_tier', 'last_login_at',
        'cooldown_until', 'banned_until'
    ];

    protected $hidden = [
        'password_hash', 'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'cooldown_until' => 'datetime',
        'banned_until' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned' || 
               ($this->banned_until && $this->banned_until->isFuture());
    }

    public function hasWebAccess(): bool
    {
        return in_array($this->plan_tier, ['web', 'full']);
    }

    public function hasFullAccess(): bool
    {
        return $this->plan_tier === 'full';
    }

    public function isInCooldown(): bool
    {
        return $this->cooldown_until && $this->cooldown_until->isFuture();
    }

    public function setCooldown($minutes = 30): void
    {
        $this->update(['cooldown_until' => now()->addMinutes($minutes)]);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function getAuthPassword(): string
    {
        return $this->password_hash ?? '';
    }
}