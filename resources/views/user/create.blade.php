@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="mb-6">
    <a href="{{ route('user.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar User
    </a>
    <h2 class="text-2xl font-bold text-gray-800 mt-2">Tambah User Baru</h2>
    <p class="text-sm text-gray-500">Buat pengguna baru dan assign role hak aksesnya</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Ahmad Apoteker"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="user@domain.com"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role Akses</label>
                <select name="role" id="role" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror">
                    <option value="" disabled selected>-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }} class="capitalize">
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('user.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-6 py-2.5 rounded-xl font-medium shadow-md hover:shadow-lg transition">
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection
