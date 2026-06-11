<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role dengan pilihan: admin, kasir, pelanggan
            // Secara default, user baru akan langsung menjadi 'pelanggan'
            $table->enum('role', ['admin', 'kasir', 'pelanggan'])
                ->default('pelanggan')
                ->after('email'); // Kolom ini akan diletakkan setelah kolom email
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('role');
        });
    }
};
