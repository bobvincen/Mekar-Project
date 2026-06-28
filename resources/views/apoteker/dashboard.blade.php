@extends('layouts.app')

@section('title', 'Dashboard Apoteker')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Dashboard Apoteker</h1>
            <p class="text-sm text-slate-500 mt-1">Selamat datang kembali. Silakan periksa verifikasi resep dokter dan persediaan stok obat hari ini.</p>
        </div>
    </div>

    <!-- Summary KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pending Resep -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</span>
                <h3 class="text-2xl font-extrabold text-amber-600">{{ $pendingResepCount }}</h3>
            </div>
            <div class="p-3 bg-amber-50 text-amber-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Total Resep -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Resep</span>
                <h3 class="text-2xl font-extrabold text-blue-650">{{ $totalResep }}</h3>
            </div>
            <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Obat Stok Rendah</span>
                <h3 class="text-2xl font-extrabold text-rose-650">{{ $lowStockObatCount }}</h3>
            </div>
            <div class="p-3 bg-rose-50 text-rose-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <!-- Total Jenis Obat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Jenis Obat</span>
                <h3 class="text-2xl font-extrabold text-emerald-600">{{ $totalObat }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Details Grid Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Resep Menunggu Verifikasi -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-sm">Resep Menunggu Verifikasi</h3>
                <a href="{{ route('apoteker.resep.index', ['status' => 'pending']) }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse table-auto">
                    <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                        <tr>
                            <th class="py-3 px-5">Nama Pelanggan</th>
                            <th class="py-3 px-5">No. WhatsApp</th>
                            <th class="py-3 px-5 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                        @forelse($pendingReseps as $resep)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-5 font-bold text-slate-800">{{ $resep->nama }}</td>
                                <td class="py-3 px-5 font-mono text-xs">{{ $resep->whatsapp }}</td>
                                <td class="py-3 px-5 text-center">
                                    <a href="{{ route('apoteker.resep.show', $resep->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-650 rounded-lg text-xs font-bold transition">
                                        Verifikasi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400 font-normal italic">
                                    Tidak ada resep baru yang menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Peringatan Stok Rendah -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                    <span class="text-rose-500 font-bold">⚠️</span> Peringatan Stok Rendah (≤ 20)
                </h3>
                <a href="{{ route('apoteker.obat.index', ['stok_rendah' => 1]) }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse table-auto">
                    <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                        <tr>
                            <th class="py-3 px-5 w-24">Kode</th>
                            <th class="py-3 px-5">Nama Obat</th>
                            <th class="py-3 px-5 text-right w-24">Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                        @forelse($lowStockObats as $obat)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-5 font-bold text-slate-400">{{ $obat->kode_obat }}</td>
                                <td class="py-3 px-5 font-bold text-slate-800">{{ $obat->nama_obat }}</td>
                                <td class="py-3 px-5 text-right font-extrabold text-rose-600">
                                    <span class="px-2 py-0.5 bg-rose-50 border border-rose-100 rounded-lg text-xs">{{ $obat->stok }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400 font-normal italic">
                                    Semua persediaan obat dalam kondisi aman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
