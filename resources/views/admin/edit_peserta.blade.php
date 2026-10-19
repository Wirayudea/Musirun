<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta - {{ $registrant->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --navy:#101828; --blue:#1689e8; --red:#fa464d; --line:#e7ebf2; --muted:#667085; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--navy); background:#f5f7fb; font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .shell { display:flex; min-height:100vh; } .sidebar { position:sticky; top:0; width:240px; height:100vh; flex:0 0 240px; padding:26px 14px 20px; background:#fff; border-right:1px solid var(--line); display:flex; flex-direction:column; }
        .brand { display:flex; align-items:center; gap:10px; padding:0 16px 24px; border-bottom:1px solid var(--line); color:var(--navy); text-decoration:none; font-weight:800; letter-spacing:.04em; } .brand img { width:46px; height:46px; object-fit:contain; }
        .nav-list { padding-top:24px; } .nav-link { display:flex; align-items:center; gap:13px; margin:4px 0; padding:13px 16px; border-radius:9px; color:#344054; text-decoration:none; font-weight:600; } .nav-link:hover { color:var(--blue); background:#fff8ea; }
        .sidebar-footer { margin-top:auto; padding:20px 6px 0; } .logout { width:100%; border:1px solid var(--red); border-radius:8px; color:var(--red); background:#fff; padding:10px; font-weight:600; }
        .main { min-width:0; flex:1; padding:30px clamp(18px, 4vw, 48px) 48px; } .mobile-bar { display:none; } .breadcrumb { color:var(--blue); margin-bottom:20px; } h1 { margin:0; font-size:clamp(1.7rem, 3vw, 2.35rem); font-weight:800; } .subtitle { color:var(--muted); margin:4px 0 24px; }
        .panel { max-width:1050px; padding:24px; background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 8px 20px rgba(16,24,40,.04); } .section-title { margin:22px 0 14px; padding-bottom:8px; border-bottom:1px solid var(--line); color:var(--blue); font-size:1rem; } .section-title:first-child { margin-top:0; }
        .form-label { color:#344054; font-weight:600; } .form-control, .form-select { border-color:#d8dee8; } .form-control:focus, .form-select:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(22,137,232,.12); }
        @media (max-width:700px) { .shell { display:block; } .sidebar { position:fixed; z-index:20; inset:0 auto 0 0; width:250px; transform:translateX(-105%); transition:transform .2s ease; box-shadow:12px 0 30px rgba(16,24,40,.16); } .sidebar.open { transform:translateX(0); } .mobile-bar { display:flex; align-items:center; justify-content:space-between; margin:-8px 0 22px; } .mobile-menu { border:1px solid var(--line); border-radius:8px; background:#fff; padding:7px 10px; } .main { padding:20px 14px 32px; } .panel { padding:18px; } }
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar" id="adminSidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Logo Musi Run"><span>MUSI RUN VII</span></a>
        <nav class="nav-list" aria-label="Navigasi admin">
            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a>
            <a class="nav-link active" href="{{ route('admin.peserta') }}"><i class="bi bi-people-fill"></i>Daftar Peserta</a>
            <a class="nav-link" href="{{ route('admin.peserta_diterima') }}"><i class="bi bi-person-check-fill"></i>Peserta Diterima</a>
            <a class="nav-link" href="{{ route('admin.export') }}"><i class="bi bi-file-earmark-spreadsheet-fill"></i>Export Data</a>
        </nav>
        <div class="sidebar-footer">@auth<form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="logout" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button></form>@endauth</div>
    </aside>
    <main class="main">
        <div class="mobile-bar"><strong>MUSI RUN VII</strong><button class="mobile-menu" type="button" id="menuToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button></div>
        <div class="breadcrumb"><a href="{{ route('admin.peserta') }}" class="text-decoration-none">Daftar Peserta</a><span class="mx-2">/</span> Edit Peserta</div>
        <h1>Edit Peserta</h1>
        <p class="subtitle">Perbarui field yang diizinkan untuk {{ $registrant->name }}.</p>
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form class="panel" method="POST" action="{{ route('admin.registrant.update', $registrant) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="alert alert-info"><i class="bi bi-info-circle me-1"></i>Admin hanya dapat mengubah nama, email, nomor HP, nomor HP darurat, jarak lari, ukuran jersey, tanggal lahir, dan jenis kelamin.</div>
            <h2 class="section-title">Data yang Dapat Diubah</h2>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama Lengkap *</label><input class="form-control" name="name" value="{{ old('name', $registrant->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Email *</label><input type="email" class="form-control" name="email" value="{{ old('email', $registrant->email) }}" required></div>
                <div class="col-md-6"><label class="form-label">Tanggal Lahir *</label><input type="date" class="form-control" name="dob" value="{{ old('dob', optional($registrant->dob)->format('Y-m-d')) }}" required></div>
                <div class="col-md-6"><label class="form-label">Jenis Kelamin *</label><select class="form-select" name="gender" required><option value="Laki-laki" @selected(old('gender', $registrant->gender) === 'Laki-laki')>Laki-laki</option><option value="Perempuan" @selected(old('gender', $registrant->gender) === 'Perempuan')>Perempuan</option></select></div>
                <div class="col-md-6"><label class="form-label">No. WhatsApp *</label><input class="form-control" name="whatsapp" value="{{ old('whatsapp', $registrant->whatsapp ?: $registrant->phone) }}" required></div>
                <div class="col-md-6"><label class="form-label">Ukuran Jersey *</label><select class="form-select" name="jersey_size" required><option value="">Pilih Ukuran</option>@foreach(['XS','S','M','L','XL','XXL','3XL','4XL'] as $size)<option value="{{ $size }}" @selected(old('jersey_size', $registrant->jersey_size) === $size)>{{ $size }}</option>@endforeach</select></div>
            </div>
            <h2 class="section-title">Jarak dan Kontak Darurat</h2>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Kategori Jarak *</label><input class="form-control" name="kategori_jarak" value="{{ old('kategori_jarak', $registrant->kategori_jarak) }}" required></div>
                <div class="col-md-6"><label class="form-label">Nomor Kontak Darurat *</label><input class="form-control" name="emergency_phone" value="{{ old('emergency_phone', $registrant->emergency_phone) }}" required></div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-4"><a href="{{ route('admin.registrant.show', $registrant) }}" class="btn btn-outline-secondary">Batal</a><button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan Perubahan</button></div>
        </form>
    </main>
</div>
<script>document.getElementById('menuToggle')?.addEventListener('click', () => document.getElementById('adminSidebar').classList.toggle('open'));</script>
@include('admin.partials.confirm-action-modal')
</body>
</html>
