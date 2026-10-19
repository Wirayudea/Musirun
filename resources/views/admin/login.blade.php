<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#101828">
    <title>Masuk Admin - MUSI RUN VII</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --navy: #101828;
            --navy-soft: #18263a;
            --orange: #ff9f0a;
            --muted: #667085;
            --line: #e7ebf2;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 28px;
            color: var(--navy);
            background:
                radial-gradient(ellipse at 12% 12%, rgba(255, 159, 10, .12), transparent 32%),
                #f4f6f9;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        .login-layout {
            width: min(100%, 960px);
            min-height: 570px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(16, 24, 40, .06);
            border-radius: 24px;
            box-shadow: 0 28px 80px rgba(16, 24, 40, .12);
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100%;
            overflow: hidden;
            padding: 42px;
            color: #fff;
            background: linear-gradient(145deg, var(--navy-soft), var(--navy) 72%);
        }

        .brand-panel::before,
        .brand-panel::after {
            position: absolute;
            z-index: 0;
            content: "";
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 390px;
            height: 390px;
            right: -175px;
            bottom: -90px;
            box-shadow: 0 0 0 34px rgba(255, 255, 255, .025), 0 0 0 70px rgba(255, 255, 255, .02);
        }

        .brand-panel::after {
            width: 220px;
            height: 220px;
            top: 32%;
            right: -105px;
            border-color: rgba(255, 159, 10, .35);
        }

        .brand-content { position: relative; z-index: 1; }

        .brand-lockup {
            display: inline-flex;
            align-items: center;
            gap: 13px;
            color: #fff;
            text-decoration: none;
        }

        .brand-logo {
            width: 58px;
            height: 58px;
            padding: 5px;
            border-radius: 15px;
            background: #fff;
            object-fit: contain;
        }

        .brand-name {
            display: block;
            font-size: 1.02rem;
            font-weight: 850;
            letter-spacing: .08em;
        }

        .brand-edition {
            display: block;
            margin-top: 2px;
            color: rgba(255, 255, 255, .65);
            font-size: .75rem;
            letter-spacing: .13em;
        }

        .brand-message { margin: 68px 0 46px; }

        .brand-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            color: #ffd28b;
            font-size: .76rem;
            font-weight: 750;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        .brand-kicker::before {
            width: 22px;
            height: 2px;
            content: "";
            background: var(--orange);
        }

        .brand-message h1 {
            max-width: 370px;
            margin: 0 0 16px;
            font-size: clamp(2.2rem, 4vw, 3.1rem);
            font-weight: 800;
            letter-spacing: -.055em;
            line-height: 1.08;
        }

        .brand-message h1 span { color: var(--orange); }

        .brand-message p {
            max-width: 340px;
            margin: 0;
            color: rgba(255, 255, 255, .7);
            font-size: .96rem;
            line-height: 1.7;
        }

        .brand-footer {
            position: relative;
            z-index: 1;
            margin: 0;
            color: rgba(255, 255, 255, .52);
            font-size: .78rem;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px clamp(28px, 6vw, 66px);
        }

        .login-form { width: 100%; max-width: 360px; }

        .form-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            margin-bottom: 24px;
            border-radius: 14px;
            color: #ad6800;
            background: #fff4df;
            font-size: 1.25rem;
        }

        .form-heading {
            margin: 0;
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -.045em;
        }

        .form-subtitle {
            margin: 8px 0 30px;
            color: var(--muted);
            font-size: .93rem;
            line-height: 1.6;
        }

        .form-label {
            margin-bottom: 8px;
            color: #344054;
            font-size: .84rem;
            font-weight: 700;
        }

        .input-wrap { position: relative; }

        .input-wrap > .bi {
            position: absolute;
            top: 50%;
            left: 15px;
            color: #98a2b3;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .form-control {
            min-height: 50px;
            padding: 12px 15px 12px 44px;
            border-color: var(--line);
            border-radius: 11px;
            color: var(--navy);
            font-size: .92rem;
            box-shadow: none;
        }

        .form-control::placeholder { color: #a0a8b5; }
        .form-control:focus { border-color: var(--orange); box-shadow: 0 0 0 4px rgba(255, 159, 10, .13); }
        .password-input { padding-right: 48px; }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 8px;
            color: #667085;
            background: transparent;
            transform: translateY(-50%);
        }

        .password-toggle:hover { color: var(--navy); background: #f2f4f7; }
        .password-toggle:focus-visible { outline: 3px solid rgba(255, 159, 10, .4); }

        .form-check-input { border-color: #cbd2dc; }
        .form-check-input:checked { border-color: var(--orange); background-color: var(--orange); }
        .form-check-input:focus { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(255, 159, 10, .15); }
        .form-check-label { color: #475467; font-size: .84rem; }

        .btn-login {
            min-height: 50px;
            border: 0;
            border-radius: 11px;
            color: #fff;
            background: var(--navy);
            font-size: .92rem;
            font-weight: 750;
            transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .btn-login:hover {
            color: #fff;
            background: #24364f;
            box-shadow: 0 8px 18px rgba(16, 24, 40, .17);
            transform: translateY(-1px);
        }

        .btn-login:focus-visible { outline: 3px solid rgba(255, 159, 10, .48); outline-offset: 3px; }

        .login-note {
            display: flex;
            justify-content: center;
            gap: 7px;
            margin: 25px 0 0;
            color: #98a2b3;
            font-size: .77rem;
        }

        @media (max-width: 700px) {
            body { display: block; padding: 16px; }
            .login-layout { max-width: 460px; min-height: 0; grid-template-columns: 1fr; margin: 3vh auto; border-radius: 20px; }
            .brand-panel { min-height: auto; padding: 25px 26px 27px; }
            .brand-logo { width: 48px; height: 48px; border-radius: 13px; }
            .brand-message { margin: 30px 0 0; }
            .brand-message h1 { max-width: 330px; font-size: 2rem; }
            .brand-message p { font-size: .88rem; }
            .brand-footer { display: none; }
            .form-panel { padding: 34px 26px 32px; }
            .form-icon { width: 43px; height: 43px; margin-bottom: 19px; }
            .form-heading { font-size: 1.65rem; }
            .form-subtitle { margin-bottom: 24px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <main class="login-layout">
        <section class="brand-panel" aria-label="MUSI RUN VII">
            <div class="brand-content">
                <a class="brand-lockup" href="{{ route('admin.login') }}" aria-label="MUSI RUN VII">
                    <img class="brand-logo" src="{{ asset('assets/images/logo.png') }}" alt="Logo MUSI RUN">
                    <span>
                        <span class="brand-name">MUSI RUN</span>
                        <span class="brand-edition">EDISI VII</span>
                    </span>
                </a>

                <div class="brand-message">
                    <div class="brand-kicker">Panel pengelola</div>
                    <h1>Setiap langkah, <span>lebih berarti.</span></h1>
                    <p>Kelola pendaftaran dan informasi peserta MUSI RUN dari satu tempat.</p>
                </div>
            </div>
            <p class="brand-footer">© {{ date('Y') }} MUSI RUN VII · Panel Admin</p>
        </section>

        <section class="form-panel" aria-labelledby="login-heading">
            <div class="login-form">
                <div class="form-icon" aria-hidden="true"><i class="bi bi-person-lock"></i></div>
                <h2 class="form-heading" id="login-heading">Selamat datang</h2>
                <p class="form-subtitle">Masuk menggunakan akun administrator Anda.</p>

                @if($errors->any())
                    <div class="alert alert-danger py-2 px-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-circle me-1" aria-hidden="true"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope" aria-hidden="true"></i>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="nama@contoh.com"
                                autocomplete="username"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock" aria-hidden="true"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control password-input"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >
                            <button class="password-toggle" type="button" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <button class="btn btn-login w-100" type="submit">
                        Masuk ke dashboard <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                    </button>
                </form>

                <p class="login-note"><i class="bi bi-shield-lock" aria-hidden="true"></i>Akses khusus administrator</p>
            </div>
        </section>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('togglePassword');

        passwordToggle.addEventListener('click', () => {
            const showingPassword = passwordInput.type === 'password';
            passwordInput.type = showingPassword ? 'text' : 'password';
            passwordToggle.setAttribute('aria-pressed', String(showingPassword));
            passwordToggle.setAttribute('aria-label', showingPassword ? 'Sembunyikan password' : 'Tampilkan password');
            passwordToggle.innerHTML = `<i class="bi ${showingPassword ? 'bi-eye-slash' : 'bi-eye'}" aria-hidden="true"></i>`;
        });
    </script>
</body>
</html>
