<section>
    <header class="border-b border-slate-100 pb-4 mb-6">
        <h2 class="text-lg font-bold text-slate-800">
            Perbarui Kata Sandi
        </h2>
        <p class="text-xs text-slate-400 mt-1">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="m-0 space-y-6" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('.btn-text').innerText = 'Memperbarui...'; this.querySelector('.btn-spinner').classList.remove('hidden');">
        @csrf
        @method('put')

        <!-- Password Saat Ini -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700 mb-2">
                Kata Sandi Saat Ini <span class="text-rose-500">*</span>
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                    class="w-full border border-slate-200 rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('current_password', 'updatePassword') border-rose-300 bg-rose-50/20 @enderror">
                <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none animate-fade-in" aria-label="Tampilkan Password">
                    <svg class="eye-icon w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="eye-slash-icon w-4.5 h-4.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69 9.69a3 3 0 004.243 4.243m-1.89-3.238L12 10.5m-3.5 1L12 10.5M3 3l18 18" />
                    </svg>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Baru -->
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-slate-700 mb-2">
                Kata Sandi Baru <span class="text-rose-500">*</span>
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                    class="w-full border border-slate-200 rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('password', 'updatePassword') border-rose-300 bg-rose-50/20 @enderror">
                <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none animate-fade-in" aria-label="Tampilkan Password">
                    <svg class="eye-icon w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="eye-slash-icon w-4.5 h-4.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69 9.69a3 3 0 004.243 4.243m-1.89-3.238L12 10.5m-3.5 1L12 10.5M3 3l18 18" />
                    </svg>
                </button>
            </div>
            @error('password', 'updatePassword')
                <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                    class="w-full border border-slate-200 rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('password_confirmation', 'updatePassword') border-rose-300 bg-rose-50/20 @enderror">
                <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none animate-fade-in" aria-label="Tampilkan Password">
                    <svg class="eye-icon w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="eye-slash-icon w-4.5 h-4.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69 9.69a3 3 0 004.243 4.243m-1.89-3.238L12 10.5m-3.5 1L12 10.5M3 3l18 18" />
                    </svg>
                </button>
            </div>
            @error('password_confirmation', 'updatePassword')
                <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-4 pt-2 border-t border-slate-100">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm hover:shadow transition duration-200 disabled:opacity-50">
                <svg class="btn-spinner animate-spin h-4 w-4 text-white hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="btn-text">Ubah Kata Sandi</span>
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-bold text-emerald-600 flex items-center gap-1.5"
                >
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Kata sandi berhasil diubah.</span>
                </p>
            @endif
        </div>
    </form>
</section>
