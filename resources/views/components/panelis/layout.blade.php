@props([
    'title' => 'Panelis – Individual Development Plan',
    'user' => null,
    'notifications' => null,
])

@php
    $unreadNotifications =
        isset($notifications) && $notifications
            ? (is_array($notifications)
                ? collect($notifications)->where('is_read', false)
                : $notifications->where('is_read', false))
            : collect();
    $hasUnreadNotif = $unreadNotifications->count() > 0;

    $nama = $user->nama ?? ($user->name ?? 'Panelis');
    $parts = explode(' ', trim($nama));
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
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

        /* ── Navbar ── */
        .navbar-outer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            width: 100%;
            height: 80px;
            display: flex;
            align-items: center;
            background: #0f172a;
            padding: 0 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        /* ── Dropdown panel ── */
        .dropdown-panel {
            transform-origin: top right;
            animation: dropIn 0.18s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-6px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* ── Mobile Menu ── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            background: #0f172a;
            flex-direction: column;
            padding: 1rem 1.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            z-index: 49;
        }

        .mobile-menu.open {
            display: flex;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .mobile-menu {
                top: 60px;
                padding: 1rem;
            }

            .navbar-outer {
                height: 60px;
                padding: 0 16px;
            }
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
    {{ $styles ?? '' }}
    @vite(['resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#ffffff] min-h-screen flex flex-col pt-[60px] lg:pt-[80px] relative">

    <div class="bg-decoration">
    </div>

    {{-- ── NAVBAR ── --}}
    <div class="navbar-outer">

        {{-- Logo + Title --}}
        <a href="{{ route('panelis.dashboard') }}"
            class="flex items-center gap-3 hover:opacity-90 transition-opacity flex-shrink-0">
            <div
                class="hidden sm:flex items-center justify-center w-11 h-11 lg:w-12 lg:h-12 bg-white rounded-xl shadow-md flex-shrink-0 ring-2 ring-white/20">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 lg:w-9 lg:h-9 object-contain">
            </div>
            <div class="hidden sm:block">
                <h1 class="text-white font-extrabold text-lg lg:text-xl leading-tight tracking-wide">Individual
                    Development Plan</h1>
            </div>
            <h1 class="text-white text-base font-bold tracking-wide whitespace-nowrap sm:hidden flex items-center gap-2.5">
                <div class="flex items-center justify-center w-11 h-11 bg-white rounded-lg shadow-md flex-shrink-0 ring-2 ring-white/20">
                    <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                IDP Panelis
            </h1>
        </a>

        {{-- Desktop Nav Links --}}
        <div class="hidden xl:flex items-center gap-8 ml-auto pr-8">
            <a href="{{ route('panelis.dashboard') }}"
                class="text-sm font-semibold transition-colors pb-0.5
                {{ request()->routeIs('panelis.dashboard') ? 'text-white border-b-2 border-[#14b8a6]' : 'text-white/60 hover:text-white' }}">
                Dashboard
            </a>
            <a href="{{ route('panelis.history') }}"
                class="text-sm font-semibold transition-colors pb-0.5
                {{ request()->routeIs('panelis.history') ? 'text-white border-b-2 border-[#14b8a6]' : 'text-white/60 hover:text-white' }}">
                History
            </a>
        </div>

        {{-- ── Right: Actions ── --}}
        <div
            class="flex items-center space-x-2 sm:space-x-3 pl-0 lg:pl-4 border-l-0 lg:border-l border-white/20 lg:ml-0 ml-auto flex-shrink-0">

            <div class="hidden"></div>

            <div class="relative hidden lg:block" id="bell-wrapper">
                <button id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')" aria-label="Notifikasi"
                    class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    @if ($hasUnreadNotif)
                        @php
                            $unreadCount = $unreadNotifications->count();
                            $displayCount = $unreadCount > 99 ? '99+' : $unreadCount;
                        @endphp
                        <span id="bell-red-badge" class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] animate-bounce" style="animation-duration: 2s;">
                            {{ $displayCount }}
                        </span>
                        <span class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40"></span>
                    @endif
                </button>

                {{-- Bell Dropdown --}}
                <div id="bell-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div
                        class="px-5 py-3.5 bg-gradient-to-r from-[#0f172a] to-[#38475a] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            <span class="text-sm font-bold text-white">Notifikasi</span>
                        </div>
                        <form action="{{ route('panelis.notifikasi.markAllRead') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                                Tandai semua
                            </button>
                        </form>
                    </div>

                    @if ($hasUnreadNotif)
                        <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto" id="panelis-bell-list">
                            @foreach ($unreadNotifications->take(3) as $notif)
                                <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer"
                                    onclick="window.location='{{ route('panelis.notifikasi') }}'">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{!! $notif['title'] !!}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{!! $notif['desc'] !!}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center py-10 text-center px-4" id="panelis-bell-empty-state">
                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi</p>
                            <p class="text-gray-400 text-xs mt-1">Anda sudah up to date!</p>
                        </div>
                    @endif

                    <div class="px-5 py-3 border-t border-gray-100 text-center">
                        <a href="{{ route('panelis.notifikasi') }}"
                            class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                            Lihat semua notifikasi →
                        </a>
                    </div>
                </div>
            </div>



            {{-- Profile --}}
            <div class="relative hidden lg:block" id="profile-wrapper">
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
                        <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">Panelis</p>
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
                    <div class="px-4 py-4 bg-gradient-to-br from-[#0f172a] to-[#38475a]">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-sm"
                                style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initials }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-white truncate">
                                    {{ $user->nama ?? ($user->name ?? '-') }}</p>
                                <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                                <span
                                    class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">Panelis</span>
                            </div>
                        </div>
                    </div>

                    {{-- Menu Items --}}
                    <ul class="py-1.5">
                        <li>
                            <a href="{{ route('panelis.profile') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#0f172a] flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 text-gray-500 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span>Lihat Profil</span>
                            </a>
                        </li>
                        {{-- Notifikasi – hanya tampil di mobile --}}
                        <li class="lg:hidden">
                            <a href="{{ route('panelis.notifikasi') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#0f172a] flex items-center justify-center transition-colors flex-shrink-0 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 text-gray-500 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                    @if ($hasUnreadNotif)
                                        <span
                                            class="absolute top-0.5 right-0.5 w-2 h-2 bg-[#14b8a6] rounded-full"></span>
                                    @endif
                                </div>
                                <span>Notifikasi</span>
                                @if ($hasUnreadNotif)
                                    <span
                                        class="ml-auto bg-[#f97316] text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $unreadNotifications->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="mx-3 border-t border-gray-100 my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors group">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5 text-red-500 group-hover:text-white transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
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

            {{-- Mobile Dropdown Menu --}}
            <div class="relative block lg:hidden ml-2" id="mobile-menu-wrapper">
                <button
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95"
                    aria-label="Menu" id="mobile-menu-btn"
                    onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div id="mobile-menu-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-[300px] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
                    {{-- Dropdown Header --}}

                    <div class="px-5 py-5 bg-gradient-to-br from-[#0f172a] to-[#38475a]">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-base"
                                style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initials }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[14px] font-bold text-white truncate">
                                    {{ $user->nama ?? ($user->name ?? '-') }}</p>
                                <p class="text-[11px] text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                                <span
                                    class="inline-block mt-1.5 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Panelis</span>
                            </div>
                        </div>
                    </div>

                    <div class="py-2.5">
                        {{-- Quick Action: Notifikasi --}}
                        <div class="px-3 mb-1">
                            <a href="{{ route('panelis.notifikasi') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#0f172a] flex items-center justify-center transition-colors flex-shrink-0 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-gray-500 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                    @if ($hasUnreadNotif)
                                        <span class="absolute top-1 right-1 w-2 h-2 bg-[#14b8a6] rounded-full"></span>
                                    @endif
                                </div>
                                <span class="font-medium">Notifikasi</span>
                                @if ($hasUnreadNotif)
                                    <span
                                        class="ml-auto bg-[#f97316]/10 text-[#f97316] text-[11px] font-bold px-2 py-0.5 rounded-full">Baru</span>
                                @endif
                            </a>
                        </div>

                        <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                        {{-- Section: Dashboard Menu --}}
                        <div class="px-3 space-y-0.5">
                            <a href="{{ route('panelis.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('panelis.dashboard') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            <a href="{{ route('panelis.history') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('panelis.history') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Riwayat Penilaian</span>
                            </a>
                        </div>

                        <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                        {{-- Section: Account --}}
                        <div class="px-3">
                            <a href="{{ route('panelis.profile') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#0f172a] flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-gray-500 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium">Lihat Profil</span>
                            </a>
                            @if (Auth::user() && Auth::user()->roles->count() > 1)
                                <a href="{{ route('role.select') }}"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-[#005ba1] hover:bg-[#f8fafc] transition-colors group">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-[#e6f0f9] group-hover:bg-[#005ba1] flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5 text-[#005ba1] group-hover:text-white transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Ganti Role</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-red-500 hover:bg-red-50 transition-colors group">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-red-500 group-hover:text-white transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- MAIN CONTENT --}}
    <main id="main-content"
        class="px-4 py-8 lg:px-6 min-h-[calc(100vh-80px)]">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    @if(request()->routeIs('panelis.dashboard'))
    <footer class="mt-auto w-full relative z-10 border-t border-white/5 bg-[#0f172a] py-[50px] px-8">
        <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row items-center justify-between gap-[20px]">
            {{-- Bagian Kiri: Logo & Deskripsi --}}
            <div class="flex items-center gap-[12px]">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="h-[52px] w-[52px] object-contain bg-white p-[6px] rounded-xl" style="max-width: 52px; max-height: 52px; width: 100%; height: auto;">
                <div class="text-left text-[0.75rem] text-white/30 leading-[1.6]">
                    <strong class="text-white/50 text-[0.8rem]">IDP Dashboard</strong><br>
                    Platform Individual Development Plan
                </div>
            </div>

            {{-- Bagian Tengah: Links --}}
            <div class="flex flex-wrap justify-center gap-6 text-[0.78rem]">
                <a href="{{ route('panelis.dashboard') }}" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Dashboard</a>
                <a href="{{ route('panelis.history') }}" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">History</a>
            </div>

            {{-- Bagian Kanan: Copyright --}}
            <div class="text-center md:text-right text-[0.75rem] text-white/30 leading-[1.6]">
                &copy; {{ date('Y') }} IDP Dashboard. All rights reserved.
            </div>
        </div>
    </footer>
    @endif

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

        document.addEventListener('DOMContentLoaded', function () {
            const shouldShowPanelisNotifPopup = @json(session()->pull('panelis_just_logged_in', false) && $hasUnreadNotif && config('app.env') !== 'testing');

            if (shouldShowPanelisNotifPopup) {
                setTimeout(function () {
                    const bellDropdown = document.getElementById('bell-dropdown');
                    if (!bellDropdown) return;

                    bellDropdown.classList.remove('hidden');
                    bellDropdown.style.transformOrigin = 'top right';
                    bellDropdown.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    bellDropdown.style.transform = 'scale(1)';
                    bellDropdown.style.opacity = '1';

                    setTimeout(function () {
                        if (!bellDropdown.classList.contains('hidden')) {
                            bellDropdown.style.transform = 'scale(0)';
                            bellDropdown.style.opacity = '0';

                            setTimeout(function () {
                                bellDropdown.classList.add('hidden');
                                bellDropdown.style = '';
                            }, 500);
                        }
                    }, 5000);
                }, 250);
            }
        });

        window.addEventListener('notifikasi-marked-read', function () {
            const badge = document.getElementById('bell-red-badge');
            if (badge) badge.remove();

            const bellBtn = document.getElementById('bell-btn');
            if (bellBtn) {
                const ping = bellBtn.querySelector('.animate-ping');
                if (ping) ping.remove();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Echo === 'undefined') return;

            let panelisBellPopupTimeout = null;
            let panelisBellCleanupTimeout = null;

            window.Echo.private('user-notifications.{{ auth()->id() }}')
                .listen('.notification.created', function (data) {
                    window.dispatchEvent(new CustomEvent('app-notification-received', {
                        detail: data
                    }));
                    panelisUpdateBadge();
                    panelisInsertRealtimeNotification(data.title || 'Notifikasi Baru', data.desc || '');
                    panelisShowBellPopup();
                });

            function panelisUpdateBadge() {
                let badge = document.getElementById('bell-red-badge');

                if (badge) {
                    const current = parseInt((badge.textContent || '').trim(), 10) || 0;
                    const next = current + 1;
                    badge.textContent = next > 99 ? '99+' : next;
                    return;
                }

                const bellBtn = document.getElementById('bell-btn');
                if (!bellBtn) return;

                badge = document.createElement('span');
                badge.id = 'bell-red-badge';
                badge.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] animate-bounce';
                badge.style.animationDuration = '2s';
                badge.textContent = '1';
                bellBtn.appendChild(badge);

                const ping = document.createElement('span');
                ping.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40';
                bellBtn.appendChild(ping);
            }

            function panelisInsertRealtimeNotification(title, desc) {
                const dropdown = document.getElementById('bell-dropdown');
                if (!dropdown) return;

                const emptyState = document.getElementById('panelis-bell-empty-state');
                if (emptyState) emptyState.remove();

                let list = document.getElementById('panelis-bell-list');
                if (!list) {
                    list = document.createElement('ul');
                    list.id = 'panelis-bell-list';
                    list.className = 'divide-y divide-gray-50 max-h-60 overflow-y-auto';

                    const footer = dropdown.querySelector('.px-5.py-3.border-t');
                    if (footer) {
                        dropdown.insertBefore(list, footer);
                    } else {
                        dropdown.appendChild(list);
                    }
                }

                const item = document.createElement('li');
                item.className = 'px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer';
                item.onclick = function () {
                    window.location = '{{ route('panelis.notifikasi') }}';
                };
                item.innerHTML = `
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate"></p>
                        <p class="text-xs text-gray-500 truncate"></p>
                    </div>
                `;

                const titleEl = item.querySelector('p.text-sm');
                const descEl = item.querySelector('p.text-xs');
                if (titleEl) titleEl.textContent = title;
                if (descEl) descEl.textContent = desc;

                list.prepend(item);

                while (list.children.length > 3) {
                    list.removeChild(list.lastElementChild);
                }
            }

            function panelisShowBellPopup() {
                const bellDropdown = document.getElementById('bell-dropdown');
                if (!bellDropdown) return;

                clearTimeout(panelisBellPopupTimeout);
                clearTimeout(panelisBellCleanupTimeout);

                bellDropdown.classList.remove('hidden');
                bellDropdown.style.transformOrigin = 'top right';
                bellDropdown.style.transition = 'opacity .35s ease, transform .35s cubic-bezier(0.22, 1, 0.36, 1)';
                bellDropdown.style.opacity = '0';
                bellDropdown.style.transform = 'scale(0.82) translateY(-10px)';

                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        bellDropdown.style.opacity = '1';
                        bellDropdown.style.transform = 'scale(1) translateY(0)';
                    });
                });

                panelisBellPopupTimeout = setTimeout(function () {
                    bellDropdown.style.opacity = '0';
                    bellDropdown.style.transform = 'scale(0.86) translateY(-8px)';

                    panelisBellCleanupTimeout = setTimeout(function () {
                        bellDropdown.classList.add('hidden');
                        bellDropdown.style.transition = '';
                        bellDropdown.style.transformOrigin = '';
                        bellDropdown.style.opacity = '';
                        bellDropdown.style.transform = '';
                    }, 350);
                }, 4500);
            }
        });
    </script>
    @livewireScripts
    {{ $scripts ?? '' }}
</body>

</html>
