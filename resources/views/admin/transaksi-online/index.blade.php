@extends('layouts.app')

@section('title', 'Pesanan Online')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pesanan Online 🛒</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola transaksi dan verifikasi bukti pembayaran transfer pelanggan marketplace</p>
        </div>
    </div>

    <!-- Notification Alerts -->
    @if (session('success'))
        <div class="bg-green-50 text-green-600 border border-green-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 text-red-600 border border-red-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="px-5 py-4 text-center w-20">No</th>
                        <th class="px-4 py-4 whitespace-nowrap w-48">Kode Invoice</th>
                        <th class="px-4 py-4 w-36">Tanggal</th>
                        <th class="px-4 py-4">Pelanggan</th>
                        <th class="px-4 py-4 w-36">Metode</th>
                        <th class="px-5 py-4 text-right w-40">Total Harga</th>
                        <th class="px-5 py-4 text-center w-48">Status</th>
                        <th class="px-5 py-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse ($transaksis as $index => $trx)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-5 py-4 text-center font-bold text-slate-400 whitespace-nowrap">
                                {{ $transaksis->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4 font-bold text-blue-600 whitespace-nowrap font-mono">
                                <a href="{{ route('admin.transaksi-online.show', $trx->id) }}" class="hover:underline">
                                    {{ $trx->kode_transaksi }}
                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-slate-500">
                                {{ \Carbon\Carbon::parse($trx->tanggal_transaksi ?? $trx->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-4 font-bold text-slate-800 whitespace-nowrap">
                                {{ $trx->nama_pelanggan }}
                            </td>
                            <td class="px-4 py-4 text-slate-500 whitespace-nowrap">
                                {{ $trx->metode_pengambilan }}
                            </td>
                            <td class="px-5 py-4 text-right font-bold text-slate-800 whitespace-nowrap">
                                Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @php
                                    $statusBadge = match($trx->status) {
                                        'Menunggu Pembayaran' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Menunggu Verifikasi' => 'bg-blue-50 text-blue-600 border-blue-100 animate-pulse',
                                        'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'Diproses' => 'bg-sky-50 text-sky-600 border-sky-100',
                                        'Siap Diambil', 'Sedang Diantar' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Dibatalkan' => 'bg-slate-50 text-slate-400 border-slate-200',
                                        default => 'bg-slate-50 text-slate-400 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold border {{ $statusBadge }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.transaksi-online.show', $trx->id) }}" title="Detail & Verifikasi"
                                        class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl border border-slate-200 bg-white text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition shadow-sm text-xs font-bold gap-1">
                                        <span>Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-300 mb-2 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="text-xs">Belum ada pesanan online dari marketplace.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if (method_exists($transaksis, 'hasPages') && $transaksis->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
