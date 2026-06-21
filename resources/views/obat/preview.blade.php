@extends('layouts.app')

@section('title', 'Preview Import Obat')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-lg p-6 md:p-8">

    <!-- Header Section -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('obat.index') }}" class="p-2.5 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Preview Import Data Obat
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Tinjau data obat sebelum disimpan ke database
            </p>
        </div>
    </div>

    <!-- Summary Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Data -->
        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Baris</p>
                <h3 class="text-2xl font-bold text-gray-700 mt-1">{{ $totalRows }}</h3>
            </div>
            <div class="w-10 h-10 bg-gray-200/50 rounded-xl flex items-center justify-center text-lg">📊</div>
        </div>

        <!-- Valid Data -->
        <div class="bg-green-50 rounded-2xl p-5 border border-green-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Data Valid</p>
                <h3 class="text-2xl font-bold text-green-700 mt-1">{{ $validCount }}</h3>
            </div>
            <div class="w-10 h-10 bg-green-200/50 rounded-xl flex items-center justify-center text-lg">✓</div>
        </div>

        <!-- Error Data -->
        <div class="bg-red-50 rounded-2xl p-5 border border-red-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Data Error</p>
                <h3 class="text-2xl font-bold text-red-700 mt-1">{{ $errorCount }}</h3>
            </div>
            <div class="w-10 h-10 bg-red-200/50 rounded-xl flex items-center justify-center text-lg">✗</div>
        </div>

        <!-- Status Akhir -->
        <div class="rounded-2xl p-5 border flex items-center justify-between {{ $errorCount > 0 ? 'bg-amber-50 border-amber-100' : 'bg-blue-50 border-blue-100' }}">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider {{ $errorCount > 0 ? 'text-amber-600' : 'text-blue-600' }}">Status</p>
                <h4 class="text-sm font-bold mt-1 {{ $errorCount > 0 ? 'text-amber-800' : 'text-blue-800' }}">
                    {{ $errorCount > 0 ? 'Perlu Perbaikan' : 'Siap Import' }}
                </h4>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg {{ $errorCount > 0 ? 'bg-amber-200/50' : 'bg-blue-200/50' }}">
                {{ $errorCount > 0 ? '⚠' : '✨' }}
            </div>
        </div>
    </div>

    <!-- Master Data Baru Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- New Categories -->
        <div class="border rounded-2xl p-5 bg-white shadow-sm">
            <h3 class="font-bold text-gray-700 mb-3 flex items-center gap-2">
                <span class="text-blue-500">📁</span> Kategori Baru yang Akan Dibuat ({{ count($newCategories) }})
            </h3>
            @if(count($newCategories) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($newCategories as $cat)
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold rounded-lg">{{ $cat }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-gray-400 italic">Semua kategori sudah terdaftar dalam sistem.</p>
            @endif
        </div>

        <!-- New Suppliers -->
        <div class="border rounded-2xl p-5 bg-white shadow-sm">
            <h3 class="font-bold text-gray-700 mb-3 flex items-center gap-2">
                <span class="text-purple-500">🚚</span> Supplier Baru yang Akan Dibuat ({{ count($newSuppliers) }})
            </h3>
            @if(count($newSuppliers) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($newSuppliers as $sup)
                        <span class="px-3 py-1 bg-purple-50 text-purple-700 border border-purple-100 text-xs font-bold rounded-lg">{{ $sup }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-gray-400 italic">Semua supplier sudah terdaftar dalam sistem.</p>
            @endif
        </div>
    </div>

    <!-- Error List Section -->
    @if($errorCount > 0)
        <div class="mb-8 border border-red-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="bg-red-50 px-5 py-4 border-b border-red-200">
                <h3 class="font-bold text-red-800 flex items-center gap-2">
                    <span>✗</span> Daftar Kesalahan pada Baris Excel (Harus Diperbaiki)
                </h3>
                <p class="text-xs text-red-600 mt-1">Harap perbaiki data di bawah ini pada file Excel Anda, lalu unggah kembali.</p>
            </div>
            <div class="p-5 max-h-80 overflow-y-auto space-y-3 bg-red-50/20">
                @foreach($errors as $rowNum => $rowErrors)
                    <div class="flex items-start gap-3 bg-white p-3 rounded-xl border border-red-100 shadow-sm">
                        <span class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-extrabold rounded-lg">Baris {{ $rowNum }}</span>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-1 font-medium">
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
    <div class="border rounded-2xl overflow-hidden shadow-sm bg-white mb-8">
        <div class="bg-slate-50 px-5 py-4 border-b">
            <h3 class="font-bold text-gray-700 flex items-center gap-2">
                <span>✓</span> Rincian Data Obat Valid ({{ $validCount }} Data)
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-gray-400 font-semibold uppercase text-xs">
                        <th class="text-left py-4 px-5">No</th>
                        <th class="text-left py-4 px-5">Nama Obat</th>
                        <th class="text-center py-4 px-5">Gambar</th>
                        <th class="text-left py-4 px-5">Kategori</th>
                        <th class="text-left py-4 px-5">Supplier</th>
                        <th class="text-center py-4 px-5">Stok</th>
                        <th class="text-right py-4 px-5">Harga Jual</th>
                        <th class="text-center py-4 px-5">Kadaluarsa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($validRows as $valRow)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3 px-5 font-semibold text-gray-400">{{ $loop->iteration }}</td>
                            <td class="py-3 px-5 font-bold text-gray-700">{{ $valRow['nama_obat'] }}</td>
                            <td class="py-3 px-5 text-center">
                                @if(!empty($valRow['gambar_temp_path']))
                                    <img src="{{ asset('storage/' . $valRow['gambar_temp_path']) }}" alt="Preview" class="w-12 h-12 rounded-lg object-cover mx-auto border shadow-sm">
                                    <span class="text-[9px] text-green-600 font-bold block mt-1">Sesuai ZIP</span>
                                @elseif(!empty($valRow['gambar']))
                                    <div class="text-[10px] text-amber-600 font-semibold leading-tight">
                                        {{ $valRow['gambar'] }}
                                        <span class="text-[8px] text-amber-500 block mt-0.5">(Tidak ada di ZIP)</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-5">{{ $valRow['kategori'] }}</td>
                            <td class="py-3 px-5">{{ $valRow['supplier'] }}</td>
                            <td class="py-3 px-5 text-center font-semibold text-gray-600">{{ $valRow['stok'] }}</td>
                            <td class="py-3 px-5 text-right font-bold text-slate-800">Rp {{ number_format($valRow['harga_jual'], 0, ',', '.') }}</td>
                            <td class="py-3 px-5 text-center font-mono text-gray-500">{{ $valRow['tanggal_kadaluarsa'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-400 italic">Tidak ada data valid dalam file.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
        <a href="{{ route('obat.index') }}" class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-center transition-colors">
            Batal
        </a>

        @if($errorCount === 0 && $validCount > 0)
            <form action="{{ route('obat.import') }}" method="POST">
                @csrf
                <button type="submit" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-md hover:shadow-lg transition-all uppercase tracking-wider text-xs">
                    Konfirmasi Import
                </button>
            </form>
        @else
            <button disabled class="px-8 py-3 rounded-xl bg-gray-300 text-gray-500 font-bold cursor-not-allowed uppercase tracking-wider text-xs flex items-center gap-2">
                <span>⚠</span> Tidak Dapat Diimport
            </button>
        @endif
    </div>

</div>
@endsection
