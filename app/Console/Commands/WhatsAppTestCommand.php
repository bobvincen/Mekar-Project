<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FonnteService;

class WhatsAppTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {target?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test WhatsApp message using Fonnte API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = $this->argument('target') ?: config('services.fonnte.admin_phone');
        $token = config('services.fonnte.token');
        $baseUrl = config('services.fonnte.base_url');

        $this->info('Starting Fonnte WhatsApp API Diagnostic Test...');
        $this->line('----------------------------------------------');
        $this->line('Base URL      : ' . ($baseUrl ?: 'Not configured'));
        $this->line('Token Status  : ' . ($token ? 'Configured (' . substr($token, 0, 4) . '...' . substr($token, -4) . ')' : 'Not configured'));
        $this->line('Target Phone  : ' . ($target ?: 'Not configured'));
        $this->line('----------------------------------------------');

        if (empty($token)) {
            $this->error('ERROR: Fonnte API Token is empty. Please set FONNTE_TOKEN in your .env file.');
            return 1;
        }

        if (empty($target)) {
            $this->error('ERROR: Target phone number is empty. Please set FONNTE_ADMIN_PHONE in your .env file.');
            return 1;
        }

        $message = "Halo! Ini adalah pesan uji coba (Diagnostic Test) dari sistem Mekar Pharmacy pada " . now()->toDateTimeString() . ".";
        
        $this->info('Sending test message to: ' . $target);
        
        $result = FonnteService::send($target, $message);

        $this->line('----------------------------------------------');
        if ($result['success']) {
            $this->info('SUCCESS: Message sent successfully!');
            if (isset($result['response'])) {
                $this->line('Response Details:');
                $this->line(json_encode($result['response'], JSON_PRETTY_PRINT));
            }
            return 0;
        } else {
            $this->error('FAILED: Message delivery failed.');
            $this->error('Reason: ' . $result['message']);
            if (isset($result['response'])) {
                $this->line('Raw response details:');
                $this->line(json_encode($result['response'], JSON_PRETTY_PRINT));
            }
            return 1;
        }
    }
}
