@extends('layouts.app')

@section('title', 'Verifikasi Resep - ' . $resep->nama)

@section('content')
<div class="mb-6">
    <a href="{{ route('apoteker.resep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar Resep
    </a>
    <h2 class="text-2xl font-bold text-gray-800 mt-2">Detail & Verifikasi Resep</h2>
    <p class="text-sm text-gray-500">Periksa detail dokumen resep dokter pelanggan di bawah ini</p>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 text-green-600 border border-green-200 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Panel Kiri: Informasi Pelanggan & Form Verifikasi -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Info Pelanggan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Informasi Pelanggan</h3>
            <div class="space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</label>
                    <span class="block font-semibold text-gray-800 mt-0.5">{{ $resep->nama }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">WhatsApp</label>
                    <a href="https://wa.me/{{ $resep->whatsapp }}" target="_blank" class="block font-semibold text-blue-600 hover:underline mt-0.5">
                        {{ $resep->whatsapp }} ↗
                    </a>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal Unggah</label>
                    <span class="block text-gray-700 mt-0.5">{{ $resep->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Catatan Pelanggan</label>
                    <p class="text-gray-700 mt-0.5 bg-gray-50 p-2.5 rounded-lg border border-gray-100">{{ $resep->catatan ?: '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Status & Aksi Verifikasi -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Status Verifikasi</h3>
            
            @if($resep->status !== 'pending')
                <!-- Sudah di Verifikasi -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Status saat ini</label>
                        @if($resep->status === 'disetujui')
                            <span class="inline-block px-3 py-1.5 text-xs font-bold bg-green-50 text-green-600 rounded-lg uppercase tracking-wider border border-green-200">
                                ✓ Disetujui
                            </span>
                        @else
                            <span class="inline-block px-3 py-1.5 text-xs font-bold bg-red-50 text-red-600 rounded-lg uppercase tracking-wider border border-red-200">
                                ✗ Ditolak
                            </span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Catatan Apoteker</label>
                        <p class="text-gray-700 mt-1.5 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">{{ $resep->catatan_verifikasi ?: 'Tidak ada catatan verifikasi' }}</p>
                    </div>
                </div>
            @else
                <!-- Form Verifikasi -->
                <form action="{{ route('apoteker.resep.verify', $resep->id) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Tindakan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="border rounded-xl p-3 flex items-center justify-center gap-2 cursor-pointer transition @error('status') border-red-500 bg-red-50 @else border-gray-200 hover:border-green-300 @enderror">
                                <input type="radio" name="status" value="disetujui" required class="text-green-600 focus:ring-green-500">
                                <span class="text-sm font-semibold text-green-700">Setujui</span>
                            </label>
                            <label class="border rounded-xl p-3 flex items-center justify-center gap-2 cursor-pointer transition @error('status') border-red-500 bg-red-50 @else border-gray-200 hover:border-red-300 @enderror">
                                <input type="radio" name="status" value="ditolak" class="text-red-600 focus:ring-red-500">
                                <span class="text-sm font-semibold text-red-700">Tolak</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan_verifikasi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Catatan Verifikasi</label>
                        <textarea name="catatan_verifikasi" id="catatan_verifikasi" rows="4" placeholder="Masukkan instruksi penyiapan obat atau alasan penolakan resep..."
                            class="w-full border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('catatan_verifikasi') border-red-500 bg-red-50 @else border-gray-300 @enderror">{{ old('catatan_verifikasi') }}</textarea>
                        @error('catatan_verifikasi')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition">
                        Kirim Keputusan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Panel Kanan: Foto Resep -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Dokumen Foto Resep</h3>
            <div class="flex-1 bg-gray-50 rounded-xl border border-dashed border-gray-200 p-4 flex items-center justify-center overflow-hidden">
                <a href="{{ asset('storage/' . $resep->foto_resep) }}" target="_blank" class="hover:opacity-95 transition flex flex-col items-center">
                    <img src="{{ asset('storage/' . $resep->foto_resep) }}" alt="Foto Resep {{ $resep->nama }}" class="max-h-[500px] w-auto rounded shadow-sm border border-gray-200 object-contain">
                    <span class="text-xs text-blue-600 font-semibold mt-3 hover:underline">Buka Gambar di Tab Baru ↗</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
