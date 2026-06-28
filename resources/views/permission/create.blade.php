@extends('layouts.app')

@section('title', 'Tambah Permission')

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('permission.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Permission</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tambahkan kriteria hak akses baru ke dalam sistem</p>
        </div>
    </div>

    <!-- Form Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <form action="{{ route('permission.store') }}" method="POST" class="m-0 space-y-6">
            @csrf

            <!-- Nama Permission -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Permission</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                    placeholder="Contoh: Edit Penjualan"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('name') border-rose-300 bg-rose-50/20 @enderror">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('permission.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold transition text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                    Simpan Permission
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
