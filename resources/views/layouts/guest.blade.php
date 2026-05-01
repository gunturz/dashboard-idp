<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IDP Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Tailwind CDN for ngrok/remote testing -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .login-bg {
            background-image:
                linear-gradient(135deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.8) 100%),
                url("{{ asset('asset/Gambar%20TS.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: #1e293b;
            /* fallback color */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 1.5rem 2.5rem;
            width: 100%;
            max-width: 440px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }

        .login-card::-webkit-scrollbar {
            width: 5px;
        }

        .login-card::-webkit-scrollbar-track {
            background: transparent;
        }

        .login-card::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 99px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        .login-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            text-align: center;
            line-height: 1.3;
            letter-spacing: -0.5px;
            margin-bottom: 1.25rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .login-logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .login-logo-wrapper img {
            height: 64px;
            width: 64px;
            object-fit: contain;
            background: white;
            padding: 8px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .login-subtitle {
            font-size: 0.8rem;
            color: #94a3b8;
            text-align: center;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.5rem;
            letter-spacing: 0.2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 16px;
            height: 16px;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            font-size: 0.9rem;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            transition: all 0.25s ease;
            outline: none;
            box-sizing: border-box;
            backdrop-filter: blur(5px);
        }

        .form-input::placeholder {
            color: #cbd5e1;
            font-style: italic;
        }

        .form-input:focus {
            border-color: #22c55e;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
        }

        /* Fix for Browser Autofill (Putih saat ngetik/isi otomatis) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 50px #0f172a inset !important;
            /* Gunakan warna gelap yg konsisten */
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-input:focus+.input-icon,
        .input-wrapper:focus-within .input-icon {
            color: #22c55e;
        }

        .password-toggle {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #64748b;
        }

        .password-toggle svg {
            width: 17px;
            height: 17px;
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.78rem;
            color: #10b981;
            text-decoration: none;
            margin-top: 0.4rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #059669;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 0.95rem 1.5rem;
            background: linear-gradient(135deg, #0d9488, #10b981);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px -5px rgba(13, 148, 136, 0.4);
            letter-spacing: 0.5px;
            margin-top: 1.25rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0f766e, #059669);
            box-shadow: 0 15px 25px -5px rgba(13, 148, 136, 0.5);
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
            background: linear-gradient(135deg, #115e59, #065f46);
            box-shadow: 0 5px 15px rgba(13, 148, 136, 0.3);
        }

        .btn-login svg {
            width: 18px;
            height: 18px;
        }

        .register-link-text {
            text-align: center;
            font-size: 0.82rem;
            color: #94a3b8;
            margin-top: 0.75rem;
        }

        .register-link-text a {
            color: #10b981;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-link-text a:hover {
            color: #059669;
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 1.5rem 0;
        }

        /* ── SELECT DROPDOWN ── */
        .social-divider {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin: 0.75rem 0;
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.18);
        }

        .btn-social-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.9rem;
            padding: 0.95rem 1.25rem;
            border-radius: 14px;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.96);
            color: #111827;
            font-size: 1rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 12px 22px -10px rgba(15, 23, 42, 0.45);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
        }

        .btn-social-google:hover {
            transform: translateY(-2px);
            background: #ffffff;
            box-shadow: 0 16px 28px -12px rgba(15, 23, 42, 0.55);
        }

        .btn-social-google:active {
            transform: translateY(0);
        }

        .btn-social-google svg {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .google-error-message {
            margin-top: 0.75rem;
        }

        .form-select {
            width: 100%;
            padding: 0.8rem 2.4rem 0.8rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            font-size: 0.9rem;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%23ffffff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px;
            appearance: none;
            -webkit-appearance: none;
            transition: all 0.25s ease;
            outline: none;
            cursor: pointer;
            box-sizing: border-box;
            backdrop-filter: blur(5px);
        }

        .form-select:focus {
            border-color: #22c55e;
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
        }

        .form-select:invalid {
            color: #cbd5e1;
            font-style: italic;
        }

        .form-select option {
            background-color: #1e293b;
            /* Background gelap saat list dropdown terbuka */
            color: #ffffff;
            font-style: normal;
        }

        .form-select option[value=''][disabled] {
            color: rgba(255, 255, 255, 0.4);
            font-style: italic;
        }

        .session-status {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1rem;
        }

        /* ── NOTIFIKASI SUKSES REGISTRASI ── */
        .reg-success-alert {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1.5px solid #86efac;
            border-radius: 10px;
            padding: 0.9rem 1rem;
            margin-bottom: 1.25rem;
            animation: slideUp 0.5s ease-out;
        }

        .reg-success-icon {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            color: #16a34a;
            margin-top: 1px;
        }

        .reg-success-icon svg {
            width: 22px;
            height: 22px;
        }

        .reg-success-text {
            font-size: 0.82rem;
            font-weight: 500;
            color: #15803d;
            line-height: 1.55;
            margin: 0;
        }

        /* ── FORGOT PASSWORD ── */
        .fp-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .fp-icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-radius: 10px;
            margin-bottom: 1rem;
            color: #16a34a;
        }

        .fp-icon-wrap svg {
            width: 28px;
            height: 28px;
        }

        .fp-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.35;
            letter-spacing: -0.3px;
            margin-bottom: 0.5rem;
        }

        .fp-subtitle {
            font-size: 0.82rem;
            color: #94a3b8;
            font-weight: 400;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="login-bg flex items-center justify-center px-4 py-8">

        <div class="login-card">
            <!-- Title hanya muncul di halaman login -->
            @if (request()->routeIs('login'))
                <div class="login-logo-wrapper">
                    <img src="{{ asset('asset/logo%20ts.png') }}" alt="Logo">
                </div>
                <h1 class="login-title">Individual<br>Development Plan</h1>
            @endif

            {{ $slot }}
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>

</html>