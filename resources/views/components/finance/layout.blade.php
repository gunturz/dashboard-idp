@props([
    'title' => 'Finance – Individual Development Plan',
    'user' => null,
    'notifications' => null,
])

@php
    $unreadNotifications = isset($notifications) && $notifications
        ? (is_array($notifications) ? collect($notifications)->where('is_read', false) : $notifications->where('is_read', false))
        : collect();
    $hasUnreadNotif = $unreadNotifications->count() > 0;

    $nama = $user->nama ?? ($user->name ?? 'Finance');
    $nameParts = explode(' ', $nama);
    $initials = count($nameParts) >= 2 
        ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1)) 
        : strtoupper(substr($nameParts[0], 0, 2));
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
            background: #343E4E;
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

        /* ── Nav menu links (active bold + teal underline) ── */
        .nav-menu-link {
            transition: color 0.2s, border-color 0.2s;
        }

        .nav-menu-link.active {
            color: #ffffff !important;
            border-bottom-width: 2px !important;
            border-bottom-color: #14b8a6 !important;
            border-bottom-style: solid !important;
        }

        .dropdown-panel .nav-menu-link {
            color: #475569;
            font-weight: 500;
            border-bottom: none;
        }

        .dropdown-panel .nav-menu-link:hover {
            color: #005ba1;
            background-color: #f8fafc;
        }

        .dropdown-panel .nav-menu-link.active {
            color: #005ba1;
            font-weight: 700;
            background-color: #f8fafc;
            border-bottom: none;
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

            .navbar-outer h1 {
                font-size: 1.1rem;
                white-space: normal;
                line-height: 1.3;
            }

            .nav-icon-btn {
                width: 38px;
                height: 38px;
            }

            .desktop-logo-text {
                display: none;
            }

            .navbar-outer {
                height: 60px;
                padding: 0 16px;
            }

            .navbar-outer h1 {
                font-size: 1.1rem;
                white-space: normal;
                line-height: 1.3;
            }

            .nav-icon-btn {
                width: 38px;
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
    {{ $styles ?? '' }}
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col pt-[60px] lg:pt-[80px] relative">

    {{-- DECORATIVE BACKGROUND --}}
    <div class="bg-decoration">
        <div class="bg-blob w-[800px] h-[800px] bg-blue-200/30 -top-64 -left-64"></div>
        <div class="bg-blob w-[600px] h-[600px] bg-indigo-200/30 top-1/2 -right-32" style="animation-delay: -5s;"></div>
        <div class="bg-blob w-[900px] h-[900px] bg-sky-200/20 -bottom-48 left-1/4" style="animation-delay: -10s;"></div>
        <div class="bg-blob w-[500px] h-[500px] bg-blue-100/40 top-1/4 left-1/2" style="animation-delay: -15s;"></div>
    </div>

    <div class="navbar-outer">

        {{-- Logo + Title --}}
        <a href="{{ route('finance.dashboard') }}"
            class="flex items-center gap-2 lg:gap-4 flex-shrink-0 hover:opacity-90 transition-opacity">
            <div
                class="bg-white p-1.5 lg:p-2 rounded-[8px] lg:rounded-[10px] shadow-sm flex items-center justify-center w-10 h-10 lg:w-14 lg:h-14 hidden sm:flex">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
            </div>
            <h1
                class="text-white text-base lg:text-xl font-bold tracking-wide whitespace-nowrap desktop-logo-text sm:block hidden">
                Individual Development Plan
            </h1>
            <h1 class="text-white text-base font-bold tracking-wide whitespace-nowrap sm:hidden flex items-center gap-2.5">
                <div class="flex items-center justify-center w-11 h-11 bg-white rounded-lg shadow-md flex-shrink-0 ring-2 ring-white/20">
                    <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                IDP Finance
            </h1>
        </a>

        <div class="hidden xl:flex items-center gap-8 ml-auto pr-8">
            <a href="{{ route('finance.dashboard') }}"
                class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150 {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('finance.permintaan_validasi') }}"
                class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150 {{ request()->routeIs('finance.permintaan_validasi') ? 'active' : '' }}">
                Validasi
            </a>
            <a href="{{ route('finance.riwayat') }}"
                class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150 {{ request()->routeIs('finance.riwayat') ? 'active' : '' }}">
                Riwayat
            </a>
        </div>

        <div
            class="flex items-center space-x-2 sm:space-x-3 pl-0 xl:pl-6 border-l-0 xl:border-l border-white/20 xl:ml-0 ml-auto">
            {{-- ═══ Notification Bell ═══ --}}
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
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#14b8a6] rounded-full">
                            <span class="absolute inset-0 rounded-full bg-[#14b8a6] animate-ping opacity-75"></span>
                        </span>
                    @endif
                </button>

                <div id="bell-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div
                        class="px-5 py-3.5 bg-gradient-to-r from-[#2e3746] to-[#38475a] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            <span class="text-sm font-bold text-white">Notifikasi</span>
                        </div>
                        <form action="{{ route('finance.notifikasi.markAllRead') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                                Tandai semua
                            </button>
                        </form>
                    </div>

                    @if ($hasUnreadNotif)
                        <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto">
                            @foreach ($unreadNotifications->take(3) as $notif)
                                <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer"
                                    onclick="window.location='{{ route('finance.notifikasi') }}'">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{!! $notif['title'] ?? ($notif->title ?? '-') !!}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{!! $notif['desc'] ?? ($notif['time'] ?? '') !!}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center py-10 text-center px-4">
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
                        <a href="{{ route('finance.notifikasi') }}"
                            class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                            Lihat semua notifikasi →
                        </a>
                    </div>
                </div>
            </div>

            {{-- ═══ Desktop: Profile ═══ --}}
            <div class="relative hidden lg:block" id="profile-wrapper">
                <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')"
                    aria-label="Profil"
                    class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                        {{ $initials }}
                    </div>
                    <div class="hidden lg:block text-left">
                        <p class="text-white text-sm font-semibold leading-tight max-w-[120px] truncate">
                            {{ $nama }}</p>
                        <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">Finance</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5 text-white/60 hidden lg:block flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="profile-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-4 bg-gradient-to-br from-[#2e3746] to-[#38475a]">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-sm"
                                style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initials }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-white truncate">{{ $nama }}</p>
                                <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                                <span
                                    class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">Finance</span>
                            </div>
                        </div>
                    </div>

                    <ul class="py-1.5">
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div
                                    class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#2e3746] flex items-center justify-center transition-colors flex-shrink-0">
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
                        @if (Auth::user() && Auth::user()->roles->count() > 1)
                            <li>
                                <a href="{{ route('role.select') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#005ba1] hover:bg-gray-50 transition-colors group">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-[#005ba1]/10 group-hover:bg-[#005ba1] flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5 text-[#005ba1] group-hover:text-white transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <span>Ganti Role</span>
                                </a>
                            </li>
                        @endif
                        <li class="mx-3 border-t border-gray-100 my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
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

            <!-- Mobile Hamburger Button -->
            <div class="relative block xl:hidden ml-2" id="mobile-menu-wrapper">
                <button class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95" aria-label="Menu" id="mobile-menu-btn" onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div id="mobile-menu-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-[300px] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
                    {{-- Dropdown Header --}}
                    <div class="px-5 py-5 bg-gradient-to-br from-[#2e3746] to-[#38475a]">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-base"
                                style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initials }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[14px] font-bold text-white truncate">{{ $user->nama ?? ($user->name ?? '-') }}</p>
                                <p class="text-[11px] text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                                <span class="inline-block mt-1.5 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Finance</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="py-2.5">
                        {{-- Quick Action: Notifikasi --}}
                        <div class="px-3 mb-1">
                            <a href="{{ route('finance.notifikasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#2e3746] flex items-center justify-center transition-colors flex-shrink-0 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 group-hover:text-white transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                    @if($hasUnreadNotif)
                                        <span class="absolute top-1 right-1 w-2 h-2 bg-[#14b8a6] rounded-full"></span>
                                    @endif
                                </div>
                                <span class="font-medium">Notifikasi</span>
                                @if($hasUnreadNotif)
                                    <span class="ml-auto bg-[#f97316]/10 text-[#f97316] text-[11px] font-bold px-2 py-0.5 rounded-full">Baru</span>
                                @endif
                            </a>
                        </div>

                        <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                        {{-- Section: Dashboard Menu --}}
                        <div class="px-3 space-y-0.5">
                            <a href="{{ route('finance.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('finance.dashboard') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            <a href="{{ route('finance.permintaan_validasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('finance.permintaan_validasi') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Validasi</span>
                            </a>
                            <a href="{{ route('finance.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('finance.riwayat') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Riwayat</span>
                            </a>
                        </div>

                        <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                        {{-- Section: Account --}}
                        <div class="px-3">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-700 hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#2e3746] flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 group-hover:text-white transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium">Lihat Profil</span>
                            </a>
                            @if(Auth::user()->roles->count() > 1)
                                <a href="{{ route('role.select') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-[#005ba1] hover:bg-[#f8fafc] transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-[#e6f0f9] group-hover:bg-[#005ba1] flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#005ba1] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Ganti Role</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-red-500 hover:bg-red-50 transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
    <div class="flex-1">
        <main id="main-content"
            class="p-4 lg:p-8 min-h-[calc(100vh-80px)] bg-white/90 backdrop-blur-md mt-4 mx-4 lg:mx-6 lg:mt-6 rounded-2xl shadow-sm border border-white/20">
            {{ $slot }}
        </main>
    </div>

    {{-- FOOTER --}}
    <footer class="mt-8 bg-gradient-to-br from-[#343E4E] to-[#1e293b] py-6 text-center w-full border-t border-white/5">
        <span class="text-white/80 text-sm font-medium tracking-wide">
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
