@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('role.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Edit Role</h1>
            <p class="text-xs text-slate-500 mt-0.5">Sesuaikan hak akses untuk role: <span class="capitalize font-bold text-blue-600">{{ $role->name }}</span></p>
        </div>
    </div>

    <!-- Form Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <form action="{{ route('role.update', $role->id) }}" method="POST" class="m-0 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nama Role -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Role</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $role->name) }}"
                    @if(in_array($role->name, ['admin', 'kasir', 'pelanggan', 'apoteker'])) readonly @endif
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-750 @if(in_array($role->name, ['admin', 'kasir', 'pelanggan', 'apoteker'])) bg-slate-50 text-slate-400 cursor-not-allowed border-slate-150 @else placeholder-slate-400 @endif @error('name') border-rose-300 bg-rose-50/20 @enderror">
                
                @if(in_array($role->name, ['admin', 'kasir', 'pelanggan', 'apoteker']))
                    <p class="text-[11px] text-amber-600 mt-2 font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Role bawaan sistem tidak dapat diubah namanya, namun Anda tetap dapat menyesuaikan hak aksesnya.
                    </p>
                @endif
                @error('name')
                    <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hak Akses (Permissions) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Hak Akses (Permissions)</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/50 rounded-2xl p-5 border border-slate-100">
                    @foreach($permissions as $perm)
                        <label class="flex items-center gap-3 p-3 bg-white border border-slate-100/50 hover:border-slate-200 rounded-xl transition cursor-pointer shadow-sm">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                @if(in_array($perm->name, $rolePermissions)) checked @endif
                                class="w-5 h-5 rounded text-blue-600 border-slate-200 focus:ring-blue-500 cursor-pointer">
                            <span class="text-xs font-bold text-slate-700">{{ $perm->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('role.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold transition text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
