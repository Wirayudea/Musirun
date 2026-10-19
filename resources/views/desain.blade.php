<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desain Jersey dan Medali | MUSI RUN VII</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700;900&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gold:#f5be00; --blue:#00B2FF; --ink:#07101c; --panel:#0a0a0a; --navy:#07101c; --muted:#a8b8c8; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; color:#fff; background:radial-gradient(circle at 12% 8%,rgba(0,178,255,.16),transparent 30%),radial-gradient(circle at 90% 88%,rgba(245,190,0,.12),transparent 28%),#0a0a0a; font-family:'Rajdhani',sans-serif; }
        .topbar { width:min(1180px,calc(100% - 32px)); margin:0 auto; padding:20px 0; display:flex; align-items:center; justify-content:space-between; gap:20px; }
        .brand { display:flex; align-items:center; gap:10px; color:#fff; text-decoration:none; font-family:'Orbitron',sans-serif; font-size:clamp(.8rem,2vw,1.05rem); font-weight:700; letter-spacing:.04em; }
        .brand img { width:43px; height:43px; object-fit:contain; }
        .back-link { color:var(--gold); border:1px solid rgba(245,190,0,.65); padding:8px 14px; border-radius:2px; text-decoration:none; font-weight:700; }
        .back-link:hover { color:var(--ink); background:var(--gold); }
        .page { width:min(1180px,calc(100% - 32px)); margin:0 auto 42px; padding:clamp(24px,4vw,54px); background:linear-gradient(135deg,rgba(10,20,32,.97),rgba(7,16,28,.94)); border:1px solid rgba(0,178,255,.35); border-top:7px solid var(--gold); border-radius:4px; box-shadow:0 22px 48px rgba(0,0,0,.45),0 0 34px rgba(0,178,255,.08); }
        .eyebrow { margin:0 0 8px; color:var(--gold); font-weight:700; letter-spacing:.18em; text-transform:uppercase; text-align:center; }
        h1 { margin:0 0 42px; text-align:center; font-family:'Orbitron',sans-serif; font-size:clamp(1.6rem,4vw,2.8rem); letter-spacing:.04em; }
        .section { padding:0 0 44px; } .section + .section { padding-top:40px; border-top:1px solid rgba(255,255,255,.12); }
        .section-heading { margin:0 0 25px; color:var(--gold); text-align:center; font-family:'Orbitron',sans-serif; font-size:clamp(1.2rem,3vw,1.8rem); }
        .jersey-layout { display:grid; grid-template-columns:1.05fr .95fr; gap:34px; align-items:center; }
        .jersey-gallery { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:24px; }
        .jersey-card { min-height:350px; padding:22px; display:flex; flex-direction:column; justify-content:space-between; align-items:center; border-radius:4px; background:linear-gradient(145deg,rgba(4,12,22,.95),rgba(22,31,48,.85)); border:1px solid rgba(168,184,200,.22); box-shadow:inset 0 0 30px rgba(0,178,255,.08); }
        .jersey-card h3 { margin:0; color:var(--gold); font-size:1rem; letter-spacing:.12em; text-transform:uppercase; }
        .shirt { position:relative; width:165px; height:235px; margin:auto; background:linear-gradient(160deg,#fff 0 43%,#ffca4b 43% 56%,#f27d16 56% 100%); clip-path:polygon(25% 4%,40% 0,50% 8%,60% 0,75% 4%,100% 22%,88% 39%,77% 31%,77% 100%,23% 100%,23% 31%,12% 39%,0 22%); filter:drop-shadow(0 14px 8px rgba(0,0,0,.35)); }
        .shirt::before { content:'MUSI\\A RUN'; white-space:pre; position:absolute; top:65px; left:50%; transform:translateX(-50%); color:var(--blue); text-align:center; font-family:'Orbitron',sans-serif; font-size:13px; font-weight:900; line-height:1.25; }
        .shirt::after { content:'VII'; position:absolute; bottom:26px; left:50%; transform:translateX(-50%); color:#fff; font-family:'Orbitron',sans-serif; font-size:26px; font-weight:900; }
        .back-shirt { background:linear-gradient(160deg,#fff 0 39%,#f8c640 39% 52%,#ef7815 52% 100%); }
        .back-shirt::before { content:'SUMATERA\\A EKSPRES'; top:74px; color:var(--gold); font-size:11px; }
        .back-shirt::after { content:'2027'; bottom:25px; }
        .size-panel { padding:24px; border-radius:4px; background:rgba(4,12,22,.78); border:1px solid rgba(168,184,200,.2); }
        .size-table { width:100%; border-collapse:separate; border-spacing:0 7px; text-align:center; font-size:1rem; } .size-table th { padding:13px 10px; background:var(--navy); color:#fff; } .size-table td { padding:12px 10px; background:rgba(255,255,255,.06); } .size-table tr:nth-child(even) td { background:rgba(0,178,255,.12); } .size-table th:first-child,.size-table td:first-child { border-radius:2px 0 0 2px; } .size-table th:last-child,.size-table td:last-child { border-radius:0 2px 2px 0; }
        .note { margin:22px 0 0; color:#eee; text-align:center; font-style:italic; font-size:1rem; }
        .medal-layout { display:grid; grid-template-columns:.8fr 1.2fr; gap:34px; align-items:center; } .medal-stage { min-height:280px; display:grid; place-items:center; border-radius:4px; background:linear-gradient(145deg,rgba(4,12,22,.95),rgba(22,31,48,.85)); border:1px solid rgba(168,184,200,.22); }
        .medal { position:relative; width:185px; height:185px; display:grid; place-items:center; border:10px solid #ffd467; border-radius:50%; background:radial-gradient(circle at 35% 30%,#fff0a2 0 8%,#f0a522 9% 45%,#b9650b 46% 100%); box-shadow:0 0 0 8px #d47c16,0 15px 22px rgba(0,0,0,.4); color:#fff; text-align:center; font-family:'Orbitron',sans-serif; }
        .medal::before { content:''; position:absolute; top:-78px; width:52px; height:72px; background:linear-gradient(90deg,var(--blue) 50%,var(--gold) 50%); clip-path:polygon(0 0,100% 0,100% 100%,50% 78%,0 100%); z-index:-1; } .medal strong { display:block; font-size:1.25rem; } .medal span { display:block; margin-top:7px; font-size:.65rem; letter-spacing:.08em; }
        .medal-copy h3 { margin:0 0 12px; color:var(--gold); font-size:1.5rem; } .medal-copy p { max-width:520px; margin:0; color:var(--muted); font-size:1.08rem; line-height:1.5; }
        .route-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:22px; }
        .route-card { min-height:270px; padding:24px; border:1px solid rgba(168,184,200,.22); border-radius:4px; background:linear-gradient(145deg,rgba(4,12,22,.95),rgba(22,31,48,.85)); }
        .route-card h3 { margin:0 0 6px; color:var(--gold); font-family:'Orbitron',sans-serif; font-size:1.1rem; }
        .route-card p { margin:0 0 18px; color:var(--muted); font-size:1rem; }
        .route-placeholder { min-height:150px; display:grid; place-items:center; border:1px dashed rgba(0,178,255,.65); border-radius:3px; background:repeating-linear-gradient(135deg,rgba(0,178,255,.05) 0 10px,transparent 10px 20px); color:var(--blue); text-align:center; }
        .route-placeholder strong { display:block; color:#fff; font-family:'Orbitron',sans-serif; font-size:.9rem; }
        .route-placeholder span { display:block; margin-top:6px; color:var(--muted); font-size:.9rem; }
        .route-meta { display:flex; justify-content:space-between; gap:14px; margin-top:16px; color:#fff; font-weight:600; }
        .route-meta span { color:var(--muted); font-weight:400; }
        .cta { display:block; width:max-content; margin:40px auto 0; padding:12px 24px; color:var(--ink); background:linear-gradient(90deg,var(--gold),#ffd95a); border-radius:2px; text-decoration:none; font-family:'Orbitron',sans-serif; font-size:1rem; font-weight:700; }
        @media (max-width:850px) { .jersey-layout,.medal-layout,.route-grid { grid-template-columns:1fr; } .jersey-gallery { max-width:620px; width:100%; margin:auto; } .size-panel { max-width:620px; width:100%; margin:auto; } }
        @media (max-width:520px) { .topbar { align-items:flex-start; } .back-link { font-size:.85rem; white-space:nowrap; } .page { width:calc(100% - 20px); padding:24px 15px; border-radius:14px; } .jersey-gallery { gap:10px; } .jersey-card { min-height:270px; padding:14px 8px; } .shirt { transform:scale(.78); margin:-18px 0; } .size-panel { padding:14px 8px; overflow-x:auto; } .size-table { min-width:420px; } .medal-stage { min-height:240px; } }
    </style>
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="MUSI RUN VII"><span>MUSI RUN VII</span></a>
        <a class="back-link" href="{{ url('/') }}">Kembali</a>
    </header>
    <main class="page">
        <p class="eyebrow">Musi Run VII 2027</p>
        <h1>DESAIN JERSEY &amp; MEDALI</h1>
        <section class="section">
            <h2 class="section-heading">JERSEY</h2>
            <div class="jersey-layout">
                <div class="jersey-gallery"><article class="jersey-card"><h3>Tampak Depan</h3><div class="shirt"></div></article><article class="jersey-card"><h3>Tampak Belakang</h3><div class="shirt back-shirt"></div></article></div>
                <div class="size-panel"><table class="size-table"><thead><tr><th>Ukuran</th><th>Lebar</th><th>Panjang</th></tr></thead><tbody><tr><td>XS</td><td>47</td><td>68</td></tr><tr><td>S</td><td>49</td><td>70</td></tr><tr><td>M</td><td>51</td><td>72</td></tr><tr><td>L</td><td>53</td><td>74</td></tr><tr><td>XL</td><td>55</td><td>76</td></tr><tr><td>XXL</td><td>58</td><td>78</td></tr><tr><td>XXXL</td><td>61</td><td>81</td></tr></tbody></table><p class="note">* Desain dapat berubah berdasarkan sponsor.</p></div>
            </div>
        </section>
        <section class="section">
            <h2 class="section-heading">MEDALI FINISHER</h2>
            <div class="medal-layout"><div class="medal-stage"><div class="medal"><div><strong>MUSI<br>RUN</strong><span>FINISHER 2027</span></div></div></div><div class="medal-copy"><h3>Satu langkah, seribu semangat</h3><p>Medali finisher diberikan kepada peserta yang berhasil menyelesaikan lintasan. Simpan sebagai pengingat setiap langkah dan perjuangan di MUSI RUN VII.</p></div></div>
        </section>
        <section class="section">
            <h2 class="section-heading">RUTE LARI</h2>
            <div class="route-grid">
                <article class="route-card">
                    <h3>7 KILOMETER</h3>
                    <p>Rute lari kategori 7K MUSI RUN VII.</p>
                    <div class="route-placeholder"><div><strong>FOTO RUTE SEGERA HADIR</strong><span>Area ini siap untuk foto rute 7K.</span></div></div>
                    <div class="route-meta"><span>Jarak</span>7 KM</div>
                </article>
                <article class="route-card">
                    <h3>12 KILOMETER</h3>
                    <p>Rute lari kategori 12K MUSI RUN VII.</p>
                    <div class="route-placeholder"><div><strong>FOTO RUTE SEGERA HADIR</strong><span>Area ini siap untuk foto rute 12K.</span></div></div>
                    <div class="route-meta"><span>Jarak</span>12 KM</div>
                </article>
            </div>
        </section>
        <a class="cta" href="{{ url('/registrasi') }}">Daftar Sekarang</a>
    </main>
</body>
</html>
