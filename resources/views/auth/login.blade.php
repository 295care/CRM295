<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CRM 295 Solution</title>

    {{-- ===== SEO & Open Graph (WhatsApp / Social Preview) ===== --}}
    <meta name="title" content="Login - CRM 295 Solution">
    <meta name="description" content="Sistem CRM internal 295 Solution untuk manajemen klien dan tracking penawaran untuk performa tim sales yang lebih baik.">

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ url()->current() }}">
    <meta property="og:title"        content="Login - CRM 295 Solution">
    <meta property="og:description"  content="Sistem CRM internal 295 Solution untuk manajemen klien dan tracking penawaran untuk performa tim sales yang lebih baik.">
    <meta property="og:image"        content="{{ asset('images/og-preview.png') }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name"    content="295 Solution">
    <meta property="og:locale"       content="id_ID">

    {{-- Twitter --}}
    <meta property="twitter:card"        content="summary_large_image">
    <meta property="twitter:url"         content="{{ url()->current() }}">
    <meta property="twitter:title"       content="Login - CRM 295 Solution">
    <meta property="twitter:description" content="Sistem CRM internal 295 Solution untuk manajemen klien dan tracking penawaran untuk performa tim." >
    <meta property="twitter:image"       content="{{ asset('images/og-preview.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Inter', system-ui, sans-serif;
            background: #1a3a42;
        }

        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(26,107,116,0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(15,60,70,0.4) 0%, transparent 40%);
            pointer-events: none;
        }

        .login-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
        }

        /* Brand mark above card */
        .brand-mark {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-mark h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
        }

        .brand-mark p {
            margin: 6px 0 0;
            color: rgba(255,255,255,0.55);
            font-size: 13px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.35);
        }

        .card-title {
            margin: 0 0 6px;
            font-size: 18px;
            font-weight: 700;
            color: #1e2022;
        }

        .card-subtitle {
            margin: 0 0 24px;
            color: #8a929e;
            font-size: 13px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #4b5563;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: inherit;
            background: #f9fafb;
            color: #1f2937;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1a6b74;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,107,116,0.12);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 16px 0 20px;
        }

        .remember-row label {
            margin: 0;
            font-size: 13px;
            text-transform: none;
            letter-spacing: 0;
            color: #6b7280;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            border: none;
            border-radius: 8px;
            padding: 11px 16px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            color: #fff;
            background: #1a6b74;
            cursor: pointer;
            transition: background 0.15s, box-shadow 0.15s;
        }

        .btn-login:hover {
            background: #155d66;
            box-shadow: 0 4px 14px rgba(26,107,116,0.3);
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="brand-mark">
            <h1>CRM 295</h1>
            <p>Customer Relationship Management</p>
        </div>

        <div class="card">
            <h2 class="card-title">Masuk ke Akun</h2>
            <p class="card-subtitle">Gunakan username dan password yang diberikan admin.</p>

            @if ($errors->any())
                <div class="alert-error">
                    <strong>Login gagal.</strong> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" required autofocus placeholder="Masukkan username Anda">
                    @error('username')
                        <div style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••">
                </div>

                <div class="remember-row">
                    <input id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat saya</label>
                </div>

                <button class="btn-login" type="submit">Masuk ke CRM</button>
            </form>
        </div>
    </div>
</body>
</html>
