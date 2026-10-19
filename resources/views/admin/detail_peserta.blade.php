<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta - {{ $registrant->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --navy:#101828; --blue:#1689e8; --orange:#ff9f0a; --red:#fa464d; --line:#e7ebf2; --muted:#667085; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--navy); background:#f5f7fb; font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .shell { display:flex; min-height:100vh; }
        .sidebar { position:sticky; top:0; width:240px; height:100vh; flex:0 0 240px; padding:26px 14px 20px; background:#fff; border-right:1px solid var(--line); display:flex; flex-direction:column; }
        .brand { display:flex; align-items:center; gap:10px; padding:0 16px 24px; border-bottom:1px solid var(--line); color:var(--navy); text-decoration:none; font-weight:800; letter-spacing:.04em; }
        .brand img { width:46px; height:46px; object-fit:contain; }
        .nav-list { padding-top:24px; } .nav-link { display:flex; align-items:center; gap:13px; margin:4px 0; padding:13px 16px; border-radius:9px; color:#344054; text-decoration:none; font-weight:600; } .nav-link:hover { color:var(--blue); background:#fff8ea; }
        .sidebar-footer { margin-top:auto; padding:20px 6px 0; } .logout { width:100%; border:1px solid var(--red); border-radius:8px; color:var(--red); background:#fff; padding:10px; font-weight:600; }
        .main { min-width:0; flex:1; padding:30px clamp(18px, 4vw, 48px) 48px; } .mobile-bar { display:none; } .breadcrumb { color:var(--blue); margin-bottom:20px; } h1 { margin:0; font-size:clamp(1.7rem, 3vw, 2.35rem); font-weight:800; } .subtitle { color:var(--muted); margin:4px 0 24px; }
        .layout { display:grid; grid-template-columns:minmax(0,1.15fr) minmax(300px,.85fr); gap:22px; } .panel { min-width:0; padding:24px; background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 8px 20px rgba(16,24,40,.04); } .panel h2 { margin:0 0 18px; font-size:1.05rem; color:var(--orange); }
        .data-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:0 24px; } .data-item { padding:13px 0; border-bottom:1px solid var(--line); } .data-label { display:block; color:var(--muted); font-size:.76rem; margin-bottom:3px; } .data-value { overflow-wrap:anywhere; font-weight:600; }
        .status { display:inline-flex; padding:5px 10px; border-radius:6px; font-size:.8rem; font-weight:700; } .status.pending { color:#8a5a00; background:#fff0c2; } .status.approved { color:#087443; background:#d9f7e8; } .status.rejected { color:#b42318; background:#ffe0e2; }
        .proof { width:100%; max-height:520px; object-fit:contain; border:1px solid var(--line); border-radius:10px; background:#f8fafc; } .empty-proof { padding:48px 20px; border:1px dashed #cfd6e1; border-radius:10px; color:var(--muted); text-align:center; }
        .actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:22px; } .actions form { display:inline-flex; }
        @media (max-width:850px) { .layout { grid-template-columns:1fr; } }
        @media (max-width:700px) { .shell { display:block; } .sidebar { position:fixed; z-index:20; inset:0 auto 0 0; width:250px; transform:translateX(-105%); transition:transform .2s ease; box-shadow:12px 0 30px rgba(16,24,40,.16); } .sidebar.open { transform:translateX(0); } .mobile-bar { display:flex; align-items:center; justify-content:space-between; margin:-8px 0 22px; } .mobile-menu { border:1px solid var(--line); border-radius:8px; background:#fff; padding:7px 10px; } .main { padding:20px 14px 32px; } .panel { padding:18px; } .data-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar" id="adminSidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Logo Musi Run"><span>MUSI RUN VII</span></a>
        <nav class="nav-list" aria-label="Navigasi admin">
            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a>
            <a class="nav-link" href="{{ route('admin.peserta') }}"><i class="bi bi-people-fill"></i>Daftar Peserta</a>
            <a class="nav-link" href="{{ route('admin.peserta_diterima') }}"><i class="bi bi-person-check-fill"></i>Peserta Diterima</a>
            <a class="nav-link" href="{{ route('admin.export') }}"><i class="bi bi-file-earmark-spreadsheet-fill"></i>Export Data</a>
        </nav>
        <div class="sidebar-footer">@auth<form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="logout" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button></form>@endauth</div>
    </aside>
    <main class="main">
        <div class="mobile-bar"><strong>MUSI RUN VII</strong><button class="mobile-menu" type="button" id="menuToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button></div>
        <div class="breadcrumb"><a href="{{ route('admin.peserta') }}" class="text-decoration-none">Daftar Peserta</a><span class="mx-2">/</span> Detail Peserta</div>
        <h1>Detail Pendaftar</h1>
        <p class="subtitle">Informasi lengkap peserta dan bukti pembayaran.</p>
        @if($errors->any())<div class="alert alert-danger" role="alert"><strong>Periksa kembali input.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('warning'))<div class="alert alert-warning alert-dismissible fade show" role="alert">{{ session('warning') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        <div class="layout">
            <section class="panel">
                <h2><i class="bi bi-person-vcard me-2"></i>{{ $registrant->name }}</h2>
                <div class="data-grid">
                    <div class="data-item"><span class="data-label">No. BIB</span><span class="data-value">{{ $registrant->race_number ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Status</span><span class="status {{ $registrant->status }}">{{ ucfirst($registrant->status) }}</span></div>
                    <div class="data-item"><span class="data-label">NIK</span><span class="data-value">{{ $registrant->nik ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Jenis Kelamin</span><span class="data-value">{{ $registrant->gender ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Email</span><span class="data-value">{{ $registrant->email ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">No. WhatsApp</span><span class="data-value">{{ $registrant->whatsapp ?: $registrant->phone ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Tanggal Lahir</span><span class="data-value">{{ optional($registrant->dob)->format('d/m/Y') ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Golongan Darah</span><span class="data-value">{{ $registrant->blood_type ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Ukuran Jersey</span><span class="data-value">{{ $registrant->jersey_size ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Kategori Peserta</span><span class="data-value">{{ ucfirst($registrant->kategori ?: '-') }}</span></div>
                    <div class="data-item"><span class="data-label">Kategori Jarak</span><span class="data-value">{{ $registrant->kategori_jarak ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Daftar Pada</span><span class="data-value">{{ optional($registrant->created_at)->format('d/m/Y H:i') ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Kontak Darurat</span><span class="data-value">{{ $registrant->emergency_name ?: '-' }} - {{ $registrant->emergency_phone ?: '-' }}</span></div>
                    <div class="data-item"><span class="data-label">Komunitas</span><span class="data-value">{{ $registrant->community ?: '-' }}</span></div>
                </div>
                <div class="data-item"><span class="data-label">Alamat</span><span class="data-value">{{ $registrant->alamat ?: '-' }}</span></div>
                <div class="actions">
                    <a href="{{ route('admin.peserta') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    @if($registrant->status !== 'approved')<form action="{{ route('admin.registrant.status', $registrant) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="btn btn-success" type="submit"><i class="bi bi-check-circle me-1"></i>Setujui</button></form>@endif
                    @if($registrant->status !== 'rejected')<form action="{{ route('admin.registrant.status', $registrant) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="btn btn-outline-danger" type="submit"><i class="bi bi-x-circle me-1"></i>Tolak</button></form>@endif
                </div>
            </section>
            <section class="panel"><h2><i class="bi bi-receipt me-2"></i>Bukti Pembayaran</h2>@if($registrant->payment_proof_path)<img class="proof" src="{{ Storage::url($registrant->payment_proof_path) }}" alt="Bukti pembayaran {{ $registrant->name }}"><a href="{{ Storage::url($registrant->payment_proof_path) }}" target="_blank" class="btn btn-outline-primary w-100 mt-3"><i class="bi bi-box-arrow-up-right me-1"></i>Buka Bukti Pembayaran</a>@else<div class="empty-proof"><i class="bi bi-image fs-2 d-block mb-2"></i>Bukti pembayaran belum diunggah.</div>@endif</section>
        </div>
    </main>
</div>
<script>document.getElementById('menuToggle')?.addEventListener('click', () => document.getElementById('adminSidebar').classList.toggle('open'));</script>
@include('admin.partials.confirm-action-modal')
</body>
</html>
