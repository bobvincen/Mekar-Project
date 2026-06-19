@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="mb-6">
    <a href="{{ route('role.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Daftar Role
    </a>
    <h2 class="text-2xl font-bold text-gray-800 mt-2">Edit Role: <span class="capitalize text-blue-600">{{ $role->name }}</span></h2>
    <p class="text-sm text-gray-500">Sesuaikan hak akses untuk role ini</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-3xl">
    <form action="{{ route('role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Role</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $role->name) }}"
                @if(in_array($role->name, ['admin', 'kasir', 'pelanggan', 'apoteker'])) readonly @endif
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @if(in_array($role->name, ['admin', 'kasir', 'pelanggan', 'apoteker'])) bg-gray-50 text-gray-500 cursor-not-allowed @endif @error('name') border-red-500 @enderror">
            @if(in_array($role->name, ['admin', 'kasir', 'pelanggan', 'apoteker']))
                <p class="text-xs text-amber-600 mt-1.5 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Role bawaan sistem tidak dapat diubah namanya, namun Anda tetap dapat mengubah hak aksesnya.
                </p>
            @endif
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">Hak Akses (Permissions)</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-2xl p-4 border border-gray-100">
                @foreach($permissions as $perm)
                <label class="flex items-center gap-3 p-2 hover:bg-white rounded-lg transition cursor-pointer">
                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                        @if(in_array($perm->name, $rolePermissions)) checked @endif
                        class="w-4.5 h-4.5 rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="text-sm font-medium text-gray-700">{{ $perm->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('role.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-6 py-2.5 rounded-xl font-medium shadow-md hover:shadow-lg transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
