<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi | MUSI RUN VII</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/main.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      background: #ffffff;
      color:#2d3748;
      font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      padding: 24px 16px;
      min-height: 100vh;
    }
    .form-container {
      max-width: 800px;
      margin: auto;
      background: #ffffff;
      padding: 32px;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.15);
      border: 1px solid #e2e8f0;
    }
    h2 {
      color: #1a202c;
      font-weight: 700;
      font-size: 28px;
      margin-bottom: 8px;
    }
    .form-label {
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 8px;
      font-size: 14px;
      letter-spacing: 0.3px;
    }
    .form-control, .form-select {
      border: 1.5px solid #e2e8f0;
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 14px;
      transition: all 0.3s ease;
      background-color: #f8fafc;
    }
    .form-control:focus, .form-select:focus {
      border-color: #4a5568;
      background-color: #ffffff;
      box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
      outline: none;
    }
    .form-check-input {
      border-color: #cbd5e0;
      cursor: pointer;
      width: 18px;
      height: 18px;
    }
    .form-check-input:checked {
      background-color: #4a5568;
      border-color: #4a5568;
    }
    .form-check-input:focus {
      box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
    }
    .gender-options {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
    }
    .gender-option {
      position: relative;
      display: block;
      margin: 0;
      cursor: pointer;
    }
    .gender-option input {
      position: absolute;
      width: 1px;
      height: 1px;
      opacity: 0;
      pointer-events: none;
    }
    .gender-option__content {
      display: flex;
      align-items: center;
      gap: 12px;
      min-height: 58px;
      padding: 12px 14px;
      border: 1px solid rgba(168,184,200,.35);
      border-radius: 2px;
      color: #dce8f2;
      background: rgba(4,12,22,.62);
      transition: border-color .25s ease, background .25s ease, transform .25s ease, box-shadow .25s ease;
    }
    .gender-option:hover .gender-option__content {
      border-color: var(--blue);
      transform: translateY(-2px);
    }
    .gender-option input:focus-visible + .gender-option__content {
      outline: 2px solid var(--blue);
      outline-offset: 3px;
    }
    .gender-option input:checked + .gender-option__content {
      border-color: var(--gold);
      color: #fff;
      background: linear-gradient(135deg, rgba(245,190,0,.16), rgba(0,178,255,.1));
      box-shadow: 0 8px 20px rgba(0,0,0,.18), inset 3px 0 0 var(--gold);
    }
    .gender-option__icon {
      display: grid;
      width: 34px;
      height: 34px;
      flex: 0 0 34px;
      place-items: center;
      border: 1px solid rgba(168,184,200,.4);
      border-radius: 50%;
      color: var(--muted);
      font-size: 1rem;
    }
    .gender-option input:checked + .gender-option__content .gender-option__icon {
      border-color: var(--blue);
      color: var(--blue);
      background: rgba(0,178,255,.12);
    }
    .gender-option__name {
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: .02em;
    }
    .gender-option__check {
      width: 17px;
      height: 17px;
      margin-left: auto;
      border: 1px solid rgba(168,184,200,.5);
      border-radius: 50%;
    }
    .gender-option input:checked + .gender-option__content .gender-option__check {
      border: 5px solid var(--blue);
      box-shadow: 0 0 0 2px rgba(0,178,255,.18);
    }
    .form-check-label {
      cursor: pointer;
      font-weight: 500;
      margin-left: 6px;
    }
    .text-danger { color: #f56565; font-weight: 600; }
    .text-muted { color: #718096; font-size: 13px; }
    .jarak-card {
      display: block;
      border: 2px solid #e2e8f0;
      padding: 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      background: #f8fafc;
    }
    .jarak-card:hover {
      border-color: #4a5568;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.1);
    }
    .jarak-card.disabled-card {
      opacity: 0.4;
      cursor: not-allowed;
      background: #f0f4f8;
    }
    .jarak-card.active {
      border-color: #4a5568;
      background: linear-gradient(135deg, rgba(74, 85, 104, 0.05), rgba(45, 55, 72, 0.05));
      box-shadow: 0 6px 20px rgba(74, 85, 104, 0.15);
    }
    .jarak-content { margin-top: 4px; }
    .jarak-content strong { color: #1a202c; font-size: 15px; }
    .progress {
      height: 8px;
      border-radius: 10px;
      background-color: #edf2f7;
    }
    .progress-bar {
      background: #4a5568;
      border-radius: 10px;
    }
    small {
      color: #718096;
      font-weight: 500;
      display: block;
      margin-bottom: 12px;
    }
    #currentStep {
      font-weight: 700;
      color: #4a5568;
    }
    .btn-primary {
      background: #4a5568;
      border: none;
      border-radius: 8px;
      padding: 10px 24px;
      font-weight: 600;
      transition: all 0.3s ease;
      color: #ffffff;
    }
    .btn-primary:hover {
      background: #2d3748;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(74, 85, 104, 0.3);
    }
    .btn-success {
      background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
      border: none;
      border-radius: 8px;
      padding: 10px 24px;
      font-weight: 600;
    }
    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
    }
    .btn-outline-secondary {
      border-color: #cbd5e0;
      color: #2d3748;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
      background-color: #edf2f7;
      border-color: #a0aec0;
    }
    .border {
      border: 1.5px solid #e2e8f0 !important;
      border-radius: 10px;
      background-color: #f8fafc;
    }
    textarea {
      resize: vertical;
      font-family: inherit;
    }
    .row.g-3 { margin-bottom: 20px; }
    @media (max-width: 768px) {
      .form-container {
        padding: 20px;
        margin: auto;
      }
      h2 {
        font-size: 24px;
        margin-bottom: 6px;
      }
      .form-control, .form-select {
        font-size: 16px;
        padding: 12px;
      }
      .btn {
        font-size: 14px;
        padding: 8px 16px;
      }
    }

    :root { --gold: #f5be00; --blue: #00b2ff; --ink: #07101c; --muted: #a8b8c8; }
    body { min-height: 100vh; padding: 32px 16px 72px; color: #f5f8fb; background: #07101c; font-family: 'Rajdhani', sans-serif; }
    body::before { content: ''; position: fixed; inset: 0; pointer-events: none; background: radial-gradient(circle at 8% 8%, rgba(0,178,255,.16), transparent 28%), radial-gradient(circle at 92% 90%, rgba(245,190,0,.12), transparent 30%); }
    .registration-page { position: relative; max-width: 1080px; margin: 0 auto; }
    .registration-topbar { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 26px; }
    .registration-brand { display: inline-flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; font-family: 'Orbitron', sans-serif; font-size: clamp(1rem, 2vw, 1.35rem); font-weight: 700; letter-spacing: .06em; }
    .registration-brand img { width: 46px; height: 46px; object-fit: contain; }
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      min-height: 42px;
      padding: 9px 16px;
      color: var(--gold);
      border: 1px solid rgba(245,190,0,.65);
      border-radius: 2px;
      font-weight: 700;
      text-decoration: none;
      letter-spacing: .04em;
      transition: color .25s ease, background .25s ease, border-color .25s ease, transform .25s ease;
    }
    .back-link:hover {
      color: var(--ink);
      border-color: var(--gold);
      background: var(--gold);
      transform: translateY(-2px);
    }
    .back-link:focus-visible {
      outline: 2px solid var(--blue);
      outline-offset: 3px;
    }
    .form-container { position: relative; overflow: hidden; max-width: 100%; padding: clamp(22px, 4vw, 52px); background: rgba(10, 20, 32, .88); border: 1px solid rgba(0,178,255,.35); border-radius: 4px; box-shadow: 0 24px 80px rgba(0,0,0,.42), 0 0 32px rgba(0,178,255,.08); }
    .form-container::after { content: ''; position: absolute; top: 0; right: 0; width: 140px; height: 4px; background: linear-gradient(90deg, transparent, var(--gold)); }
    .form-container h2 { color: #fff; font-family: 'Orbitron', sans-serif; font-size: clamp(1.35rem, 3vw, 2rem); letter-spacing: .04em; }
    .form-container h5, .form-container h6 { color: var(--gold); font-family: 'Orbitron', sans-serif; letter-spacing: .04em; }
    .form-label { color: #dce8f2; }
    .gender-option__content { font-family: 'Rajdhani', sans-serif; }
    .form-control, .form-select { color: #f5f8fb; border: 1px solid rgba(168,184,200,.35); border-radius: 2px; background: rgba(4,12,22,.72); }
    .form-control::placeholder { color: #718397; }
    .form-control:focus, .form-select:focus { color: #fff; border-color: var(--blue); background: rgba(4,12,22,.95); box-shadow: 0 0 0 3px rgba(0,178,255,.14); }
    .form-select option { color: #fff; background-color: #07101c; }
    .form-check-input:checked { background-color: var(--blue); border-color: var(--blue); }
    .form-check-label { color: #dce8f2; }
    .text-danger { color: #ff8b67 !important; }
    .field-validation-error { display: block; margin-top: 5px; color: #ff8b67 !important; font-size: .9rem; font-weight: 600; }
    .text-muted, small { color: var(--muted) !important; }
    #currentStep { color: var(--gold); }
    .progress { height: 7px; border-radius: 0; background: rgba(168,184,200,.18); }
    .progress-bar { background: linear-gradient(90deg, var(--gold), var(--blue)); }
    .jarak-card { border: 1px solid rgba(168,184,200,.35); border-radius: 2px; background: rgba(4,12,22,.62); transition: border-color .25s ease, transform .25s ease, background .25s ease; }
    .jarak-card:hover, .jarak-card.active { border-color: var(--gold); background: rgba(245,190,0,.08); transform: translateY(-2px); }
    .jarak-card input { margin: 0 10px 0 0; accent-color: var(--gold); vertical-align: top; }
    .jarak-card.disabled-card { opacity: .72; background: rgba(4,12,22,.48); transform: none; cursor: not-allowed; }
    .jarak-card.disabled-card:hover { border-color: rgba(168,184,200,.35); background: rgba(4,12,22,.48); }
    .jarak-content { display: inline-flex; min-width: calc(100% - 30px); flex-direction: column; gap: 5px; vertical-align: top; }
    .jarak-content strong { color: #fff; font-family: 'Orbitron', sans-serif; font-size: .83rem; line-height: 1.45; }
    .jarak-price { color: var(--muted); font-size: .95rem; }
    .jarak-status { color: #ffb4a0; font-size: .78rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
    .jarak-card.active .jarak-price { color: #fff; }
    .btn { border-radius: 2px; font-family: 'Rajdhani', sans-serif; font-weight: 700; letter-spacing: .04em; }
    .btn-primary, .btn-success { color: var(--ink); border: 0; background: linear-gradient(90deg, var(--gold), #ffd95a); }
    .btn-primary:hover, .btn-success:hover { color: var(--ink); background: linear-gradient(90deg, var(--blue), #7cdbff); box-shadow: 0 8px 22px rgba(0,178,255,.2); }
    .btn-outline-secondary { color: #dce8f2; border-color: rgba(168,184,200,.5); }
    .btn-outline-secondary:hover { color: var(--ink); background: #dce8f2; }
    .border { border: 1px solid rgba(168,184,200,.28) !important; border-radius: 2px; background: rgba(4,12,22,.56); }
    .payment-guide { padding: 18px 20px; border: 1px solid rgba(168,184,200,.28); border-radius: 4px; background: rgba(4,12,22,.72); color: #dce8f2; }
    .payment-guide h5 { margin-bottom: 12px; color: var(--gold); }
    .payment-guide ol { margin: 0; padding-left: 1.4rem; }
    .payment-guide li { margin: 6px 0; padding-left: 4px; }
    .payment-guide ul { margin: 6px 0 12px; padding-left: 1.4rem; }
    .payment-guide strong { color: #fff; }
    .payment-guide .email-warning { color: #ff6b5f; font-weight: 700; }
    .submit-modal { position: fixed; z-index: 1000; inset: 0; display: grid; place-items: center; padding: 20px; visibility: hidden; opacity: 0; transition: opacity .25s ease, visibility .25s ease; }
    .submit-modal.is-open { visibility: visible; opacity: 1; }
    .submit-modal__backdrop { position: absolute; inset: 0; background: rgba(3,9,16,.8); backdrop-filter: blur(8px); }
    .submit-modal__card { position: relative; width: min(520px,100%); padding: 32px; border: 1px solid rgba(0,178,255,.38); border-radius: 4px; background: linear-gradient(145deg,#0b1726,#101522); box-shadow: 0 24px 80px rgba(0,0,0,.55); transform: translateY(16px) scale(.98); transition: transform .25s ease; }
    .submit-modal.is-open .submit-modal__card { transform: translateY(0) scale(1); }
    .submit-modal__card::before { content:''; position:absolute; top:0; left:0; width:100%; height:4px; background:linear-gradient(90deg,var(--gold),var(--blue)); }
    .submit-modal__close { position:absolute; top:12px; right:14px; width:32px; height:32px; border:1px solid rgba(168,184,200,.35); border-radius:50%; color:var(--muted); background:transparent; font-size:1.4rem; cursor:pointer; }
    .submit-modal__close:hover { color:var(--ink); background:var(--gold); }
    .submit-modal__eyebrow { margin:0 0 8px; color:var(--gold); font-family:'Orbitron',sans-serif; font-size:.75rem; letter-spacing:.14em; }
    .submit-modal h3 { margin:0; color:#fff; font-family:'Orbitron',sans-serif; font-size:clamp(1.2rem,3vw,1.65rem); }
    .submit-modal p { color:var(--muted); line-height:1.5; }
    .submit-modal__warning { margin:18px 0; padding:12px 14px; border-left:3px solid var(--gold); color:#fff !important; background:rgba(245,190,0,.08); }
    .submit-modal__actions { display:flex; justify-content:flex-end; gap:10px; margin-top:22px; }
    .submit-modal__actions button { min-height:42px; padding:10px 18px; border-radius:2px; font-family:'Rajdhani',sans-serif; font-weight:700; cursor:pointer; }
    .submit-modal__cancel { border:1px solid rgba(168,184,200,.45); color:#dce8f2; background:transparent; }
    .submit-modal__confirm { border:0; color:var(--ink); background:linear-gradient(90deg,var(--gold),#ffd95a); }
    .submit-modal__cancel:hover { border-color:var(--blue); color:#fff; }
    .submit-modal__confirm:hover { background:linear-gradient(90deg,var(--blue),#7cdbff); }
    .submit-success-modal__icon { display:grid; width:56px; height:56px; margin-bottom:18px; place-items:center; border:1px solid rgba(74,222,128,.45); border-radius:50%; color:#4ade80; background:rgba(74,222,128,.1); font-size:1.8rem; }
    .submit-success-modal .submit-modal__card::before { background:linear-gradient(90deg,#4ade80,var(--blue)); }
    .submit-success-modal .submit-modal__eyebrow { color:#4ade80; }
    body.submit-modal-open, body.submit-success-open { overflow:hidden; }
    @media (max-width: 576px) { body { padding: 18px 10px 44px; } .registration-topbar { align-items: flex-start; } .registration-brand { font-size: .9rem; } .registration-brand img { width: 36px; height: 36px; } .back-link { font-size: .85rem; white-space: nowrap; } .form-container { padding: 22px 16px; } .form-control, .form-select { font-size: 16px; } .btn { width: 100%; } .d-flex.justify-content-between { flex-wrap: wrap; gap: 12px; } .gender-options { grid-template-columns: 1fr; } }
  </style>
</head>
<body class="{{ session('success') ? 'submit-success-open' : '' }}">
  <main class="registration-page">
    <header class="registration-topbar">
      <a href="{{ url('/') }}" class="registration-brand">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Musi Run">
        <span>MUSI RUN VII</span>
      </a>
    </header>

    <div class="form-container">
      <h2 class="mb-1">FORM REGISTRASI MUSI RUN 2027</h2>
      <p class="text-muted">Isi data peserta dan unggah bukti pembayaran.</p>
      <p class="text-danger mb-3"><strong>Keterangan:</strong> Kolom bertanda <span aria-hidden="true">*</span> wajib diisi. Jika ada yang terlewat, pesan kesalahan akan ditampilkan pada kolom terkait.</p>

      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          <strong>Pendaftaran belum tersimpan.</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
      @endif

    <form id="registrasiForm" method="POST" action="{{ route('registrasi.store', [], false) }}" enctype="multipart/form-data" novalidate>
      @csrf
      <div id="clientValidationSummary" class="alert alert-danger" role="alert" tabindex="-1" hidden></div>

      <div class="col-12">
            <div class="payment-guide" aria-labelledby="paymentGuideTitle">
              <h5 id="paymentGuideTitle">Tata Cara Pembayaran</h5>
              <ol>
                <li>Pilih kategori jarak race yang ingin diikuti.</li>
                <li>Transfer pembayaran ke:
                  <ul>
                    <li>PT. Sumeks Kreatif Palembang - BNI: <strong>5570557077</strong></li>
                    <li>PT. Citra Bumi Sumatera - Mandiri: <strong>1120001099519</strong></li>
                  </ul>
                </li>
                <li>Upload bukti pembayaran di bawah ini.</li>
                <li>Submit pendaftaran dan tunggu email approval. <span class="email-warning">Pastikan email Anda input benar!</span></li>
              </ol>
            </div>
          </div>

      <!-- STEP 1 -->
      <div id="step-1" class="step">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input id="name" name="name" class="form-control" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">NIK <span class="text-danger">*</span></label>
            <input id="nik" name="nik" class="form-control" pattern="[0-9]+" inputmode="numeric" minlength="13" maxlength="20" placeholder="16 digit" required>
            @error('nik')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input id="email" name="email" type="email" class="form-control" required>
            <small class="form-text">Notifikasi pendaftaran akan dikirim ke email ini. Jika belum terlihat di kotak masuk, periksa juga folder Spam/Junk.</small>
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
            <input id="dob" name="dob" type="date" class="form-control" required>
            @error('dob')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">No. WhatsApp <span class="text-danger">*</span></label>
            <input id="whatsapp" name="whatsapp" class="form-control" pattern="[0-9]+" inputmode="numeric" minlength="10" maxlength="15" placeholder="62812345678" required>
            @error('whatsapp')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Ukuran Jersey <span class="text-danger">*</span></label>
            <select id="jersey_size" name="jersey_size" class="form-select" required>
              <option value="">Pilih Ukuran</option>
              <option>XS</option><option>S</option><option>M</option><option>L</option>
              <option>XL</option><option>XXL</option><option>3XL</option>
            </select>
            @error('jersey_size')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
            <div class="gender-options" role="radiogroup" aria-label="Pilih jenis kelamin">
              <label class="gender-option" for="gender_m">
                <input type="radio" name="gender" id="gender_m" value="Laki-laki" required>
                <span class="gender-option__content">
                  <span class="gender-option__icon"><i class="bi bi-person-standing"></i></span>
                  <span class="gender-option__name">Laki-laki</span>
                  <span class="gender-option__check" aria-hidden="true"></span>
                </span>
              </label>
              <label class="gender-option" for="gender_f">
                <input type="radio" name="gender" id="gender_f" value="Perempuan">
                <span class="gender-option__content">
                  <span class="gender-option__icon"><i class="bi bi-person-standing-dress"></i></span>
                  <span class="gender-option__name">Perempuan</span>
                  <span class="gender-option__check" aria-hidden="true"></span>
                </span>
              </label>
            </div>
            @error('gender')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="kategori" id="kategori" class="form-select" required>
              <option value="">Pilih Kategori</option>
              <option value="umum">Umum</option>
              <option value="pelajar">Pelajar</option>
            </select>
            @error('kategori')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Jenis Identitas</label>
            <select name="id_type" id="id_type" class="form-select">
              <option value="KTP">KTP</option>
              <option value="KK">Kartu Keluarga</option>
              <option value="SIM">SIM</option>
              <option value="KIA">KIA</option>
              <option value="Kartu Pelajar">Kartu Pelajar</option>
              <option value="Passport">Passport</option>
              <option value="KITAS">KITAS</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Golongan Darah</label>
            <select name="blood_type" id="blood_type" class="form-select">
              <option value="" selected>Pilih Golongan Darah</option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
              <option value="None">None</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Kewarganegaraan</label>
            <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" value="Indonesia">
          </div>

          <div class="col-md-6">
            <label class="form-label">Negara <span class="text-danger">*</span></label>
            <select name="negara" id="negara" class="form-select" required>
              <option value="">Pilih Negara</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Malaysia">Malaysia</option>
              <option value="Singapura">Singapura</option>
              <option value="Thailand">Thailand</option>
              <option value="Filipina">Filipina</option>
              <option value="Brunei">Brunei</option>
              <option value="Vietnam">Vietnam</option>
              <option value="Kamboja">Kamboja</option>
              <option value="Laos">Laos</option>
              <option value="Myanmar">Myanmar</option>
              <option value="Australia">Australia</option>
              <option value="Tiongkok">Tiongkok</option>
              <option value="Jepang">Jepang</option>
              <option value="Korea Selatan">Korea Selatan</option>
              <option value="India">India</option>
              <option value="Amerika Serikat">Amerika Serikat</option>
              <option value="Inggris">Inggris</option>
              <option value="Prancis">Prancis</option>
              <option value="Jerman">Jerman</option>
              <option value="Negara Lainnya">Negara Lainnya</option>
            </select>
            @error('negara')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Provinsi / State</label>
            <select name="provinsi" id="provinsi" class="form-select">
              <option value="">Pilih Provinsi</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Kota / Kabupaten / District</label>
            <select name="kota" id="kota" class="form-select">
              <option value="">Pilih Kota</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="2"></textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label">Nomor Kontak Darurat <span class="text-danger">*</span></label>
            <input type="tel" name="emergency_phone" id="emergency_phone" class="form-control" pattern="[0-9]+" inputmode="numeric" minlength="10" maxlength="15" placeholder="62812345678" required>
            @error('emergency_phone')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Nama Kontak Darurat <span class="text-danger">*</span></label>
            <input type="text" name="emergency_name" id="emergency_name" class="form-control" required>
            @error('emergency_name')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Hubungan dengan Kontak Darurat</label>
            <input type="text" name="emergency_relation" id="emergency_relation" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Nama Komunitas <small class="text-muted">(opsional)</small></label>
            <input type="text" name="community" id="community" class="form-control">
          </div>

          <div class="col-12">
            <label class="form-label">Riwayat Penyakit Khusus (opsional)</label>
            <textarea name="medical_history" id="medical_history" class="form-control" rows="3"></textarea>
          </div>

          <div class="col-12">
            <h5>Kategori Jarak <span class="text-danger">*</span></h5>
            @error('kategori_jarak')<small class="text-danger">{{ $message }}</small>@enderror
            <div class="row g-3" id="kategoriJarakContainer" tabindex="-1"></div>
          </div>


          <div class="col-12">
            <h5>Upload Bukti Pembayaran</h5>
            <label class="form-label" for="payment_proof">Bukti pembayaran <span class="text-danger">*</span></label>
            <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.webp,.svg" aria-describedby="paymentProofSizeError" required>
            <small id="paymentProofSizeError" class="text-danger" aria-live="polite" hidden>Ukuran file melebihi batas maksimal 1 MB. Silakan pilih file yang lebih kecil.</small>
            <small class="text-muted">Maksimal 1 MB. Format: JPG, JPEG, PNG, WEBP, atau SVG.</small>
            @error('payment_proof')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
            <a href="{{ url('/') }}" class="back-link" aria-label="Kembali ke halaman index">
              <i class="bi bi-arrow-left" aria-hidden="true"></i>
              <span>Kembali ke Halaman Utama</span>
            </a>
            <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
          </div>
      </div>

    </form>
    </div>
  </main>

  <div class="submit-modal" id="submitModal" aria-hidden="true">
    <div class="submit-modal__backdrop" data-submit-close></div>
    <section class="submit-modal__card" role="dialog" aria-modal="true" aria-labelledby="submitModalTitle">
      <button type="button" class="submit-modal__close" aria-label="Tutup" data-submit-close>&times;</button>
      <p class="submit-modal__eyebrow">KONFIRMASI PENDAFTARAN</p>
      <h3 id="submitModalTitle">Kirim data pendaftaran sekarang?</h3>
      <p>Pastikan seluruh data peserta sudah benar dan bukti pembayaran yang diunggah dapat terbaca.</p>
      <p class="submit-modal__warning"><strong>Perhatian:</strong> email yang benar diperlukan untuk menerima informasi approval pendaftaran.</p>
      <div class="submit-modal__actions">
        <button type="button" class="submit-modal__cancel" data-submit-close>Periksa Lagi</button>
        <button type="button" class="submit-modal__confirm" id="confirmSubmit">Ya, Kirim Pendaftaran</button>
      </div>
    </section>
  </div>

  @if(session('success'))
    <div class="submit-modal submit-success-modal is-open" id="submitSuccessModal" aria-hidden="false">
      <div class="submit-modal__backdrop" data-success-close></div>
      <section class="submit-modal__card" role="dialog" aria-modal="true" aria-labelledby="submitSuccessTitle" aria-describedby="submitSuccessDescription">
        <button type="button" class="submit-modal__close" aria-label="Tutup" data-success-close>&times;</button>
        <span class="submit-success-modal__icon" aria-hidden="true"><i class="bi bi-check-lg"></i></span>
        <p class="submit-modal__eyebrow">PENDAFTARAN TERKIRIM</p>
        <h3 id="submitSuccessTitle">Terima kasih, {{ session('registrant_name') }}!</h3>
        <p id="submitSuccessDescription">Data dan bukti pembayaran Anda berhasil kami terima. Pendaftaran saat ini menunggu verifikasi panitia.</p>
        <p><strong>Waktu pendaftaran:</strong> {{ session('registrant_created_at') }}</p>
        <p class="submit-modal__warning"><strong>Langkah selanjutnya:</strong> Pantau email atau WA Anda untuk menerima informasi setelah pendaftaran ditinjau. Periksa juga folder Spam/Junk pada email.</p>
        <div class="submit-modal__actions">
          <button type="button" class="submit-modal__confirm" data-success-close>Mengerti</button>
        </div>
      </section>
    </div>
  @endif

  <script>
  // Restrict input ke angka saja untuk NIK dan WhatsApp
  document.getElementById('nik').addEventListener('input', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });
  document.getElementById('whatsapp').addEventListener('input', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });
  document.getElementById('emergency_phone').addEventListener('input', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // Data Negara, Provinsi, Kota - Comprehensive Indonesian Cities
  const countryData = {
    'Indonesia': {
      'Aceh': ['Banda Aceh', 'Sabang', 'Lhokseumawe', 'Langsa', 'Meulaboh', 'Takengon', 'Calang', 'Sigli', 'Bireuen', 'Jantho'],
      'Sumatera Utara': ['Medan', 'Binjai', 'Pematangsiantar', 'Tebing Tinggi', 'Deli Serdang', 'Langkat', 'Asahan', 'Labuhanbatu', 'Nias', 'Tapanuli Utara', 'Tapanuli Tengah', 'Tapanuli Selatan', 'Mandailing Natal', 'Padang Lawas', 'Padang Lawas Utara', 'Samosir', 'Serdang Bedagai', 'Batubara', 'Padang Sidimpuan', 'Gunungsitoli'],
      'Sumatera Barat': ['Padang', 'Bukittinggi', 'Pariaman', 'Payakumbuh', 'Sawahlunto', 'Solok', 'Sungai Penuh', 'Lima Puluh Kota', 'Pasaman', 'Pasaman Barat', 'Agam', 'Tanah Datar', 'Padang Pariaman', 'Pesisir Selatan', 'Mentawai', 'Dharmasraya', 'Solok Selatan'],
      'Riau': ['Pekanbaru', 'Dumai', 'Seberida', 'Perawang', 'Tualang', 'Siak Sri Indrapura', 'Rengat', 'Pasir Pengaraian', 'Indragiri Hilir', 'Indragiri Hulu', 'Kampar', 'Rokan Hilir', 'Rokan Hulu', 'Bengkalis', 'Kepulauan Meranti', 'Inhil', 'Inhu', 'Pelalawan'],
      'Jambi': ['Jambi', 'Sungai Penuh', 'Muara Jambi', 'Kuantan Singingi', 'Tebo', 'Batang Hari', 'Muara Bulian', 'Mersam'],
      'Sumatera Selatan': ['Palembang', 'Prabumulih', 'Lubuklinggau', 'Lahat', 'Sekayu', 'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Ilir', 'Muara Enim', 'Belitung', 'Belitung Timur', 'Banyuasin', 'Musi Banyuasin', 'Musi Rawas', 'Empat Lawang'],
      'Bengkulu': ['Bengkulu', 'Curup', 'Lebih', 'Kepahiang', 'Muara Aman', 'Argamakmur', 'Muko-Muko', 'Kaur', 'Seluma', 'Rejang Lebong', 'Bengkulu Utara', 'Bengkulu Selatan'],
      'Lampung': ['Bandarlampung', 'Metro', 'Liwa', 'Tulangbawang', 'Menggala', 'Sukadana', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Utara', 'Lampung Barat', 'Tulang Bawang Barat', 'Pesawaran', 'Tanggamus', 'Pringsewu', 'Mesuji'],
      'Bangka Belitung': ['Pangkal Pinang', 'Tanjung Pandan', 'Sungailiat', 'Mangsang', 'Toboali', 'Koba', 'Mentok', 'Belitung', 'Belitung Timur', 'Bangka', 'Bangka Barat', 'Bangka Tengah', 'Bangka Selatan'],
      'Kepulauan Riau': ['Batam', 'Tanjung Pinang', 'Karimun', 'Bintan', 'Anambas', 'Natuna'],
      'DKI Jakarta': ['Jakarta Selatan', 'Jakarta Utara', 'Jakarta Timur', 'Jakarta Barat', 'Jakarta Pusat', 'Kepulauan Seribu'],
      'Jawa Barat': ['Bandung', 'Bogor', 'Bekasi', 'Depok', 'Cirebon', 'Tasikmalaya', 'Garut', 'Cianjur', 'Subang', 'Majalengka', 'Kuningan', 'Cirebon', 'Sukabumi', 'Purwakarta', 'Karawang', 'Pangandaran', 'Bandung Barat', 'Sumedang', 'Indramayu', 'Subang'],
      'Jawa Tengah': ['Semarang', 'Surakarta', 'Pekalongan', 'Salatiga', 'Purwokerto', 'Magelang', 'Tegal', 'Kudus', 'Pati', 'Kendal', 'Jepara', 'Batang', 'Cilacap', 'Demak', 'Grobogan', 'Blora', 'Rembang', 'Brebes', 'Boyolali', 'Ngawi', 'Sukoharjo', 'Wonogiri', 'Karanganyar', 'Klaten', 'Sleman', 'Temanggung', 'Wonosobo'],
      'DI Yogyakarta': ['Yogyakarta', 'Sleman', 'Bantul', 'Gunung Kidul', 'Kulon Progo'],
      'Jawa Timur': ['Surabaya', 'Malang', 'Sidoarjo', 'Gresik', 'Pasuruan', 'Mojokerto', 'Jember', 'Banyuwangi', 'Lumajang', 'Bondowoso', 'Situbondo', 'Probolinggo', 'Pamekasan', 'Sampang', 'Sumenep', 'Tuban', 'Lamongan', 'Bojonegoro', 'Magetan', 'Madiun', 'Nganjuk', 'Blitar', 'Kediri', 'Tulungagung', 'Trenggalek', 'Ponorogo', 'Pacitan', 'Bangil', 'Rasulan'],
      'Banten': ['Serang', 'Cilegon', 'Tangerang', 'Tangerang Selatan', 'Lebak', 'Pandeglang', 'Cikupa', 'Balaraja'],
      'Bali': ['Denpasar', 'Ubud', 'Kuta', 'Sanur', 'Seminyak', 'Bukit', 'Gianyar', 'Klungkung', 'Bangli', 'Jembrana', 'Tabanan'],
      'Nusa Tenggara Barat': ['Mataram', 'Bima', 'Lombok', 'Praya', 'Dompu', 'Sumbawa', 'Sumbawa Barat', 'Sumbawa Timur'],
      'Nusa Tenggara Timur': ['Kupang', 'Maumere', 'Larantuka', 'Ende', 'Bajawa', 'Ruteng', 'Rote', 'Alor', 'Timor Tengah Utara', 'Timor Tengah Selatan', 'Malaka'],
      'Kalimantan Barat': ['Pontianak', 'Singkawang', 'Sambas', 'Mempawah', 'Sanggau', 'Bengkayang', 'Landak', 'Kubu Raya', 'Mempawah Utama'],
      'Kalimantan Tengah': ['Palangka Raya', 'Sampit', 'Pangkalan Bun', 'Muara Teweh', 'Kumai'],
      'Kalimantan Selatan': ['Banjarmasin', 'Banjarbaru', 'Martapura', 'Kandangan', 'Pelaihari', 'Tapin', 'Tanah Bumbu', 'Hulu Sungai Utara', 'Hulu Sungai Selatan', 'Kota Baru'],
      'Kalimantan Timur': ['Samarinda', 'Balikpapan', 'Berau', 'Bontang', 'Tarakan', 'Tenggarong', 'Samarinda Ulu', 'Samarinda Ilir', 'Kutai Timur', 'Kutai Barat', 'Kutai Kartanegara', 'Pasir', 'Penajam'],
      'Kalimantan Utara': ['Tanjung Selor', 'Tarakan', 'Bulungan', 'Nunukan', 'Malinau', 'Tana Tidung'],
      'Sulawesi Utara': ['Manado', 'Tomohon', 'Bitung', 'Tondano', 'Amurang', 'Minahasa', 'Minahasa Selatan', 'Minahasa Utara', 'Bolaang Mongondow', 'Bolaang Mongondow Utara', 'Bolaang Mongondow Selatan'],
      'Sulawesi Tengah': ['Palu', 'Buol', 'Luwuk', 'Banggai', 'Donggo', 'Parigi Moutong', 'Toli-Toli', 'Buol'],
      'Sulawesi Selatan': ['Makassar', 'Parepare', 'Palopo', 'Gowa', 'Takalar', 'Jeneponto', 'Bantaeng', 'Bulukumba', 'Sinjai', 'Maros', 'Pangkajene Kepulauan', 'Barru', 'Bone', 'Soppeng', 'Wajo', 'Sidrap', 'Pinrang', 'Enrekang', 'Luwu', 'Luwu Utara', 'Luwu Timur', 'Tana Toraja', 'Toraja Utara'],
      'Sulawesi Tenggara': ['Kendari', 'Bau-Bau', 'Kolaka', 'Unaaha', 'Mandar', 'Mori', 'Buton Utara', 'Buton Tengah'],
      'Gorontalo': ['Gorontalo', 'Mantikulore', 'Bone Bolango', 'Pohuwato', 'Boalemo'],
      'Sulawesi Barat': ['Mamuju', 'Polewali', 'Majene', 'Mamasa', 'Pasangkayu'],
      'Maluku': ['Ambon', 'Tual', 'Masohi', 'Banda', 'Bula', 'Seram Barat', 'Seram Timur', 'Maluku Tenggara', 'Maluku Tenggara Barat'],
      'Maluku Utara': ['Ternate', 'Tidore', 'Sofifi', 'Halmahera Barat', 'Halmahera Timur', 'Halmahera Tengah', 'Halmahera Selatan', 'Manado', 'Pulau Morotai'],
      'Papua': ['Jayapura', 'Wamena', 'Sorong', 'Merauke', 'Biak', 'Tiom', 'Nabire', 'Manokwari', 'Kota Jayapura', 'Pegunungan Jaya', 'Tolikara', 'Mamberamo Raya', 'Waropen'],
      'Papua Barat': ['Manokwari', 'Sorong', 'Ransiki', 'Teminabuan', 'Fakfak', 'Kaimana', 'Teluk Wondama', 'Maybrat', 'Tambrauw']
    },
    'Malaysia': {
      'Selangor': ['Kuala Lumpur', 'Petaling Jaya', 'Subang', 'Shah Alam', 'Klang', 'Kajang', 'Selangor Darul Ehsan'],
      'Wilayah Persekutuan': ['Kuala Lumpur', 'Labuan', 'Putrajaya'],
      'Johor': ['Johor Bahru', 'Kota Tinggi', 'Iskandar Puteri', 'Stulang Laut', 'Batu Pahat'],
      'Kedah': ['Alor Setar', 'Sungai Petani', 'Bandar Baharu', 'Kodiang'],
      'Kelantan': ['Kota Bharu', 'Kuantan', 'Kuala Terengganu', 'Pasir Puteh'],
      'Negeri Sembilan': ['Seremban', 'Port Dickson', 'Kuala Pilah', 'Nilai'],
      'Pahang': ['Kuantan', 'Temerloh', 'Raub', 'Bentong', 'Pahang'],
      'Penang': ['George Town', 'Penang', 'Seberang Perai', 'Butterworth'],
      'Perak': ['Ipoh', 'Kuala Lumpur', 'Taiping', 'Seri Manjung', 'Perak'],
      'Perlis': ['Kangar', 'Arau', 'Perlis'],
      'Sabah': ['Kota Kinabalu', 'Sandakan', 'Tawau', 'Lahad Datu', 'Keningau'],
      'Sarawak': ['Kuching', 'Sibu', 'Miri', 'Bintulu', 'Sri Aman']
    },
    'Singapura': {
      'Singapura': ['Singapura', 'Marina Bay', 'Tanjong Pagar', 'Orchard', 'Sentosa']
    },
    'Thailand': {
      'Bangkok': ['Bangkok', 'Din Daeng', 'Dusit', 'Khlong Toei', 'Lat Phrao'],
      'Chiang Mai': ['Chiang Mai', 'Chiang Rai', 'Nan', 'Phrae'],
      'Phuket': ['Phuket', 'Phang Nga', 'Krabi'],
      'Rayong': ['Rayong', 'Chonburi', 'Samut Prakan']
    },
    'Filipina': {
      'Metro Manila': ['Manila', 'Quezon City', 'Makati', 'Pasay', 'Caloocan'],
      'Calabarzon': ['Cavite', 'Laguna', 'Batangas', 'Rizal', 'Quezon'],
      'Visayas': ['Cebu', 'Iloilo', 'Bacolod', 'Dumaguete', 'Tacloban'],
      'Mindanao': ['Davao', 'Cagayan de Oro', 'General Santos', 'Cotabato', 'Zamboanga']
    },
    'Brunei': {
      'Brunei-Muara': ['Bandar Seri Begawan', 'Tutong', 'Kuala Belait'],
      'Belait': ['Kuala Belait', 'Pekan Tutong'],
      'Tutong': ['Tutong', 'Pekan Tutong'],
      'Temburong': ['Bangar', 'Pekan Tutong']
    },
    'Vietnam': {
      'Ha Noi': ['Ha Noi', 'Ba Dinh', 'Dong Da', 'Hoan Kiem'],
      'Ho Chi Minh': ['Ho Chi Minh', 'District 1', 'District 3', 'District 5'],
      'Da Nang': ['Da Nang', 'Hai Chau', 'Thanh Khe'],
      'Hai Phong': ['Hai Phong', 'Hong Bang', 'Ngo Quyen']
    },
    'Negara Lainnya': {
      'Internasional': ['Pilih negara terlebih dahulu']
    }
  };

  // Event listener untuk mengubah provinsi dan kota berdasarkan negara
  document.getElementById('negara').addEventListener('change', function(){
    const negaraVal = this.value;
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');

    provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
    kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';

    if(negaraVal && countryData[negaraVal]){
      Object.keys(countryData[negaraVal]).forEach(prov => {
        const opt = document.createElement('option');
        opt.value = prov;
        opt.textContent = prov;
        provinsiSelect.appendChild(opt);
      });
    }
  });

  // Event listener untuk mengubah kota berdasarkan provinsi
  document.getElementById('provinsi').addEventListener('change', function(){
    const negaraVal = document.getElementById('negara').value;
    const provinsiVal = this.value;
    const kotaSelect = document.getElementById('kota');

    kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';

    if(negaraVal && provinsiVal && countryData[negaraVal] && countryData[negaraVal][provinsiVal]){
      countryData[negaraVal][provinsiVal].forEach(kota => {
        const opt = document.createElement('option');
        opt.value = kota;
        opt.textContent = kota;
        kotaSelect.appendChild(opt);
      });
    }
  });

  const kategoriJarak = [
    { nama: '7 Kilometer', earlyBird:{start:'2026-06-01',end:'2026-12-09',hargaNormal:200000,hargaDiskon:160000}, normal:{start:'2025-12-10',end:'2026-01-10',hargaNormal:200000} },
    { nama: '12 Kilometer', earlyBird:{start:'2026-06-01',end:'2026-12-09',hargaNormal:250000,hargaDiskon:200000}, normal:{start:'2025-12-10',end:'2026-01-10',hargaNormal:230000} }
  ];

  (function renderKategori(){
    const container = document.getElementById('kategoriJarakContainer');
    const today = new Date();
    kategoriJarak.forEach(k=>{
      const earlyStart=new Date(k.earlyBird.start), earlyEnd=new Date(k.earlyBird.end);
      const normalStart=new Date(k.normal.start), normalEnd=new Date(k.normal.end);
      const isEarly = today>=earlyStart && today<=earlyEnd;
      const isNormal = today>=normalStart && today<=normalEnd;
      const earlyHtml = `<div class="col-md-6"><label class="jarak-card ${!isEarly?'disabled-card':''}"><input type="radio" name="kategori_jarak" value="${k.nama}_Early" ${!isEarly?'disabled':''}> <span class="jarak-content"><strong>${k.nama} Early Bird</strong><span class="jarak-price">${isEarly?('Diskon Rp '+(k.earlyBird.hargaDiskon).toLocaleString()):'Belum tersedia'}</span>${!isEarly?'<span class="jarak-status">Periode belum aktif</span>':''}</span></label></div>`;
      const normalHtml = `<div class="col-md-6"><label class="jarak-card ${!isNormal?'disabled-card':''}"><input type="radio" name="kategori_jarak" value="${k.nama}_Normal" ${!isNormal?'disabled':''}> <span class="jarak-content"><strong>${k.nama} Normal</strong><span class="jarak-price">Rp ${(k.normal.hargaNormal).toLocaleString()}</span>${!isNormal?'<span class="jarak-status">Periode belum aktif</span>':''}</span></label></div>`;
      container.insertAdjacentHTML('beforeend', earlyHtml+normalHtml);
    });
    document.addEventListener('click', e=>{
      const card = e.target.closest('.jarak-card');
      if(!card || card.classList.contains('disabled-card')) return;
      document.querySelectorAll('.jarak-card').forEach(c=>c.classList.remove('active'));
      card.classList.add('active');
      const input = card.querySelector('input[type="radio"]'); if(input) input.checked=true;
    });
  })();

  function getSelectedCategory(){ const sel=document.querySelector('input[name="kategori_jarak"]:checked'); return sel?sel.value:null; }
  function formatRupiah(n){ return 'Rp '+Number(n).toLocaleString('id-ID'); }
  function populateOrderSummary(){ const sel=getSelectedCategory(); const el=document.getElementById('orderSummary'); if(!sel){ el.innerHTML='- Belum ada pilihan jarak'; return; } const parts=sel.split('_'); const nama=parts[0], tipe=parts[1]; let price=0; for(let k of kategoriJarak){ if(k.nama===nama){ price=(tipe==='Early') ? (k.earlyBird.hargaDiskon||k.earlyBird.hargaNormal) : k.normal.hargaNormal; } } el.innerHTML=`<div>${nama} — <strong>${tipe}</strong></div><div class="mt-2">Total: <strong>${formatRupiah(price)}</strong></div>`; }

  function populateReview(){
    const review=document.getElementById('reviewArea');
    const data = {
      nama: document.getElementById('name').value,
      nik: document.getElementById('nik').value,
      email: document.getElementById('email').value,
      dob: document.getElementById('dob').value,
      gender: document.querySelector('input[name="gender"]:checked')?.value || '-',
      whatsapp: document.getElementById('whatsapp').value,
      jersey_size: document.getElementById('jersey_size').value,
      kategori: document.getElementById('kategori').value,
      id_type: document.getElementById('id_type').value,
      blood_type: document.getElementById('blood_type').value,
      kewarganegaraan: document.getElementById('kewarganegaraan').value,
      negara: document.getElementById('negara').value,
      provinsi: document.getElementById('provinsi').value,
      kota: document.getElementById('kota').value,
      alamat: document.getElementById('alamat').value,
      emergency_phone: document.getElementById('emergency_phone').value,
      emergency_name: document.getElementById('emergency_name').value,
      emergency_relation: document.getElementById('emergency_relation').value,
      community: document.getElementById('community').value,
      medical_history: document.getElementById('medical_history').value,
      kategori_jarak: (document.querySelector('input[name="kategori_jarak"]:checked')||{}).value || '-'
    };

    let priceText = document.getElementById('orderSummary').innerHTML;

    let html = `
      <div style="font-size:14px; line-height:1.6;">
        <h6 style="margin-top:12px; margin-bottom:8px; font-weight:600; border-bottom:2px solid #e2e8f0; padding-bottom:6px;">DATA PRIBADI</h6>
        <p style="margin:4px 0;"><strong>Nama Lengkap:</strong> ${data.nama}</p>
        <p style="margin:4px 0;"><strong>NIK:</strong> ${data.nik}</p>
        <p style="margin:4px 0;"><strong>Email:</strong> ${data.email}</p>
        <p style="margin:4px 0;"><strong>Tanggal Lahir:</strong> ${data.dob}</p>
        <p style="margin:4px 0;"><strong>Jenis Kelamin:</strong> ${data.gender}</p>
        <p style="margin:4px 0;"><strong>No. WhatsApp:</strong> ${data.whatsapp}</p>
        <p style="margin:4px 0;"><strong>Ukuran Jersey:</strong> ${data.jersey_size}</p>
        <p style="margin:4px 0;"><strong>Kategori:</strong> ${data.kategori}</p>

        <h6 style="margin-top:12px; margin-bottom:8px; font-weight:600; border-bottom:2px solid #e2e8f0; padding-bottom:6px;">IDENTITAS & MEDIS</h6>
        <p style="margin:4px 0;"><strong>Jenis Identitas:</strong> ${data.id_type}</p>
        <p style="margin:4px 0;"><strong>Golongan Darah:</strong> ${data.blood_type}</p>
        <p style="margin:4px 0;"><strong>Kewarganegaraan:</strong> ${data.kewarganegaraan}</p>
        <p style="margin:4px 0;"><strong>Riwayat Penyakit Khusus:</strong> ${data.medical_history || '-'}</p>

        <h6 style="margin-top:12px; margin-bottom:8px; font-weight:600; border-bottom:2px solid #e2e8f0; padding-bottom:6px;">LOKASI & ALAMAT</h6>
        <p style="margin:4px 0;"><strong>Negara:</strong> ${data.negara}</p>
        <p style="margin:4px 0;"><strong>Provinsi/State:</strong> ${data.provinsi || '-'}</p>
        <p style="margin:4px 0;"><strong>Kota/Kabupaten:</strong> ${data.kota || '-'}</p>
        <p style="margin:4px 0;"><strong>Alamat Lengkap:</strong> ${data.alamat || '-'}</p>

        <h6 style="margin-top:12px; margin-bottom:8px; font-weight:600; border-bottom:2px solid #e2e8f0; padding-bottom:6px;">KONTAK DARURAT</h6>
        <p style="margin:4px 0;"><strong>Nama:</strong> ${data.emergency_name}</p>
        <p style="margin:4px 0;"><strong>No. Telpon:</strong> ${data.emergency_phone}</p>
        <p style="margin:4px 0;"><strong>Hubungan:</strong> ${data.emergency_relation || '-'}</p>

        <h6 style="margin-top:12px; margin-bottom:8px; font-weight:600; border-bottom:2px solid #e2e8f0; padding-bottom:6px;">KOMUNITAS & PENDAFTARAN</h6>
        <p style="margin:4px 0;"><strong>Komunitas:</strong> ${data.community || '-'}</p>
        <p style="margin:4px 0;"><strong>Kategori Jarak:</strong> ${data.kategori_jarak}</p>

        <h6 style="margin-top:12px; margin-bottom:8px; font-weight:600; border-bottom:2px solid #e2e8f0; padding-bottom:6px;">RINGKASAN PESANAN</h6>
        <div style="background:#f8fafc; padding:10px; border-radius:6px; border-left:3px solid #4a5568;">
          ${priceText}
        </div>
      </div>
    `;

    review.innerHTML = html;
  }

  // Validasi kategori jarak sebelum mengirim satu-satunya tahapan form.
  const registrasiForm = document.getElementById('registrasiForm');
  const submitModal = document.getElementById('submitModal');
  const validationSummary = document.getElementById('clientValidationSummary');
  const successModal = document.getElementById('submitSuccessModal');
  const paymentProofInput = document.getElementById('payment_proof');
  const paymentProofSizeError = document.getElementById('paymentProofSizeError');
  const closeSubmitModal = () => { submitModal.classList.remove('is-open'); submitModal.setAttribute('aria-hidden', 'true'); document.body.classList.remove('submit-modal-open'); };
  const closeSuccessModal = () => {
    if (!successModal) return;
    successModal.classList.remove('is-open');
    successModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('submit-success-open');
  };

  function validationMessage(field) {
    if (field.name === 'payment_proof' && field.validity.customError) {
      return paymentProofSizeError.textContent;
    }
    if (field.validity.valueMissing) return 'Kolom ini wajib diisi.';
    if (field.validity.typeMismatch) return 'Masukkan format yang valid.';
    if (field.validity.patternMismatch) return 'Gunakan angka saja.';
    if (field.validity.tooShort) return `Masukkan minimal ${field.minLength} karakter.`;
    if (field.validity.tooLong) return `Maksimal ${field.maxLength} karakter.`;
    return 'Periksa kembali isian ini.';
  }

  function clearClientValidationError(field) {
    field.removeAttribute('aria-invalid');
    if (field === paymentProofInput) paymentProofSizeError.hidden = true;
    registrasiForm.querySelectorAll('.field-validation-error').forEach(error => {
      if (error.dataset.field === field.name) error.remove();
    });
    validationSummary.hidden = true;
    validationSummary.textContent = '';
  }

  function showClientValidationError(field, message) {
    clearClientValidationError(field);
    field.setAttribute('aria-invalid', 'true');
    if (field === paymentProofInput && field.validity.customError) {
      paymentProofSizeError.hidden = false;
      return;
    }
    const error = document.createElement('small');
    error.className = 'field-validation-error';
    error.dataset.field = field.name;
    error.textContent = message;

    const target = field.name === 'gender'
      ? field.closest('.gender-options')
      : field;
    target.insertAdjacentElement('afterend', error);
  }

  ['input', 'change'].forEach(eventName => {
    registrasiForm.addEventListener(eventName, event => {
      if (event.target.matches('input, select, textarea')) {
        clearClientValidationError(event.target);
      }
    });
  });

  paymentProofInput.addEventListener('change', () => {
    const selectedFile = paymentProofInput.files[0];
    const exceedsSizeLimit = selectedFile && selectedFile.size > 1024 * 1024;
    paymentProofInput.setCustomValidity(exceedsSizeLimit ? paymentProofSizeError.textContent : '');
    if (exceedsSizeLimit) {
      showClientValidationError(paymentProofInput, paymentProofSizeError.textContent);
    }
  });

  registrasiForm.addEventListener('submit', function(e){
    const invalidFields = Array.from(registrasiForm.elements)
      .filter(field => field.willValidate && !field.checkValidity());
    const missingCategory = !getSelectedCategory();
    validationSummary.hidden = true;
    validationSummary.textContent = '';
    registrasiForm.querySelectorAll('.field-validation-error').forEach(error => error.remove());
    registrasiForm.querySelectorAll('[aria-invalid="true"]').forEach(field => field.removeAttribute('aria-invalid'));

    invalidFields.forEach(field => showClientValidationError(field, validationMessage(field)));
    if (missingCategory) {
      const categoryError = document.createElement('small');
      categoryError.className = 'field-validation-error';
      categoryError.dataset.field = 'kategori_jarak';
      categoryError.textContent = 'Pilih kategori jarak terlebih dahulu.';
      document.getElementById('kategoriJarakContainer').insertAdjacentElement('beforebegin', categoryError);
    }

    if (invalidFields.length || missingCategory) {
      e.preventDefault();
      const invalidLabels = [...new Set(invalidFields.map(field => {
        const label = field.type === 'radio'
          ? field.closest('.col-md-6, .col-12')?.querySelector('.form-label')
          : registrasiForm.querySelector('label[for="' + field.id + '"]')
            || field.closest('.col-md-6, .col-12')?.querySelector('.form-label');
        return label?.textContent.replace('*', '').trim() || field.name;
      }))];
      if (missingCategory) invalidLabels.push('Kategori Jarak');

      validationSummary.textContent = 'Pendaftaran belum dapat dikirim. Lengkapi atau perbaiki: ' + invalidLabels.join(', ') + '.';
      validationSummary.hidden = false;
      const categoryInput = document.querySelector('input[name="kategori_jarak"]:not(:disabled)');
      const firstInvalidField = [...invalidFields, ...(missingCategory ? [categoryInput || document.getElementById('kategoriJarakContainer')] : [])]
        .sort((first, second) => {
          const position = first.compareDocumentPosition(second);
          if (position & Node.DOCUMENT_POSITION_FOLLOWING) return -1;
          if (position & Node.DOCUMENT_POSITION_PRECEDING) return 1;
          return 0;
        })[0];
      const fieldToFocus = firstInvalidField;
      const fieldToScroll = fieldToFocus.type === 'radio' && fieldToFocus.name === 'gender'
        ? fieldToFocus.closest('.gender-options')
        : fieldToFocus.type === 'radio' && fieldToFocus.name === 'kategori_jarak'
          ? fieldToFocus.closest('.jarak-card')
          : fieldToFocus;
      fieldToScroll.scrollIntoView({ behavior: 'smooth', block: 'center' });
      fieldToFocus.focus({ preventScroll: true });
      return;
    }

    if(!registrasiForm.dataset.confirmed){ e.preventDefault(); submitModal.classList.add('is-open'); submitModal.setAttribute('aria-hidden', 'false'); document.body.classList.add('submit-modal-open'); document.getElementById('confirmSubmit').focus(); }
  });
  document.querySelectorAll('[data-submit-close]').forEach(button => button.addEventListener('click', closeSubmitModal));
  document.querySelectorAll('[data-success-close]').forEach(button => button.addEventListener('click', closeSuccessModal));
  document.getElementById('confirmSubmit').addEventListener('click', () => { registrasiForm.dataset.confirmed = 'true'; closeSubmitModal(); registrasiForm.requestSubmit(); });
  if (successModal) successModal.querySelector('[data-success-close]:not(.submit-modal__backdrop)')?.focus();
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      closeSubmitModal();
      closeSuccessModal();
    }
  });
  </script>
</body>
</html>
