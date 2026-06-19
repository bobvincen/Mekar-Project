@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg p-6 md:p-8">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url('/home') }}"
                class="p-2.5 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-xl transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Data Kategori
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Kelola kategori obat
                </p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Data Kategori</h2>
                <p class="text-gray-500 text-sm mt-0.5">Kelola informasi kategori Mekar Pharmacy</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <input type="text" id="inputCari" placeholder="Cari kategori..."
                        class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 transition duration-150">
                    <span class="absolute right-3 top-3 text-gray-400 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                </div>

                <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-800 text-sm font-medium">
                <i class="fa-solid fa-circle-check mr-2 text-green-500"></i> {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto border border-gray-100 rounded-2xl shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 w-20 text-center">ID</th>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($kategoris as $kategori)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-center font-medium text-gray-500">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $kategori->nama_kategori }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-2">
                                    <!-- Edit Button (blue / primary styling style) -->
                                    <a href="{{ route('kategori.edit', $kategori->id) }}"
                                        class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500 font-medium bg-gray-50/30">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2" />
                                    </svg>
                                    @if (request('search'))
                                        <span>Tidak ada kategori yang cocok dengan kata kunci
                                            "{{ request('search') }}"</span>
                                    @else
                                        <span>Belum ada data kategori. Silakan tambahkan kategori baru.</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalTambah"
        class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">
                    Tambah Kategori
                </h2>
                <button type="button" onclick="tutupModal()"
                    class="text-gray-400 hover:text-red-500 transition-colors text-lg p-1">
                    ✕
                </button>
            </div>

            <form action="{{ route('kategori.store') }}" method="POST" onsubmit="return validasiKategori()"
                class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}"
                        placeholder="Masukkan nama kategori"
                        class="w-full border border-gray-300 focus:ring-blue-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150"
                        required>
                    <p id="errorKategori" class="text-red-500 text-xs mt-2 hidden"></p>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="tutupModal()"
                        class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition-all text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tutupModal() {
            document.getElementById('modalTambah').classList.add('hidden');
            document.getElementById('nama_kategori').value = '';
            document.getElementById('errorKategori').classList.add('hidden');
        }

        function validasiKategori() {
            let input = document.getElementById('nama_kategori').value.trim();
            let error = document.getElementById('errorKategori');

            let kategoriTersedia = [
                @foreach ($kategoris as $kategori)
                    "{{ strtolower($kategori->nama_kategori) }}",
                @endforeach
            ];

            if (input === '') {
                error.innerText = 'Nama kategori wajib diisi';
                error.classList.remove('hidden');
                return false;
            }

            if (kategoriTersedia.includes(input.toLowerCase())) {
                error.innerText = 'Nama kategori sudah ada';
                error.classList.remove('hidden');
                return false;
            }

            error.classList.add('hidden');
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            let inputCari = document.getElementById('inputCari');

            if (inputCari) {
                inputCari.addEventListener('keyup', function() {
                    let kataKunci = this.value.toLowerCase().trim();
                    let barisTabel = document.querySelectorAll('tbody tr');
                    let dataDitemukan = false;

                    barisTabel.forEach(function(baris) {
                        let kolomKategori = baris.querySelector('td:nth-child(2)');

                        if (kolomKategori) {
                            let teksKategori = kolomKategori.textContent.toLowerCase();

                            if (teksKategori.includes(kataKunci)) {
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
                            <td colspan="3" class="text-center py-12 text-gray-400 font-medium">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Tidak ada kategori yang cocok dengan kata kunci "${inputCari.value}"</span>
                                </div>
                            </td>`;
                            tbody.appendChild(tr);
                        }
                    } else if (barisKosong) {
                        barisKosong.remove();
                    }
                });
            }
        });
    </script>
@endsection
