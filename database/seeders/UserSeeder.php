<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@mekar.com'],
            [
                'name' => 'Admin Mekar',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Apotek Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Kasir
        User::updateOrCreate(
            ['email' => 'kasir@mekar.com'],
            [
                'name' => 'Kasir Mekar',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@gmail.com'],
            [
                'name' => 'Siti Kasir',
                'password' => Hash::make('password123'),
                'role' => 'kasir',
            ]
        );

        // 3. Akun Pelanggan
        User::updateOrCreate(
            ['email' => 'pelanggan@mekar.com'],
            [
                'name' => 'Pelanggan Mekar',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Pelanggan',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
            ]
        );
    }
}
