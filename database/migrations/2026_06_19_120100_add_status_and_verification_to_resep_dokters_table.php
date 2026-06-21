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
        Schema::table('resep_dokters', function (Blueprint $table) {
            $table->string('status')->default('pending'); // pending, disetujui, ditolak
            $table->text('catatan_verifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resep_dokters', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan_verifikasi']);
        });
    }
};
