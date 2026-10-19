<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi Status Pendaftaran MUSI RUN</title>
    <style>
        body { margin: 0; padding: 24px 12px; background: #f3f1ee; color: #343a40; font-family: Arial, sans-serif; }
        .email-container { max-width: 620px; margin: 0 auto; overflow: hidden; border: 1px solid #e6ded8; border-radius: 12px; background: #fff; }
        .email-header { padding: 28px 24px; background: #44352f; color: #fff; }
        .event-label { margin: 0 0 18px; color: #edc99f; font-size: 12px; font-weight: 700; letter-spacing: 2px; }
        .email-header h1 { margin: 0; color: #fff; font-size: 24px; line-height: 1.35; }
        .email-header p:last-child { margin: 12px 0 0; color: #f0e5dc; line-height: 1.6; }
        .route-mark { height: 5px; background: linear-gradient(90deg, #bd775b 0 35%, #edc99f 35% 65%, #f3f1ee 65%); }
        .email-body { padding: 28px 24px; }
        .intro { margin: 0 0 20px; color: #59636a; font-size: 15px; line-height: 1.7; }
        .status-card { margin: 0 0 22px; padding: 15px 18px; border-left: 4px solid #a64c3c; border-radius: 6px; background: #fbefec; }
        .status-card strong { display: block; margin-bottom: 4px; color: #8e3f32; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .status-card span { color: #59342f; font-size: 16px; font-weight: 700; }
        .reason { margin: 0; padding: 16px 18px; border: 1px solid #eadbd4; border-radius: 8px; background: #fcf8f5; }
        .reason strong { display: block; margin-bottom: 8px; color: #594239; }
        .reason p { margin: 0; color: #514943; line-height: 1.7; overflow-wrap: anywhere; }
        .footer { padding: 18px 24px; border-top: 1px solid #eee7e1; background: #faf8f6; color: #766e68; font-size: 12px; line-height: 1.6; }
        @media only screen and (max-width: 480px) {
            body { padding: 12px 8px; }
            .email-header, .email-body { padding: 22px 18px; }
            .email-header h1 { font-size: 21px; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <p class="event-label">MUSI RUN 2027 · PALEMBANG</p>
            <h1>Pembaruan Pendaftaran</h1>
            <p>Halo {{ $participant->name }}, panitia telah meninjau pendaftaran Anda.</p>
        </div>
        <div class="route-mark" aria-hidden="true"></div>

        <div class="email-body">
            <p class="intro">Kami informasikan bahwa pendaftaran MUSI RUN Anda belum dapat kami setujui. Alasan dari panitia tercantum di bawah ini.</p>
            <div class="status-card">
                <strong>Status pendaftaran</strong>
                <span>Belum disetujui</span>
            </div>
            <div class="reason">
                <strong>Catatan dari panitia</strong>
                <p>{{ $participant->rejection_reason }}</p>
            </div>
            <p style="margin: 22px 0 0; color: #59636a; line-height: 1.7">Jika Anda merasa ada kekeliruan atau ingin menanyakan informasi lebih lanjut, silakan hubungi panitia MUSI RUN.</p>
            <p style="margin: 20px 0 0; color: #59636a; line-height: 1.6">Salam,<br><strong>Panitia MUSI RUN 2027</strong></p>
        </div>

        <div class="footer">Pemberitahuan otomatis dari panitia MUSI RUN 2027 terkait status pendaftaran Anda.</div>
    </div>
</body>
</html>
