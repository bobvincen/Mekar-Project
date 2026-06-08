@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-2xl font-bold">
                Data Kategori
            </h1>

            <p class="text-gray-500">
                Kelola kategori obat
            </p>

        </div>

        <button
            onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

            + Tambah Kategori

        </button>

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

            <th class="text-left py-4">
                ID
            </th>

            <th class="text-left py-4">
                Nama Kategori
            </th>

            <th class="text-center py-4">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody>

        @forelse($kategoris as $kategori)

        <tr class="border-b hover:bg-gray-50">

            <td class="py-4">
                {{ $loop->iteration }}
            </td>

            <td class="py-4">
                {{ $kategori->nama_kategori }}
            </td>

            <td class="py-4 text-center">

                <div class="flex justify-center gap-2">


                    <a href="{{ route('kategori.edit', $kategori->id) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg">

                        Edit

                    </a>


                    <form
                        action="{{ route('kategori.destroy',$kategori->id) }}"
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

            <td colspan="3" class="text-center py-6 text-gray-500">

                Belum ada data kategori

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

<div id="modalTambah"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">

    <div class="bg-white rounded-3xl p-6 w-96">

        <h2 class="text-xl font-bold mb-4">
            Tambah Kategori
        </h2>

        <form action="{{ route('kategori.store') }}" method="POST">

            @csrf

            <input
                type="text"
                name="nama_kategori"
                placeholder="Nama kategori"
                class="w-full border rounded-xl px-4 py-3 mb-4">

            <div class="flex justify-end gap-2">

                <button
                    type="button"
                    onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="px-4 py-2 rounded-xl bg-gray-300">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl bg-blue-600 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
