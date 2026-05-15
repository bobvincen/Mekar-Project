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
         Schema::create('obats', function (Blueprint $table) {
        $table->id();

        $table->foreignId('kategori_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('supplier_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->string('kode_obat')->unique();

        $table->string('nama_obat');

        $table->integer('stok');

        $table->decimal('harga_jual', 10, 2);

        $table->date('tanggal_kadaluarsa');

        $table->text('deskripsi')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
