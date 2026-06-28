<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpVerification;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OtpVerificationController extends Controller
{
    /**
     * Display the OTP verification view.
     */
    public function showVerifyForm()
    {
        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi Anda tidak ditemukan. Silakan login atau daftar kembali.');
        }

        $user = User::findOrFail($userId);

        // Check if the user is already verified
        if ($user->phone_verified_at !== null) {
            Auth::login($user);
            session()->forget('otp_user_id');
            return redirect('/marketplace');
        }

        // Calculate seconds remaining for resend throttling
        $secondsRemaining = 0;
        $lastOtp = OtpVerification::where('user_id', $user->id)
            ->latest()
            ->first();

        if ($lastOtp) {
            $diff = now()->diffInSeconds($lastOtp->created_at);
            if ($diff < 60) {
                $secondsRemaining = 60 - $diff;
            }
        }

        return view('auth.otp-verify', compact('user', 'secondsRemaining'));
    }

    /**
     * Handle the OTP verification request.
     */
    public function verifyOtp(Request $request)
    {
        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi Anda telah berakhir.');
        }

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        $user = User::findOrFail($userId);

        // Find the latest active OTP verification record
        $otpRecord = OtpVerification::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->with('error', 'Kode OTP kadaluarsa atau tidak valid. Silakan klik kirim ulang.');
        }

        // Max attempts check (5 attempts allowed)
        if ($otpRecord->attempts >= 5) {
            return back()->with('error', 'Anda telah melebihi batas maksimal percobaan (5 kali). Silakan kirim ulang OTP baru.');
        }

        // Increment attempts count
        $otpRecord->increment('attempts');

        // Check if the entered OTP is correct
        if ($otpRecord->otp === $request->otp) {
            // Mark the OTP as verified
            $otpRecord->verified_at = now();
            $otpRecord->save();

            // Mark the user as verified
            $user->phone_verified_at = now();
            $user->save();

            // Log the user in automatically
            Auth::login($user);

            // Forget verify session
            session()->forget('otp_user_id');

            return redirect('/marketplace')->with('success', 'Nomor WhatsApp berhasil diverifikasi! Selamat datang di Mekar Pharmacy.');
        }

        $remainingAttempts = 5 - $otpRecord->attempts;
        if ($remainingAttempts <= 0) {
            return back()->with('error', 'Kode OTP salah. Anda telah melebihi batas maksimal percobaan. Silakan kirim ulang OTP baru.');
        }

        return back()->with('error', "Kode OTP salah. Sisa percobaan: {$remainingAttempts} kali.");
    }

    /**
     * Resend a new OTP.
     */
    public function resendOtp(Request $request)
    {
        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi Anda telah berakhir.');
        }

        $user = User::findOrFail($userId);

        // Verify if 60 seconds have passed since the last OTP creation
        $lastOtp = OtpVerification::where('user_id', $user->id)
            ->latest()
            ->first();

        if ($lastOtp && now()->diffInSeconds($lastOtp->created_at) < 60) {
            $secondsLeft = 60 - now()->diffInSeconds($lastOtp->created_at);
            return back()->with('error', "Harap tunggu {$secondsLeft} detik sebelum mengirim ulang OTP.");
        }

        // Generate and send a new OTP
        self::generateAndSendOtp($user);

        return back()->with('success', 'Kode OTP baru telah berhasil dikirim ke nomor WhatsApp Anda.');
    }

    /**
     * Generate OTP and send it via Fonnte.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    public static function generateAndSendOtp(User $user): string
    {
        // 1. Generate 6 digit numeric OTP
        $otp = sprintf('%06d', rand(0, 999999));

        // 2. Store OTP in database
        OtpVerification::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        // 3. Send message via Fonnte Service
        $message = "MEKAR PHARMACY\n\nKode OTP registrasi Anda adalah: *{$otp}*\n\nKode ini berlaku selama 5 menit. Harap JANGAN sebarkan kode ini kepada siapapun demi keamanan akun Anda.";
        
        Log::info('Sending OTP to user: ' . $user->id . ' - Phone: ' . $user->whatsapp);
        FonnteService::send($user->whatsapp ?? '', $message);

        return $otp;
    }
}
