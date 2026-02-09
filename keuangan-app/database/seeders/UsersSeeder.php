<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // CEO
        User::firstOrCreate(
            ['username' => 'ceo'],
            [
                'password' => Hash::make('ceo123'),
                'role' => 'ceo',
            ]
        );
    }
}
