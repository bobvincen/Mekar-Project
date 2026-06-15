<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('nama_pelanggan')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('metode_pengambilan')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('jarak', 8, 2)->nullable();
            $table->decimal('ongkir', 12, 2)->nullable();
            $table->decimal('subtotal', 12, 2)->nullable();
            $table->decimal('diskon', 12, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('Menunggu Konfirmasi');
            
            // Allow existing columns to be nullable for marketplace orders
            $table->foreignId('user_id')->nullable()->change();
            $table->decimal('bayar', 12, 2)->nullable()->change();
            $table->decimal('kembalian', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pelanggan', 'whatsapp', 'alamat', 'metode_pengambilan',
                'latitude', 'longitude', 'jarak', 'ongkir', 'subtotal', 'diskon', 'catatan', 'status'
            ]);
            
            // Revert changes to nullable
            $table->foreignId('user_id')->nullable(false)->change();
            $table->decimal('bayar', 12, 2)->nullable(false)->change();
            $table->decimal('kembalian', 12, 2)->nullable(false)->change();
        });
    }
};
