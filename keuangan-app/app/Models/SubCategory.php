<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name'];

    // Relasi: sub kategori milik kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: 1 sub kategori punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
