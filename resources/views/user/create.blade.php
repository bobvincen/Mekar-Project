@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('user.index') }}"
                class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                    Tambah User
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Tambahkan pengguna baru beserta role hak aksesnya
                </p>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">

            <form action="{{ route('user.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Nama -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>

                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="Contoh: Ahmad Apoteker" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-rose-300 bg-rose-50/20 @enderror">

                        @error('name')
                            <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Email <span class="text-rose-500">*</span>
                        </label>

                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="user@domain.com" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-rose-300 bg-rose-50/20 @enderror">

                        @error('email')
                            <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Role <span class="text-rose-500">*</span>
                        </label>

                        <select name="role" id="role" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-rose-300 bg-rose-50/20 @enderror">

                            <option value="">-- Pilih Role --</option>

                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>

                        @error('role')
                            <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Password <span class="text-rose-500">*</span>
                        </label>

                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required
                                class="w-full border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-rose-300 bg-rose-50/20 @enderror">

                            <button type="button"
                                class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">

                                <svg class="eye-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7" />
                                </svg>

                                <svg class="eye-slash-icon w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Konfirmasi Password <span class="text-rose-500">*</span>
                        </label>

                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ulangi password" required
                                class="w-full border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            <button type="button"
                                class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">

                                <svg class="eye-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7" />
                                </svg>

                                <svg class="eye-slash-icon w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('user.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                        Simpan User
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
