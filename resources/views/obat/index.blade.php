@extends('layouts.app')

@section('title', 'Obat')

@section('content')
    <div class="w-full bg-white rounded-3xl shadow-lg p-4 md:p-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Data Obat</h2>
                <p class="text-gray-500 text-sm mt-0.5">Kelola informasi obat dan stok distributor Mekar Pharmacy</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <input type="text" id="inputCari" placeholder="Cari obat..."
                        class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 transition duration-150">
                    <span class="absolute right-3 top-3 text-gray-400 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                </div>

                <a href="{{ route('obat.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Obat</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-800 text-sm font-medium">
                <i class="fa-solid fa-circle-check mr-2 text-green-500"></i> {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto border border-gray-100 rounded-2xl shadow-sm w-full">
            <table class="w-full text-sm text-left table-auto">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 w-32 text-center">Kode</th>
                        <th class="px-4 py-4 w-42">Nama Obat</th>
                        <th class="px-4 pl-2 py-4 w-44">Kategori</th>
                        <th class="px-4 pl-2 py-4 w-52">Supplier</th>
                        <th class="px-4 py-4 text-center w-24">Stok</th>
                        <th class="px-6 py-4 text-center w-40">Harga</th>
                        <th class="px-6 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($obats as $custom_obat)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-center font-medium text-gray-500 whitespace-nowrap">
                                {{ $custom_obat->kode_obat }}
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-800 whitespace-nowrap">
                                {{ $custom_obat->nama_obat }}
                            </td>
                            <td class="px-4 pl-2 py-4 text-gray-600 truncate">
                                {{ $custom_obat->kategori->nama_kategori }}
                            </td>
                            <td class="px-4 pl-2 py-4 text-gray-600 truncate">
                                {{ $custom_obat->supplier->nama_supplier }}
                            </td>
                            <td
                                class="px-4 py-4 text-center font-medium @if ($custom_obat->stok <= 5) text-red-600 font-bold @else text-gray-700 @endif">
                                {{ $custom_obat->stok }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800 text-center whitespace-nowrap">
                                Rp {{ number_format($custom_obat->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('obat.edit', $custom_obat->id) }}"
                                        class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150 text-decoration-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('obat.destroy', $custom_obat->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data obat ini?')"
                                        class="m-0">
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
                            <td colspan="7" class="text-center py-12 text-gray-500 font-medium bg-gray-50/30">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/xl" class="h-10 w-10 text-gray-300 mb-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2" />
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let inputCari = document.getElementById('inputCari');

            if (inputCari) {
                inputCari.addEventListener('keyup', function() {
                    let kataKunci = this.value.toLowerCase().trim();
                    let barisTabel = document.querySelectorAll('tbody tr:not(#barisKosong)');
                    let dataDitemukan = false;

                    barisTabel.forEach(function(baris) {
                        let kolomKode = baris.querySelector('td:nth-child(1)');
                        let kolomNama = baris.querySelector('td:nth-child(2)');

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
                                <td colspan="7" class="text-center py-12 text-gray-400 font-medium">
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
        });
    </script>
@endsection
