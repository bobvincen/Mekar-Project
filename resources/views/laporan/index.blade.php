@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')

{{-- Welcome Section --}}
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
            Laporan & Rekap Penjualan
        </h1>
        <p class="text-slate-500 mt-1">
            Analisis rekapitulasi data transaksi apotek Mekar Pharmacy.
        </p>
    </div>
    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl shadow-sm text-sm font-medium flex items-center gap-2">
        <span>📅</span> {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Total Transaksi</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalTransaksi }}</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">
                Seluruh Transaksi Penjualan
            </span>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-xl">
            📦
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Total Pendapatan</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-green-50 text-green-600 rounded-full">
                Omzet Penjualan Kotor
            </span>
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-xl">
            💰
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Rata-rata Penjualan</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">
                Rp {{ number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') }}
            </h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-cyan-50 text-cyan-600 rounded-full">
                Rata-rata Per Transaksi
            </span>
        </div>
        <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-xl">
            📊
        </div>
    </div>
</div>

{{-- Transactions Table --}}
<div class="bg-white rounded-3xl shadow-lg p-6">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Daftar Transaksi Terbaru</h2>
        <p class="text-slate-400 text-sm mt-0.5">Berikut 50 transaksi penjualan obat terakhir:</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b text-slate-500 font-medium">
                    <th class="text-left py-4">No</th>
                    <th class="text-left py-4">Kode Transaksi</th>
                    <th class="text-left py-4">Tanggal</th>
                    <th class="text-left py-4">Pelanggan</th>
                    <th class="text-left py-4">Total Harga</th>
                    <th class="text-left py-4">Bayar</th>
                    <th class="text-left py-4">Kembalian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="border-b hover:bg-slate-50/50 transition-colors">
                    <td class="py-4">{{ $loop->iteration }}</td>
                    <td class="py-4 font-mono font-semibold text-blue-600">
                        {{ $t->kode_transaksi }}
                    </td>
                    <td class="py-4">
                        {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}
                    </td>
                    <td class="py-4">
                        {{ $t->pelanggan->nama_pelanggan ?? 'Umum' }}
                    </td>
                    <td class="py-4 font-semibold text-slate-800">
                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="py-4">
                        Rp {{ number_format($t->bayar, 0, ',', '.') }}
                    </td>
                    <td class="py-4 text-green-600 font-semibold">
                        Rp {{ number_format($t->kembalian, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-slate-400 font-light">
                        Belum ada data transaksi untuk laporan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
