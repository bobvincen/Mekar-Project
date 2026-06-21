@extends('layouts.app')

@section('title', 'Manajemen Permission')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Permission</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar hak akses yang dapat dikaitkan dengan Role</p>
    </div>
    <a href="{{ route('permission.create') }}" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-md hover:shadow-lg transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Permission
    </a>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 text-green-600 border border-green-200 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                    <th class="py-4 px-6 font-semibold whitespace-nowrap">ID</th>
                    <th class="py-4 px-6 font-semibold">Nama Permission</th>
                    <th class="py-4 px-6 font-semibold">Guard Name</th>
                    <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($permissions as $perm)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6 text-gray-500">
                        {{ $perm->id }}
                    </td>
                    <td class="py-4 px-6 font-semibold text-gray-900">
                        {{ $perm->name }}
                    </td>
                    <td class="py-4 px-6 text-gray-500">
                        {{ $perm->guard_name }}
                    </td>
                    <td class="py-4 px-6 text-right whitespace-nowrap">
                        <a href="{{ route('permission.edit', $perm->id) }}" class="inline-block p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        
                        <form action="{{ route('permission.destroy', $perm->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permission ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 px-6 text-center text-gray-500">
                        <p>Belum ada data permission.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
