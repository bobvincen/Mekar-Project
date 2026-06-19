@extends('layouts.guest')

@section('content')
<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fbff;
    }

    /* Abstract Organic Background */
    .bg-abstract {
        background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 50%, #e0f2fe 100%);
    }

    /* Floating Animations */
    @keyframes float-slow {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
        100% { transform: translateY(0) rotate(0deg); }
    }
    @keyframes float-medium {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(-5deg); }
        100% { transform: translateY(0) rotate(0deg); }
    }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-float-1 { animation: float-slow 8s infinite ease-in-out; }
    .animate-float-2 { animation: float-medium 6s infinite ease-in-out reverse; }
    .animate-float-3 { animation: float-slow 10s infinite ease-in-out 1s; }
    
    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }
    .animate-fade-in-delayed {
        opacity: 0;
        animation: fade-in 0.8s ease-out 0.2s forwards;
    }

    /* Card Glow */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.05), 0 1px 3px rgba(0,0,0,0.02);
    }
    
    /* Input modern style */
    .input-modern:focus-within {
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }
</style>

<!-- Load Alpine if not already loaded (Breeze usually has it, but fallback just in case) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="min-h-screen flex flex-col lg:flex-row w-full overflow-hidden bg-abstract relative">
    
    <!-- Ambient Blurs for Depth -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-blue-400/20 blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-cyan-300/20 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-[20%] left-[40%] w-[30%] h-[30%] rounded-full bg-indigo-300/10 blur-[80px] pointer-events-none"></div>

    {{-- ===== SISI KIRI: HERO SECTION ===== --}}
    <div class="w-full lg:w-[50%] xl:w-[55%] relative flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-12 lg:py-0 z-10 lg:min-h-screen">
        
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 mb-8 lg:mb-14 group w-fit animate-fade-in">
            <div class="relative w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300 border border-slate-50">
                <div class="absolute inset-0 bg-blue-500 rounded-2xl blur-md opacity-30 group-hover:opacity-50 transition-opacity"></div>
                <img src="/logo.png" alt="Mekar Pharmacy" class="w-8 h-8 object-contain relative z-10">
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-extrabold tracking-tight text-blue-700 leading-none">MEKAR</span>
                <span class="text-sm font-semibold tracking-wide text-blue-500 leading-none mt-0.5">Pharmacy</span>
            </div>
        </a>

        <!-- Typography -->
        <div class="max-w-xl animate-fade-in">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold mb-6">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Bergabung Bersama Kami
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-[50px] font-extrabold text-slate-800 leading-[1.15] tracking-tight mb-6">
                Langkah Pertama Menuju <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Kesehatan Optimal</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-500 font-medium leading-relaxed max-w-md">
                Daftar sekarang dan nikmati kemudahan akses ke ribuan produk kesehatan, resep dokter, dan konsultasi profesional.
            </p>
        </div>

        <!-- Floating Abstract Medical Elements -->
        <div class="absolute right-[5%] bottom-[15%] lg:bottom-[20%] w-64 h-64 hidden sm:block pointer-events-none opacity-80">
            <div class="absolute top-0 right-0 text-blue-500/20 animate-float-1">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="absolute bottom-10 left-0 text-cyan-400/30 animate-float-2">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M10.5 20.5 19 12a4.95 4.95 0 1 0-7-7L3.5 12a4.95 4.95 0 1 0 7 7Z M12 6.5l5.5 5.5"/></svg>
            </div>
            <div class="absolute top-1/2 right-1/4 text-indigo-400/20 animate-float-3">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 10h-5V5h-4v5H5v4h5v5h4v-5h5v-4z"/></svg>
            </div>
            <div class="absolute top-1/4 left-1/4 text-red-400/20 animate-float-1" style="animation-delay: 1.5s;">
                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>

    </div>

    {{-- ===== SISI KANAN: FORM REGISTER ===== --}}
    <div class="w-full lg:w-[50%] xl:w-[45%] flex items-center justify-center p-6 sm:p-12 lg:p-12 z-20 overflow-y-auto">
        
        <div class="w-full max-w-[460px] glass-card rounded-[24px] p-8 sm:p-10 animate-fade-in-delayed transform transition-all duration-500 hover:shadow-[0_30px_60px_rgba(37,99,235,0.12)]">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Buat Akun Baru</h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Lengkapi data Anda di bawah ini.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ password: '' }">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Nama Lengkap</label>
                    <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                        <div class="pl-4 pr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus autocomplete="name" class="w-full bg-transparent border-none py-3 pl-1 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Email -->
                <div>
                    <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Alamat Email</label>
                    <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                        <div class="pl-4 pr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required autocomplete="username" class="w-full bg-transparent border-none py-3 pl-1 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input No WhatsApp -->
                <div>
                    <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Nomor WhatsApp</label>
                    <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                        <div class="pl-4 pr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08123456789" class="w-full bg-transparent border-none py-3 pl-1 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                    </div>
                </div>

                <!-- Input Password & Confirm -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Kata Sandi</label>
                        <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                            <div class="pl-3 pr-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input x-model="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" class="w-full bg-transparent border-none py-3 pl-1 pr-2 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Konfirmasi</label>
                        <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                            <div class="pl-3 pr-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <input type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" class="w-full bg-transparent border-none py-3 pl-1 pr-2 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                        </div>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <div class="pt-1 pb-2">
                    <div class="flex gap-1.5 h-1.5 w-full rounded-full overflow-hidden bg-slate-100">
                        <div class="h-full rounded-full transition-all duration-300" :class="password.length > 0 ? (password.length >= 8 ? 'bg-emerald-400 w-1/3' : 'bg-red-400 w-1/3') : 'w-0'"></div>
                        <div class="h-full rounded-full transition-all duration-300" :class="password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) ? 'bg-emerald-400 w-1/3' : 'w-0'"></div>
                        <div class="h-full rounded-full transition-all duration-300" :class="password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password) ? 'bg-emerald-400 w-1/3' : 'w-0'"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1.5 font-medium ml-1" x-show="password.length > 0">
                        <span x-show="password.length < 8" class="text-red-500">Terlalu pendek</span>
                        <span x-show="password.length >= 8 && !(/[A-Z]/.test(password) && /[0-9]/.test(password))" class="text-amber-500">Sedang (Tambahkan huruf besar & angka)</span>
                        <span x-show="password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && !/[^A-Za-z0-9]/.test(password)" class="text-emerald-500">Kuat</span>
                        <span x-show="password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)" class="text-emerald-600 font-bold">Sangat Kuat</span>
                    </p>
                </div>

                @error('password')
                    <p class="text-red-500 text-xs mt-1.5 ml-1 font-bold">{{ $message }}</p>
                @enderror

                <!-- Button Submit -->
                <div class="pt-1">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-[14px] font-bold shadow-[0_8px_20px_rgba(37,99,235,0.25)] hover:shadow-[0_12px_25px_rgba(37,99,235,0.35)] transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Daftar Akun
                    </button>
                </div>

                <!-- Link Login -->
                <p class="text-center text-[13px] font-medium text-slate-500 pt-3">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors">Masuk di sini</a>
                </p>

            </form>
        </div>

    </div>
</div>
@endsection
