@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Laporan Pesanan Online 🛍️</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar transaksi pesanan dari Marketplace Mekar Pharmacy.</p>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ open: true }" x-show="open" class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-lg flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button @click="open = false" class="text-emerald-400 hover:text-emerald-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-slate-200">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                    <tr>
                        <th class="px-5 py-4 font-semibold text-left">Kode / Tanggal</th>
                        <th class="px-5 py-4 font-semibold text-left">Pelanggan</th>
                        <th class="px-5 py-4 font-semibold text-left">Metode</th>
                        <th class="px-5 py-4 font-semibold text-right">Total Tagihan</th>
                        <th class="px-5 py-4 font-semibold text-center">Status</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-200">
                    @forelse ($transaksis as $trx)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $trx->kode_transaksi }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800">{{ $trx->nama_pelanggan }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $trx->whatsapp }}</div>
                            </td>
                            <td class="px-5 py-4">
                                @if($trx->metode_pengambilan == 'Ambil di Apotek')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Apotek
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600 border border-indigo-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                        Kirim
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="font-bold text-blue-600">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusColor = match($trx->status) {
                                        'Menunggu Konfirmasi' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        'Diproses' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Dikirim' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                        'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Dibatalkan' => 'bg-red-50 text-red-600 border-red-200',
                                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('admin.transaksi-online.show', $trx->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <span class="text-sm">Belum ada pesanan online yang masuk.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transaksis->hasPages())
        <div class="px-5 py-4 border-t border-slate-200">
            {{ $transaksis->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
