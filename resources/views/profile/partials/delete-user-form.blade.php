<section class="space-y-6">
    <header class="border-b border-rose-100 pb-4 mb-6">
        <h2 class="text-lg font-bold text-rose-800 flex items-center gap-2">
            <svg class="w-5.5 h-5.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Hapus Akun Permanen
        </h2>
        <p class="text-xs text-rose-600 mt-1">
            Setelah akun Anda dihapus, semua data dan sumber daya di dalamnya akan dihapus secara permanen.
        </p>
    </header>

    <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">
        Harap unduh data penting yang ingin Anda simpan terlebih dahulu sebelum melanjutkan proses penghapusan. Tindakan ini tidak dapat dibatalkan.
    </p>

    <div>
        <button type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-sm hover:shadow transition duration-200">
            Hapus Akun Saya
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 m-0 space-y-6" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('.btn-delete-text').innerText = 'Menghapus...'; this.querySelector('.btn-delete-spinner').classList.remove('hidden');">
            @csrf
            @method('delete')

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Apakah Anda yakin ingin menghapus akun?
                </h2>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                    Setelah akun Anda dihapus, semua data akan hilang secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.
                </p>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Masukkan Kata Sandi Anda <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-sm w-full sm:w-3/4">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" placeholder="Kata Sandi Akun" required
                        class="w-full border border-slate-200 rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('password', 'userDeletion') border-rose-300 bg-rose-50/20 @enderror">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none animate-fade-in" aria-label="Tampilkan Password">
                        <svg class="eye-icon w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon w-4.5 h-4.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69a3 3 0 004.243 4.243m-1.89-3.238L12 10.5m-3.5 1L12 10.5M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password', 'userDeletion')
                    <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition duration-200">
                    Batal
                </button>

                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-sm hover:shadow transition duration-200 disabled:opacity-50">
                    <svg class="btn-delete-spinner animate-spin h-4 w-4 text-white hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="btn-delete-text">Hapus Akun</span>
                </button>
            </div>
        </form>
    </x-modal>
</section>
