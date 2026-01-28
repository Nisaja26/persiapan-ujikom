<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi (fillable).
     */
    protected $fillable = [
        'username',
        'password',
        'role', // admin atau ceo
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting kolom.
     */
    protected $casts = [
        'password' => 'hashed',
    ];

     public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Setter otomatis untuk password (langsung di-hash).
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Cek role user.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCeo()
    {
        return $this->role === 'ceo';
    }
}
