<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Status Pendaftaran MUSI RUN</title>
    <style>
        body { margin: 0; padding: 24px 12px; background: #eaf3f8; color: #243746; font-family: Arial, sans-serif; }
        .email-container { max-width: 620px; margin: 0 auto; overflow: hidden; border: 1px solid #d6e5ec; border-radius: 14px; background: #fff; }
        .email-header { padding: 28px 24px; background: #123b56; color: #fff; text-align: left; }
        .event-label { margin: 0 0 18px; color: #9fe3e8; font-size: 12px; font-weight: 700; letter-spacing: 2px; }
        .email-header h1 { margin: 0; color: #fff; font-size: 25px; line-height: 1.3; }
        .email-header h2 { margin: 12px 0 0; color: #d8eaf1; font-size: 17px; font-weight: 400; }
        .route-mark { height: 5px; background: linear-gradient(90deg, #38b6c5 0 35%, #f1bd55 35% 65%, #eaf3f8 65%); }
        .email-body { padding: 28px 24px; }
        .intro { margin: 0 0 20px; color: #405969; font-size: 15px; line-height: 1.7; }
        .status-card { margin: 0 0 22px; padding: 15px 18px; border-left: 4px solid #1b9a91; border-radius: 6px; background: #eaf7f4; }
        .status-card strong { display: block; margin-bottom: 4px; color: #14776f; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .status-card span { color: #214b4a; font-size: 16px; font-weight: 700; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 11px 9px; border-bottom: 1px solid #e5edf1; text-align: left; line-height: 1.45; }
        .data-table th { width: 38%; color: #617784; font-size: 13px; font-weight: 600; }
        .data-table td { color: #263d4b; font-size: 14px; overflow-wrap: anywhere; }
        .rpc-ticket { margin: 24px 0 0; padding: 20px; border: 1px solid #d6e5ec; border-radius: 10px; background: #f8fbfc; text-align: center; }
        .rpc-ticket h3 { margin: 0 0 8px; color: #123b56; font-size: 17px; }
        .rpc-ticket p { margin: 0 0 14px; color: #405969; font-size: 14px; line-height: 1.6; }
        .rpc-ticket img { display: block; width: 220px; max-width: 100%; height: auto; margin: 0 auto 12px; }
        .rpc-bib { margin: 0 !important; color: #123b56 !important; font-size: 18px !important; font-weight: 700; letter-spacing: 1px; }
        .rpc-note { margin: 22px 0 0; padding: 16px; border-radius: 8px; background: #f2f7fa; color: #405969; font-size: 14px; line-height: 1.7; }
        .footer { padding: 18px 24px; border-top: 1px solid #e2edf2; background: #f7fafb; color: #71838d; font-size: 12px; line-height: 1.6; }
        @media only screen and (max-width: 480px) {
            body { padding: 12px 8px; }
            .email-header, .email-body { padding: 22px 18px; }
            .email-header h1 { font-size: 21px; }
            .data-table th { width: 42%; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <p class="event-label">MUSI RUN 2027 · PALEMBANG</p>
            <h1>Konfirmasi Pendaftaran</h1>
            <h2>Halo {{ $participant->name }}, hasil pemeriksaan pendaftaran Anda sudah tersedia.</h2>
        </div>
        <div class="route-mark" aria-hidden="true"></div>

        <div class="email-body">
            <p class="intro">Panitia telah meninjau data pendaftaran MUSI RUN Anda. Berikut adalah status dan ringkasan data yang tercatat.</p>
            <div class="status-card">
                <strong>Status pendaftaran</strong>
                <span>Disetujui oleh panitia</span>
            </div>

            <table class="data-table">
                <tbody>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $participant->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $participant->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $participant->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $participant->kategori_jarak ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ukuran Jersey</th>
                        <td>{{ $participant->jersey_size ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $participant->dob?->format('d F Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $participant->gender ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Golongan Darah</th>
                        <td>{{ $participant->blood_type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $participant->phone ?: ($participant->whatsapp ?? '-') }}</td>
                    </tr>
                    <tr>
                        <th>No. HP Darurat</th>
                        <td>{{ $participant->emergency_phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Komunitas</th>
                        <td>{{ $participant->community ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Persetujuan</th>
                        <td>{{ $participant->approved_at?->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') ?? '-' }} WIB</td>
                    </tr>
                </tbody>
            </table>

            <div class="rpc-ticket">
                <h3>QR Code Pengambilan Race Pack (RPC)</h3>
                <p>Tunjukkan QR Code ini kepada panitia saat mengambil race pack. Setiap QR Code berlaku untuk satu peserta.</p>
                <img src="{{ $message->embedData($rpcQrCode, 'rpc-qr.png', 'image/png') }}" alt="QR Code pengambilan race pack">
                <p class="rpc-bib">{{ $participant->race_number }}</p>
            </div>
            <div class="rpc-note">Simpan email ini dan jangan bagikan QR Code Anda. Jika ada pertanyaan mengenai data pendaftaran, silakan hubungi panitia MUSI RUN.</div>
            <p style="margin: 22px 0 0; color: #405969; line-height: 1.6">Sampai bertemu di garis start,<br><strong>Panitia MUSI RUN 2027</strong></p>
        </div>

        <div class="footer">Pemberitahuan otomatis dari panitia MUSI RUN 2027. Email ini dikirim khusus terkait status pendaftaran Anda.</div>
    </div>
</body>
</html>
