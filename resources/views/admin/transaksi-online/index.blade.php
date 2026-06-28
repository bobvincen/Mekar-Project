@extends('layouts.app')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Pesanan Online 🛒</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola transaksi dan verifikasi pembayaran dari pelanggan marketplace.</p>
            </div>
        </div>

        @if (session('success'))
            <div x-data="{ open: true }" x-show="open"
                class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-lg flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="open = false" class="text-emerald-400 hover:text-emerald-600"><svg class="w-4 h-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg></button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ open: true }" x-show="open"
                class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-600 rounded-lg flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button @click="open = false" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg></button>
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-slate-200">
                    <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                        <tr>
                            <th class="px-5 py-4 font-semibold text-center w-20">No</th>
                            <th class="px-4 text-left py-4 whitespace-nowrap w-48">Kode Invoice</th>
                            <th class="px-4 pl-2 py-4 text-left w-36">Tanggal</th>
                            <th class="px-4 pl-2 py-4 text-left">Pelanggan</th>
                            <th class="px-4 pl-2 py-4 text-left w-36">Metode</th>
                            <th class="px-5 py-4 font-semibold text-right w-40">Total Harga</th>
                            <th class="px-5 py-4 font-semibold text-center w-48">Status</th>
                            <th class="px-5 py-4 font-semibold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 text-slate-700">
                        @forelse ($transaksis as $index => $trx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-4 text-center font-medium text-slate-400 whitespace-nowrap">
                                    {{ $transaksis->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4 font-bold text-blue-600 whitespace-nowrap font-mono">
                                    <a href="{{ route('admin.transaksi-online.show', $trx->id) }}" class="hover:underline">
                                        {{ $trx->kode_transaksi }}
                                    </a>
                                </td>
                                <td class="px-4 pl-2 py-4 text-left whitespace-nowrap text-slate-500">
                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi ?? $trx->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 pl-2 py-4 text-left font-semibold text-slate-800 whitespace-nowrap">
                                    {{ $trx->nama_pelanggan }}
                                </td>
                                <td class="px-4 pl-2 py-4 text-left whitespace-nowrap text-slate-500">
                                    {{ $trx->metode_pengambilan }}
                                </td>
                                <td class="px-5 py-4 text-right font-bold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    @php
                                        $statusBadge = match($trx->status) {
                                            'Menunggu Pembayaran' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            'Menunggu Verifikasi' => 'bg-blue-50 text-blue-600 border-blue-200 animate-pulse',
                                            'Ditolak' => 'bg-red-50 text-red-600 border-red-200',
                                            'Diproses' => 'bg-sky-50 text-sky-600 border-sky-200',
                                            'Siap Diambil', 'Sedang Diantar' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                            'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'Dibatalkan' => 'bg-slate-50 text-slate-500 border-slate-200',
                                            default => 'bg-slate-50 text-slate-500 border-slate-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusBadge }}">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.transaksi-online.show', $trx->id) }}" title="Detail & Verifikasi"
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all shadow-sm text-xs font-bold gap-1">
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
                                <td colspan="8" class="px-5 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="text-sm font-medium">Belum ada pesanan online dari marketplace.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($transaksis, 'hasPages') && $transaksis->hasPages())
                <div class="px-5 py-4 border-t border-slate-200">
                    {{ $transaksis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
