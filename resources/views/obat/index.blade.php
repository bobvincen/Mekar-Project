@extends('layouts.app')

@section('title', 'Obat')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-2xl font-bold">
                Data Obat
            </h1>

            <p class="text-gray-500">
                Kelola data obat
            </p>

        </div>

        <a href="{{ route('obat.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

            + Tambah Obat

        </a>

    </div>

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

@endsection