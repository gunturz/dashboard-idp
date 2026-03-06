<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi – Individual Development Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        /* ── Smooth entrance ── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeSlideUp 0.5s ease both;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.12s;
        }

        /* ── Title Animation ── */
        @keyframes titleReveal {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-title {
            animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        /* ── Navbar outer wrapper ── */
        .navbar-outer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            width: 100%;
            display: flex;
            align-items: center;
            background: #2e3746;
            padding: 1rem 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-outer.nav-hidden {
            transform: translateY(-110%);
        }

        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 9px;
            height: 9px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid white;
        }

        .nav-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
            color: #2e3746;
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.15s;
            position: relative;
        }

        .nav-icon-btn:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
            transform: translateY(-1px);
        }

        /* Notification Card Styles */
        .notif-card {
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .notif-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        .notif-unread {
            background-color: #f0fdf4;
            border-color: #86efac;
        }

        .notif-icon-wrap {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .icon-success {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #16a34a;
        }

        .icon-info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #2563eb;
        }

        .icon-warning {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #d97706;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col pt-[80px]">

    {{-- ══════════════════════════════ NAVBAR ══════════════════════════════ --}}
    <div class="navbar-outer">
        <div class="flex items-center gap-4 flex-shrink-0">
            <div class="bg-white p-2 rounded-[10px] shadow-sm flex items-center justify-center w-14 h-14">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white text-xl font-bold tracking-wide whitespace-nowrap">
                Individual Development Plan
            </h1>
        </div>

        <div class="flex items-center space-x-14 text-white text-sm font-medium ml-auto pr-6">
            <a href="{{ route('kandidat.dashboard') }}#Kompetensi"
                class="hover:text-blue-200 transition-colors duration-150">Kompetensi</a>
            <a href="{{ route('kandidat.dashboard') }}#IDP Monitoring"
                class="hover:text-blue-200 transition-colors duration-150">IDP</a>
            <a href="{{ route('kandidat.dashboard') }}#Project Improvement"
                class="hover:text-blue-200 transition-colors duration-150">Project Improvement</a>
            <a href="{{ route('kandidat.dashboard') }}#LogBook"
                class="hover:text-blue-200 transition-colors duration-150">LogBook</a>
        </div>

        <div class="flex items-center space-x-3 pl-4 border-l border-white/20">
            <a href="{{ route('kandidat.notifikasi') }}" class="nav-icon-btn" aria-label="Notifikasi">
                <span class="notif-badge"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                </svg>
            </a>
            <button class="nav-icon-btn" aria-label="Profil">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════ CONTENT AREA ══════════════════════════════ --}}
    <div class="w-full max-w-4xl mx-auto px-6 pt-10 pb-12 flex-grow fade-up fade-up-1">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h2 class="text-2xl font-bold text-[#2e3746] animate-title">Notifikasi</h2>
            </div>
            <button class="text-sm font-semibold text-teal-600 hover:text-teal-700 transition">Tandai semua
                dibaca</button>
        </div>

        {{-- Notifications List --}}
        <div class="space-y-3">

            {{-- Notif 1 (Unread, Success) --}}
            <div class="notif-card notif-unread">
                <div class="notif-icon-wrap icon-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-800 text-base">Submit IDP Berhasil</h3>
                        <span class="text-xs text-teal-600 font-semibold bg-teal-50 px-2 py-1 rounded-md">Baru</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2 leading-relaxed">Formulir <span
                            class="font-semibold">Exposure</span> Anda telah berhasil dikirim dan sedang menunggu
                        tinjauan dari mentor/atasan.</p>
                    <span class="text-xs text-gray-400 font-medium">10 menit yang lalu</span>
                </div>
            </div>

            {{-- Notif 2 (Info) --}}
            <div class="notif-card">
                <div class="notif-icon-wrap icon-info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-800 text-base">Review Mentor Selesai</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-2 leading-relaxed">Project Improvement Anda berjudul <span
                            class="font-semibold">"Sistem Logistik Baru"</span> telah direview oleh mentor Anda. Klik
                        untuk melihat feedback.</p>
                    <span class="text-xs text-gray-400 font-medium">2 jam yang lalu</span>
                </div>
            </div>

            {{-- Notif 3 (Warning) --}}
            <div class="notif-card">
                <div class="notif-icon-wrap icon-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-800 text-base">Pengingat LogBook</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-2 leading-relaxed">Anda belum mengisi LogBook untuk aktivitas
                        <span class="font-semibold">Mentoring</span> minggu ini. Pastikan untuk memperbaruinya segera.
                    </p>
                    <span class="text-xs text-gray-400 font-medium">Kemarin, 14:30</span>
                </div>
            </div>

            {{-- Notif 4 (Success) --}}
            <div class="notif-card">
                <div class="notif-icon-wrap icon-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-800 text-base">Pembaruan Kompetensi</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-2 leading-relaxed">Atasan Anda telah memberikan penilaian
                        kompetensi terbaru untuk Anda. Periksa grafik pada dashboard.</p>
                    <span class="text-xs text-gray-400 font-medium">3 hari yang lalu</span>
                </div>
            </div>

        </div>

    </div>

    {{-- FOOTER --}}
    <footer class="mt-auto bg-[#2e3746] py-5 text-center w-full">
        <span class="text-white text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>

    <script>
        (function() {
            const navbar = document.querySelector('.navbar-outer');
            let lastScrollY = window.scrollY;
            let ticking = false;

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        const currentScrollY = window.scrollY;
                        if (currentScrollY > lastScrollY && currentScrollY > 80) {
                            navbar.classList.add('nav-hidden');
                        } else {
                            navbar.classList.remove('nav-hidden');
                        }
                        lastScrollY = currentScrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        })();
    </script>
</body>

</html>
