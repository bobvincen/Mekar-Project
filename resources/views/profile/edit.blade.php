<x-app-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pengaturan Profil</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola informasi pribadi, preferensi akun, dan keamanan Anda</p>
            </div>
            <div class="text-sm font-medium text-slate-400 bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm self-start md:self-auto">
                Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
            </div>
        </div>

        <!-- Main Profile Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Summary Card, Profile Photo & Info -->
            <div class="space-y-6 lg:col-span-1">
                <!-- Profile Avatar Card -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6 text-center relative overflow-hidden group hover:shadow-md transition duration-300">
                    <!-- Dynamic background pattern -->
                    <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-90"></div>
                    
                    <!-- Avatar section with camera hover -->
                    <div class="relative mt-8 mb-4 inline-block z-10">
                        <div id="avatarContainer" class="w-24 h-24 rounded-full border-4 border-white bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-extrabold text-3xl flex items-center justify-center shadow-md select-none transition group-hover:scale-105 duration-300">
                            <span id="avatarInitials">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            <img id="avatarImage" src="" class="w-full h-full rounded-full object-cover hidden" alt="Avatar">
                        </div>
                        
                        <!-- Camera overlay for mock photo upload -->
                        <label for="avatarUploadInput" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-slate-900 hover:bg-blue-600 text-white flex items-center justify-center cursor-pointer shadow-sm hover:scale-110 active:scale-95 transition-all duration-300 border-2 border-white" title="Ubah Foto Profil">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                        <input type="file" id="avatarUploadInput" accept="image/*" class="hidden">
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-800 mt-2 truncate">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-400 font-medium truncate mt-0.5">{{ $user->email }}</p>
                    
                    <!-- Role Badge -->
                    <div class="mt-3 flex justify-center">
                        @php
                            $roleName = $user->role ?? 'pelanggan';
                            $roleColors = match(strtolower($roleName)) {
                                'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                'apoteker' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'kasir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                default => 'bg-blue-50 text-blue-600 border-blue-100'
                            };
                        @endphp
                        <span class="px-3 py-1 text-xs font-bold border rounded-lg uppercase tracking-wide {{ $roleColors }}">
                            {{ $roleName }}
                        </span>
                    </div>

                    <!-- Client-side photo upload feedback -->
                    <div id="avatarActionsContainer" class="mt-4 flex justify-center gap-2 hidden">
                        <button type="button" id="btnCancelAvatar" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] font-bold rounded-lg transition duration-200">
                            Batal
                        </button>
                        <button type="button" id="btnRemoveAvatar" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 text-[10px] font-bold rounded-lg transition duration-200">
                            Hapus
                        </button>
                        <button type="button" id="btnSaveAvatarMock" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold rounded-lg shadow-sm transition duration-200">
                            Simpan
                        </button>
                    </div>
                    
                    <p id="avatarHelpText" class="text-[9px] text-slate-400 mt-2.5 italic">
                        Pratinjau visual lokal. Fitur penyimpanan cloud akan segera hadir.
                    </p>
                </div>

                <!-- Account Information Summary Card -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6 hover:shadow-md transition duration-300">
                    <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Ringkasan Akun
                    </h3>
                    <div class="space-y-4">
                        <!-- Role Info -->
                        <div class="flex items-center justify-between py-2 border-b border-slate-50">
                            <div class="flex items-center gap-2.5">
                                <span class="text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </span>
                                <span class="text-xs font-semibold text-slate-500">Peran Sistem</span>
                            </div>
                            <span class="text-xs font-bold text-slate-700 capitalize">{{ $user->role ?? 'Pelanggan' }}</span>
                        </div>


                        <!-- WhatsApp Status -->
                        <div class="flex items-center justify-between py-2 border-b border-slate-50">
                            <div class="flex items-center gap-2.5">
                                <span class="text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <span class="text-xs font-semibold text-slate-500">Nomor WhatsApp</span>
                            </div>
                            @if ($user->whatsapp)
                                <span class="text-xs font-bold text-slate-700 font-mono">{{ $user->whatsapp }}</span>
                            @else
                                <span class="text-xs font-bold text-slate-400 italic">Belum Lengkap</span>
                            @endif
                        </div>

                        <!-- Last Activity session (Mock) -->
                        <div class="flex items-center justify-between py-2 border-b border-slate-50">
                            <div class="flex items-center gap-2.5">
                                <span class="text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <span class="text-xs font-semibold text-slate-500">Aktivitas Terakhir</span>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Sesi Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Editing Forms -->
            <div class="space-y-8 lg:col-span-2">
                <!-- Profile Info Form Card -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6 hover:shadow-md transition duration-300">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Password Form Card -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6 hover:shadow-md transition duration-300">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account Form Card -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6 border-rose-100 hover:shadow-md transition duration-300">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    <!-- Client-side script for photo upload interaction -->
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('avatarUploadInput');
        const container = document.getElementById('avatarContainer');
        const initials = document.getElementById('avatarInitials');
        const image = document.getElementById('avatarImage');
        const actionsContainer = document.getElementById('avatarActionsContainer');
        const btnCancel = document.getElementById('btnCancelAvatar');
        const btnRemove = document.getElementById('btnRemoveAvatar');
        const btnSave = document.getElementById('btnSaveAvatarMock');

        // Load cached mock avatar if exists
        const cachedAvatar = localStorage.getItem('mock_avatar_src');
        if (cachedAvatar) {
            image.src = cachedAvatar;
            image.classList.remove('hidden');
            initials.classList.add('hidden');
        }

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    image.src = e.target.result;
                    image.classList.remove('hidden');
                    initials.classList.add('hidden');
                    actionsContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        btnCancel.addEventListener('click', function () {
            fileInput.value = '';
            const originalCache = localStorage.getItem('mock_avatar_src');
            if (originalCache) {
                image.src = originalCache;
                image.classList.remove('hidden');
                initials.classList.add('hidden');
            } else {
                image.src = '';
                image.classList.add('hidden');
                initials.classList.remove('hidden');
            }
            actionsContainer.classList.add('hidden');
        });

        btnRemove.addEventListener('click', function () {
            fileInput.value = '';
            image.src = '';
            image.classList.add('hidden');
            initials.classList.remove('hidden');
            localStorage.removeItem('mock_avatar_src');
            actionsContainer.classList.add('hidden');
            alert('Foto profil dihapus (lokal).');
        });

        btnSave.addEventListener('click', function () {
            if (image.src && image.src.startsWith('data:')) {
                localStorage.setItem('mock_avatar_src', image.src);
                actionsContainer.classList.add('hidden');
                alert('Foto profil berhasil diunggah (simulasi pratinjau lokal).');
            }
        });
    });
    </script>
    @endpush
</x-app-layout>
