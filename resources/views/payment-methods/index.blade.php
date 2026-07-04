@extends('layouts.app')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Metode Pembayaran</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola metode pembayaran pelanggan yang tampil di halaman invoice marketplace</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.payment-methods.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl font-semibold text-xs shadow-md hover:shadow-lg transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Metode
            </a>
        </div>
    </div>

    <!-- Notification Alerts -->
    @if (session('success'))
        <div class="bg-green-50 text-green-600 border border-green-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Metode Pembayaran Aktif & Nonaktif</h3>
            <span class="text-xs text-slate-450">Total: <b>{{ count($paymentMethods) }}</b> Pilihan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                 <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-4 px-6 w-24 text-center">Gambar/Logo</th>
                        <th class="py-4 px-6">Nama Metode</th>
                        <th class="py-4 px-6">Tipe</th>
                        <th class="py-4 px-6">Nomor / Rekening</th>
                        <th class="py-4 px-6">Pemilik</th>
                        <th class="py-4 px-6 text-center w-32">Status</th>
                        <th class="py-4 px-6 text-center w-40">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-655 font-medium">
                    @forelse($paymentMethods as $method)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($method->image_path)
                                    <img src="{{ $method->image_url }}" alt="{{ $method->name }}" class="w-11 h-11 rounded-lg object-contain mx-auto border border-slate-100 bg-slate-50 p-1">
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-400">
                                        No Image
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800 whitespace-nowrap">
                                {{ $method->name }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                @php
                                    $typeLabels = [
                                        'bank_transfer' => 'Transfer Bank',
                                        'qris' => 'QRIS',
                                        'e_wallet' => 'E-Wallet',
                                    ];
                                    $typeColors = [
                                        'bank_transfer' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'qris' => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'e_wallet' => 'bg-cyan-50 text-cyan-600 border-cyan-100',
                                    ];
                                    $label = $typeLabels[$method->type] ?? $method->type;
                                    $color = $typeColors[$method->type] ?? 'bg-slate-50 text-slate-500';
                                @endphp
                                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold border {{ $color }} rounded-lg uppercase tracking-wider">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-600">
                                {{ $method->account_number ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $method->account_owner ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($method->is_active)
                                    <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold bg-slate-50 text-slate-550 border border-slate-200 rounded-lg">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Edit Metode">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Hapus Metode">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- EMPTY STATE --}}
                        <tr>
                            <td colspan="7" class="text-center py-16 text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mb-4 text-2xl">
                                        💳
                                    </div>
                                    <h3 class="font-bold text-slate-800 text-sm">Metode Pembayaran Kosong</h3>
                                    <p class="text-xs text-slate-455 mt-1 leading-relaxed">
                                        Mitra belum menambahkan metode pembayaran. Pelanggan tidak akan bisa melakukan checkout/pembayaran pesanan online.
                                    </p>
                                    <a href="{{ route('admin.payment-methods.create') }}" class="mt-4 px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold text-xs rounded-xl transition">
                                        Tambah Metode Pertama
                                    </a>
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
