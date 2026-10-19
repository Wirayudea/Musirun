<?php

namespace Tests\Feature;

use App\Models\Registrant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ScannerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_receive_a_scanner_token_without_expiration(): void
    {
        $admin = $this->createAdmin();

        $this->postJson('/api/scanner/login', [
            'email' => $admin->email,
            'password' => 'admin-password',
            'device_name' => 'Petugas Gerbang 1',
        ])
            ->assertOk()
            ->assertJsonPath('message', 'Login berhasil.')
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.user.email', $admin->email)
            ->assertJsonPath('data.expires_at', null)
            ->assertJsonStructure(['data' => ['token', 'expires_at']]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $admin->id,
            'name' => 'Petugas Gerbang 1',
            'expires_at' => null,
        ]);
    }

    public function test_non_admin_account_cannot_login_to_scanner_api(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('admin-password'),
            'role' => 'user',
        ]);

        $this->postJson('/api/scanner/login', [
            'email' => 'user@example.com',
            'password' => 'admin-password',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }

    public function test_scanning_an_approved_participant_records_rpc_pickup(): void
    {
        $token = $this->loginAdmin();
        $registrant = $this->createApprovedRegistrant();

        $this->withToken($token)
            ->postJson('/api/scanner/scan', [
                'qr_code' => 'MUSI-RUN-RPC|M70001',
            ])
            ->assertOk()
            ->assertJsonPath('message', 'Pengambilan race pack berhasil dicatat.')
            ->assertJsonPath('data.name', 'Peserta Tes')
            ->assertJsonPath('data.phone', '081234567890')
            ->assertJsonPath('data.email', 'peserta@example.com')
            ->assertJsonPath('data.gender', 'Laki-laki')
            ->assertJsonPath('data.nik', '1234567890123456')
            ->assertJsonPath('data.dob', '1990-05-12')
            ->assertJsonPath('data.jersey_size', 'M')
            ->assertJsonPath('data.rpc_status', 'sudah_diambil')
            ->assertJsonPath('data.already_collected', false)
            ->assertJsonMissingPath('data.race_number');

        $this->assertDatabaseHas('registrants', [
            'id' => $registrant->id,
            'rpc_status' => 'sudah_diambil',
        ]);
        $this->assertNotNull($registrant->fresh()->rpc_collected_at);
    }

    public function test_scanning_a_collected_participant_returns_conflict_without_changing_pickup_time(): void
    {
        $token = $this->loginAdmin();
        $collectedAt = now()->subHour();
        $this->createApprovedRegistrant([
            'rpc_status' => 'sudah_diambil',
            'rpc_collected_at' => $collectedAt,
        ]);

        $this->withToken($token)
            ->postJson('/api/scanner/scan', [
                'qr_code' => 'MUSI-RUN-RPC|M70001',
            ])
            ->assertStatus(409)
            ->assertJsonPath('data.rpc_status', 'sudah_diambil')
            ->assertJsonPath('data.already_collected', true)
            ->assertJsonMissingPath('data.race_number');

        $this->assertDatabaseHas('registrants', [
            'race_number' => 'M70001',
            'rpc_collected_at' => $collectedAt->toDateTimeString(),
        ]);
    }

    public function test_scanner_token_is_required_and_invalid_qr_is_rejected(): void
    {
        $this->postJson('/api/scanner/scan', [
            'qr_code' => 'MUSI-RUN-RPC|M70001',
        ])->assertUnauthorized();

        $this->withToken($this->loginAdmin())
            ->postJson('/api/scanner/scan', [
                'qr_code' => 'M70001',
            ])
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Format QR Code tidak valid.');
    }

    public function test_logout_revokes_the_current_scanner_token(): void
    {
        $token = $this->loginAdmin();

        $this->withToken($token)
            ->postJson('/api/scanner/logout')
            ->assertOk()
            ->assertJsonPath('message', 'Logout berhasil.');

        $this->withToken($token)
            ->postJson('/api/scanner/scan', [
                'qr_code' => 'MUSI-RUN-RPC|M70001',
            ])
            ->assertUnauthorized();
    }

    private function loginAdmin(): string
    {
        $admin = $this->createAdmin();

        return $this->postJson('/api/scanner/login', [
            'email' => $admin->email,
            'password' => 'admin-password',
        ])->assertOk()->json('data.token');
    }

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin-password'),
            'role' => 'admin',
        ]);
    }

    private function createApprovedRegistrant(array $overrides = []): Registrant
    {
        return Registrant::create(array_merge([
            'race_number' => 'M70001',
            'name' => 'Peserta Tes',
            'phone' => '081234567890',
            'email' => 'peserta@example.com',
            'gender' => 'Laki-laki',
            'nik' => '1234567890123456',
            'dob' => '1990-05-12',
            'jersey_size' => 'M',
            'kategori_jarak' => '7 Kilometer',
            'status' => 'approved',
            'rpc_status' => 'belum_diambil',
        ], $overrides));
    }
}
