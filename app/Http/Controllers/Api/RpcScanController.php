<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RpcScanController extends Controller
{
    public function scan(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'qr_code' => ['required', 'string', 'max:100'],
        ]);

        if (! preg_match('/\AMUSI-RUN-RPC\|([MF](?:7|12)\d{4})\z/', $validated['qr_code'], $matches)) {
            return response()->json([
                'message' => 'Format QR Code tidak valid.',
            ], 422);
        }

        [$status, $body] = DB::transaction(function () use ($matches): array {
            $registrant = Registrant::where('race_number', $matches[1])
                ->lockForUpdate()
                ->first();

            if (! $registrant || $registrant->status !== 'approved') {
                return [404, [
                    'message' => 'Peserta tidak ditemukan atau belum disetujui.',
                ]];
            }

            if ($registrant->rpc_status === 'sudah_diambil') {
                return [409, [
                    'message' => 'Race pack peserta ini sudah pernah diambil.',
                    'data' => $this->participantData($registrant, alreadyCollected: true),
                ]];
            }

            $registrant->update([
                'rpc_status' => 'sudah_diambil',
                'rpc_collected_at' => now(),
            ]);

            return [200, [
                'message' => 'Pengambilan race pack berhasil dicatat.',
                'data' => $this->participantData($registrant, alreadyCollected: false),
            ]];
        });

        return response()->json($body, $status);
    }

    private function participantData(Registrant $registrant, bool $alreadyCollected): array
    {
        return [
            'name' => $registrant->name,
            'phone' => $registrant->phone ?: $registrant->whatsapp,
            'email' => $registrant->email,
            'gender' => $registrant->gender,
            'nik' => $registrant->nik,
            'dob' => $registrant->dob?->format('Y-m-d'),
            'jersey_size' => $registrant->jersey_size,
            'kategori_jarak' => $registrant->kategori_jarak,
            'rpc_status' => $registrant->rpc_status,
            'rpc_collected_at' => $registrant->rpc_collected_at?->toIso8601String(),
            'already_collected' => $alreadyCollected,
        ];
    }
}
