@extends('layouts.app')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Data Transaksi 📑</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola transaksi penjualan obat Mekar Pharmacy.</p>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('transaksi.create') }}"
                    class="btn bg-blue-600 hover:bg-blue-700 text-white inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors text-decoration-none">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Transaksi</span>
                </a>
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

        <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-slate-200">
                    <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                        <tr>
                            <th class="px-5 py-4 font-semibold text-center w-24">No</th>
                            <th class="px-4 text-left py-4 whitespace-nowrap w-48">Kode Transaksi</th>
                            <th class="px-4 pl-2 py-4 text-left w-36">Tanggal</th>
                            <th class="px-4 pl-2 py-4 text-left">Pelanggan</th>
                            <th class="px-4 py-4 text-center w-28">Item</th>
                            <th class="px-5 py-4 font-semibold text-right w-40">Total Harga</th>
                            <th class="px-5 py-4 font-semibold text-right w-40">Bayar</th>
                            <th class="px-5 py-4 font-semibold text-center w-36">Kembalian</th>
                            <th class="px-5 py-4 font-semibold text-center w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 text-slate-700">
                        @forelse ($transaksis as $index => $trx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-4 text-center font-medium text-slate-400 whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 font-bold text-blue-600 whitespace-nowrap">
                                    <a href="{{ route('transaksi.show', $trx->id) }}" class="hover:underline">
                                        {{ $trx->kode_transaksi }}
                                    </a>
                                </td>
                                <td class="px-4 pl-2 py-4 text-left whitespace-nowrap text-slate-500">
                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi ?? $trx->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-4 pl-2 py-4 text-left font-semibold text-slate-800 whitespace-nowrap">
                                    {{ $trx->nama_pelanggan ?? 'Umum' }}
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                        {{ $trx->total_item ?? '1' }} item
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right font-bold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-right text-slate-600 whitespace-nowrap">
                                    Rp {{ number_format($trx->bayar ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-center whitespace-nowrap font-medium text-emerald-600">
                                    Rp {{ number_format($trx->kembalian ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('transaksi.show', $trx->id) }}" title="Detail"
                                            class="inline-flex items-center justify-center p-2 rounded-lg border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('transaksi.edit', $trx->id) }}" title="Edit"
                                            class="inline-flex items-center justify-center p-2 rounded-lg border border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-200 hover:bg-amber-50 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"
                                            class="m-0 inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="inline-flex items-center justify-center p-2 rounded-lg border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="text-sm font-medium">Belum ada riwayat transaksi penjualan.</span>
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
