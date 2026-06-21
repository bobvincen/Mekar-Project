@extends('layouts.app')

@section('title', 'Obat')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">
                Data Obat
            </h1>
            <p class="text-gray-500">
                Kelola data obat
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Download Template -->
            <a href="{{ route('obat.download-template') }}"
               class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl font-medium inline-flex items-center gap-1.5 text-sm transition-colors">
                📄 Template Excel
            </a>

            <!-- Import Excel Form -->
            <form action="{{ route('obat.preview-import') }}" method="POST" enctype="multipart/form-data" class="inline" id="importForm">
                @csrf
                <label class="cursor-pointer bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl inline-flex items-center gap-1.5 font-medium text-sm transition-colors">
                    📥 Import Excel
                    <input type="file" name="file_excel" class="hidden" accept=".xlsx,.xls" onchange="document.getElementById('importForm').submit()">
                </label>
            </form>

            <!-- Tambah Obat -->
            <a href="{{ route('obat.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-medium inline-flex items-center gap-1.5 text-sm transition-colors">
                + Tambah Obat
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))

    <div class="mb-4 bg-green-100 text-green-700 p-4 rounded-xl">

        {{ session('success') }}

    </div>

    @endif

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-4">Kode</th>
                    <th class="text-left py-4">Nama Obat</th>
                    <th class="text-left py-4">Kategori</th>
                    <th class="text-left py-4">Supplier</th>
                    <th class="text-left py-4">Stok</th>
                    <th class="text-left py-4">Harga</th>
                    <th class="text-center py-4">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($obats as $obat)

                <tr class="border-b hover:bg-gray-50">

                    <td class="py-4">{{ $obat->kode_obat }}</td>

                    <td class="py-4">{{ $obat->nama_obat }}</td>

                    <td class="py-4">
                        {{ $obat->kategori->nama_kategori }}
                    </td>

                    <td class="py-4">
                        {{ $obat->supplier->nama_supplier }}
                    </td>

                    <td class="py-4">
                        {{ $obat->stok }}
                    </td>

                    <td class="py-4">
                        Rp {{ number_format($obat->harga_jual,0,',','.') }}
                    </td>

                    <td class="py-4 text-center">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('obat.edit',$obat->id) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg">

                                Edit

                            </a>

                            <form action="{{ route('obat.destroy',$obat->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Yakin hapus?')"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7"
                        class="text-center py-6 text-gray-500">

                        Belum ada data obat

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

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
                    <p class="mb-3"><strong class="text-blue-600">LANGKAH 6</strong><br>Klik tombol <strong>"Import Excel"</strong> dan pilih file yang telah Anda simpan.</p>
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

</div>

@endsection