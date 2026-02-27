<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IDP Dashboard') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .login-bg {
            background: #4B586F;
            min-height: 100vh;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35), 0 8px 20px rgba(0, 0, 0, 0.15);
            padding: 2.5rem 2.5rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
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
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            text-align: center;
            line-height: 1.35;
            letter-spacing: -0.3px;
            margin-bottom: 1.75rem;
        }

        .login-subtitle {
            font-size: 0.8rem;
            color: #94a3b8;
            text-align: center;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.45rem;
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
            padding: 0.7rem 1rem 0.7rem 2.6rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.25s ease;
            outline: none;
            box-sizing: border-box;
        }

        .form-input::placeholder {
            color: #cbd5e1;
            font-style: italic;
        }

        .form-input:focus {
            border-color: #22c55e;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12);
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
            color: #22c55e;
            text-decoration: none;
            margin-top: 0.4rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #16a34a;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 0.8rem 1rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);
            letter-spacing: 0.2px;
            margin-top: 1.6rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(34, 197, 94, 0.3);
        }

        .btn-login svg {
            width: 18px;
            height: 18px;
        }

        .register-link-text {
            text-align: center;
            font-size: 0.82rem;
            color: #94a3b8;
            margin-top: 1.2rem;
        }

        .register-link-text a {
            color: #22c55e;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-link-text a:hover {
            color: #16a34a;
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



        .session-status {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-bg flex items-center justify-center px-4 py-8">

        <div class="login-card">
            <!-- Title -->
            <h1 class="login-title">Individual<br>Development Plan</h1>

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
