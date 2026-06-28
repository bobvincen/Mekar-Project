@extends('layouts.app')

@section('title', 'Preview Import Obat')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('obat.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Preview Import Data Obat</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau data lembar kerja Excel sebelum disimpan permanen ke database</p>
        </div>
    </div>

    <!-- Summary KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Data -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Baris</span>
                <h3 class="text-xl font-extrabold text-slate-800">{{ $totalRows }}</h3>
            </div>
            <div class="p-3 bg-slate-50 text-slate-400 rounded-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
        </div>

        <!-- Valid Data -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Valid</span>
                <h3 class="text-xl font-extrabold text-emerald-600">{{ $validCount }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Error Data -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Error</span>
                <h3 class="text-xl font-extrabold text-rose-600">{{ $errorCount }}</h3>
            </div>
            <div class="p-3 bg-rose-50 text-rose-500 rounded-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Status Card -->
        <div class="p-5 rounded-2xl border flex items-center justify-between shadow-[0_4px_20px_rgba(0,0,0,0.02)] {{ $errorCount > 0 ? 'bg-amber-50 border-amber-100' : 'bg-blue-50 border-blue-100' }}">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider {{ $errorCount > 0 ? 'text-amber-500' : 'text-blue-500' }}">Status Dokumen</span>
                <h4 class="text-sm font-extrabold {{ $errorCount > 0 ? 'text-amber-800' : 'text-blue-800' }}">
                    {{ $errorCount > 0 ? 'Perlu Perbaikan' : 'Siap Import' }}
                </h4>
            </div>
            <div class="p-3 rounded-xl {{ $errorCount > 0 ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600' }}">
                @if($errorCount > 0)
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <!-- Master Data Baru Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- New Categories -->
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
            <h3 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                <span class="p-1.5 bg-blue-50 text-blue-500 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </span> 
                Kategori Baru Akan Dibuat ({{ count($newCategories) }})
            </h3>
            @if(count($newCategories) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($newCategories as $cat)
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 text-xs font-bold rounded-lg">{{ $cat }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Semua kategori sudah terdaftar dalam sistem.</p>
            @endif
        </div>

        <!-- New Suppliers -->
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
            <h3 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                <span class="p-1.5 bg-indigo-50 text-indigo-500 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
                Supplier Baru Akan Dibuat ({{ count($newSuppliers) }})
            </h3>
            @if(count($newSuppliers) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($newSuppliers as $sup)
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 text-xs font-bold rounded-lg">{{ $sup }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Semua supplier sudah terdaftar dalam sistem.</p>
            @endif
        </div>
    </div>

    <!-- Error List Section -->
    @if($errorCount > 0)
        <div class="border border-rose-200 rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
            <div class="bg-rose-50 px-5 py-4 border-b border-rose-100">
                <h3 class="font-bold text-rose-800 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Daftar Kesalahan pada Baris Excel (Harus Diperbaiki)
                </h3>
                <p class="text-xs text-rose-600 mt-1 font-medium">Harap perbaiki data di bawah ini pada berkas Excel Anda, lalu unggah kembali.</p>
            </div>
            <div class="p-5 max-h-80 overflow-y-auto space-y-3 bg-rose-50/20 custom-scrollbar">
                @foreach($errors as $rowNum => $rowErrors)
                    <div class="flex items-start gap-3 bg-white p-3 rounded-xl border border-rose-100/50 shadow-sm">
                        <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-[10px] font-extrabold rounded-lg whitespace-nowrap">Baris {{ $rowNum }}</span>
                        <ul class="list-disc list-inside text-xs text-rose-600 space-y-1 font-semibold">
                            @foreach($rowErrors as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Valid Data Table Section -->
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
        <div class="p-5 border-b border-slate-50 bg-slate-50/25">
            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Rincian Data Obat Valid ({{ $validCount }} Data)
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-4 px-5 w-16 text-center">No</th>
                        <th class="py-4 px-5">Nama Obat</th>
                        <th class="py-4 px-5 text-center w-24">Gambar</th>
                        <th class="py-4 px-5">Kategori</th>
                        <th class="py-4 px-5">Supplier</th>
                        <th class="py-4 px-5 text-center w-24">Stok</th>
                        <th class="py-4 px-5 text-right w-36">Harga Jual</th>
                        <th class="py-4 px-5 text-center w-36">Kadaluarsa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($validRows as $valRow)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-5 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="py-3 px-5 font-bold text-slate-800">{{ $valRow['nama_obat'] }}</td>
                            <td class="py-3 px-5 text-center">
                                @if(!empty($valRow['gambar_temp_path']))
                                    <img src="{{ asset('storage/' . $valRow['gambar_temp_path']) }}" alt="Preview" class="w-10 h-10 rounded-lg object-cover mx-auto border border-slate-100 shadow-sm">
                                    <span class="text-[9px] text-emerald-600 font-bold block mt-1">Sesuai ZIP</span>
                                @elseif(!empty($valRow['gambar']))
                                    <div class="text-[10px] text-amber-600 font-bold leading-tight">
                                        {{ $valRow['gambar'] }}
                                        <span class="text-[8px] text-amber-500 block font-medium mt-0.5">(Tidak di ZIP)</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic font-normal">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-5 text-slate-500">{{ $valRow['kategori'] }}</td>
                            <td class="py-3 px-5 text-slate-500">{{ $valRow['supplier'] }}</td>
                            <td class="py-3 px-5 text-center font-bold text-slate-700">{{ $valRow['stok'] }}</td>
                            <td class="py-3 px-5 text-right font-bold text-slate-800">Rp {{ number_format($valRow['harga_jual'], 0, ',', '.') }}</td>
                            <td class="py-3 px-5 text-center font-mono text-xs text-slate-400">{{ $valRow['tanggal_kadaluarsa'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-400 italic font-normal">Tidak ada data valid dalam file.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
        <a href="{{ route('obat.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold transition text-sm">
            Batal
        </a>

        @if($errorCount === 0 && $validCount > 0)
            <form action="{{ route('obat.import') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                    Konfirmasi Import
                </button>
            </form>
        @else
            <button disabled class="px-5 py-2.5 rounded-xl bg-slate-200 text-slate-400 font-semibold cursor-not-allowed text-sm inline-flex items-center gap-1.5 border border-slate-300">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Tidak Dapat Diimport
            </button>
        @endif
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection
