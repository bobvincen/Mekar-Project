@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex">

    <!-- Kiri -->
    <div class="w-2/3 bg-gradient-to-b from-blue-900 to-cyan-500 flex items-center justify-center">

        <div class="text-center text-white">

            <h1 class="text-6xl font-bold mb-4">
                MEKAR
            </h1>

            <p class="text-3xl">
                PHARMACY
            </p>

            <p class="mt-8 text-lg">
                Smart Pharmacy for Better Health
            </p>

        </div>

    </div>

    <!-- Kanan -->
    <div class="w-1/3 bg-slate-100 flex items-center justify-center">

        <div class="w-96">

            <h2 class="text-4xl font-bold text-cyan-600 text-center mb-10">
                Login
            </h2>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="mb-5">

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        class="w-full px-5 py-4 rounded-full bg-cyan-100 border-none focus:ring-2 focus:ring-cyan-500">

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div class="mb-6">

                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="w-full px-5 py-4 rounded-full bg-cyan-100 border-none focus:ring-2 focus:ring-cyan-500">

                    @error('password')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="w-full py-4 rounded-full bg-gradient-to-r from-blue-900 to-cyan-500 text-white font-semibold">

                    Masuk

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
