@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-3xl border border-slate-100 p-6 sm:p-8">

            <div class="flex items-start gap-4 mb-8">
                <a href="{{ route('obat.index') }}"
                    class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Edit Data Obat</h1>
                    <p class="text-slate-400 text-sm mt-0.5">Ubah informasi detail untuk obat "{{ $obat->nama_obat }}"</p>
                </div>
            </div>

            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode Obat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="kode_obat" value="{{ old('kode_obat', $obat->kode_obat) }}"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('kode_obat') border-red-500 bg-red-50 @enderror">
                    @error('kode_obat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Obat <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('nama_obat') border-red-500 bg-red-50 @enderror">
                    @error('nama_obat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori <span
                            class="text-red-500">*</span></label>
                    <select name="kategori_id"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('kategori_id') border-red-500 bg-red-50 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $obat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Supplier <span
                            class="text-red-500">*</span></label>
                    <select name="supplier_id"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('supplier_id') border-red-500 bg-red-50 @enderror">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id', $obat->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Stok <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="stok" value="{{ old('stok', $obat->stok) }}"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('stok') border-red-500 bg-red-50 @enderror">
                    @error('stok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Jual <span
                            class="text-red-500">*</span></label>
                    <input type="number" min="1" name="harga_jual"
                        value="{{ old('harga_jual', $obat->harga_jual) }}"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('harga_jual') border-red-500 bg-red-50 @enderror">
                    @error('harga_jual')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Kadaluarsa</label>
                    <input type="date" name="tanggal_kadaluarsa"
                        value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors">
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('obat.index') }}"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition-colors text-decoration-none">
                        Kembali
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-colors">
                        Update Obat
                    </button>
                </div>
            </form>
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
            <label>Tanggal Kadaluarsa <span class="text-red-500">*</span></label>

            <input
                type="date"
                name="tanggal_kadaluarsa"
                value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}"
                class="w-full rounded-xl px-4 py-3 border
                @error('tanggal_kadaluarsa')
                    border-red-500 bg-red-50
                @enderror">

            @error('tanggal_kadaluarsa')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
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
