@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Data Obat</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data informasi obat dan persediaan stok di apotek Anda</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('obat.download-template') }}" class="px-4 py-2.5 border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 rounded-xl font-semibold text-xs transition inline-flex items-center gap-1.5 shadow-sm">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Template Excel
            </a>
            <button type="button" onclick="document.getElementById('modalImport').classList.remove('hidden')" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-xs transition inline-flex items-center gap-1.5 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import Data
            </button>
            <a href="{{ route('obat.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl font-semibold text-xs shadow-md hover:shadow-lg transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Obat
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

    <!-- Search bar card & Table container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <!-- Search bar inside table layout -->
        <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="font-bold text-slate-800 text-base">Daftar Inventaris Obat</h3>
            
            <div class="relative w-full sm:w-80">
                <input type="text" id="inputCari" placeholder="Cari kode atau nama obat..."
                    class="w-full pl-10 pr-9 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="button" id="btnClear" class="hidden absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-32 text-center">Kode</th>
                        <th class="px-4 py-4 w-24 text-center">Gambar</th>
                        <th class="px-6 py-4">Nama Obat</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-4 py-4 text-center w-24">Stok</th>
                        <th class="px-6 py-4 text-right w-40">Harga Jual</th>
                        <th class="px-6 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($obats as $custom_obat)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="px-6 py-4 text-center font-bold text-slate-900 whitespace-nowrap">
                                {{ $custom_obat->kode_obat }}
                            </td>
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                @if($custom_obat->image_path)
                                    <img src="{{ $custom_obat->image_url }}" alt="{{ $custom_obat->nama_obat }}" class="w-11 h-11 rounded-xl object-cover mx-auto border border-slate-100 shadow-sm">
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                        N/A
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">
                                {{ $custom_obat->nama_obat }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $custom_obat->kategori->nama_kategori }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $custom_obat->supplier->nama_supplier }}
                            </td>
                            <td class="px-4 py-4 text-center font-bold">
                                @if($custom_obat->stok <= 5)
                                    <span class="px-2 py-0.5 text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 rounded-lg">
                                        {{ $custom_obat->stok }}
                                    </span>
                                @elseif($custom_obat->stok <= 20)
                                    <span class="px-2 py-0.5 text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100 rounded-lg">
                                        {{ $custom_obat->stok }}
                                    </span>
                                @else
                                    <span class="text-slate-700">
                                        {{ $custom_obat->stok }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800 text-right whitespace-nowrap">
                                Rp {{ number_format($custom_obat->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('obat.edit', $custom_obat->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('obat.destroy', $custom_obat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
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
                            <td colspan="8" class="text-center py-12 text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 stroke-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Belum ada data obat. Silakan tambahkan obat baru.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="modalImport" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all duration-200 border border-slate-100">
            <div class="flex justify-between items-center px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-800">Import Data Obat</h2>
                <button type="button" onclick="tutupModalImport()" class="text-slate-400 hover:text-rose-500 font-bold text-xs p-1">✕</button>
            </div>

            <form action="{{ route('obat.preview-import') }}" method="POST" enctype="multipart/form-data" class="p-6 m-0 space-y-5">
                @csrf
                
                <!-- File Excel -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        File Excel <span class="text-rose-500">*</span>
                    </label>
                    <input type="file" name="file_excel" accept=".xlsx,.xls" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white cursor-pointer">
                    <p class="text-xs text-slate-400 mt-1.5">Unggah file excel template (.xlsx atau .xls).</p>
                </div>

                <!-- File ZIP Gambar -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        ZIP Gambar Obat <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="file" name="file_zip" accept=".zip"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white cursor-pointer">
                    <p class="text-xs text-slate-400 mt-1.5">ZIP gambar obat. Nama file di dalam ZIP harus sesuai dengan nama gambar di Excel.</p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="tutupModalImport()"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                        Preview Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Instructions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panduan Card -->
        <div class="lg:col-span-2 bg-slate-50 border border-slate-100 rounded-2xl p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                PANDUAN IMPORT DATA OBAT
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-500 leading-relaxed font-medium">
                <div>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 1:</span> Unduh berkas template Excel yang benar.</p>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 2:</span> Isi baris data obat sesuai format contoh.</p>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 3:</span> Kolom header template tidak boleh diubah.</p>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 4:</span> Stok, harga, dan format tanggal (YYYY-MM-DD) wajib valid.</p>
                </div>
                <div>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 5:</span> Simpan file dalam bentuk berkas <strong>.xlsx</strong>.</p>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 6:</span> Unggah Excel dan ZIP gambar di form Import.</p>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 7:</span> Periksa validitas data di halaman preview.</p>
                    <p class="mb-3"><span class="font-bold text-blue-600">LANGKAH 8:</span> Klik tombol konfirmasi untuk melakukan import.</p>
                </div>
            </div>
        </div>

        <!-- Catatan Penting Card -->
        <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-6">
            <h3 class="text-base font-bold text-amber-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                CATATAN PENTING
            </h3>
            <ul class="list-disc list-inside text-xs text-amber-700/80 space-y-2 font-semibold">
                <li>Gunakan template excel yang telah disediakan.</li>
                <li>Kategori & Supplier baru akan terbuat otomatis jika belum terdaftar.</li>
                <li>Data tidak valid dilewati secara otomatis.</li>
                <li>Nama gambar di excel harus sama dengan di dalam ZIP.</li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function tutupModalImport() {
        document.getElementById('modalImport').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const inputCari = document.getElementById('inputCari');
        const btnClear = document.getElementById('btnClear');

        if (inputCari) {
            inputCari.addEventListener('keyup', function() {
                let kataKunci = this.value.toLowerCase().trim();
                let barisTabel = document.querySelectorAll('tbody tr:not(#barisKosong)');
                let dataDitemukan = false;

                if (kataKunci !== '') {
                    btnClear.classList.remove('hidden');
                } else {
                    btnClear.classList.add('hidden');
                }

                barisTabel.forEach(function(baris) {
                    let kolomKode = baris.querySelector('td:nth-child(1)');
                    let kolomNama = baris.querySelector('td:nth-child(3)');

                    if (kolomNama || kolomKode) {
                        let teksKode = kolomKode ? kolomKode.textContent.toLowerCase() : '';
                        let teksNama = kolomNama ? kolomNama.textContent.toLowerCase() : '';

                        if (teksKode.includes(kataKunci) || teksNama.includes(kataKunci)) {
                            baris.style.display = '';
                            dataDitemukan = true;
                        } else {
                            baris.style.display = 'none';
                        }
                    }
                });

                let barisKosong = document.getElementById('barisKosong');
                if (!dataDitemukan && kataKunci !== '') {
                    if (!barisKosong) {
                        let tbody = document.querySelector('tbody');
                        let tr = document.createElement('tr');
                        tr.id = 'barisKosong';
                        tr.innerHTML = `
                            <td colspan="8" class="text-center py-12 text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Tidak ada data obat yang cocok dengan "${inputCari.value}"</span>
                                </div>
                            </td>`;
                        tbody.appendChild(tr);
                    }
                } else if (barisKosong) {
                    barisKosong.remove();
                }
            });
        }

        if (btnClear) {
            btnClear.addEventListener('click', function() {
                inputCari.value = '';
                btnClear.classList.add('hidden');

                let barisTabel = document.querySelectorAll('tbody tr:not(#barisKosong)');
                barisTabel.forEach(function(baris) {
                    baris.style.display = '';
                });

                let barisKosong = document.getElementById('barisKosong');
                if (barisKosong) barisKosong.remove();

                inputCari.focus();
            });
        }
    });
</script>
@endpush
@endsection
