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
        User::create([
            'name' => 'Apotek Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Akun Kasir
        User::create([
            'name' => 'Siti Kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        // 3. Akun Pelanggan
        User::create([
            'name' => 'Budi Pelanggan',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);
    }
}
