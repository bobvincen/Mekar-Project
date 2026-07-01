@extends('layouts.app')

@section('title', 'Verifikasi Resep Dokter')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi Resep Dokter</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar unggahan resep dokter oleh pelanggan yang perlu diverifikasi</p>
    </div>
    
    <!-- Filter Status -->
    <div class="flex flex-wrap items-center gap-1.5 bg-white p-1.5 rounded-xl border border-gray-200">
        <a href="{{ route('apoteker.resep.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ !$status ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'menunggu_verifikasi']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'menunggu_verifikasi' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Menunggu Verifikasi
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'sedang_diproses']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'sedang_diproses' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Sedang Diproses
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'menunggu_persetujuan']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'menunggu_persetujuan' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Menunggu Persetujuan
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'siap_checkout']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'siap_checkout' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Siap Checkout
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'checkout']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'checkout' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Checkout
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'selesai']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'selesai' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Selesai
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'ditolak']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'ditolak' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Ditolak
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 text-green-600 border border-green-200 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                    <th class="py-4 px-6 font-semibold whitespace-nowrap">Tanggal Unggah</th>
                    <th class="py-4 px-6 font-semibold">Nama Pelanggan</th>
                    <th class="py-4 px-6 font-semibold">Kontak WA</th>
                    <th class="py-4 px-6 font-semibold">Catatan Pelanggan</th>
                    <th class="py-4 px-6 font-semibold text-center">Status</th>
                    <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($reseps as $resep)
                @php
                    $statusColors = [
                        'menunggu_verifikasi' => 'bg-amber-50 text-amber-600 border-amber-200',
                        'sedang_diproses'     => 'bg-blue-50 text-blue-600 border-blue-200',
                        'menunggu_persetujuan' => 'bg-purple-50 text-purple-600 border-purple-200',
                        'siap_checkout'       => 'bg-indigo-50 text-indigo-650 border-indigo-200',
                        'checkout'            => 'bg-sky-50 text-sky-600 border-sky-200',
                        'selesai'             => 'bg-green-50 text-green-600 border-green-200',
                        'ditolak'             => 'bg-red-50 text-red-600 border-red-200',
                    ];

                    $statusLabels = [
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'sedang_diproses'     => 'Sedang Diproses',
                        'menunggu_persetujuan' => 'Menunggu Persetujuan',
                        'siap_checkout'       => 'Siap Checkout',
                        'checkout'            => 'Checkout',
                        'selesai'             => 'Selesai',
                        'ditolak'             => 'Ditolak',
                    ];

                    $colorClass = $statusColors[$resep->status] ?? 'bg-slate-50 text-slate-650 border-slate-200';
                    $label = $statusLabels[$resep->status] ?? $resep->status;
                @endphp
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6 whitespace-nowrap text-gray-500">
                        {{ $resep->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="py-4 px-6 font-semibold text-gray-900">
                        {{ $resep->nama }}
                    </td>
                    <td class="py-4 px-6">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $resep->whatsapp) }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                            {{ $resep->whatsapp }} ↗
                        </a>
                    </td>
                    <td class="py-4 px-6 max-w-xs truncate" title="{{ $resep->catatan }}">
                        {{ $resep->catatan ?: '-' }}
                    </td>
                    <td class="py-4 px-6 text-center whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold border rounded-lg uppercase tracking-wider {{ $colorClass }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right whitespace-nowrap">
                        <div class="flex justify-end gap-2">
                            @if(in_array($resep->status, ['menunggu_verifikasi', 'sedang_diproses', 'menunggu_persetujuan']))
                                <a href="{{ route('resep.proses', $resep->id) }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-xs font-bold transition">
                                    Proses Resep
                                </a>
                            @else
                                <a href="{{ route('apoteker.resep.show', $resep->id) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-xs font-bold transition">
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-4">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>Tidak ada data resep dokter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($reseps->hasPages())
    <div class="mt-4">
        {{ $reseps->links() }}
    </div>
@endif
@endsection
