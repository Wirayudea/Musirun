<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta - MUSI RUN VII</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --navy:#101828; --blue:#1689e8; --red:#fa464d; --line:#e7ebf2; --muted:#667085; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--navy); background:#f5f7fb; font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .shell { display:flex; min-height:100vh; }
        .sidebar { position:sticky; top:0; width:240px; height:100vh; flex:0 0 240px; padding:26px 14px 20px; background:#fff; border-right:1px solid var(--line); display:flex; flex-direction:column; }
        .brand { display:flex; align-items:center; gap:10px; padding:0 16px 24px; border-bottom:1px solid var(--line); color:var(--navy); text-decoration:none; font-weight:800; letter-spacing:.04em; }
        .brand img { width:46px; height:46px; object-fit:contain; }
        .nav-list { padding-top:24px; }
        .nav-link { display:flex; align-items:center; gap:13px; margin:4px 0; padding:13px 16px; border-radius:9px; color:#344054; text-decoration:none; font-weight:600; }
        .nav-link:hover, .nav-link.active { color:var(--blue); background:#fff8ea; }
        .nav-link.active { border-left:3px solid var(--blue); padding-left:13px; }
        .sidebar-footer { margin-top:auto; padding:20px 6px 0; }
        .logout { width:100%; border:1px solid var(--red); border-radius:8px; color:var(--red); background:#fff; padding:10px; font-weight:600; }
        .main { min-width:0; flex:1; padding:30px clamp(18px, 4vw, 48px) 48px; }
        .mobile-bar { display:none; }
        .breadcrumb { color:var(--blue); margin-bottom:20px; }
        h1 { margin:0; font-size:clamp(1.8rem, 3vw, 2.5rem); font-weight:800; letter-spacing:-.03em; }
        .subtitle { color:var(--muted); margin:4px 0 24px; }
        .panel { padding:24px; background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 8px 20px rgba(16,24,40,.04); }
        .table { min-width:1450px; vertical-align:middle; }
        .table thead th { color:var(--muted); white-space:nowrap; font-size:.76rem; text-transform:uppercase; letter-spacing:.035em; }
        .participants-table-scroll { max-height:70vh; overflow:auto; -webkit-overflow-scrolling:touch; }
        .participants-table-scroll thead th { position:sticky; top:0; z-index:2; background:#fff; }
        .table tbody td { color:#344054; white-space:nowrap; }
        .detail-cell { white-space:normal !important; min-width:160px; }
        .detail-cell summary { color:var(--blue); cursor:pointer; font-weight:700; }
        .detail-cell div { padding-top:8px; color:var(--muted); font-size:.8rem; line-height:1.55; }
        .gender-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 9px; border-radius:999px; font-size:.78rem; font-weight:700; }
        .gender-badge--male { color:#175cd3; background:#eff8ff; }
        .gender-badge--female { color:#c11574; background:#fdf2fa; }
        .gender-badge--unknown { color:#475467; background:#f2f4f7; }
        .badge.bg-pending { color:#8a5a00; background:#fff0c2 !important; }
        .badge.bg-approved { color:#087443; background:#d9f7e8 !important; }
        .badge.bg-rejected { color:#b42318; background:#ffe0e2 !important; }
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
        <div class="breadcrumb"><i class="bi bi-house-door me-1"></i> Home <span class="mx-2">/</span> Daftar Peserta</div>
        <h1>Daftar Peserta</h1>
        <p class="subtitle">Kelola data peserta, verifikasi status, dan lihat bukti pembayaran.</p>
        @if($errors->any())<div class="alert alert-danger" role="alert"><strong>Periksa kembali input.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('warning'))<div class="alert alert-warning alert-dismissible fade show" role="alert">{{ session('warning') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        <section class="panel">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3"><strong>Data Pendaftar MUSI RUN VII</strong><a href="{{ route('admin.export') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i>Export Excel</a></div>
            <div class="table-responsive participants-table-scroll" tabindex="0" role="region" aria-label="Tabel data pendaftar, dapat digulir ke samping dan ke bawah"><table class="table table-hover" id="participantsTable"><thead><tr><th>No.</th><th>No. BIB</th><th>Nama Lengkap</th><th>Detail</th><th>JK</th><th>NIK</th><th>Email</th><th>HP</th><th>UK Jersey</th><th>Kategori Jarak</th><th>Kategori Peserta</th><th>Status</th><th>Daftar Pada</th><th>Aksi</th></tr></thead><tbody>@foreach($registrants as $index => $registrant)<tr><td>{{ $index + 1 }}</td><td><strong>{{ $registrant->race_number ?: '-' }}</strong></td><td>{{ $registrant->name }}</td><td class="detail-cell"><a href="{{ route('admin.registrant.show', $registrant) }}"><i class="bi bi-box-arrow-up-right me-1"></i>Lihat detail</a></td><td>@if($registrant->gender === 'Laki-laki')<span class="gender-badge gender-badge--male"><i class="bi bi-gender-male" aria-hidden="true"></i>{{ $registrant->gender }}</span>@elseif($registrant->gender === 'Perempuan')<span class="gender-badge gender-badge--female"><i class="bi bi-gender-female" aria-hidden="true"></i>{{ $registrant->gender }}</span>@else<span class="gender-badge gender-badge--unknown">{{ $registrant->gender ?: '-' }}</span>@endif</td><td>{{ $registrant->nik }}</td><td>{{ $registrant->email }}</td><td>{{ $registrant->whatsapp ?: $registrant->phone }}</td><td>{{ $registrant->jersey_size }}</td><td>{{ $registrant->kategori_jarak }}</td><td>{{ ucfirst($registrant->kategori ?: '-') }}</td><td><span class="badge bg-{{ $registrant->status }}">{{ ucfirst($registrant->status) }}</span></td><td>{{ $registrant->created_at->format('d/m/Y H:i') }}</td><td><div class="dropdown"><button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button><ul class="dropdown-menu"><li><a href="{{ route('admin.registrant.edit', $registrant) }}" class="dropdown-item"><i class="bi bi-pencil-square me-2"></i>Edit Data</a></li><li><hr class="dropdown-divider"></li><li><form action="{{ route('admin.registrant.status', $registrant) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button type="submit" class="dropdown-item text-success">Setujui</button></form></li><li><form action="{{ route('admin.registrant.status', $registrant) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button type="submit" class="dropdown-item text-danger">Tolak</button></form></li><li><hr class="dropdown-divider"></li><li>@if($registrant->payment_proof_path)<a href="{{ Storage::url($registrant->payment_proof_path) }}" class="dropdown-item" target="_blank">Lihat Bukti Bayar</a>@else<span class="dropdown-item text-muted">Bukti belum ada</span>@endif</li></ul></div></td></tr>@endforeach</tbody></table></div>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>$('#participantsTable').DataTable({ language:{ url:'//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' }, order:[[12, 'desc']], pageLength:25 }); document.getElementById('menuToggle')?.addEventListener('click', () => document.getElementById('adminSidebar').classList.toggle('open'));</script>
@include('admin.partials.confirm-action-modal')
</body>
</html>
