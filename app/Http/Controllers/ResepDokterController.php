<?php

namespace App\Http\Controllers;

use App\Models\ResepDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepDokterController extends Controller
{
    public function create()
    {
        return view('marketplace.upload-resep');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'catatan' => 'nullable|string',
            'foto_resep' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'foto_resep.required' => 'Foto resep wajib diunggah.',
            'foto_resep.image' => 'File harus berupa gambar.',
            'foto_resep.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto_resep.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('foto_resep')) {
            $path = $request->file('foto_resep')->store('resep', 'public');
            $validated['foto_resep'] = $path;
        }

        $resep = ResepDokter::create($validated);

        // Siapkan link WhatsApp
        $adminWa = config('services.fonnte.admin_phone', '6282240432990');
        $fotoUrl = asset('storage/' . $resep->foto_resep);
        $pesan = "Halo Admin Mekar Pharmacy 👋\n\nSaya telah mengirim resep dokter.\n\nNama:\n" . $resep->nama . "\n\nWhatsApp:\n" . $resep->whatsapp . "\n\nCatatan:\n" . ($resep->catatan ?? '-') . "\n\nLink Foto Resep:\n" . $fotoUrl . "\n\nMohon dilakukan pengecekan resep terlebih dahulu.\n\nTerima kasih 🙏";
        
        $waUrl = 'https://wa.me/' . $adminWa . '?text=' . urlencode($pesan);

        \Illuminate\Support\Facades\Log::info('Foto Resep', [
            'path' => $path ?? null,
            'url' => $fotoUrl,
            'wa_url' => $waUrl
        ]);

        // Kirim via Fonnte API di backend
        $sendResult = \App\Services\FonnteService::send($adminWa, $pesan);

        $successMsg = 'Resep berhasil dikirim. Admin akan memeriksa resep Anda terlebih dahulu.';
        if (!$sendResult['success']) {
            $successMsg .= ' (Catatan: Notifikasi WhatsApp otomatis gagal: ' . $sendResult['message'] . '. Harap klik tombol di bawah untuk melanjutkan secara manual)';
        }

        return redirect()->back()->with([
            'success' => $successMsg,
            'waUrl' => $waUrl
        ]);
    }
}
