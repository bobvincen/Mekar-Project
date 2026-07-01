@extends('layouts.app')

@section('title', 'Transaksi POS')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Data Transaksi POS</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola transaksi penjualan langsung (POS) offline apotek</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('transaksi.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl font-semibold text-xs shadow-md hover:shadow-lg transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Transaksi POS
            </a>
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

    <!-- Export Report Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Rekap Laporan Penjualan PDF
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">Pilih rentang tanggal transaksi untuk mencetak berkas laporan rekap PDF</p>
        </div>

        <form action="{{ route('transaksi.export-pdf') }}" method="GET" target="_blank" class="flex flex-wrap items-end gap-4 m-0">
            @csrf

            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" required
                    class="w-full sm:w-48 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-750 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('tanggal_mulai', now()->startOfMonth()->format('Y-m-d')) }}">
            </div>

            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" required
                    class="w-full sm:w-48 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-750 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('tanggal_selesai', now()->format('Y-m-d')) }}">
            </div>

            <button type="submit"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-xs transition inline-flex items-center justify-center gap-1.5 shadow-sm">
                 Cetak PDF
            </button>
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
               <thead class="bg-slate-100 text-slate-600 font-bold text-xs uppercase border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-4 px-5 w-16 text-center">No</th>
                        <th class="py-4 px-5">Kode Transaksi</th>
                        <th class="py-4 px-5">Tanggal</th>
                        <th class="py-4 px-5">Pelanggan</th>
                        <th class="py-4 px-5 text-center w-28">Item</th>
                        <th class="py-4 px-5 text-right w-36">Total Harga</th>
                        <th class="py-4 px-5 text-right w-36">Bayar</th>
                        <th class="py-4 px-5 text-right w-36">Kembalian</th>
                        <th class="py-4 px-5 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($transaksis as $t)
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <td class="py-4 px-5 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="py-4 px-5 font-mono font-bold text-blue-600 whitespace-nowrap">
                                {{ $t->kode_transaksi }}
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap text-slate-550">
                                {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-5 text-slate-800 font-bold">
                                {{ $t->pelanggan->nama_pelanggan ?? 'Umum' }}
                            </td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full"></span>
                                    {{ $t->detailTransaksis->count() }} item
                                </span>
                            </td>
                            <td class="py-4 px-5 font-bold text-slate-800 text-right whitespace-nowrap">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-5 text-slate-500 text-right whitespace-nowrap">
                                Rp {{ number_format($t->bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-5 text-emerald-600 font-bold text-right whitespace-nowrap">
                                Rp {{ number_format($t->kembalian, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('transaksi.show', $t) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('transaksi.edit', $t) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-xl transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('transaksi.destroy', $t) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-12 text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 stroke-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>Belum ada data transaksi offline (POS).</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transaksis->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    Menampilkan <b>{{ $transaksis->firstItem() }}</b> sampai <b>{{ $transaksis->lastItem() }}</b> dari <b>{{ $transaksis->total() }}</b> transaksi
                </div>
                <div>
                    {{ $transaksis->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection