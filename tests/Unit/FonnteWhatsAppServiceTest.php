<?php

namespace Tests\Unit;

use App\Services\FonnteWhatsAppService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class FonnteWhatsAppServiceTest extends TestCase
{
    public function test_it_sends_a_message_through_fonnte(): void
    {
        config(['services.fonnte.token' => 'test-fonnte-token']);
        Http::fake([
            'api.fonnte.com/send' => Http::response(['status' => true, 'detail' => 'success']),
        ]);

        app(FonnteWhatsAppService::class)->send('081234567890', 'Tes notifikasi');

        Http::assertSent(fn (Request $request) => $request->url() === 'https://api.fonnte.com/send'
            && $request->hasHeader('Authorization', 'test-fonnte-token')
            && $request['target'] === '6281234567890'
            && $request['message'] === 'Tes notifikasi');
    }

    public function test_it_throws_when_fonnte_rejects_a_message(): void
    {
        config(['services.fonnte.token' => 'test-fonnte-token']);
        Http::fake([
            'api.fonnte.com/send' => Http::response(['status' => false, 'detail' => 'Invalid token']),
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Fonnte menolak pengiriman pesan: Invalid token');

        app(FonnteWhatsAppService::class)->send('6281234567890', 'Tes notifikasi');
    }
}
