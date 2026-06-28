<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Send a message to a WhatsApp target number.
     *
     * @param string $target
     * @param string $message
     * @return array
     */
    public static function send(string $target, string $message): array
    {
        return app(self::class)->sendMessage($target, $message);
    }

    /**
     * Send a message to a WhatsApp target number (instance method).
     *
     * @param string $target
     * @param string $message
     * @return array
     */
    public function sendMessage(string $target, string $message): array
    {
        $token = config('services.fonnte.token');
        $baseUrl = config('services.fonnte.base_url', 'https://api.fonnte.com');
        $sslVerify = config('services.fonnte.ssl_verify', false);
        $endpoint = rtrim($baseUrl, '/') . '/send';
        $currentTime = now()->toDateTimeString();

        $maskedToken = !empty($token) ? substr($token, 0, 4) . '...' . substr($token, -4) : 'Empty';
        $loggedHeaders = [
            'Authorization' => $maskedToken,
            'Accept' => 'application/json',
        ];

        // Clean phone number (leave digits and commas)
        $cleanTarget = preg_replace('/[^0-9,]/', '', $target);

        // 1. Initial attempt logging
        Log::info('Fonnte API - Sending Message Attempt', [
            'endpoint' => $endpoint,
            'headers' => $loggedHeaders,
            'target' => $target,
            'clean_target' => $cleanTarget,
            'message' => $message,
            'time' => $currentTime,
        ]);

        if (empty($token)) {
            $errMessage = 'Fonnte API Token is not configured.';
            Log::error('Fonnte API Error: ' . $errMessage, [
                'endpoint' => $endpoint,
                'headers' => $loggedHeaders,
                'target' => $target,
                'time' => $currentTime,
            ]);
            return [
                'success' => false,
                'message' => $errMessage,
            ];
        }

        if (empty($cleanTarget)) {
            $errMessage = 'WhatsApp target phone number is invalid.';
            Log::error('Fonnte API Error: ' . $errMessage, [
                'endpoint' => $endpoint,
                'headers' => $loggedHeaders,
                'original_target' => $target,
                'time' => $currentTime,
            ]);
            return [
                'success' => false,
                'message' => $errMessage,
            ];
        }

        $payload = [
            'target' => $cleanTarget,
            'message' => $message,
            'countryCode' => '62',
        ];

        try {
            $request = Http::timeout(10);
            if (!$sslVerify) {
                $request = $request->withoutVerifying();
            }

            $response = $request->withHeaders([
                'Authorization' => $token,
            ])
            ->asForm()
            ->post($endpoint, $payload);

            $status = $response->status();
            $body = $response->json();

            // Logging response details
            Log::info('Fonnte API - Response Received', [
                'endpoint' => $endpoint,
                'headers' => $loggedHeaders,
                'target' => $cleanTarget,
                'message' => $message,
                'payload' => $payload,
                'http_status' => $status,
                'response' => $body,
                'time' => $currentTime,
            ]);

            if ($response->successful() && isset($body['status']) && $body['status'] == true) {
                return [
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim.',
                    'response' => $body,
                ];
            }

            $reason = $body['reason'] ?? 'API returned error code ' . $status;
            return [
                'success' => false,
                'message' => 'Fonnte API Error: ' . $reason,
                'response' => $body,
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $errMessage = 'Connection to Fonnte API timed out or failed: ' . $e->getMessage();
            Log::error('Fonnte API Connection Error: ' . $errMessage, [
                'endpoint' => $endpoint,
                'headers' => $loggedHeaders,
                'target' => $cleanTarget,
                'message' => $message,
                'payload' => $payload,
                'exception' => $e->getMessage(),
                'time' => $currentTime,
            ]);
            return [
                'success' => false,
                'message' => 'Gagal terhubung ke server Fonnte (Koneksi error/SSL error).',
            ];
        } catch (\Exception $e) {
            $errMessage = 'Unexpected error during Fonnte send: ' . $e->getMessage();
            Log::error('Fonnte API Unexpected Error: ' . $errMessage, [
                'endpoint' => $endpoint,
                'headers' => $loggedHeaders,
                'target' => $cleanTarget,
                'message' => $message,
                'payload' => $payload,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'time' => $currentTime,
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat mengirim WhatsApp.',
            ];
        }
    }
}
