@extends('marketplace.layouts.app')

@section('title', 'Resep Saya')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Riwayat Resep Saya</h1>
            <p class="text-slate-500 font-light mt-1">Daftar resep dokter yang pernah Anda unggah dan status pemrosesannya</p>
        </div>
        <div>
            <a href="{{ route('resep.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-md shadow-blue-600/20 hover:shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Unggah Resep Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-4">
        @forelse($reseps as $resep)
            @php
                $statusColors = [
                    'menunggu_verifikasi' => 'bg-amber-50 text-amber-600 border-amber-200',
                    'sedang_diproses'     => 'bg-blue-50 text-blue-600 border-blue-200',
                    'menunggu_persetujuan' => 'bg-purple-50 text-purple-600 border-purple-200',
                    'siap_checkout'       => 'bg-indigo-50 text-indigo-600 border-indigo-200',
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

            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <!-- Info Kiri -->
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 shrink-0 flex items-center justify-center">
                        <img src="{{ route('resep.file', $resep->id) }}" alt="Resep" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="text-xs text-slate-400 font-medium">{{ $resep->created_at->format('d M Y, H:i') }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $colorClass }}">
                                {{ $label }}
                            </span>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">
                            Resep Dokter #{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}
                        </h3>
                        <p class="text-slate-500 text-xs font-light line-clamp-1 max-w-lg">
                            Catatan: {{ $resep->catatan ?: '-' }}
                        </p>
                    </div>
                </div>

                <!-- Aksi Kanan -->
                <div class="flex items-center gap-3 shrink-0 self-end md:self-center">
                    @if($resep->status === 'menunggu_persetujuan')
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                        <a href="{{ route('resep.show', $resep->id) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs transition uppercase tracking-wider">
                            Tinjau Penawaran
                        </a>
                    @else
                        <a href="{{ route('resep.show', $resep->id) }}" class="px-5 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-bold rounded-xl text-xs transition uppercase tracking-wider">
                            Lihat Detail
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-100 rounded-3xl p-16 text-center shadow-sm">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Resep Dokter</h3>
                <p class="text-slate-500 text-sm font-light max-w-sm mx-auto mb-6">Anda belum pernah mengunggah resep dokter untuk pemesanan obat online.</p>
                <a href="{{ route('resep.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-md">
                    Unggah Resep Pertama
                </a>
            </div>
        @endforelse
    </div>

    @if($reseps->hasPages())
        <div class="mt-8">
            {{ $reseps->links() }}
        </div>
    @endif

</div>
@endsection
