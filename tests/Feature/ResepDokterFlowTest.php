<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Obat;
use App\Models\ResepDokter;
use App\Models\ResepDokterItem;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepDokterFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_admin_and_apoteker_can_access_proses_resep_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $admin->assignRole('admin');

        $customer = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);

        $resep = ResepDokter::create([
            'user_id' => $customer->id,
            'nama' => $customer->name,
            'whatsapp' => $customer->whatsapp ?? '081234567890',
            'catatan' => 'Resep asma',
            'foto_resep' => 'prescriptions/test.jpg',
            'status' => 'menunggu_verifikasi',
        ]);

        // Process view can be rendered by admin
        $response = $this->actingAs($admin)->get(route('resep.proses', $resep->id));
        $response->assertStatus(200);
        $response->assertViewHas('selectedObatsJson');

        // Status is automatically updated to 'sedang_diproses'
        $resep->refresh();
        $this->assertEquals('sedang_diproses', $resep->status);
    }
}
