<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mekar.com'],
            [
                'name' => 'Admin Mekar',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@mekar.com'],
            [
                'name' => 'Kasir Mekar',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        );
    }
}
