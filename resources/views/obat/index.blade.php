@extends('layouts.app')

@section('title', 'Obat')

@section('content')
    <div class="w-full bg-white rounded-3xl shadow-lg p-6 md:p-8">

        <!-- Header and Action Buttons -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">Data Obat</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola informasi obat dan stok distributor Mekar Pharmacy</p>
            </div>

            <div class="flex flex-wrap lg:flex-nowrap gap-3 w-full lg:w-auto items-stretch lg:items-center">
                <!-- Search Input -->
                <div class="relative flex items-center w-full lg:w-80">
                    <input type="text" id="inputCari" placeholder="Cari kode atau nama obat..."
                        class="w-full pl-12 pr-10 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm font-semibold text-gray-700 placeholder-gray-400">
                    <div class="absolute left-4 text-gray-400 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="button" id="btnClear" class="hidden absolute right-4 text-gray-400 hover:text-gray-600 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Template Excel Link -->
                <a href="{{ route('obat.download-template') }}"
                   class="border border-gray-200 hover:bg-gray-50 text-gray-700 px-5 py-3 rounded-xl font-semibold inline-flex items-center justify-center gap-1.5 text-sm transition-all duration-200 shadow-sm whitespace-nowrap text-decoration-none">
                    📄 Template Excel
                </a>

                <!-- Import Data Button (Opens Modal) -->
                <button type="button" onclick="document.getElementById('modalImport').classList.remove('hidden')"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl inline-flex items-center justify-center gap-1.5 font-semibold text-sm transition-all duration-200 shadow-sm whitespace-nowrap">
                    📥 Import Data
                </button>

                <!-- Tambah Obat Link -->
                <a href="{{ route('obat.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl flex items-center justify-center gap-2 font-semibold shadow-md hover:shadow-lg transition-all duration-200 whitespace-nowrap text-decoration-none text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Obat</span>
                </a>
            </div>
        </div>

        <!-- Notification Alerts -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-800 text-sm font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 transition-colors">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-800 text-sm font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 transition-colors">✕</button>
            </div>
        @endif

        <!-- Table Grid -->
        <div class="overflow-x-auto border border-gray-100 rounded-2xl shadow-sm w-full">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold border-b border-gray-200 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-32 text-center">Kode</th>
                        <th class="px-4 py-4 w-24 text-center">Gambar</th>
                        <th class="px-4 py-4 w-42">Nama Obat</th>
                        <th class="px-4 py-4 w-44">Kategori</th>
                        <th class="px-4 py-4 w-52">Supplier</th>
                        <th class="px-4 py-4 text-center w-24">Stok</th>
                        <th class="px-6 py-4 text-center w-40">Harga</th>
                        <th class="px-6 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($obats as $custom_obat)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                            <td class="px-6 py-4 text-center font-medium text-gray-500 whitespace-nowrap">
                                {{ $custom_obat->kode_obat }}
                            </td>
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                @if($custom_obat->image_path)
                                    <img src="{{ $custom_obat->image_url }}" alt="{{ $custom_obat->nama_obat }}" class="w-12 h-12 rounded-xl object-cover mx-auto border border-gray-200 shadow-sm">
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-400 border border-gray-200">
                                        Tidak Ada Gambar
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                {{ $custom_obat->nama_obat }}
                            </td>
                            <td class="px-4 py-4 text-gray-600 truncate">
                                {{ $custom_obat->kategori->nama_kategori }}
                            </td>
                            <td class="px-4 py-4 text-gray-600 truncate">
                                {{ $custom_obat->supplier->nama_supplier }}
                            </td>
                            <td class="px-4 py-4 text-center font-semibold">
                                <span class="{{ $custom_obat->stok <= 5 ? 'text-red-600 bg-red-50 px-2.5 py-1 rounded-lg font-bold' : 'text-gray-700' }}">
                                    {{ $custom_obat->stok }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800 text-center whitespace-nowrap">
                                Rp {{ number_format($custom_obat->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('obat.edit', $custom_obat->id) }}"
                                        class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150 text-decoration-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('obat.destroy', $custom_obat->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-gray-500 font-medium bg-gray-50/30">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2" />
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
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all duration-200">
            <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Import Data Obat</h2>
                <button type="button" onclick="tutupModalImport()" class="text-gray-400 hover:text-red-500 transition-colors text-sm font-bold p-1">✕</button>
            </div>

            <form action="{{ route('obat.preview-import') }}" method="POST" enctype="multipart/form-data" class="p-6 m-0">
                @csrf
                
                <!-- File Excel -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        File Excel <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="file_excel" accept=".xlsx,.xls" required
                        class="w-full border border-gray-300 focus:ring-blue-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 text-sm bg-white">
                    <p class="text-xs text-gray-400 mt-1.5">Unggah file excel template (.xlsx atau .xls).</p>
                </div>

                <!-- File ZIP Gambar -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        ZIP Gambar Obat <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="file" name="file_zip" accept=".zip"
                        class="w-full border border-gray-300 focus:ring-blue-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 text-sm bg-white">
                    <p class="text-xs text-gray-400 mt-1.5">Unggah file ZIP yang berisi gambar-gambar obat. Nama file gambar di dalam ZIP harus sesuai dengan nama file di kolom <b>gambar</b> pada Excel.</p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="tutupModalImport()"
                        class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition-all text-sm">
                        Preview Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tutorial & Alert Card -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panduan Card -->
        <div class="lg:col-span-2 bg-slate-50 border border-slate-100 rounded-3xl p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                📘 PANDUAN IMPORT DATA OBAT
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-600 leading-relaxed">
                <div>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 1</strong><br>Klik tombol <strong>"Template Excel"</strong> untuk mengunduh format Excel yang benar.</p>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 2</strong><br>Isi data obat sesuai contoh yang tersedia di dalam template.</p>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 3</strong><br>Jangan mengubah nama kolom pada template Excel.</p>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 4</strong><br>Pastikan stok berupa angka, harga berupa angka, dan tanggal menggunakan format YYYY-MM-DD.</p>
                </div>
                <div>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 5</strong><br>Simpan file Excel Anda dalam format <strong>.xlsx</strong>.</p>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 6</strong><br>Klik tombol <strong>"Import Data"</strong> dan pilih file Excel serta ZIP gambar Anda.</p>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 7</strong><br>Periksa hasil preview data di halaman preview. Pastikan statusnya valid.</p>
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 8</strong><br>Klik tombol <strong>"Konfirmasi Import"</strong> untuk menyimpan seluruh data obat ke sistem.</p>
                </div>
            </div>
        </div>

        <!-- Catatan Penting Card -->
        <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6">
            <h3 class="text-lg font-bold text-amber-800 mb-3 flex items-center gap-2">
                ⚠ CATATAN PENTING
            </h3>
            <ul class="list-disc list-inside text-sm text-amber-700 space-y-2 font-medium">
                <li>Nama kolom template tidak boleh diubah.</li>
                <li>Kategori baru akan dibuat otomatis jika belum tersedia.</li>
                <li>Supplier baru akan dibuat otomatis jika belum tersedia.</li>
                <li>Data yang salah tidak akan disimpan.</li>
                <li>Gunakan format file <strong>.xlsx</strong>.</li>
                <li>Periksa preview sebelum menekan tombol Import.</li>
            </ul>
        </div>
    </div>

    <!-- Active Search Filter Javascript -->
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
                        let kolomNama = baris.querySelector('td:nth-child(3)'); // Updated index from 2 to 3

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
                                <td colspan="8" class="text-center py-12 text-gray-400 font-medium bg-gray-50/10">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
@endsection
