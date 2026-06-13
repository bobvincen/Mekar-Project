@extends('layouts.guest')

@section('content')

<style>
.watermark-bg {
    background-color: #eef3f8;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='240' height='240' viewBox='0 0 240 240'%3E%3Cg fill='none' stroke='%2300a9ff' stroke-width='1.2' stroke-opacity='0.045' transform='rotate(-15 120 120)'%3E%3Cpath d='M30,50 C24,56 24,66 30,72 C36,78 46,78 52,72 C58,66 58,56 52,50 C46,44 36,44 30,50 Z M37,57 L45,65' /%3E%3Ccircle cx='180' cy='60' r='18' /%3E%3Cpath d='M172,60 H188 M180,52 V68' stroke-width='2' /%3E%3Cpath d='M30,170 H60 V195 H30 Z M37,170 V162 H53 V170 M38,182 H52 M45,176 V188' /%3E%3Cpath d='M160,170 L200,170 L200,185 L160,185 Z M170,170 L175,160 L185,160 L190,170 M172,178 H188 M180,174 V182' /%3E%3C/g%3E%3C/svg%3E");
    background-repeat: repeat;
}
</style>

<div class="min-h-screen flex w-full overflow-hidden">

    <!-- Kiri (Gradient & Brand Identity) -->
    <div class="relative w-[58%] bg-gradient-to-br from-[#051D3B] to-[#00A9FF] flex items-center justify-center p-12 min-h-screen overflow-hidden">
        
        <div class="flex flex-col items-center justify-center text-center max-w-lg z-10">
            <div class="flex items-center justify-center">
                <img src="{{ asset('logo-login.png') }}" alt="Mekar Pharmacy Logo" class="h-50 w-auto drop-shadow-md">
            </div>

            <p class="mt-8 text-[#00F0FF] text-lg font-bold tracking-wide">
                Smart Pharmacy for Better Health
            </p>
        </div>

        <!-- Wave mask overlay sitting on the right edge of left section -->
        <div class="absolute top-0 right-0 h-full w-[160px] pointer-events-none z-20">
            <svg class="h-full w-full" viewBox="0 0 160 1000" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M160,0 L80,0 C130,300 -20,700 160,1000 Z" fill="#eef3f8" />
            </svg>
        </div>
        
    </div>

    <!-- Kanan (Watermark & Form Login) -->
    <div class="w-[42%] watermark-bg flex items-center justify-center relative min-h-screen px-12">
        
        <div class="w-full max-w-sm z-10">

            <h2 class="text-4xl font-extrabold text-[#008DDA] text-center mb-8 tracking-wide">
                Login
            </h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">

                @csrf

                <!-- Input Email / Nama -->
                <div>
                    <div class="relative flex items-center rounded-full bg-gradient-to-r from-[#93A9D1] to-[#9DE2F0] border border-[#7D95C0]/30 shadow-sm transition-all focus-within:ring-2 focus-within:ring-cyan-500 focus-within:border-transparent">
                        <div class="flex items-center justify-center pl-5 pr-3 text-[#1E3A8A]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="h-6 w-[1px] bg-[#1E3A8A]/20"></div>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Nama"
                            required
                            autofocus
                            class="w-full bg-transparent border-none py-3.5 pl-4 pr-5 text-[#1E3A8A] placeholder-[#1E3A8A]/60 focus:ring-0 focus:outline-none rounded-r-full font-medium"
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 ml-5 font-semibold">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Input Password / Kata Sandi -->
                <div>
                    <div class="relative flex items-center rounded-full bg-gradient-to-r from-[#93A9D1] to-[#9DE2F0] border border-[#7D95C0]/30 shadow-sm transition-all focus-within:ring-2 focus-within:ring-cyan-500 focus-within:border-transparent">
                        <div class="flex items-center justify-center pl-5 pr-3 text-[#1E3A8A]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="h-6 w-[1px] bg-[#1E3A8A]/20"></div>
                        <input
                            type="password"
                            name="password"
                            placeholder="Kata sandi"
                            required
                            autocomplete="current-password"
                            class="w-full bg-transparent border-none py-3.5 pl-4 pr-5 text-[#1E3A8A] placeholder-[#1E3A8A]/60 focus:ring-0 focus:outline-none rounded-r-full font-medium"
                        >
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 ml-5 font-semibold">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Atau Masuk Dengan (Google) -->
                <div class="text-center pt-2">
                    <span class="text-xs italic text-slate-500 font-medium">Atau masuk dengan</span>
                    <button type="button" class="w-full mt-3 py-2.5 rounded-full bg-white border border-slate-200 shadow-sm flex items-center justify-center hover:bg-slate-50 transition-all">
                        <svg class="h-6 w-auto" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335" />
                        </svg>
                    </button>
                </div>

                <!-- Button Submit Masuk -->
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full py-3.5 rounded-full bg-gradient-to-r from-[#0A3981] to-[#00A9FF] text-white font-bold hover:opacity-95 shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2"
                    >
                        Masuk
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
