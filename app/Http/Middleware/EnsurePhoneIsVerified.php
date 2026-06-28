<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'pelanggan' && $user->phone_verified_at === null) {
            // Store user ID in session to allow verify OTP screen lookup
            session(['otp_user_id' => $user->id]);

            // Immediately logout user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('otp.verify')->with('error', 'Nomor WhatsApp Anda belum terverifikasi. Silakan masukkan kode OTP yang dikirim.');
        }

        return $next($request);
    }
}
