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

        /* ── Dropdown panel ── */
        .dropdown-panel {
            transform-origin: top right;
            animation: dropIn 0.18s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @keyframes dropIn {
            from { opacity: 0; transform: scale(0.95) translateY(-6px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ── Nav menu links (active bold) ── */
        .nav-menu-link {
            transition: color 0.2s, border-color 0.2s;
        }

        .nav-menu-link.active {
            color: #ffffff !important;
            border-bottom-width: 2px !important;
            border-bottom-color: #14b8a6 !important;
            border-bottom-style: solid !important;
        }

        /* Mobile Dropdown Nav Links Overlay */
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

<body class="bg-white min-h-screen pt-[80px] flex flex-col">

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

        {{-- Desktop Nav Links --}}
        <div class="hidden xl:flex items-center gap-8 ml-auto pr-8">
            <a href="{{ route('atasan.dashboard') }}"
                class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150
                {{ request()->routeIs('atasan.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('atasan.monitoring') }}"
                class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150
                {{ request()->routeIs('atasan.monitoring') ? 'active' : '' }}">
                Monitoring
            </a>
        </div>

        <div class="flex items-center space-x-2 sm:space-x-3 pl-0 lg:pl-4 border-l-0 lg:border-l border-white/20 lg:ml-0 ml-auto">

            <!-- Mobile Dropdown Menu -->
            <div class="relative block lg:hidden" id="mobile-menu-wrapper">
                <button class="flex items-center justify-center p-2 text-white hover:bg-white/10 rounded-[8px] transition-all cursor-pointer" aria-label="Menu" id="mobile-menu-btn" onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div id="mobile-menu-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-[300px] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
                    <div class="px-5 py-5 border-b border-gray-100 flex items-center justify-between bg-white relative">
                        <div class="flex items-center gap-3.5">
                            @php
                                $nameParts = explode(' ', $user->nama ?? ($user->name ?? 'User'));
                                $initials = count($nameParts) >= 2 ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1)) : strtoupper(substr($nameParts[0], 0, 2));
                            @endphp
                            <div class="w-[52px] h-[52px] rounded-full bg-[#466675] text-white flex items-center justify-center font-bold text-lg tracking-wide outline outline-1 outline-[#003865]/20 ring-[3px] ring-white shadow-sm flex-shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-bold text-[#001e36] uppercase tracking-[0.02em] leading-snug break-words line-clamp-2 max-w-[130px]">{{ $user->nama ?? ($user->name ?? 'User') }}</span>
                                <a href="{{ route('profile.edit') }}" class="text-[#005ba1] font-semibold text-[13px] mt-0.5 inline-flex items-center group hover:underline">
                                    Lihat Profil
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <ul class="py-3 px-3">
                        <li class="mb-1">
                            <a href="{{ route('atasan.dashboard') }}" class="mobile-nav-link block px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap {{ request()->routeIs('atasan.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('atasan.monitoring') }}" class="mobile-nav-link block px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap {{ request()->routeIs('atasan.monitoring') ? 'active' : '' }}">
                                Monitoring
                            </a>
                        </li>
                        <li class="border-t border-gray-100 mt-2 pt-2">
                            @if(Auth::user() && Auth::user()->roles->count() > 1)
                                <a href="{{ route('role.select') }}" class="w-full flex items-center gap-2.5 px-4 py-3 rounded-xl text-[14px] text-[#005ba1] hover:bg-[#f8fafc] transition-colors font-medium mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Ganti Role
                                </a>
                            @endif
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
                @php
                    $rawNotif = \App\Models\AppNotification::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
                    $unreadNotifications = $rawNotif->where('is_read', false)->map(function ($n) {
                        return [
                            'title' => $n->title,
                            'desc'  => $n->desc,
                            'time'  => $n->created_at->diffForHumans(),
                        ];
                    });
                    $hasUnreadNotif = $unreadNotifications->count() > 0;
                @endphp
                <button id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')" aria-label="Notifikasi"
                    class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    @if($hasUnreadNotif)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#14b8a6] rounded-full">
                            <span class="absolute inset-0 rounded-full bg-[#14b8a6] animate-ping opacity-75"></span>
                        </span>
                    @endif
                </button>

                <div id="bell-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-5 py-3.5 bg-gradient-to-r from-[#2e3746] to-[#38475a] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            <span class="text-sm font-bold text-white">Notifikasi</span>
                        </div>
                        <form action="{{ route('atasan.notifikasi.markAllRead') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                                Tandai semua
                            </button>
                        </form>
                    </div>

                    @if($hasUnreadNotif)
                        <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto">
                            @foreach($unreadNotifications->take(3) as $notif)
                                <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('atasan.notifikasi') }}'">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{!! $notif['title'] !!}</p>
                                        <p class="text-xs text-gray-500 truncate">{!! $notif['desc'] ?? $notif['time'] !!}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center py-10 text-center px-4">
                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi</p>
                            <p class="text-gray-400 text-xs mt-1">Anda sudah up to date!</p>
                        </div>
                    @endif

                    <div class="px-5 py-3 border-t border-gray-100 text-center">
                        <a href="{{ route('atasan.notifikasi') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                            Lihat semua notifikasi →
                        </a>
                    </div>
                </div>
            </div>

            {{-- ═══ Desktop: Profile (hidden on mobile) ═══ --}}
            <div class="relative hidden lg:block" id="profile-wrapper">
                <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')" aria-label="Profil"
                    class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                    
                    @php
                        $namaLengkap = $user->nama ?? ($user->name ?? 'User');
                        $partsProfile = explode(' ', trim($namaLengkap));
                        $initialsProfile = strtoupper(substr($partsProfile[0], 0, 1) . (isset($partsProfile[1]) ? substr($partsProfile[1], 0, 1) : ''));
                    @endphp
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0" style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                        {{ $initialsProfile }}
                    </div>

                    <div class="hidden lg:block text-left">
                        <p class="text-white text-sm font-semibold leading-tight max-w-[120px] truncate">{{ $namaLengkap }}</p>
                        <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">Atasan</p>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white/60 hidden lg:block flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="profile-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-4 bg-gradient-to-br from-[#2e3746] to-[#38475a]">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-sm" style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initialsProfile }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-white truncate">{{ $namaLengkap }}</p>
                                <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                                <span class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">Atasan</span>
                            </div>
                        </div>
                    </div>

                    <ul class="py-1.5">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#2e3746] flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500 group-hover:text-white transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span>Lihat Profil</span>
                            </a>
                        </li>
                        <li class="mx-3 border-t border-gray-100 my-1"></li>
                        @if(Auth::user()->roles->count() > 1)
                            <li>
                                <a href="{{ route('role.select') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#005ba1] hover:bg-[#f8fafc] transition-colors group">
                                    <div class="w-7 h-7 rounded-lg bg-[#e6f0f9] group-hover:bg-[#005ba1] flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#005ba1] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <span>Ganti Role</span>
                                </a>
                            </li>
                            <li class="mx-3 border-t border-gray-100 my-1"></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors group">
                                    <div class="w-7 h-7 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="px-8 py-8 w-full">
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
    {{-- FOOTER --}}
    <footer class="mt-auto bg-[#2e3746] py-5 text-center w-full">
        <span class="text-white text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>

    {{ $scripts ?? '' }}
</body>

</html>
