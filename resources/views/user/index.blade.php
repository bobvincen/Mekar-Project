@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar pengguna aplikasi Mekar Pharmacy beserta peran aksesnya</p>
    </div>
    <a href="{{ route('user.create') }}" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-md hover:shadow-lg transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Tambah User
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

@if(session('error'))
    <div class="mb-6 bg-red-50 text-red-600 border border-red-200 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span class="font-medium text-sm">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                    <th class="py-4 px-6 font-semibold whitespace-nowrap">Nama</th>
                    <th class="py-4 px-6 font-semibold">Email</th>
                    <th class="py-4 px-6 font-semibold">Role</th>
                    <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($users as $usr)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6 font-semibold text-gray-900 whitespace-nowrap">
                        {{ $usr->name }}
                        @if(auth()->id() === $usr->id)
                            <span class="ml-2 px-2 py-0.5 text-[10px] font-medium bg-gray-100 text-gray-600 rounded">Saya</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-gray-500">
                        {{ $usr->email }}
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap">
                        @php
                            $roleName = $usr->roles->first()?->name ?? $usr->role ?? 'pelanggan';
                            $badgeClasses = match($roleName) {
                                'admin' => 'bg-red-50 text-red-600',
                                'kasir' => 'bg-green-50 text-green-600',
                                'apoteker' => 'bg-purple-50 text-purple-600',
                                default => 'bg-blue-50 text-blue-600'
                            };
                        @endphp
                        <span class="px-2.5 py-1 text-xs font-semibold {{ $badgeClasses }} rounded-lg uppercase tracking-wider">
                            {{ $roleName }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right whitespace-nowrap">
                        <a href="{{ route('user.edit', $usr->id) }}" class="inline-block p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        
                        @if(auth()->id() !== $usr->id)
                        <form action="{{ route('user.destroy', $usr->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 px-6 text-center text-gray-500">
                        <p>Belum ada data user.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
