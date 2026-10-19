<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FonnteWhatsAppService
{
    public function send(string $target, string $message): void
    {
        $token = config('services.fonnte.token');

        if (! is_string($token) || trim($token) === '') {
            throw new RuntimeException('Token API Fonnte belum dikonfigurasi.');
        }

        $target = preg_replace('/\D+/', '', $target) ?? '';

        if ($target === '') {
            throw new RuntimeException('Nomor WhatsApp penerima tidak valid.');
        }

        if (str_starts_with($target, '0')) {
            $target = '62'.substr($target, 1);
        }

        $response = Http::asForm()
            ->withHeaders(['Authorization' => $token])
            ->timeout(15)
            ->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
            ])
            ->throw();

        $result = $response->json();

        if (! is_array($result) || ($result['status'] ?? false) !== true) {
            $detail = is_string($result['detail'] ?? null)
                ? $result['detail']
                : 'Respons API tidak sesuai.';

            throw new RuntimeException('Fonnte menolak pengiriman pesan: '.$detail);
        }
    }
}
