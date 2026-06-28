@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Laporan & Rekap Penjualan</h1>
            <p class="text-sm text-slate-500 mt-1">Analisis rekapitulasi data transaksi penjualan Mekar Pharmacy</p>
        </div>
        <div class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl shadow-sm text-xs font-bold inline-flex items-center gap-1.5">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
            </svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Transaksi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transaksi</span>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalTransaksi }}</h3>
                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 rounded-lg">
                    Seluruh Penjualan
                </span>
            </div>
            <div class="p-3.5 bg-blue-50 text-blue-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                <h3 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg">
                    Omset Kotor
                </span>
            </div>
            <div class="p-3.5 bg-emerald-50 text-emerald-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 14a2 2 0 110-4h4" />
                </svg>
            </div>
        </div>

        <!-- Rata-rata Penjualan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata Transaksi</span>
                <h3 class="text-2xl font-extrabold text-slate-800">
                    Rp {{ number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') }}
                </h3>
                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold bg-cyan-50 text-cyan-600 border border-cyan-100 rounded-lg">
                    Nilai Keranjang Rata-rata
                </span>
            </div>
            <div class="p-3.5 bg-cyan-50 text-cyan-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="p-5 border-b border-slate-50 bg-slate-50/25">
            <h3 class="font-bold text-slate-800 text-base">Daftar Transaksi Terakhir</h3>
            <p class="text-xs text-slate-400 mt-0.5">Berikut daftar rekap 50 transaksi penjualan obat terakhir di apotek:</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-4 px-6 w-20 text-center">No</th>
                        <th class="py-4 px-6">Kode Transaksi</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6 text-right w-40">Total Harga</th>
                        <th class="py-4 px-6 text-right w-40">Tunai Dibayar</th>
                        <th class="py-4 px-6 text-right w-40">Uang Kembalian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($transaksis as $t)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6 font-mono font-bold text-blue-600 whitespace-nowrap">
                                {{ $t->kode_transaksi }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500">
                                {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $t->pelanggan->nama_pelanggan ?? 'Umum' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-850 text-right whitespace-nowrap">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 text-right whitespace-nowrap">
                                Rp {{ number_format($t->bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-emerald-600 font-bold text-right whitespace-nowrap">
                                Rp {{ number_format($t->kembalian, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 stroke-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2" />
                                    </svg>
                                    <span>Belum ada data transaksi penjualan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
