<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin default
        User::create([
            'username' => 'admin',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // CEO default
        User::create([
            'username' => 'ceo',
            'password' => 'password',
            'role' => 'ceo',
        ]);
    }
}
