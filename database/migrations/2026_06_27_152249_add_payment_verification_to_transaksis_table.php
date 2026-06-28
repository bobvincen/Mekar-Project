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
            $table->string('bukti_transfer')->nullable()->after('status');
            $table->text('verifikasi_catatan')->nullable()->after('bukti_transfer');
            $table->foreignId('verifikator_id')->nullable()->after('verifikasi_catatan')->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_verifikasi')->nullable()->after('verifikator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['verifikator_id']);
            $table->dropColumn(['bukti_transfer', 'verifikasi_catatan', 'verifikator_id', 'tanggal_verifikasi']);
        });
    }
};
