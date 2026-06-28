@extends('layouts.guest')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fbff;
    }

    .bg-abstract {
        background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 50%, #e0f2fe 100%);
    }

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

    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.05), 0 1px 3px rgba(0,0,0,0.02);
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
        <a href="/" class="flex items-center gap-3 mb-10 group w-fit animate-fade-in">
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
                Keamanan & Verifikasi Dua Langkah
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-[54px] font-extrabold text-slate-800 leading-[1.15] tracking-tight mb-6">
                Verifikasi Akun <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">WhatsApp Anda</span>
            </h1>
            <p class="text-base sm:text-lg text-slate-500 font-medium leading-relaxed max-w-md">
                Kami berkomitmen menjaga keamanan akun Anda dengan mengirimkan kode verifikasi 6 digit langsung ke nomor WhatsApp Anda.
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
        </div>

    </div>

    {{-- ===== SISI KANAN: FORM VERIFIKASI OTP ===== --}}
    <div class="w-full lg:w-[45%] flex items-center justify-center p-6 sm:p-12 lg:p-16 z-20">
        
        <div class="w-full max-w-[420px] glass-card rounded-[24px] p-8 sm:p-10 animate-fade-in-delayed transform transition-all duration-500 hover:shadow-[0_30px_60px_rgba(37,99,235,0.12)]">
            
            <div class="text-center mb-8">
                <div class="inline-flex p-3 rounded-full bg-blue-50 text-blue-600 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Verifikasi OTP</h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">
                    Masukkan 6 digit kode OTP yang kami kirimkan ke nomor WhatsApp <span class="font-bold text-slate-700">{{ $user->whatsapp }}</span>.
                </p>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 text-xs font-bold flex items-center gap-2 animate-fade-in">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs font-bold flex items-center gap-2 animate-fade-in">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 text-xs font-bold flex items-center gap-2 animate-fade-in">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- OTP Input Form -->
            <form method="POST" action="{{ route('otp.verify.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="otp" class="block text-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Kode OTP</label>
                    <div class="relative">
                        <input type="text" name="otp" id="otp" maxlength="6" required autocomplete="off" autofocus placeholder="000000"
                               class="w-full text-center text-3xl font-extrabold tracking-[0.5em] pl-[0.5em] py-3.5 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 placeholder:text-slate-200 placeholder:font-normal">
                    </div>
                    @error('otp')
                        <p class="text-red-500 text-xs mt-2 text-center font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-[14px] font-bold shadow-[0_8px_20px_rgba(37,99,235,0.25)] hover:shadow-[0_12px_25px_rgba(37,99,235,0.35)] transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Verifikasi OTP
                </button>
            </form>

            <!-- Resend Form -->
            <form id="resend-form" method="POST" action="{{ route('otp.resend') }}" class="mt-6 text-center border-t border-slate-100 pt-4">
                @csrf
                <p class="text-xs text-slate-500 font-medium mb-1">Tidak menerima kode OTP?</p>
                <button type="submit" id="resend-btn" class="text-[13px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                    Kirim Ulang OTP
                </button>
                <p id="countdown-text" class="text-xs text-slate-400 mt-2.5 font-bold"></p>
            </form>

            <!-- Return Link -->
            <p class="text-center text-xs font-semibold text-slate-400 mt-6">
                Salah nomor WhatsApp? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Daftar ulang</a>
            </p>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let seconds = Math.ceil({{ $secondsRemaining ?? 0 }});
        const resendBtn = document.getElementById('resend-btn');
        const countdownText = document.getElementById('countdown-text');
        
        function updateTimer() {
            if (seconds > 0) {
                resendBtn.disabled = true;
                resendBtn.style.pointerEvents = 'none';
                resendBtn.classList.add('opacity-50', 'text-slate-400', 'cursor-not-allowed');
                resendBtn.classList.remove('text-blue-600', 'hover:text-blue-800');
                countdownText.innerText = `Kirim ulang tersedia dalam ${seconds} detik`;
            } else {
                resendBtn.disabled = false;
                resendBtn.style.pointerEvents = 'auto';
                resendBtn.classList.remove('opacity-50', 'text-slate-400', 'cursor-not-allowed');
                resendBtn.classList.add('text-blue-600', 'hover:text-blue-800');
                countdownText.innerText = '';
            }
        }

        updateTimer();

        if (seconds > 0) {
            let interval = setInterval(function () {
                seconds--;
                updateTimer();
                
                if (seconds <= 0) {
                    clearInterval(interval);
                }
            }, 1000);
        }

        // Simple numbers-only filter for OTP input
        const otpInput = document.getElementById('otp');
        otpInput.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection
