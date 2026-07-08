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

<div class="min-h-screen flex flex-col lg:flex-row w-full overflow-hidden bg-abstract relative">
    
    <!-- Ambient Blurs for Depth -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-blue-400/20 blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-cyan-300/20 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-[20%] left-[40%] w-[30%] h-[30%] rounded-full bg-indigo-300/10 blur-[80px] pointer-events-none"></div>

    {{-- ===== SISI KIRI: HERO SECTION ===== --}}
    <div class="w-full lg:w-[55%] relative flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-12 lg:py-0 z-10 lg:min-h-screen">
        
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 mb-10 lg:mb-16 group w-fit animate-fade-in">
            <div class="relative w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300 border border-slate-50">
                <!-- Soft glow behind logo -->
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
                Keamanan Akun
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-[54px] font-extrabold text-slate-800 leading-[1.15] tracking-tight mb-6">
                Pilih Sandi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Baru Anda</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-500 font-medium leading-relaxed max-w-md">
                Gunakan kombinasi huruf, angka, dan simbol untuk membuat kata sandi yang kuat dan aman.
            </p>
        </div>

        <!-- Floating Abstract Medical Elements -->
        <div class="absolute right-[5%] bottom-[15%] lg:bottom-[20%] w-64 h-64 hidden sm:block pointer-events-none opacity-80">
            <!-- Key icon instead of Shield -->
            <div class="absolute top-0 right-0 text-blue-500/20 animate-float-1">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
            </div>
            <!-- Lock icon instead of Pill -->
            <div class="absolute bottom-10 left-0 text-cyan-400/30 animate-float-2">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
            </div>
            <!-- Mail icon instead of Cross -->
            <div class="absolute top-1/2 right-1/4 text-indigo-400/20 animate-float-3">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            </div>
        </div>

    </div>

    {{-- ===== SISI KANAN: FORM RESET PASSWORD ===== --}}
    <div class="w-full lg:w-[45%] flex items-center justify-center p-6 sm:p-12 lg:p-16 z-20">
        
        <div class="w-full max-w-[420px] glass-card rounded-[24px] p-8 sm:p-10 animate-fade-in-delayed transform transition-all duration-500 hover:shadow-[0_30px_60px_rgba(37,99,235,0.12)] hover:-translate-y-1">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Atur Sandi Baru</h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Buat sandi baru untuk akun Anda.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-xl border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Input Email -->
                <div>
                    <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Alamat Email</label>
                    <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                        <div class="pl-4 pr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="contoh@email.com" required autofocus autocomplete="username" class="w-full bg-transparent border-none py-3.5 pl-1 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:ring-0">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Sandi Baru</label>
                    <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                        <div class="pl-4 pr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input type="password" name="password" placeholder="••••••••" required autocomplete="new-password" class="w-full bg-transparent border-none py-3.5 pl-1 pr-12 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                        <button type="button" class="toggle-password absolute right-3 text-slate-400 hover:text-slate-600 focus:outline-none flex items-center" aria-label="Tampilkan Password">
                            <!-- Icon Eye -->
                            <svg class="eye-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Icon Eye Slash -->
                            <svg class="eye-slash-icon w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69 9.69a3 3 0 004.243 4.243m-1.89-3.238L12 10.5m-3.5 1L12 10.5M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Confirm Password -->
                <div>
                    <label class="block text-[13px] font-bold text-slate-700 mb-1.5 ml-1">Konfirmasi Sandi Baru</label>
                    <div class="input-modern relative flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300">
                        <div class="pl-4 pr-3 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" class="w-full bg-transparent border-none py-3.5 pl-1 pr-12 text-sm text-slate-800 placeholder-slate-400 focus:ring-0 font-medium">
                        <button type="button" class="toggle-password absolute right-3 text-slate-400 hover:text-slate-600 focus:outline-none flex items-center" aria-label="Tampilkan Password">
                            <!-- Icon Eye -->
                            <svg class="eye-icon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Icon Eye Slash -->
                            <svg class="eye-slash-icon w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.69 9.69a3 3 0 004.243 4.243m-1.89-3.238L12 10.5m-3.5 1L12 10.5M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Submit -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-[14px] font-bold shadow-[0_8px_20px_rgba(37,99,235,0.25)] hover:shadow-[0_12px_25px_rgba(37,99,235,0.35)] transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan Sandi Baru
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

