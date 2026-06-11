@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit Obat
    </h1>

    <form action="{{ route('obat.update', $obat->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Kode Obat</label>

            <input
                type="text"
                name="kode_obat"
                value="{{ old('kode_obat', $obat->kode_obat) }}"
                class="w-full rounded-xl px-4 py-3 border
                @error('kode_obat')
                    border-red-500 bg-red-50
                @enderror">

            @error('kode_obat')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Nama Obat</label>

            <input
                type="text"
                name="nama_obat"
                value="{{ old('nama_obat', $obat->nama_obat) }}"
                class="w-full rounded-xl px-4 py-3 border
                @error('nama_obat')
                    border-red-500 bg-red-50
                @enderror">

            @error('nama_obat')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Kategori</label>

            <select
                name="kategori_id"
                class="w-full rounded-xl px-4 py-3 border
                @error('kategori_id')
                    border-red-500 bg-red-50
                @enderror">

                <option value="">
                    -- Pilih Kategori --
                </option>

                @foreach($kategoris as $kategori)
                    <option
                        value="{{ $kategori->id }}"
                        {{ old('kategori_id', $obat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach

            </select>

            @error('kategori_id')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Supplier</label>

            <select
                name="supplier_id"
                class="w-full rounded-xl px-4 py-3 border
                @error('supplier_id')
                    border-red-500 bg-red-50
                @enderror">

                <option value="">
                    -- Pilih Supplier --
                </option>

                @foreach($suppliers as $supplier)
                    <option
                        value="{{ $supplier->id }}"
                        {{ old('supplier_id', $obat->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nama_supplier }}
                    </option>
                @endforeach

            </select>

            @error('supplier_id')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Stok</label>

            <input
                type="number"
                min="1"
                name="stok"
                value="{{ old('stok', $obat->stok) }}"
                class="w-full rounded-xl px-4 py-3 border
                @error('stok')
                    border-red-500 bg-red-50
                @enderror">

            @error('stok')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Harga Jual</label>

            <input
                type="number"
                min="1"
                name="harga_jual"
                value="{{ old('harga_jual', $obat->harga_jual) }}"
                class="w-full rounded-xl px-4 py-3 border
                @error('harga_jual')
                    border-red-500 bg-red-50
                @enderror">

            @error('harga_jual')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Tanggal Kadaluarsa</label>

            <input
                type="date"
                name="tanggal_kadaluarsa"
                value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}"
                class="w-full border rounded-xl px-4 py-3">
        </div>

        <div class="mb-4">
            <label>Deskripsi</label>

            <textarea
                name="deskripsi"
                class="w-full border rounded-xl px-4 py-3">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
        </div>

        <button
            type="submit"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl">

            Update

        </button>

    </form>

</div>

@endsection