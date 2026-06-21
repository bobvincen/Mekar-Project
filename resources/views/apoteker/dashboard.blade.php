@extends('layouts.app')

@section('title', 'Dashboard Apoteker')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Dashboard Apoteker</h1>
    <p class="text-slate-500">Selamat datang kembali. Silakan periksa verifikasi resep dokter dan stok obat hari ini.</p>
</div>

<!-- Statistik Ringkas -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <!-- Resep Menunggu Verifikasi -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm font-medium">Menunggu Verifikasi</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $pendingResepCount }}</h2>
        </div>
        <div class="bg-amber-50 p-4 rounded-2xl text-2xl">
            ⏳
        </div>
    </div>

    <!-- Total Resep Dokter -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Resep</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalResep }}</h2>
        </div>
        <div class="bg-blue-50 p-4 rounded-2xl text-2xl">
            📄
        </div>
    </div>

    <!-- Stok Rendah -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm font-medium">Obat Stok Rendah</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $lowStockObatCount }}</h2>
        </div>
        <div class="bg-red-50 p-4 rounded-2xl text-2xl">
            ⚠️
        </div>
    </div>

    <!-- Total Jenis Obat -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Jenis Obat</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalObat }}</h2>
        </div>
        <div class="bg-emerald-50 p-4 rounded-2xl text-2xl">
            💊
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pesanan Menunggu Verifikasi -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span>📋</span> Resep Menunggu Verifikasi
            </h3>
            <a href="{{ route('apoteker.resep.index', ['status' => 'pending']) }}" class="text-sm font-semibold text-blue-600 hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-sm text-gray-500 pb-3">
                        <th class="pb-3 font-semibold">Pelanggan</th>
                        <th class="pb-3 font-semibold">WhatsApp</th>
                        <th class="pb-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                    @forelse($pendingReseps as $resep)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3.5 font-medium text-gray-900">{{ $resep->nama }}</td>
                        <td class="py-3.5 text-gray-500">{{ $resep->whatsapp }}</td>
                        <td class="py-3.5 text-right">
                            <a href="{{ route('apoteker.resep.show', $resep->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-gray-400 italic">
                            Tidak ada resep baru yang menunggu verifikasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Obat Stok Rendah -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-red-600 flex items-center gap-2">
                <span>⚠️</span> Peringatan Stok Rendah (≤ 20)
            </h3>
            <a href="{{ route('apoteker.obat.index', ['stok_rendah' => 1]) }}" class="text-sm font-semibold text-blue-600 hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-sm text-gray-500 pb-3">
                        <th class="pb-3 font-semibold">Kode</th>
                        <th class="pb-3 font-semibold">Nama Obat</th>
                        <th class="pb-3 font-semibold text-right">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                    @forelse($lowStockObats as $obat)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3.5 text-gray-500">{{ $obat->kode_obat }}</td>
                        <td class="py-3.5 font-medium text-gray-900">{{ $obat->nama_obat }}</td>
                        <td class="py-3.5 text-right font-bold text-red-600">{{ $obat->stok }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-gray-400 italic">
                            Semua stok obat aman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
