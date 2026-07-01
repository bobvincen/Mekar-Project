@extends('layouts.app')

@section('title', 'Detail Resep - ' . $resep->nama)

@section('content')
<div class="mb-6">
    <a href="{{ route('apoteker.resep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar Resep
    </a>
    <h2 class="text-2xl font-bold text-gray-800 mt-2">Detail Resep Dokter</h2>
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
    <!-- Panel Kiri: Informasi Pelanggan & Status -->
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
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $resep->whatsapp) }}" target="_blank" class="block font-semibold text-blue-600 hover:underline mt-0.5">
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
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Status Penawaran</h3>
            
            @php
                $statusColors = [
                    'menunggu_verifikasi' => 'bg-amber-50 text-amber-600 border-amber-250',
                    'sedang_diproses'     => 'bg-blue-50 text-blue-605 border-blue-200',
                    'menunggu_persetujuan' => 'bg-purple-50 text-purple-650 border-purple-200',
                    'siap_checkout'       => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                    'checkout'            => 'bg-sky-50 text-sky-655 border-sky-200',
                    'selesai'             => 'bg-green-50 text-green-600 border-green-200',
                    'ditolak'             => 'bg-red-50 text-red-600 border-red-200',
                ];

                $statusLabels = [
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'sedang_diproses'     => 'Sedang Diproses',
                    'menunggu_persetujuan' => 'Menunggu Persetujuan',
                    'siap_checkout'       => 'Siap Checkout',
                    'checkout'            => 'Checkout',
                    'selesai'             => 'Selesai',
                    'ditolak'             => 'Ditolak',
                ];

                $colorClass = $statusColors[$resep->status] ?? 'bg-slate-50 text-slate-650 border-slate-200';
                $label = $statusLabels[$resep->status] ?? $resep->status;
            @endphp

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Status saat ini</label>
                    <span class="inline-block px-3 py-1.5 text-xs font-bold border rounded-lg uppercase tracking-wider {{ $colorClass }}">
                        {{ $label }}
                    </span>
                </div>

                @if(in_array($resep->status, ['menunggu_verifikasi', 'sedang_diproses', 'menunggu_persetujuan']))
                    <div class="pt-2">
                        <a href="{{ route('resep.proses', $resep->id) }}" class="w-full text-center block bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition">
                            Proses Resep Sekarang
                        </a>
                    </div>
                @endif

                @if($resep->catatan_verifikasi)
                    <div class="pt-2 border-t border-gray-50">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Catatan Apoteker</label>
                        <p class="text-gray-700 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">{{ $resep->catatan_verifikasi }}</p>
                    </div>
                @endif

                @if($resep->catatan_revisi)
                    <div class="pt-2 border-t border-gray-50">
                        <label class="block text-xs font-semibold text-red-400 uppercase tracking-wider mb-1">Catatan Revisi Pelanggan</label>
                        <p class="text-gray-750 mt-1 bg-red-50 p-3 rounded-lg border border-red-100">{{ $resep->catatan_revisi }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel Kanan: Foto Resep (Private) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Dokumen Foto Resep</h3>
            <div class="flex-1 bg-gray-50 rounded-xl border border-dashed border-gray-200 p-4 flex items-center justify-center overflow-hidden">
                <a href="{{ route('resep.file', $resep->id) }}" target="_blank" class="hover:opacity-95 transition flex flex-col items-center">
                    <img src="{{ route('resep.file', $resep->id) }}" alt="Foto Resep {{ $resep->nama }}" class="max-h-[500px] w-auto rounded shadow-sm border border-gray-200 object-contain">
                    <span class="text-xs text-blue-600 font-semibold mt-3 hover:underline">Buka Gambar di Tab Baru ↗</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
