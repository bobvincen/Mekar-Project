<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Obat;
use App\Models\ResepDokter;
use App\Services\FonnteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WhatsAppTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Set test config variables (use double n keys)
        config(['services.fonnte.token' => 'test-token-123']);
        config(['services.fonnte.base_url' => 'https://api.fonnte.com']);
        config(['services.fonnte.admin_phone' => '6282240432990']);

        // Seed products and categories
        $this->seed(\Database\Seeders\MarketplaceSeeder::class);
    }

    public function test_whatsapp_service_success()
    {
        Http::fake([
            'api.fonnte.com/send' => Http::response([
                'status' => true,
                'target' => '6282240432990',
                'message' => 'test message',
                'reason' => 'success'
            ], 200)
        ]);

        $service = new FonnteService();
        $result = $service->sendMessage('6282240432990', 'test message');

        $this->assertTrue($result['success']);
        $this->assertEquals('Pesan berhasil dikirim.', $result['message']);
    }

    public function test_whatsapp_service_fails_when_token_is_missing()
    {
        config(['services.fonnte.token' => '']);

        $service = new FonnteService();
        $result = $service->sendMessage('6282240432990', 'test message');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Token is not configured', $result['message']);
    }

    public function test_whatsapp_service_fails_when_api_returns_error()
    {
        Http::fake([
            'api.fonnte.com/send' => Http::response([
                'status' => false,
                'reason' => 'device disconnected'
            ], 400)
        ]);

        $service = new FonnteService();
        $result = $service->sendMessage('6282240432990', 'test message');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('device disconnected', $result['message']);
    }

    public function test_whatsapp_service_handles_timeout()
    {
        Http::fake([
            'api.fonnte.com/send' => function () {
                throw new \Illuminate\Http\Client\ConnectionException('Connection timed out');
            }
        ]);

        $service = new FonnteService();
        $result = $service->sendMessage('6282240432990', 'test message');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Gagal terhubung ke server Fonnte', $result['message']);
    }

    public function test_checkout_triggers_invoice_creation()
    {
        $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
        $this->actingAs($user);

        $cart = [
            1 => [
                'name' => 'Paracetamol 500mg',
                'price' => 5000,
                'qty' => 2,
                'image' => '/storage/obat/paracetamol.jpg'
            ]
        ];
        session(['checkout_cart' => $cart]);

        $response = $this->postJson('/checkout/process', [
            'nama' => 'Budi Santoso',
            'whatsapp' => '081234567890',
            'metode' => 'Ambil di Apotek',
            'alamat' => null,
            'ongkir' => 0,
            'subtotal' => 10000,
            'total' => 10000
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure(['success', 'kode_transaksi', 'redirect_url']);
    }

    public function test_upload_bukti_triggers_whatsapp_sending()
    {
        Http::fake([
            'api.fonnte.com/send' => Http::response(['status' => true], 200)
        ]);

        $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
        $this->actingAs($user);

        // Create transaction
        $transaksi = \App\Models\Transaksi::create([
            'kode_transaksi' => 'TRX-TEST-0001',
            'user_id' => $user->id,
            'tanggal_transaksi' => now(),
            'total_harga' => 10000,
            'nama_pelanggan' => 'Budi Santoso',
            'whatsapp' => '081234567890',
            'metode_pengambilan' => 'Ambil di Apotek',
            'ongkir' => 0,
            'subtotal' => 10000,
            'status' => 'Menunggu Pembayaran',
        ]);

        $fakePhoto = UploadedFile::fake()->image('bukti.jpg', 600, 800);

        $response = $this->post("/invoice/{$transaksi->kode_transaksi}/upload-bukti", [
            'bukti_transfer' => $fakePhoto
        ]);

        $response->assertStatus(302);
        
        // Assert that Fonnte API endpoint was called to notify Admin
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.fonnte.com/send' &&
                $request['target'] === '6282240432990' &&
                str_contains($request['message'], 'TRX-TEST-0001');
        });
    }

    public function test_upload_bukti_handles_whatsapp_api_failure_gracefully()
    {
        // Simulate API error response from Fonnte
        Http::fake([
            'api.fonnte.com/send' => Http::response([
                'status' => false,
                'reason' => 'device disconnected'
            ], 400)
        ]);

        $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
        $this->actingAs($user);

        // Create transaction
        $transaksi = \App\Models\Transaksi::create([
            'kode_transaksi' => 'TRX-TEST-0002',
            'user_id' => $user->id,
            'tanggal_transaksi' => now(),
            'total_harga' => 10000,
            'nama_pelanggan' => 'Budi Santoso',
            'whatsapp' => '081234567890',
            'metode_pengambilan' => 'Ambil di Apotek',
            'ongkir' => 0,
            'subtotal' => 10000,
            'status' => 'Menunggu Pembayaran',
        ]);

        $fakePhoto = UploadedFile::fake()->image('bukti.jpg', 600, 800);

        $response = $this->post("/invoice/{$transaksi->kode_transaksi}/upload-bukti", [
            'bukti_transfer' => $fakePhoto
        ]);

        // Standard flow should not crash, it should redirect back successfully
        $response->assertStatus(302);
    }

    public function test_resep_dokter_upload_triggers_whatsapp_sending()
    {
        Http::fake([
            'api.fonnte.com/send' => Http::response(['status' => true], 200)
        ]);

        $user = User::factory()->create([
            'name' => 'Budi Santoso',
            'whatsapp' => '081234567890',
            'phone_verified_at' => now(),
            'role' => 'pelanggan'
        ]);

        $fakePhoto = UploadedFile::fake()->image('resep.jpg', 600, 800);

        $response = $this->actingAs($user)->post('/upload-resep', [
            'catatan' => 'Butuh segera',
            'foto_resep' => $fakePhoto
        ]);

        $response->assertStatus(302); // Redirect
        $response->assertRedirect(route('resep.index'));
        $response->assertSessionHas('success');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.fonnte.com/send' &&
                $request['target'] === '6282240432990' &&
                str_contains($request['message'], 'Budi Santoso');
        });
    }
}
