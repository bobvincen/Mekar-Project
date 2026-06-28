<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Daftar Permission
        $permissions = [
            'Dashboard',
            'Lihat User',
            'Tambah User',
            'Lihat Role',
            'Tambah Role',
            'Lihat Permission',
            'Tambah Permission',
            'Lihat Kategori',
            'Tambah Kategori',
            'Lihat Supplier',
            'Tambah Supplier',
            'Lihat Obat',
            'Tambah Obat',
            'Lihat Pelanggan',
            'Tambah Pelanggan',
            'Lihat Transaksi',
            'Tambah Transaksi',
            'Kelola Laporan',
            'Kelola Pesanan Online',
            'Verifikasi Resep',
            'Lihat Stok Obat',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // 2. Daftar Role dan penetapan permission
        // Role Admin
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleAdmin->syncPermissions(Permission::all());

        // Role Kasir
        $roleKasir = Role::firstOrCreate(['name' => 'kasir', 'guard_name' => 'web']);
        $roleKasir->syncPermissions([
            'Dashboard',
            'Lihat Transaksi',
            'Tambah Transaksi',
            'Lihat Pelanggan',
            'Tambah Pelanggan',
            'Lihat Stok Obat',
        ]);

        // Role Apoteker
        $roleApoteker = Role::firstOrCreate(['name' => 'apoteker', 'guard_name' => 'web']);
        $roleApoteker->syncPermissions([
            'Dashboard',
            'Verifikasi Resep',
            'Lihat Stok Obat',
        ]);

        // Role Pelanggan
        $rolePelanggan = Role::firstOrCreate(['name' => 'pelanggan', 'guard_name' => 'web']);
        // Pelanggan tidak mendapatkan permission administratif default

        // 3. Assign Role ke User yang sudah ada
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'admin') {
                $user->assignRole($roleAdmin);
            } elseif ($user->role === 'kasir') {
                $user->assignRole($roleKasir);
            } elseif ($user->role === 'apoteker') {
                $user->assignRole($roleApoteker);
            } else {
                $user->assignRole($rolePelanggan);
            }
        }
    }
}
