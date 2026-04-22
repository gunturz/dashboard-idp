<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        /* ── Background Decoration ── */
        .bg-decoration {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
            background-color: #f0f4f8;
            background-image: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.08) 100px, transparent 50%);
        }
        .bg-decoration::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(#cbd5e1 0.7px, transparent 0.7px);
            background-size: 32px 32px;
            opacity: 0.3;
        }
        .bg-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.35;
            animation: blob-float 35s infinite alternate ease-in-out;
        }
        @keyframes blob-float {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            33% { transform: translate(60px, -80px) scale(1.2) rotate(120deg); }
            66% { transform: translate(-40px, 40px) scale(0.8) rotate(240deg); }
            100% { transform: translate(0, 0) scale(1) rotate(360deg); }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased relative">
    {{-- DECORATIVE BACKGROUND --}}
    <div class="bg-decoration">
        <div class="bg-blob w-[800px] h-[800px] bg-blue-200/30 -top-64 -left-64"></div>
        <div class="bg-blob w-[600px] h-[600px] bg-indigo-200/30 top-1/2 -right-32" style="animation-delay: -5s;"></div>
        <div class="bg-blob w-[900px] h-[900px] bg-sky-200/20 -bottom-48 left-1/4" style="animation-delay: -10s;"></div>
        <div class="bg-blob w-[500px] h-[500px] bg-blue-100/40 top-1/4 left-1/2" style="animation-delay: -15s;"></div>
    </div>

    <div class="min-h-screen bg-transparent">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- TOMBOL KELUAR (FIXED POJOK KIRI BAWAH) -->
    <div class="fixed bottom-6 left-6 z-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full shadow-lg transition-all transform hover:scale-105 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</body>

</html>
