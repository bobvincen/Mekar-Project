@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-3xl border border-slate-100 p-6 sm:p-8">

            <div class="flex items-start gap-4 mb-8">
                <a href="{{ route('kategori.index') }}"
                    class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Tambah Data Kategori</h1>
                    <p class="text-slate-400 text-sm mt-0.5">Masukkan nama kategori baru untuk Mekar Pharmacy</p>
                </div>
            </div>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <!-- Nama Kategori -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Masukkan nama kategori"
                        class="w-full rounded-xl px-4 py-3 border border-slate-200 text-slate-800 focus:border-blue-400 focus:ring-1 focus:ring-blue-400 focus:outline-none transition-colors @error('nama_kategori') border-red-500 bg-red-50 @enderror" required>

                    @error('nama_kategori')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('kategori.index') }}"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition-colors text-decoration-none">
                        Kembali
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-colors">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
