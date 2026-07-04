@extends('layouts.app')

@section('title', 'Detail Supplier - ' . $supplier->nama_supplier)

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">

    {{-- ===== 1. HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
        <div class="flex items-center gap-4">
            <a href="{{ route('supplier.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Detail Supplier</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-semibold">ID Supplier: SPL-{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
        <div class="text-xs text-slate-400 font-medium">
            Terdaftar pada: {{ $supplier->created_at->format('d M Y, H:i') }}
        </div>
    </div>

    {{-- ===== 2. STATUS ===== --}}
    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 flex items-center justify-between gap-3 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="text-slate-400 text-sm font-medium">Status Kelengkapan:</span>
            @if($supplier->status === 'Lengkap')
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm uppercase tracking-wider">
                    Lengkap
                </span>
            @else
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100 shadow-sm uppercase tracking-wider animate-pulse">
                    Perlu Dilengkapi
                </span>
            @endif
        </div>
        <p class="text-xs text-slate-400 font-light hidden sm:block">Pastikan informasi alamat, telepon, dan PIC terisi lengkap.</p>
    </div>

    {{-- ===== 3. INFORMASI UTAMA ===== --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6 space-y-6">
        <h2 class="text-base font-bold text-slate-800 border-b border-slate-50 pb-3">Informasi Distributor / Rekanan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Perusahaan / Supplier</label>
                    <span class="block text-slate-850 font-bold mt-1 text-base">{{ $supplier->nama_supplier }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat Kantor</label>
                    <span class="block text-slate-700 font-medium mt-1 leading-relaxed">{{ $supplier->alamat ?? '-' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Kota</label>
                    <span class="block text-slate-700 font-bold mt-1">{{ $supplier->kota ?? '-' }}</span>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Kontak Person (PIC)</label>
                    <span class="block text-slate-800 font-bold mt-1 text-sm">{{ $supplier->kontak_pic ?? '-' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Telepon</label>
                    <span class="block text-slate-700 font-semibold mt-1 font-mono text-blue-600">{{ $supplier->telepon ?? '-' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat Email</label>
                    <span class="block text-slate-700 font-medium mt-1">{{ $supplier->email ?? '-' }}</span>
                </div>
            </div>
        </div>

        @if($supplier->keterangan)
            <div class="pt-4 border-t border-slate-50">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Keterangan Catatan</label>
                <p class="text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-100 leading-relaxed italic">{{ $supplier->keterangan }}</p>
            </div>
        @endif
    </div>

    {{-- ===== 4. TIMELINE ===== --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <h3 class="font-bold text-slate-800 text-sm mb-6 border-b border-slate-50 pb-3">Status Verifikasi & Aktivitas</h3>
        
        <div class="relative pl-6 border-l-2 border-slate-100 space-y-6">
            <div class="relative">
                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-600 border-4 border-white shadow-sm"></div>
                <h4 class="text-xs font-bold text-slate-850">Distributor Terdaftar</h4>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ $supplier->created_at->format('d M Y, H:i') }}</p>
            </div>
            
            <div class="relative">
                @php
                    $picOk = !empty($supplier->kontak_pic) && !empty($supplier->telepon);
                    $picDot = $picOk ? 'bg-emerald-600' : 'bg-amber-500 animate-pulse';
                @endphp
                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full {{ $picDot }} border-4 border-white shadow-sm"></div>
                <h4 class="text-xs font-bold text-slate-850">Verifikasi Kontak Person (PIC)</h4>
                <p class="text-[10px] text-slate-400 mt-0.5">
                    {{ $picOk ? 'Kontak dan PIC berhasil diverifikasi' : 'Harap lengkapi kontak person dan telepon distributor' }}
                </p>
            </div>
            
            <div class="relative">
                @php
                    $isLengkap = $supplier->status === 'Lengkap';
                    $statusDot = $isLengkap ? 'bg-emerald-600' : 'bg-slate-300';
                @endphp
                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full {{ $statusDot }} border-4 border-white shadow-sm"></div>
                <h4 class="text-xs font-bold text-slate-850">Mitra Kerja Sama Aktif</h4>
                <p class="text-[10px] text-slate-400 mt-0.5">
                    {{ $isLengkap ? 'Telah siap melakukan penyediaan obat resmi' : 'Menunggu kelengkapan dokumen distributor' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ===== 5. RIWAYAT ===== --}}
    @php
        $suppliedObats = \App\Models\Obat::where('supplier_id', $supplier->id)->latest()->take(5)->get();
    @endphp
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <h3 class="font-bold text-slate-800 text-sm mb-4 border-b border-slate-50 pb-3">Daftar Pasokan Obat Terakhir</h3>
        
        @if($suppliedObats->isEmpty())
            <div class="text-center py-6 text-slate-400 text-xs">
                <span>💊 Belum ada obat yang terdaftar di bawah supplier ini.</span>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                        <tr>
                            <th class="py-2.5 px-4">Nama Obat</th>
                            <th class="py-2.5 px-4">Kode Obat</th>
                            <th class="py-2.5 px-4 text-center">Stok</th>
                            <th class="py-2.5 px-4 text-right">Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-655 font-medium">
                        @foreach($suppliedObats as $obat)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-4 font-bold text-slate-800">{{ $obat->nama_obat }}</td>
                                <td class="py-3 px-4 font-mono">{{ $obat->kode_obat }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded font-bold {{ $obat->stok > 10 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600 animate-pulse' }}">
                                        {{ $obat->stok }} Pcs
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right font-bold">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ===== 6. ACTION ===== --}}
    <div class="flex items-center justify-end gap-3 pt-4">
        <a href="{{ route('supplier.edit', $supplier->id) }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow transition inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit / Lengkapi
        </a>

        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 rounded-xl font-bold text-xs transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus
            </button>
        </form>
    </div>

</div>
@endsection
