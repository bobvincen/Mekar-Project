<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Http;

class WhatsAppDiagnosticController extends Controller
{
    /**
     * Display the WhatsApp Diagnostic page.
     */
    public function index()
    {
        $token = config('services.fonnte.token');
        $baseUrl = config('services.fonnte.base_url');
        $adminPhone = config('services.fonnte.admin_phone');

        $tokenStatus = !empty($token);
        $maskedToken = $tokenStatus ? substr($token, 0, 4) . '...' . substr($token, -4) : 'Tidak dikonfigurasi';

        $connectionStatus = 'Offline / Terputus';
        $responseDetails = session('last_response', 'Belum ada pengujian.');

        if ($tokenStatus && !session()->has('last_response')) {
            try {
                // Call get-devices to inspect status
                $sslVerify = config('services.fonnte.ssl_verify', false);
                $requestObj = Http::timeout(4);
                if (!$sslVerify) {
                    $requestObj = $requestObj->withoutVerifying();
                }

                $response = $requestObj->withHeaders(['Authorization' => $token])
                    ->post(rtrim($baseUrl, '/') . '/get-devices');

                if ($response->successful()) {
                    $body = $response->json();
                    if (isset($body['status']) && $body['status'] == true) {
                        $connectionStatus = 'Online (Terhubung ke Fonnte)';
                    } else {
                        $connectionStatus = 'Error API: ' . ($body['reason'] ?? 'Token tidak valid');
                    }
                    $responseDetails = json_encode($body, JSON_PRETTY_PRINT);
                } else {
                    $connectionStatus = 'HTTP Error ' . $response->status();
                    $responseDetails = $response->body();
                }
            } catch (\Exception $e) {
                $connectionStatus = 'Error Koneksi: Gagal menghubungi server Fonnte';
                $responseDetails = 'Gagal melakukan check status koneksi: ' . $e->getMessage();
            }
        } elseif (session()->has('last_response')) {
            // If session has last response, it means we just performed a test send. Let's update the status accordingly
            $lastRespDecoded = json_decode(session('last_response'), true);
            if (isset($lastRespDecoded['status']) && $lastRespDecoded['status'] == true) {
                $connectionStatus = 'Online / Sukses Mengirim Pesan';
            } else {
                $connectionStatus = 'Gagal Mengirim / Koneksi Error';
            }
        }

        return view('admin.whatsapp-diagnostic', compact(
            'tokenStatus',
            'maskedToken',
            'baseUrl',
            'adminPhone',
            'connectionStatus',
            'responseDetails'
        ));
    }

    /**
     * Send a test message from the diagnostic page.
     */
    public function testSend(Request $request)
    {
        $request->validate([
            'target' => 'required|string|max:20'
        ], [
            'target.required' => 'Nomor tujuan test wajib diisi.'
        ]);

        $target = $request->input('target');
        $message = "Halo! Ini adalah pesan uji coba dari Halaman Diagnostik WhatsApp Mekar Pharmacy pada " . now()->toDateTimeString() . ".";

        $result = FonnteService::send($target, $message);

        $flashData = [
            'last_response' => json_encode($result['response'] ?? ['status' => false, 'reason' => $result['message']], JSON_PRETTY_PRINT)
        ];

        if ($result['success']) {
            return redirect()->back()->with(array_merge($flashData, [
                'success' => 'Pesan uji coba berhasil dikirim ke nomor ' . $target . '.'
            ]));
        } else {
            return redirect()->back()->withErrors([
                'error' => 'Gagal mengirim pesan test ke ' . $target . ': ' . $result['message']
            ])->with($flashData);
        }
    }
}
