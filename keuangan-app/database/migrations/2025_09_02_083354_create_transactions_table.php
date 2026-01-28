<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel types
            $table->foreignId('type_id')
                  ->constrained('types')
                  ->cascadeOnDelete();

            // relasi ke tabel categories
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            // relasi ke tabel sub_categories
            $table->foreignId('sub_category_id')
                  ->nullable()
                  ->constrained('sub_categories')
                  ->nullOnDelete();

            // jumlah uang (Rp) dengan 2 angka desimal
            $table->decimal('amount', 15, 2);

            // menentukan waktu
            $table->date('tanggal');

            // deskripsi opsional
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
