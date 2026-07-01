<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modifikasi tabel resep_dokters
        Schema::table('resep_dokters', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            $table->text('catatan_revisi')->nullable()->after('catatan_verifikasi');
            
            // Mengubah default value dari status (Laravel 10+ mendukung native change)
            $table->string('status')->default('menunggu_verifikasi')->change();
        });

        // 2. Buat tabel resep_dokter_items
        Schema::create('resep_dokter_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_dokter_id')->constrained('resep_dokters')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->integer('qty');
            $table->string('status')->default('tersedia'); // tersedia, tidak_tersedia
            $table->foreignId('obat_pengganti_id')->nullable()->constrained('obats')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 3. Migrasi Data Lama secara Aman (Backward Compatibility)
        try {
            // Pemetaan status lama ke status baru
            DB::table('resep_dokters')->where('status', 'pending')->update(['status' => 'menunggu_verifikasi']);
            DB::table('resep_dokters')->where('status', 'disetujui')->update(['status' => 'selesai']);

            // Hubungkan data resep lama ke user (jika nomor whatsapp/nama cocok)
            $reseps = DB::table('resep_dokters')->get();
            foreach ($reseps as $resep) {
                if (empty($resep->whatsapp)) {
                    continue;
                }
                
                // Normalisasi nomor whatsapp untuk pencarian
                $cleanWa = preg_replace('/[^0-9]/', '', $resep->whatsapp);
                
                $user = DB::table('users')->where('whatsapp', 'like', "%{$cleanWa}%")->first();
                if (!$user) {
                    $user = DB::table('users')->where('name', $resep->nama)->first();
                }

                if ($user) {
                    DB::table('resep_dokters')->where('id', $resep->id)->update([
                        'user_id' => $user->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Abaikan error migrasi data jika ada masalah integrasi data seeder awal
            \Illuminate\Support\Facades\Log::warning('Gagal migrasi data resep lama: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_dokter_items');

        Schema::table('resep_dokters', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'catatan_revisi']);
            $table->string('status')->default('pending')->change();
        });
    }
};
