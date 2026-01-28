<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi: 1 type punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}