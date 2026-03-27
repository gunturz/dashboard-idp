@props([
    'title' => 'Atasan – Individual Development Plan',
    'user' => null,
])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

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

        .dropdown-panel {
            transform-origin: top right;
            animation: dropIn 0.18s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @keyframes dropIn {
            from { opacity: 0; transform: scale(0.95) translateY(-6px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .nav-link-item {
            padding: 0 16px;
            height: 100%;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
            text-decoration: none;
        }

        .nav-link-item:hover {
            color: white;
        }

        .nav-link-item.active {
            color: white;
            font-weight: 700;
        }

        /* ── Mobile Dropdown Nav Links Overlay ── */
        .dropdown-panel .mobile-nav-link {
            color: #475569;
            font-weight: 500;
        }
        .dropdown-panel .mobile-nav-link:hover {
            color: #005ba1;
            background-color: #f8fafc;
        }
        .dropdown-panel .mobile-nav-link.active {
            color: #005ba1;
            font-weight: 700;
            background-color: #f8fafc;
        }

        /* ══════════════════════════════════════════════════════
           MOBILE ONLY STYLES — does NOT affect desktop (≥1024px)
           ══════════════════════════════════════════════════════ */

        @media (max-width: 1023px) {
            .navbar-outer {
                padding: 12px 16px;
            }
            .nav-icon-btn {
                width: 38px;
                height: 38px;
            }
            .notif-badge {
                width: 7px;
                height: 7px;
            }
            body {
                padding-top: 60px !important;
            }
        }

        /* Prevent horizontal scroll on mobile */
        @media (max-width: 767px) {
            html, body {
                overflow-x: hidden !important;
                max-width: 100vw;
            }
            main {
                padding: 16px !important;
            }
        }
    </style>
    {{ $styles ?? '' }}
</head>

<body class="bg-white min-h-screen pt-[80px]">

    <div class="navbar-outer">
        {{-- Logo + Title --}}
        <a href="{{ route('atasan.dashboard') }}" class="flex items-center gap-2 lg:gap-4 flex-shrink-0 hover:opacity-90 transition-opacity">
            <div class="bg-white p-1.5 lg:p-2 rounded-[8px] lg:rounded-[10px] shadow-sm flex items-center justify-center w-10 h-10 lg:w-14 lg:h-14">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
            </div>
            {{-- Desktop: Full title --}}
            <h1 class="text-white text-base lg:text-xl font-bold tracking-wide whitespace-nowrap hidden sm:block">
                Individual Development Plan
            </h1>
            {{-- Mobile: Short title --}}
            <h1 class="text-white text-base font-bold tracking-wide whitespace-nowrap sm:hidden block truncate max-w-[150px]">
                IDP Atasan
            </h1>
        </a>

        {{-- Desktop Nav Links (hidden on mobile) --}}
        <div class="hidden lg:flex items-center ml-auto h-full gap-6 mr-6">
            <a href="{{ route('atasan.dashboard') }}"
               class="nav-link-item {{ request()->routeIs('atasan.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('atasan.monitoring') }}"
               class="nav-link-item {{ request()->routeIs('atasan.monitoring') ? 'active' : '' }}">
                Monitoring
            </a>
        </div>

        <div class="flex items-center space-x-2 sm:space-x-3 pl-0 lg:pl-4 border-l-0 lg:border-l border-white/20 lg:ml-0 ml-auto">

            {{-- ═══ Mobile Hamburger Menu (visible only on mobile <1024px) ═══ --}}
            <div class="relative block lg:hidden" id="mobile-menu-wrapper">
                <button class="flex items-center justify-center p-2 text-white hover:bg-white/10 rounded-[8px] transition-all cursor-pointer" aria-label="Menu" id="mobile-menu-btn" onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div id="mobile-menu-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-[300px] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
                    {{-- User profile header --}}
                    <div class="px-5 py-5 border-b border-gray-100 flex items-center justify-between bg-white relative">
                        <div class="flex items-center gap-3.5">
                            @php
                                $nameParts = explode(' ', $user->nama ?? $user->name);
                                $initials = count($nameParts) >= 2 ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1)) : strtoupper(substr($nameParts[0], 0, 2));
                            @endphp
                            <div class="w-[52px] h-[52px] rounded-full bg-[#466675] text-white flex items-center justify-center font-bold text-lg tracking-wide outline outline-1 outline-[#003865]/20 ring-[3px] ring-white shadow-sm flex-shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-bold text-[#001e36] uppercase tracking-[0.02em] leading-snug break-words line-clamp-2 max-w-[130px]">{{ $user->nama ?? $user->name }}</span>
                                <a href="{{ route('profile.edit') }}" class="text-[#005ba1] font-semibold text-[13px] mt-0.5 inline-flex items-center group hover:underline">
                                    Lihat Profil
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation menu items --}}
                    <ul class="py-3 px-3">
                        <li class="mb-1">
                            <a href="{{ route('atasan.dashboard') }}" class="mobile-nav-link flex items-center w-full px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap {{ request()->routeIs('atasan.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('atasan.monitoring') }}" class="mobile-nav-link flex items-center w-full px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap {{ request()->routeIs('atasan.monitoring') ? 'active' : '' }}">
                                Monitoring
                            </a>
                        </li>
                        <li class="border-t border-gray-100 mt-2 pt-2">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-3 rounded-xl text-[14px] text-red-500 hover:bg-red-50 transition-colors font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- ═══ Desktop: Notification (hidden on mobile) ═══ --}}
            <div class="relative hidden lg:block" id="bell-wrapper">
                <button class="nav-icon-btn" aria-label="Notifikasi" id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    <span class="notif-badge"></span>
                </button>
                <div id="bell-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-700">Notifikasi</span>
                    </div>
                    <div class="p-4 text-center text-gray-400 text-xs text-sm">Belum ada notifikasi baru</div>
                </div>
            </div>

            {{-- ═══ Desktop: Profile (hidden on mobile) ═══ --}}
            <div class="relative hidden lg:block" id="profile-wrapper">
                <button class="nav-icon-btn" aria-label="Profil" id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="profile-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ $user->nama ?? $user->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $user->email }}</p>
                    </div>
                    <ul class="py-1">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Lihat Profil
                            </a>
                        </li>
                        <li class="border-t border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="p-8 max-w-7xl mx-auto">
        {{ $slot }}
    </main>

    <script>
        // ── Hide navbar on scroll down, show on scroll up (mobile behavior like talent) ──
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

        function toggleDropdown(dropdownId, btnId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
            if (isHidden) dropdown.classList.remove('hidden');
        }

        document.addEventListener('click', function(e) {
            const wrappers = ['bell-wrapper', 'profile-wrapper', 'mobile-menu-wrapper'];
            const clickedInside = wrappers.some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!clickedInside) {
                document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
            }
        });
    </script>
    {{ $scripts ?? '' }}
</body>

</html>
