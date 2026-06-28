@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('supplier.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Supplier</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tambahkan rekanan distributor/pemasok obat baru ke dalam sistem</p>
        </div>
    </div>

    <!-- Form Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <form action="{{ route('supplier.store') }}" method="POST" class="m-0 space-y-6">
            @csrf

            <div class="space-y-5">
                <!-- Nama Supplier -->
                <div>
                    <label for="nama_supplier" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Supplier <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier') }}"
                         placeholder="Contoh: PT. Kimia Farma" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('nama_supplier') border-rose-300 bg-rose-50/20 @enderror">
                    @error('nama_supplier')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kontak PIC -->
                <div>
                    <label for="kontak_pic" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Kontak / PIC
                    </label>
                    <input type="text" id="kontak_pic" name="kontak_pic" value="{{ old('kontak_pic') }}"
                         placeholder="Contoh: Budi Santoso"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('kontak_pic') border-rose-300 bg-rose-50/20 @enderror">
                    @error('kontak_pic')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon / WhatsApp -->
                <div>
                    <label for="telepon" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor WhatsApp / Telepon <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                        placeholder="Contoh: 081234567890" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('telepon') border-rose-300 bg-rose-50/20 @enderror">
                    @error('telepon')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Contoh: supplier@domain.com" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('email') border-rose-300 bg-rose-50/20 @enderror">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kota -->
                <div>
                    <label for="kota" class="block text-sm font-semibold text-slate-700 mb-2">
                        Kota
                    </label>
                    <input type="text" id="kota" name="kota" value="{{ old('kota') }}"
                        placeholder="Contoh: Jakarta"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('kota') border-rose-300 bg-rose-50/20 @enderror">
                    @error('kota')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-2">
                        Alamat Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap distributor..." required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('alamat') border-rose-300 bg-rose-50/20 @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Keterangan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="2" placeholder="Keterangan tambahan jika ada..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('keterangan') border-rose-300 bg-rose-50/20 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('supplier.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold transition text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                    Simpan Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
