@extends('layouts.app')

@section('title', 'Verifikasi Resep Dokter')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi Resep Dokter</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar unggahan resep dokter oleh pelanggan yang perlu diverifikasi</p>
    </div>
    
    <!-- Filter Status -->
    <div class="flex items-center gap-1.5 bg-white p-1 rounded-xl border border-gray-200">
        <a href="{{ route('apoteker.resep.index') }}" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ !$status ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $status === 'pending' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Menunggu
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'disetujui']) }}" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $status === 'disetujui' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            Disetujui
        </a>
        <a href="{{ route('apoteker.resep.index', ['status' => 'ditolak']) }}" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $status === 'ditolak' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
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
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6 whitespace-nowrap text-gray-500">
                        {{ $resep->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="py-4 px-6 font-semibold text-gray-900">
                        {{ $resep->nama }}
                    </td>
                    <td class="py-4 px-6">
                        <a href="https://wa.me/{{ $resep->whatsapp }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                            {{ $resep->whatsapp }} ↗
                        </a>
                    </td>
                    <td class="py-4 px-6 max-w-xs truncate" title="{{ $resep->catatan }}">
                        {{ $resep->catatan ?: '-' }}
                    </td>
                    <td class="py-4 px-6 text-center whitespace-nowrap">
                        @if($resep->status === 'pending')
                            <span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-lg uppercase tracking-wider">
                                Menunggu
                            </span>
                        @elseif($resep->status === 'disetujui')
                            <span class="px-2.5 py-1 text-xs font-semibold bg-green-50 text-green-600 rounded-lg uppercase tracking-wider">
                                Disetujui
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold bg-red-50 text-red-600 rounded-lg uppercase tracking-wider">
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right whitespace-nowrap">
                        <a href="{{ route('apoteker.resep.show', $resep->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-lg text-xs font-bold transition">
                            Lihat Detail
                        </a>
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
