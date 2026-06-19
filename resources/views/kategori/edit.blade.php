@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Edit Kategori 🏷️</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui nama kategori obat Apotek Mekar.</p>
        </div>

        <div class="bg-white shadow-lg rounded-xl border border-slate-200 p-6 sm:p-8">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Nama Kategori
                    </label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        class="w-full rounded-lg px-4 py-2.5 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('nama_kategori') border-red-500 bg-red-50 @enderror">

                    @error('nama_kategori')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('kategori.index') }}"
                        class="px-4 py-2.5 border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-700 rounded-lg text-sm font-medium transition-colors text-decoration-none">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Update Kategori</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
