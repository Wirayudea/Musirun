<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MUSI RUN VII</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --navy:#101828; --navy-soft:#18263a; --blue:#1689e8; --cyan:#14c4e8; --orange:#ff9f0a; --green:#20b879; --red:#fa464d; --line:#e7ebf2; --muted:#667085; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--navy); background:#f5f7fb; font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .admin-shell { display:flex; min-height:100vh; }
        .sidebar { position:sticky; top:0; width:240px; height:100vh; flex:0 0 240px; padding:26px 14px 20px; background:#fff; border-right:1px solid var(--line); display:flex; flex-direction:column; }
        .brand { display:flex; align-items:center; gap:10px; padding:0 16px 24px; border-bottom:1px solid var(--line); color:var(--navy); text-decoration:none; font-weight:800; letter-spacing:.04em; }
        .brand img { width:46px; height:46px; object-fit:contain; }
        .nav-list { padding-top:24px; }
        .nav-link { display:flex; align-items:center; gap:13px; margin:4px 0; padding:13px 16px; border-radius:9px; color:#344054; text-decoration:none; font-weight:600; }
        .nav-link:hover, .nav-link.active { color:var(--blue); background:#fff8ea; }
        .nav-link.active { border-left:3px solid var(--blue); padding-left:13px; }
        .sidebar-footer { margin-top:auto; padding:20px 6px 0; }
        .logout-btn { width:100%; border:1px solid var(--red); border-radius:8px; color:var(--red); background:#fff; padding:10px; font-weight:600; }
        .logout-btn:hover { color:#fff; background:var(--red); }
        .main-content { min-width:0; flex:1; padding:30px clamp(18px, 4vw, 48px) 48px; }
        .mobile-bar { display:none; }
        .breadcrumb { color:var(--blue); margin-bottom:20px; }
        .page-title { margin:0; font-size:clamp(1.8rem, 3vw, 2.55rem); font-weight:800; letter-spacing:-.03em; }
        .page-subtitle { color:var(--muted); margin:4px 0 24px; }
        .stat-grid { display:grid; grid-template-columns:repeat(4, minmax(0,1fr)); gap:22px; margin-bottom:22px; }
        .stat-card { min-height:112px; padding:20px 18px; border-radius:16px; color:#fff; box-shadow:0 10px 22px rgba(16,24,40,.08); }
        .stat-card.orange { background:var(--orange); } .stat-card.green { background:var(--green); } .stat-card.red { background:var(--red); } .stat-card.cyan { background:var(--cyan); }
        .stat-label { font-size:.9rem; } .stat-value { margin-top:4px; font-size:2rem; line-height:1; font-weight:800; }
        .insights-grid { display:grid; grid-template-columns:1fr 1fr 1.1fr; gap:22px; margin-bottom:22px; }
        .panel { min-width:0; padding:24px; background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 8px 20px rgba(16,24,40,.04); }
        .panel-title { margin:0 0 22px; color:var(--orange); font-size:1.1rem; font-weight:500; }
        .donut-wrap { display:flex; align-items:center; justify-content:center; min-height:165px; }
        .donut { width:122px; height:122px; border-radius:50%; position:relative; background:conic-gradient(var(--orange) 0 70%, #ffbe1b 70% 100%); }
        .donut::after { content:""; position:absolute; inset:29px; border-radius:50%; background:#fff; }
        .legend { margin:18px 0 0; padding:0; list-style:none; }
        .legend li { display:flex; align-items:center; gap:10px; margin:10px 0; font-size:.9rem; }
        .legend-dot { width:11px; height:11px; flex:0 0 11px; border-radius:3px; background:var(--orange); }
        .legend-count { margin-left:auto; padding:2px 8px; border-radius:6px; color:#fff; background:#707a83; font-size:.75rem; font-weight:700; }
        .bar-list { max-height:295px; overflow:auto; padding-right:6px; }
        .bar-row { margin-bottom:16px; }
        .bar-meta { display:flex; justify-content:space-between; gap:10px; margin-bottom:7px; font-size:.9rem; font-weight:700; }
        .bar-track { height:7px; overflow:hidden; border-radius:9px; background:#f0f2f5; }
        .bar-fill { height:100%; min-width:3px; border-radius:inherit; background:var(--cyan); }
        .table-panel { padding:24px; }
        .table-panel .panel-title { color:var(--navy); font-weight:700; margin-bottom:14px; }
        .table-responsive { overflow-x:auto; }
        .table { min-width:900px; vertical-align:middle; }
        .table thead th { color:var(--muted); white-space:nowrap; font-size:.78rem; text-transform:uppercase; letter-spacing:.04em; }
        .table tbody td { color:#344054; white-space:nowrap; }
        .badge.bg-pending { color:#8a5a00; background:#fff0c2 !important; } .badge.bg-approved { background:#d9f7e8 !important; color:#087443; } .badge.bg-rejected { background:#ffe0e2 !important; color:#b42318; }
        .action-btn { border:1px solid var(--line); background:#fff; color:#344054; }
        @media (max-width: 1100px) { .sidebar { width:210px; flex-basis:210px; } .stat-grid { grid-template-columns:repeat(2,1fr); } .insights-grid { grid-template-columns:1fr 1fr; } .insights-grid .jersey-panel { grid-column:1 / -1; } }
        @media (max-width: 700px) { .admin-shell { display:block; } .sidebar { position:fixed; z-index:20; inset:0 auto 0 0; width:250px; transform:translateX(-105%); transition:transform .2s ease; box-shadow:12px 0 30px rgba(16,24,40,.16); } .sidebar.open { transform:translateX(0); } .mobile-bar { display:flex; align-items:center; justify-content:space-between; margin:-8px 0 22px; } .mobile-menu { border:1px solid var(--line); border-radius:8px; background:#fff; padding:7px 10px; } .main-content { padding:20px 14px 32px; } .stat-grid, .insights-grid { grid-template-columns:1fr; gap:14px; } .insights-grid .jersey-panel { grid-column:auto; } .panel, .table-panel { padding:18px; } .page-title { font-size:1.8rem; } }
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar" id="adminSidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Musi Run">
            <span>MUSI RUN VII</span>
        </a>
        <nav class="nav-list" aria-label="Navigasi admin">
            <a class="nav-link active" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a>
            <a class="nav-link" href="{{ route('admin.peserta') }}"><i class="bi bi-people-fill"></i>Daftar Peserta</a>
            <a class="nav-link" href="{{ route('admin.peserta_diterima') }}"><i class="bi bi-person-check-fill"></i>Peserta Diterima</a>
            <a class="nav-link" href="{{ route('admin.export') }}"><i class="bi bi-file-earmark-spreadsheet-fill"></i>Export Data</a>
        </nav>
        <div class="sidebar-footer">
            @auth
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
            @endauth
        </div>
    </aside>

    <main class="main-content">
        <div class="mobile-bar"><strong>MUSI RUN VII</strong><button class="mobile-menu" type="button" id="menuToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button></div>
        <div class="breadcrumb"><i class="bi bi-house-door me-1"></i> Home <span class="mx-2">/</span> Dashboard</div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Pantau data pendaftar dan status verifikasi MUSI RUN VII.</p>
        @if($errors->any())
            <div class="alert alert-danger" role="alert"><strong>Periksa kembali input.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">{{ session('warning') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <section class="stat-grid" id="status" aria-label="Ringkasan pendaftar">
            <div class="stat-card orange"><div class="stat-label">Total Pendaftar</div><div class="stat-value">{{ $stats['total'] }}</div></div>
            <div class="stat-card green"><div class="stat-label">Sudah Disetujui</div><div class="stat-value">{{ $stats['approved'] }}</div></div>
            <div class="stat-card red"><div class="stat-label">Belum Diproses</div><div class="stat-value">{{ $stats['pending'] }}</div></div>
            <div class="stat-card cyan"><div class="stat-label">Ditolak</div><div class="stat-value">{{ $stats['rejected'] }}</div></div>
        </section>

        <section class="insights-grid">
            <div class="panel"><h2 class="panel-title">Kategori Jarak</h2><div class="donut-wrap"><div class="donut" id="categoryDonut"></div></div><ul class="legend" id="categoryLegend"></ul></div>
            <div class="panel"><h2 class="panel-title">Jenis Kelamin</h2><div class="donut-wrap"><div class="donut" id="genderDonut"></div></div><ul class="legend" id="genderLegend"></ul></div>
            <div class="panel jersey-panel"><h2 class="panel-title">Ukuran Jersey</h2><div class="bar-list">@php($maxJersey = max(1, $jerseyStats->max('count') ?? 1)) @forelse($jerseyStats as $item)<div class="bar-row"><div class="bar-meta"><span>{{ $item['label'] }}</span><span>{{ $item['count'] }}</span></div><div class="bar-track"><div class="bar-fill" style="width:{{ ($item['count'] / $maxJersey) * 100 }}%"></div></div></div>@empty<p class="text-muted">Belum ada data jersey.</p>@endforelse</div></div>
        </section>

        <section class="panel table-panel" id="peserta" style="display:none">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap"><h2 class="panel-title mb-0">Daftar Peserta</h2><a href="{{ route('admin.export') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i>Export Excel</a></div>
            <div class="table-responsive mt-3"><table class="table table-hover" id="registrantsTable"><thead><tr><th>No.</th><th>No. Peserta</th><th>Nama</th><th>Email</th><th>NIK</th><th>No. HP</th><th>Kategori</th><th>Jersey</th><th>Tgl Daftar</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@foreach($registrants as $index => $registrant)<tr><td>{{ $index + 1 }}</td><td><strong>{{ $registrant->race_number }}</strong></td><td>{{ $registrant->name }}</td><td>{{ $registrant->email }}</td><td>{{ $registrant->nik }}</td><td>{{ $registrant->whatsapp ?: $registrant->phone }}</td><td>{{ $registrant->kategori_jarak }}</td><td>{{ $registrant->jersey_size }}</td><td>{{ $registrant->created_at->format('d/m/Y H:i') }}</td><td><span class="badge bg-{{ $registrant->status }}">{{ ucfirst($registrant->status) }}</span></td><td><div class="dropdown"><button class="btn btn-sm action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button><ul class="dropdown-menu"><li><form action="{{ route('admin.registrant.status', $registrant) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button type="submit" class="dropdown-item text-success">Setujui</button></form></li><li><form action="{{ route('admin.registrant.status', $registrant) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button type="submit" class="dropdown-item text-danger">Tolak</button></form></li><li><hr class="dropdown-divider"></li><li>@if($registrant->payment_proof_path)<a href="{{ Storage::disk('public')->url($registrant->payment_proof_path) }}" class="dropdown-item" target="_blank">Lihat Bukti Bayar</a>@else<span class="dropdown-item text-muted">Bukti belum ada</span>@endif</li></ul></div></td></tr>@endforeach</tbody></table></div>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    const categoryData = @json($categoryStats);
    const genderData = @json($genderStats);
    const colors = ['#ff9f0a', '#ffbe1b', '#1689e8', '#ed2468', '#14c4e8'];
    function renderDonut(data, donutId, legendId) {
        const total = data.reduce((sum, item) => sum + item.count, 0) || 1;
        let offset = 0;
        document.getElementById(donutId).style.background = `conic-gradient(${data.map((item, index) => { const start = offset; offset += (item.count / total) * 100; return `${colors[index % colors.length]} ${start}% ${offset}%`; }).join(', ')})`;
        document.getElementById(legendId).innerHTML = data.map((item, index) => `<li><span class="legend-dot" style="background:${colors[index % colors.length]}"></span><span>${item.label}</span><span class="legend-count">${item.count}</span></li>`).join('');
    }
    renderDonut(categoryData, 'categoryDonut', 'categoryLegend');
    renderDonut(genderData, 'genderDonut', 'genderLegend');
    $('#registrantsTable').DataTable({ language:{ url:'//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' }, order:[[8, 'desc']], pageLength:25 });
    document.getElementById('menuToggle')?.addEventListener('click', () => document.getElementById('adminSidebar').classList.toggle('open'));
</script>
@include('admin.partials.confirm-action-modal')
</body>
</html>
