<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'pemasukan'],
            ['name' => 'pengeluaran'],
        ];

        foreach ($types as $type) {
            DB::table('types')->updateOrInsert(
                ['name' => $type['name']], // cek berdasarkan name
                $type
            );
        }
    }
}
