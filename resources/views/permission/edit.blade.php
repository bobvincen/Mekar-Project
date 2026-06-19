@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="mb-6">
    <a href="{{ route('permission.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar Permission
    </a>
    <h2 class="text-2xl font-bold text-gray-800 mt-2">Edit Permission: <span class="text-blue-600">{{ $permission->name }}</span></h2>
    <p class="text-sm text-gray-500">Sesuaikan nama permission</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-xl">
    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Permission</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $permission->name) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('permission.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-6 py-2.5 rounded-xl font-medium shadow-md hover:shadow-lg transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
