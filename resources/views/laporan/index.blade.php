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

    <!-- Filters Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <form action="{{ route('laporan.index') }}" method="GET" class="m-0 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-semibold text-slate-700">
            </div>

            <!-- End Date -->
            <div>
                <label for="end_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-semibold text-slate-700">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                <select id="status" name="status"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-semibold text-slate-700 bg-white">
                    <option value="">-- Semua Status --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Kasir -->
            <div>
                <label for="user_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kasir</label>
                <select id="user_id" name="user_id"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-semibold text-slate-700 bg-white">
                    <option value="">-- Semua Kasir --</option>
                    @foreach($cashiers as $cashier)
                        <option value="{{ $cashier->id }}" {{ request('user_id') == $cashier->id ? 'selected' : '' }}>
                            {{ $cashier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis Transaksi -->
            <div>
                <label for="jenis_transaksi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                <select id="jenis_transaksi" name="jenis_transaksi"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-semibold text-slate-700 bg-white">
                    <option value="">-- Semua Jenis --</option>
                    <option value="POS" {{ request('jenis_transaksi') === 'POS' ? 'selected' : '' }}>POS (Kasir)</option>
                    <option value="Online" {{ request('jenis_transaksi') === 'Online' ? 'selected' : '' }}>Online (Marketplace)</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="lg:col-span-5 flex justify-end gap-3 pt-2">
                <a href="{{ route('laporan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition text-sm">
                    Reset Filter
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Daftar Transaksi Terfilter</h3>
                <p class="text-xs text-slate-400 mt-0.5">Berikut daftar rekap data transaksi penjualan obat terfilter:</p>
            </div>

            <!-- Export Buttons -->
            <div x-data="{ exportingPdf: false, exportingExcel: false }" class="flex items-center gap-2">
                <!-- PDF -->
                <button type="button" 
                    @click="if(!exportingPdf) { exportingPdf = true; setTimeout(() => exportingPdf = false, 6000); window.location.href='{{ route('laporan.export-pdf', request()->query()) }}'; }"
                    :disabled="exportingPdf"
                    :class="exportingPdf ? 'opacity-60 cursor-not-allowed' : ''"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 rounded-xl font-bold transition text-xs">
                    <template x-if="!exportingPdf">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </template>
                    <template x-if="exportingPdf">
                        <svg class="animate-spin h-4 w-4 text-rose-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="exportingPdf ? 'Mengunduh...' : 'Export PDF'"></span>
                </button>

                <!-- Excel -->
                <button type="button" 
                    @click="if(!exportingExcel) { exportingExcel = true; setTimeout(() => exportingExcel = false, 6000); window.location.href='{{ route('laporan.export-excel', request()->query()) }}'; }"
                    :disabled="exportingExcel"
                    :class="exportingExcel ? 'opacity-60 cursor-not-allowed' : ''"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-100 rounded-xl font-bold transition text-xs">
                    <template x-if="!exportingExcel">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </template>
                    <template x-if="exportingExcel">
                        <svg class="animate-spin h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="exportingExcel ? 'Mengunduh...' : 'Export Excel'"></span>
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-4 px-6 w-20 text-center">No</th>
                        <th class="py-4 px-6">Kode Transaksi</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Kasir</th>
                        <th class="py-4 px-6 text-center w-32">Jenis</th>
                        <th class="py-4 px-6 text-right w-40">Total Harga</th>
                        <th class="py-4 px-6 text-center w-40">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($transaksis as $t)
                        @php
                            $pelanggan = $t->pelanggan->nama_pelanggan ?? ($t->nama_pelanggan ?? 'Umum');
                            $kasir = $t->user->name ?? '-';
                            $jenis = $t->nama_pelanggan ? 'Online' : 'POS';
                            $status = $t->user_id ? ($t->status === 'Dibatalkan' ? 'Dibatalkan' : 'Selesai') : $t->status;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-center font-bold text-slate-400">
                                {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                            </td>
                            <td class="py-4 px-6 font-mono font-bold text-blue-600 whitespace-nowrap">
                                {{ $t->kode_transaksi }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500">
                                {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $pelanggan }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $kasir }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold rounded-lg {{ $t->nama_pelanggan ? 'bg-purple-50 text-purple-600 border border-purple-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                    {{ $jenis }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-850 text-right whitespace-nowrap">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold rounded-lg {{ $status === 'Selesai' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($status === 'Dibatalkan' || $status === 'Ditolak' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-amber-50 text-amber-600 border border-amber-100') }}">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 font-medium bg-slate-50/10">
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

        @if ($transaksis->hasPages())
            <div class="p-5 border-t border-slate-100 bg-slate-50/10">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
