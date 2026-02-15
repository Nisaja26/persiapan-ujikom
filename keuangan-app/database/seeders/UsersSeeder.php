<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $ceoRole   = Role::where('name', 'ceo')->first();

        // ADMIN
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // CEO
        User::firstOrCreate(
            ['username' => 'ceo'],
            [
                'password' => Hash::make('ceo123'),
                'role_id' => $ceoRole->id,
            ]
        );
    }
}
