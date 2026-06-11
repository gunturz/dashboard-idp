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
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #14b8a6;
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0d9488;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #14b8a6 transparent;
        }

        /* ── Custom Scrollbar Utility ── */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 99px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #14b8a6 !important;
            border-radius: 99px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #0d9488 !important;
        }

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
            background-color: #ffffff;
        }
        .bg-decoration::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(#cbd5e1 0.7px, transparent 0.7px);
            background-size: 32px 32px;
            opacity: 0.3;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased relative overflow-x-hidden">
    <div class="bg-decoration">
    </div>

    <div class="min-h-screen bg-transparent">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-[#f9fafb] border-b border-gray-200 shadow-sm">
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
