<?php

namespace Tests\Feature;

use App\Mail\RegistrantApproved;
use App\Mail\RegistrantRejected;
use App\Models\Registrant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrantStatusNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_approving_a_registrant_sends_email_and_whatsapp_notifications(): void
    {
        config(['services.fonnte.token' => 'test-fonnte-token']);
        Http::fake([
            'api.fonnte.com/send' => Http::response(['status' => true, 'detail' => 'success']),
        ]);
        Mail::fake();

        $registrant = $this->createPendingRegistrant();

        $this->actingAs(User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]))
            ->patch(route('admin.registrant.status', $registrant), ['status' => 'approved'])
            ->assertSessionHas('success', 'Peserta berhasil disetujui. Notifikasi email dan WhatsApp telah dikirim.');

        Mail::assertSent(RegistrantApproved::class, function (RegistrantApproved $mail): bool {
            $image = getimagesizefromstring($mail->rpcQrCode);

            return is_array($image)
                && $image[2] === IMAGETYPE_PNG
                && $image[0] === 320
                && $image[1] === 320
                && str_contains($mail->rpcQrCode, 'PNG');
        });
        Http::assertSent(fn (Request $request) => $request->url() === 'https://api.fonnte.com/send'
            && $request['target'] === '6281234567890'
            && str_contains($request['message'], '*Peserta Tes*')
            && str_contains($request['message'], 'DISETUJUI')
            && str_contains($request['message'], 'Kategori: 7 Kilometer')
            && str_contains($request['message'], 'Ukuran jersey: M')
            && ! str_contains($request['message'], 'Nomor BIB'));
    }

    public function test_rejecting_a_registrant_sends_email_and_whatsapp_notifications(): void
    {
        config(['services.fonnte.token' => 'test-fonnte-token']);
        Http::fake([
            'api.fonnte.com/send' => Http::response(['status' => true, 'detail' => 'success']),
        ]);
        Mail::fake();

        $registrant = $this->createPendingRegistrant();

        $this->actingAs(User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]))
            ->patch(route('admin.registrant.status', $registrant), [
                'status' => 'rejected',
                'rejection_reason' => 'Bukti pembayaran tidak terbaca.',
            ])
            ->assertSessionHas('success', 'Pendaftaran peserta berhasil ditolak. Notifikasi email dan WhatsApp telah dikirim.');

        Mail::assertSent(RegistrantRejected::class);
        Http::assertSent(fn (Request $request) => $request->url() === 'https://api.fonnte.com/send'
            && $request['target'] === '6281234567890'
            && str_contains($request['message'], 'belum dapat disetujui')
            && str_contains($request['message'], 'Bukti pembayaran tidak terbaca.'));
    }

    private function createPendingRegistrant(): Registrant
    {
        return Registrant::create([
            'name' => 'Peserta Tes',
            'email' => 'peserta@example.com',
            'whatsapp' => '081234567890',
            'gender' => 'Laki-laki',
            'jersey_size' => 'M',
            'kategori_jarak' => '7 Kilometer',
            'status' => 'pending',
        ]);
    }
}
