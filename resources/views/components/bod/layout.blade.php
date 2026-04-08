@props([
    'title' => 'BOD – Individual Development Plan',
    'user' => null,
    'notifications' => null,
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

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

        /* ── Title Animation ── */
        @keyframes titleReveal {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .animate-title { animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both; }

        /* ── Navbar ── */
        .navbar-outer {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 50;
            width: 100%;
            height: 80px;
            display: flex;
            align-items: center;
            background: #2e3746;
            padding: 0 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        /* ── Dropdown panel ── */
        .dropdown-panel {
            transform-origin: top right;
            animation: dropIn 0.18s cubic-bezier(0.4, 0, 0.2, 1) both;
        }
        @keyframes dropIn {
            from { opacity: 0; transform: scale(0.95) translateY(-6px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ── Mobile Menu ── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 80px; left: 0; right: 0;
            background: #2e3746;
            flex-direction: column;
            padding: 1rem 1.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            z-index: 49;
        }
        .mobile-menu.open { display: flex; }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .mobile-menu { top: 60px; padding: 1rem; }
            .navbar-outer { height: 60px; padding: 0 16px; }
        }
    </style>
    {{ $styles ?? '' }}
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col pt-[60px] lg:pt-[80px]">

    {{-- ── NAVBAR ── --}}
    <div class="navbar-outer">

        {{-- Mobile hamburger --}}
        <button
            class="flex-shrink-0 xl:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-colors mr-3"
            onclick="toggleMobileMenu()" aria-label="Menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Logo + Title --}}
        <a href="{{ route('bod.dashboard') }}"
            class="flex items-center gap-3 hover:opacity-90 transition-opacity flex-shrink-0">
            <div class="hidden sm:flex items-center justify-center w-11 h-11 lg:w-12 lg:h-12 bg-white rounded-xl shadow-md flex-shrink-0 ring-2 ring-white/20">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 lg:w-9 lg:h-9 object-contain">
            </div>
            <div class="hidden sm:block">
                <h1 class="text-white font-extrabold text-lg lg:text-xl leading-tight tracking-wide">Individual
                    Development Plan</h1>
            </div>
            <h1 class="text-white font-bold text-base sm:hidden">BOD</h1>
        </a>

        {{-- Desktop Nav Links --}}
        <div class="hidden xl:flex items-center gap-8 ml-auto pr-8">
            <a href="{{ route('bod.dashboard') }}"
                class="text-sm font-semibold transition-colors pb-0.5
                {{ request()->routeIs('bod.dashboard') ? 'text-white border-b-2 border-[#14b8a6]' : 'text-white/60 hover:text-white' }}">
                Dashboard
            </a>
            <a href="{{ route('bod.history') }}"
                class="text-sm font-semibold transition-colors pb-0.5
                {{ request()->routeIs('bod.history') ? 'text-white border-b-2 border-[#14b8a6]' : 'text-white/60 hover:text-white' }}">
                History
            </a>
        </div>

        {{-- ── Right: Actions ── --}}
        <div class="flex items-center gap-2 pl-4 border-l border-white/20 flex-shrink-0">

            {{-- Notification Bell --}}
            @php
                $unreadNotifications = isset($notifications) && $notifications
                    ? (is_array($notifications) ? collect($notifications)->where('is_read', false) : $notifications->where('is_read', false))
                    : collect();
                $hasUnreadNotif = $unreadNotifications->count() > 0;
            @endphp
            <div class="relative" id="bell-wrapper">
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
                    @else
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#14b8a6] rounded-full">
                            <span class="absolute inset-0 rounded-full bg-[#14b8a6] animate-ping opacity-75"></span>
                        </span>
                    @endif
                </button>

                {{-- Bell Dropdown --}}
                <div id="bell-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-5 py-3.5 bg-gradient-to-r from-[#2e3746] to-[#38475a] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            <span class="text-sm font-bold text-white">Notifikasi</span>
                        </div>
                        <form action="{{ route('bod.notifikasi.markAllRead') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                                Tandai semua
                            </button>
                        </form>
                    </div>

                    @if($hasUnreadNotif)
                        <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto">
                            @foreach($unreadNotifications->take(3) as $notif)
                                <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer"
                                    onclick="window.location='{{ route('bod.notifikasi') }}'">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{!! $notif['title'] !!}</p>
                                        <p class="text-xs text-gray-500 truncate">{!! $notif['desc'] !!}</p>
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
                        <a href="{{ route('bod.notifikasi') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                            Lihat semua notifikasi →
                        </a>
                    </div>
                </div>
            </div>



            {{-- Profile --}}
            <div class="relative" id="profile-wrapper">
                @php
                    $nama = $user->nama ?? ($user->name ?? 'U');
                    $parts = explode(' ', trim($nama));
                    $initials = strtoupper(
                        substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''),
                    );
                @endphp
                <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')" aria-label="Profil"
                    class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">

                    {{-- Avatar with initials --}}
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                        {{ $initials }}
                    </div>

                    {{-- Name + Role (desktop) --}}
                    <div class="hidden lg:block text-left">
                        <p class="text-white text-sm font-semibold leading-tight max-w-[120px] truncate">
                            {{ $nama }}</p>
                        <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">BOD</p>
                    </div>

                    {{-- Chevron (desktop) --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5 text-white/60 hidden lg:block flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Profile Dropdown --}}
                <div id="profile-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    {{-- Header --}}
                    <div class="px-4 py-4 bg-gradient-to-br from-[#2e3746] to-[#38475a]">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-sm"
                                style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initials }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-white truncate">{{ $user->nama ?? ($user->name ?? '-') }}</p>
                                <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                                <span class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">BOD</span>
                            </div>
                        </div>
                    </div>

                    {{-- Menu Items --}}
                    <ul class="py-1.5">
                        <li>
                            <a href="{{ route('bod.profile') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#2e3746] flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 text-gray-500 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span>Lihat Profil</span>
                            </a>
                        </li>
                        <li class="mx-3 border-t border-gray-100 my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors group">
                                    <div class="w-7 h-7 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5 text-red-500 group-hover:text-white transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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

    {{-- Mobile Nav Menu --}}
    <div class="mobile-menu" id="mobile-menu">
        <a href="{{ route('bod.dashboard') }}"
            class="py-3 text-sm font-semibold border-b border-white/10
            {{ request()->routeIs('bod.dashboard') ? 'text-white' : 'text-white/60' }}">
            Dashboard
        </a>
        <a href="{{ route('bod.history') }}"
            class="py-3 text-sm font-semibold border-b border-white/10
            {{ request()->routeIs('bod.history') ? 'text-white' : 'text-white/60' }}">
            History
        </a>
        <a href="{{ route('bod.profile') }}"
            class="py-3 text-sm font-semibold border-b border-white/10
            {{ request()->routeIs('bod.profile') ? 'text-white' : 'text-white/60' }}">
            Profil Saya
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="py-3 text-sm font-semibold text-red-400 hover:text-red-300 transition-colors w-full text-left">
                Keluar
            </button>
        </form>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="flex-1">
        <main id="main-content" class="p-4 lg:p-8 min-h-[calc(100vh-80px)] bg-white mt-4 mx-4 md:mx-auto max-w-7xl lg:mt-8 rounded-xl shadow-sm border border-gray-100">
            {{ $slot }}
        </main>
    </div>

    {{-- FOOTER --}}
    <footer class="mt-8 bg-[#2e3746] py-5 text-center w-full">
        <span class="text-white text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>

    <script>
        function toggleDropdown(dropdownId, btnId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
            if (isHidden) dropdown.classList.remove('hidden');
        }

        document.addEventListener('click', function(e) {
            const wrappers = ['bell-wrapper', 'profile-wrapper'];
            const clickedInside = wrappers.some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!clickedInside) {
                document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
            }
        });

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }
    </script>
    {{ $scripts ?? '' }}
</body>

</html>
