<?php

namespace App\Http\Controllers;

use App\Exports\AcceptedRegistrantsExport;
use App\Exports\RegistrantsExport;
use App\Mail\RegistrantApproved;
use App\Mail\RegistrantRejected;
use App\Models\Registrant;
use App\Services\FonnteWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class AdminController extends Controller
{
    public function dashboard()
    {
        // guard: only allow admin users
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        $registrants = Registrant::orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => $registrants->count(),
            'approved' => $registrants->where('status', 'approved')->count(),
            'pending' => $registrants->where('status', 'pending')->count(),
            'rejected' => $registrants->where('status', 'rejected')->count(),
        ];

        $categoryStats = $registrants->groupBy('kategori_jarak')
            ->map(fn ($items, $label) => ['label' => $label ?: 'Belum dipilih', 'count' => $items->count()])
            ->values();
        $genderStats = $registrants->groupBy('gender')
            ->map(fn ($items, $label) => ['label' => $label ?: 'Belum diisi', 'count' => $items->count()])
            ->values();
        $jerseyStats = $registrants->groupBy('jersey_size')
            ->map(fn ($items, $label) => ['label' => $label ?: 'Belum diisi', 'count' => $items->count()])
            ->sortByDesc('count')
            ->values();

        return view('admin.daftar_peserta', compact(
            'registrants',
            'stats',
            'categoryStats',
            'genderStats',
            'jerseyStats'
        ));
    }

    public function participants()
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $registrants = Registrant::orderBy('created_at', 'desc')->get();

        return view('admin.peserta', compact('registrants'));
    }

    public function show(Registrant $registrant)
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return view('admin.detail_peserta', compact('registrant'));
    }

    public function edit(Registrant $registrant)
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return view('admin.edit_peserta', compact('registrant'));
    }

    public function update(Request $request, Registrant $registrant)
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $request->merge([
            'whatsapp' => preg_replace('/\D+/', '', (string) $request->input('whatsapp')),
            'emergency_phone' => preg_replace('/\D+/', '', (string) $request->input('emergency_phone')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'whatsapp' => 'required|regex:/^[0-9]{10,15}$/',
            'jersey_size' => 'required|string|max:10',
            'kategori_jarak' => 'required|string|max:100',
            'emergency_phone' => 'required|regex:/^[0-9]{10,15}$/',
        ]);
        $registrant->update($validated);

        return redirect()->route('admin.registrant.show', $registrant)
            ->with('success', 'Data peserta berhasil diperbarui');
    }

    public function accepted()
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $registrants = Registrant::where('status', 'approved')
            ->orderByDesc('approved_at')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.peserta_diterima', compact('registrants'));
    }

    public function updateStatus(Request $request, Registrant $registrant)
    {
        // guard: only allow admin users
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|string|max:1000',
        ]);

        $wasApproved = $registrant->status === 'approved';
        $wasRejected = $registrant->status === 'rejected';
        $isApproved = $validated['status'] === 'approved';
        $isRejected = $validated['status'] === 'rejected';
        $raceNumber = $isApproved
            ? ($registrant->race_number ?: Registrant::generateRaceNumber($registrant->gender, $registrant->kategori_jarak))
            : null;

        $registrant->update([
            'status' => $validated['status'],
            'approved_at' => $isApproved ? ($registrant->approved_at ?: now()) : null,
            'race_number' => $raceNumber,
            'rejection_reason' => $isRejected ? trim($validated['rejection_reason']) : null,
        ]);

        if ($isApproved && ! $wasApproved) {
            return $this->sendStatusNotifications($registrant, true);
        }

        if ($isRejected && ! $wasRejected) {
            return $this->sendStatusNotifications($registrant, false);
        }

        return redirect()->back()->with('success', 'Status peserta berhasil diperbarui');
    }

    private function sendStatusNotifications(Registrant $registrant, bool $approved)
    {
        $statusMessage = $approved
            ? 'Peserta berhasil disetujui.'
            : 'Pendaftaran peserta berhasil ditolak.';
        $failures = [];

        if (blank($registrant->email)) {
            $failures[] = 'Email tidak dikirim karena alamat email peserta belum tersedia.';
        } else {
            try {
                $mail = $approved
                    ? new RegistrantApproved($registrant)
                    : new RegistrantRejected($registrant);

                Mail::to($registrant->email)->send($mail);
            } catch (Throwable $exception) {
                Log::error('Gagal mengirim email notifikasi status pendaftaran.', [
                    'registrant_id' => $registrant->id,
                    'error' => $exception->getMessage(),
                ]);
                $failures[] = 'Email gagal dikirim. Periksa konfigurasi SMTP dan log aplikasi.';
            }
        }

        if (blank($registrant->whatsapp)) {
            $failures[] = 'WhatsApp tidak dikirim karena nomor peserta belum tersedia.';
        } else {
            $message = $approved
                ? implode("\n", [
                    "Yth. *{$registrant->name}*,",
                    'Pendaftaran Anda untuk *MUSI RUN 2027* telah *DISETUJUI*.',
                    '',
                    '*Ringkasan Pendaftaran*',
                    '- Nama: '.($registrant->name ?: '-'),
                    '- Kategori: '.($registrant->kategori_jarak ?: '-'),
                    '- Ukuran jersey: '.($registrant->jersey_size ?: '-'),
                    '- Tanggal lahir: '.($registrant->dob?->format('d-m-Y') ?: '-'),
                    '- Jenis kelamin: '.($registrant->gender ?: '-'),
                    '- Komunitas: '.($registrant->community ?: '-'),
                    '- Waktu persetujuan: '.($registrant->approved_at?->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') ?: '-').' WIB',
                    '',
                    'Simpan pesan ini sebagai konfirmasi. Sampai bertemu di garis start!',
                    '',
                    'Salam,',
                    '*Panitia MUSI RUN 2027*',
                ])
                : implode("\n", [
                    "Yth. *{$registrant->name}*,",
                    'Pendaftaran Anda untuk *MUSI RUN 2027* belum dapat disetujui.',
                    '',
                    '*Catatan Panitia*',
                    $registrant->rejection_reason ?: '-',
                    '',
                    'Jika ada kekeliruan atau Anda memerlukan informasi lebih lanjut, silakan hubungi panitia MUSI RUN.',
                    '',
                    'Salam,',
                    '*Panitia MUSI RUN 2027*',
                ]);

            try {
                app(FonnteWhatsAppService::class)->send($registrant->whatsapp, $message);
            } catch (Throwable $exception) {
                Log::error('Gagal mengirim WhatsApp notifikasi status pendaftaran.', [
                    'registrant_id' => $registrant->id,
                    'error' => $exception->getMessage(),
                ]);
                $failures[] = 'WhatsApp gagal dikirim. Periksa konfigurasi Fonnte dan log aplikasi.';
            }
        }

        if ($failures !== []) {
            return redirect()->back()->with([
                'success' => $statusMessage,
                'warning' => 'Status sudah tersimpan, tetapi sebagian notifikasi tidak terkirim: '.implode(' ', $failures),
            ]);
        }

        return redirect()->back()->with([
            'success' => $statusMessage.' Notifikasi email dan WhatsApp telah dikirim.',
        ]);
    }

    public function updateRpcStatus(Request $request, Registrant $registrant)
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $validated = $request->validate([
            'rpc_status' => 'required|in:belum_diambil,sudah_diambil',
        ]);

        $registrant->update([
            'rpc_status' => $validated['rpc_status'],
            'rpc_collected_at' => $validated['rpc_status'] === 'sudah_diambil' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Status RPC berhasil diperbarui');
    }

    public function export()
    {
        // guard: only allow admin users
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return Excel::download(new RegistrantsExport, 'peserta-musi-run-2025.xlsx');
    }

    public function exportAccepted(string $distance)
    {
        if (! auth()->check() || (auth()->user()->role ?? 'user') !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        abort_unless(in_array($distance, ['7', '12'], true), 404);

        return Excel::download(
            new AcceptedRegistrantsExport($distance),
            'peserta-diterima-'.$distance.'km.xlsx'
        );
    }
}
