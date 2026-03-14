<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // nama-nama kolom yang di daftarkan sehingga bisa di simpan ke tabel
        'type_id',
        'category_id',
        'sub_category_id',
        'amount',
        'tanggal',
        'deskripsi',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date', // otomatis jadi Carbon instance
    ];

    // Relasi ke Type
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // Relasi ke many to one Category
    // satu transaksi hanya memiliki 1, tetapi 1 category memiliki banyak transaksi
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}