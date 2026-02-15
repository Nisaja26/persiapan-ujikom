<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Laravel otomatis hash password
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Relasi ke tabel roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // tulisan di halaman profil
    public function getRoleLabelAttribute()
    {
        return $this->role ? ucfirst($this->role->name) : '-';
    }



    /**
     * Helper cek role
     */
    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isCeo()
    {
        return $this->role && $this->role->name === 'ceo';
    }
}
