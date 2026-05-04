@props([
    'title' => 'Finance – Individual Development Plan',
    'user' => null,
    'notifications' => null,
])

@php
    $rawUnreadNotifs = \App\Models\AppNotification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->orderBy('created_at', 'desc')
        ->get();
        
    $unreadNotifications = $rawUnreadNotifs->map(function($n) {
        return [
            'id' => $n->id,
            'title' => $n->title,
            'desc' => $n->desc,
            'time' => $n->created_at->diffForHumans()
        ];
    });
    $unreadCount = $unreadNotifications->count();
    $displayCount = $unreadCount > 99 ? '99+' : $unreadCount;
    $hasUnreadNotif = $unreadCount > 0;

    $nama = $user->nama ?? ($user->name ?? 'Finance');
    $nameParts = explode(' ', $nama);
    $initials =
        count($nameParts) >= 2
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
            .mobile-menu { top: 60px; padding: 1rem; }
            .navbar-outer { height: 60px; padding: 0 16px; }
            .navbar-outer h1 { font-size: 1.1rem; white-space: normal; line-height: 1.3; }
            .nav-icon-btn { width: 38px; height: 38px; }
            .desktop-logo-text { display: none; }
        }

        @media (max-width: 640px) {
            .prem-stat-grid { grid-template-columns: 1fr !important; }
            .dash-header-date { display: none; }
        }

        /* ══ Dash Header (matches Admin standard) ══ */
        .dash-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }
        .dash-header-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: #0f172a;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25); flex-shrink: 0;
        }
        .dash-header-icon svg { color: white; width: 24px; height: 24px; }
        .dash-header-title { font-size: 1.6rem; font-weight: 800; color: #1e293b; line-height: 1.1; }
        .dash-header-sub { font-size: 0.8rem; color: #64748b; margin-top: 2px; font-weight: 400; }
        .dash-header-date { margin-left: auto; font-size: 0.78rem; color: #94a3b8; font-weight: 500; text-align: right; }
        .dash-header-date span { display: block; font-size: 1rem; font-weight: 700; color: #475569; }

        /* ══ Page Header (legacy alias) ══ */
        .page-header { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }
        .page-header-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: #0f172a;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25); flex-shrink: 0; color: white;
        }
        .page-header-icon svg { width: 24px; height: 24px; flex-shrink: 0; }
        .page-header-title { font-size: 1.6rem; font-weight: 800; color: #1e293b; line-height: 1.1; }
        .page-header-sub { font-size: 0.8rem; color: #64748b; margin-top: 2px; font-weight: 400; }

        /* ══ Premium Stats Cards ══ */
        .prem-stat-grid { display: grid; gap: 20px; margin-bottom: 24px; }
        .prem-stat {
            background: #f9fafb; border: 1px solid #e2e8f0; border-radius: 16px;
            padding: 20px 20px 18px; display: flex; flex-direction: column;
            align-items: flex-start; gap: 0; position: relative; overflow: hidden;
            text-decoration: none; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .prem-stat::before {
            content: ''; position: absolute; top: 0; left: 0;
            width: 100%; height: 3.5px; border-radius: 16px 16px 0 0;
        }
        .prem-stat-teal::before { background: linear-gradient(90deg, #14b8a6, #2dd4bf); }
        .prem-stat-blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .prem-stat-amber::before { background: linear-gradient(90deg, #f59e0b, #fcd34d); }
        .prem-stat-green::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .prem-stat-red::before { background: linear-gradient(90deg, #ef4444, #f87171); }
        .prem-stat-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-bottom: 10px;
        }
        .prem-stat-icon svg { width: 18px; height: 18px; }
        .si-teal { background: rgba(20, 184, 166, 0.12); color: #14b8a6; }
        .si-blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
        .si-amber { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
        .si-green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .si-red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
        .prem-stat-value { font-size: 2.5rem; font-weight: 800; color: #1e293b; line-height: 1; margin-bottom: 2px; }
        .prem-stat-label { font-size: 0.82rem; color: #64748b; font-weight: 500; }

        /* ══ Premium Card ══ */
        .prem-card {
            background: #f9fafb; border: 1px solid #e2e8f0; border-radius: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04); overflow: hidden; margin-bottom: 24px;
        }
        .prem-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #e2e8f0; gap: 12px; flex-wrap: wrap;
        }
        .prem-card-title { display: flex; align-items: center; gap: 8px; font-size: .9rem; font-weight: 700; color: #1e293b; }
        .prem-card-title svg { width: 18px; height: 18px; color: #14b8a6; flex-shrink: 0; }

        /* ══ Premium Buttons ══ */
        .btn-prem {
            display: inline-flex; align-items: center; justify-content: center; gap: 5px;
            font-size: 0.8rem; font-weight: 700; padding: 8px 16px; border-radius: 10px;
            border: none; cursor: pointer; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none; white-space: nowrap;
        }
        .btn-prem:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12); }
        .btn-prem svg { width: 16px; height: 16px; flex-shrink: 0; }
        .btn-teal { background: #14b8a6; color: #fff; box-shadow: 0 2px 6px rgba(20, 184, 166, 0.25); }
        .btn-teal:hover { background: #0d9488; color: #fff; }
        .btn-ghost { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
        .btn-ghost:hover { background: #e2e8f0; color: #1e293b; }
        .btn-red { background: #ef4444; color: #fff; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.25); }
        .btn-red:hover { background: #dc2626; color: #fff; }
        .btn-dark { background: #475569; color: #fff; }
        .btn-dark:hover { background: #334155; color: #fff; }

        /* ══ Badges ══ */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-size: 0.72rem; font-weight: 700; letter-spacing: .02em; }
        .badge-teal { background: rgba(20, 184, 166, 0.12); color: #0d9488; border: 1px solid rgba(20, 184, 166, 0.25); }
        .badge-amber { background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.25); }
        .badge-green { background: rgba(16, 185, 129, 0.12); color: #059669; border: 1px solid rgba(16, 185, 129, 0.25); }
        .badge-red { background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25); }
        .badge-blue { background: rgba(59, 130, 246, 0.12); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.25); }
        .badge-gray { background: rgba(100, 116, 139, 0.1); color: #475569; border: 1px solid rgba(100, 116, 139, 0.2); }

        /* ══ Premium Table ══ */
        .prem-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .prem-table th { background: #f8fafc; color: #475569; font-weight: 700; text-align: center; padding: 11px 14px; border-bottom: 1px solid #e2e8f0; white-space: nowrap; font-size: 0.75rem; text-transform: uppercase; letter-spacing: .05em; }
        .prem-table td { padding: 13px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #334155; text-align: center; }
        .prem-table tbody tr:last-child td { border-bottom: none; }
        .prem-table tbody tr:hover td { background: #f0fdfa; }

        /* ══ Filter Bar ══ */
        .filter-bar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 12px 16px; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0, 0, 0, .03); }
        .filter-input { border: 1px solid #e2e8f0; border-radius: 10px; padding: 8px 14px; font-size: 0.83rem; color: #334155; outline: none; background: #f8fafc; transition: border-color .2s, box-shadow .2s; }
        .filter-input:focus { border-color: #14b8a6; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12); background: #fff; }

        /* ══ Empty State ══ */
        .empty-prem { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 24px; text-align: center; }
        .empty-prem svg { width: 48px; height: 48px; margin-bottom: 12px; color: #cbd5e1; }
        .empty-prem h3 { font-size: 1rem; font-weight: 700; color: #475569; margin-bottom: 4px; }
        .empty-prem p { font-size: 0.82rem; color: #94a3b8; }

        /* ── Background Decoration ── */
        .bg-decoration { position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; background-color: #ffffff; }
        .bg-decoration::before { content: ''; position: absolute; inset: 0; background-image: radial-gradient(#cbd5e1 0.7px, transparent 0.7px); background-size: 32px 32px; opacity: 0.3; }
    </style>
    {{ $styles ?? '' }}
    @vite(['resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#ffffff] min-h-screen flex flex-col pt-[60px] lg:pt-[80px] relative">

    <div class="bg-decoration">
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
            <h1
                class="text-white text-base font-bold tracking-wide whitespace-nowrap sm:hidden flex items-center gap-2.5">
                <div
                    class="flex items-center justify-center w-11 h-11 bg-white rounded-lg shadow-md flex-shrink-0 ring-2 ring-white/20">
                    <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                IDP Finance
            </h1>
        </a>

        <div class="hidden lg:flex items-center gap-8 flex-1 justify-end pr-8">
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
            class="flex items-center space-x-2 sm:space-x-3 pl-0 xl:pl-6 border-l-0 xl:border-l border-white/20 lg:ml-0 ml-auto flex-shrink-0">
            {{-- ═══ Notification Bell ═══ --}}
            <div class="relative hidden lg:block" id="bell-wrapper">
                @php
                    $financeUnreadCount = \App\Models\AppNotification::where('user_id', auth()->id())->where('is_read', false)->count();
                    $displayCount = $financeUnreadCount > 99 ? '99+' : $financeUnreadCount;
                @endphp
                <button id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')" aria-label="Notifikasi"
                    class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    @if ($financeUnreadCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#343E4E] animate-bounce" style="animation-duration: 2s;" id="bell-red-badge">
                            {{ $displayCount }}
                        </span>
                        <span class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40"></span>
                    @endif
                </button>

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
                        <form action="{{ route('finance.notifikasi.markAllRead') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                                Tandai semua
                            </button>
                        </form>
                    </div>

                    @if ($hasUnreadNotif)
                        <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto" id="finance-bell-list">
                            @foreach ($unreadNotifications->take(2) as $notif)
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
                                        <p class="text-sm font-semibold text-gray-800 truncate">{!! $notif['title'] !!}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{!! $notif['desc'] ?? $notif['time'] !!}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center py-10 text-center px-4" id="finance-bell-empty-state">
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
                <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')" aria-label="Profil"
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
                    <div class="px-4 py-4 bg-gradient-to-br from-[#0f172a] to-[#38475a]">
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
                <button
                    class="flex items-center gap-2 pl-1.5 pr-2.5 py-1.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-[1.02] active:scale-95 max-w-[calc(100vw-7rem)]"
                    aria-label="Profil dan notifikasi" id="mobile-menu-btn"
                    onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                    <div class="relative">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
                            style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                            {{ $initials }}
                        </div>
                        @if ($hasUnreadNotif)
                            <span class="mobile-trigger-notif-dot absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#343E4E]">{{ $displayCount }}</span>
                        @endif
                    </div>
                    <div class="min-w-0 text-left">
                        <p class="text-white text-[13px] font-semibold leading-tight truncate max-w-[118px]">{{ $nama }}</p>
                        <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">Finance</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/70 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobile-menu-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-[calc(100vw-1rem)] max-w-[calc(100vw-1rem)] sm:w-[320px] sm:max-w-[calc(100vw-1.5rem)] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
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
                                    class="inline-block mt-1.5 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Finance</span>
                            </div>
                        </div>
                    </div>

                    <div class="py-2.5">
                        {{-- Quick Action: Notifikasi --}}
                        <div class="px-3 mb-1">
                            <a href="{{ route('finance.notifikasi') }}"
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
                                        <span data-mobile-unread-badge class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-white">{{ $displayCount }}</span>
                                    @endif
                                </div>
                                <span class="font-medium">Notifikasi</span>
                                @if ($hasUnreadNotif)
                                    <span data-mobile-unread-pill
                                        class="ml-auto bg-[#f97316]/10 text-[#f97316] text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $displayCount }} Baru</span>
                                @endif
                            </a>
                        </div>

                        <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                        {{-- Section: Dashboard Menu --}}
                        <div class="px-3 space-y-0.5">
                            <a href="{{ route('finance.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('finance.dashboard') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
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
                            <a href="{{ route('finance.permintaan_validasi') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('finance.permintaan_validasi') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Validasi</span>
                            </a>
                            <a href="{{ route('finance.riwayat') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group {{ request()->routeIs('finance.riwayat') ? 'bg-gray-50 font-bold text-[#005ba1]' : '' }}">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Riwayat</span>
                            </a>
                        </div>

                        <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                        {{-- Section: Account --}}
                        <div class="px-3">
                            <a href="{{ route('profile.edit') }}"
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
                            @if (Auth::user()->roles->count() > 1)
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

            {{-- -- Mobile Notif Dropdown (realtime, dedicated) -- --}}
            <div id="mobile-notif-dropdown"
                class="dropdown-panel hidden fixed top-[72px] left-3 right-3 w-auto sm:absolute sm:top-auto sm:left-auto sm:right-0 sm:mt-3 sm:w-[340px] bg-white rounded-[1.25rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-gray-100 overflow-hidden z-50 sm:origin-top-right">
                <div class="px-5 py-4 bg-gradient-to-r from-[#0f172a] to-[#38475a] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                            <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                        <span class="text-[13px] font-bold text-white">Notifikasi Baru</span>
                    </div>
                    <a href="{{ route('finance.notifikasi') }}" class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">Lihat Semua</a>
                </div>
                <ul id="finance-mobile-notif-list" class="divide-y divide-gray-50 max-h-64 overflow-y-auto"></ul>
                <div id="finance-mobile-notif-empty" class="flex flex-col items-center py-8 text-center px-4">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi baru</p>
                </div>
                <div class="px-5 py-3 border-t border-gray-100 text-center">
                    <a href="{{ route('finance.notifikasi') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">Lihat semua notifikasi &#x2192;</a>
                </div>
            </div>
            </div>

        </div>
    </div>


    {{-- MAIN CONTENT --}}
    <div class="flex-1">
        <main id="main-content" class="p-4 lg:p-8 min-h-[calc(100vh-80px)] mt-4 mx-4 lg:mx-6 lg:mt-6">
            {{ $slot }}
        </main>
    </div>



    <script>
        function showDropdownPanel(dropdown, isMobileDropdown = false) {
            dropdown.classList.remove('hidden');
            dropdown.style.display = '';
            dropdown.style.opacity = '0';
            dropdown.style.transformOrigin = 'top right';
            dropdown.style.transform = isMobileDropdown ? 'translateY(-8px) scale(.98)' : 'scale(.96) translateY(-6px)';
            dropdown.style.transition = 'opacity .22s ease, transform .22s ease';

            // Force reflow to ensure transition triggers
            void dropdown.offsetWidth;

            requestAnimationFrame(() => {
                dropdown.style.opacity = '1';
                dropdown.style.transform = 'translateY(0) scale(1)';
            });
        }

        function hideDropdownPanel(dropdown) {
            dropdown.classList.add('hidden');
            dropdown.style.display = 'none';
            dropdown.style.opacity = '';
            dropdown.style.transform = '';
            dropdown.style.transition = '';
            dropdown.style.transformOrigin = '';
        }

        function toggleDropdown(dropdownId, btnId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');
            document.querySelectorAll('.dropdown-panel').forEach(el => hideDropdownPanel(el));
            const isMobile = dropdownId === 'mobile-menu-dropdown' || dropdownId === 'mobile-notif-dropdown';
            if (isHidden) showDropdownPanel(dropdown, isMobile);
        }

        document.addEventListener('click', function(e) {
            const wrappers = ['bell-wrapper', 'profile-wrapper', 'mobile-menu-wrapper'];
            const clickedInside = wrappers.some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!clickedInside) {
                document.querySelectorAll('.dropdown-panel').forEach(el => hideDropdownPanel(el));
            }
        });

        // Clear red badge when Livewire marks all as read
        window.addEventListener('notifikasi-marked-read', function () {
            const badge = document.getElementById('bell-red-badge');
            if (badge) badge.remove();
            const bellBtn = document.getElementById('bell-btn');
            if (bellBtn) {
                const ping = bellBtn.querySelector('.animate-ping');
                if (ping) ping.remove();
            }
            document.querySelectorAll('.mobile-trigger-notif-dot, [data-mobile-unread-badge], [data-mobile-unread-pill]').forEach(el => el.remove());
        });

        // Auto-expand notification bell on load if there are unread notifications (Only show once using sessionStorage)
        document.addEventListener('DOMContentLoaded', function () {
            let hasUnread = {{ ($financeUnreadCount ?? 0) > 0 ? 'true' : 'false' }};
            let bellDropdown = document.getElementById('bell-dropdown');
            let hasShownPopup = sessionStorage.getItem('finance_notif_shown');

            if (hasUnread && bellDropdown && {{ request()->routeIs('finance.dashboard') ? 'true' : 'false' }} && !hasShownPopup) {
                // Set flag to ensure it doesn't expand on next reload/visit during this session
                sessionStorage.setItem('finance_notif_shown', 'true');
                
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

                setTimeout(function () {
                    bellDropdown.style.opacity = '0';
                    bellDropdown.style.transform = 'scale(0.86) translateY(-8px)';

                    setTimeout(function () {
                        bellDropdown.classList.add('hidden');
                        bellDropdown.style.transition = '';
                        bellDropdown.style.transformOrigin = '';
                        bellDropdown.style.opacity = '';
                        bellDropdown.style.transform = '';
                    }, 350);
                }, 4500);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            let financeBellPopupTimeout = null;
            let financeBellCleanupTimeout = null;
            let financeRealtimeUiBound = false;

            function handleFinanceIncomingNotification(data) {
                if (!data) return;

                financeUpdateBadge();
                financeInsertRealtimeNotification(data.title || 'Notifikasi Baru', data.desc || '');
                financeShowBellPopup();
                financeShowToast(data.title || 'Notifikasi Baru', data.desc || '');
            }

            window.addEventListener('app-notification-received', function (event) {
                if (!financeRealtimeUiBound) return;
                handleFinanceIncomingNotification(event.detail || {});
            });

            function initFinanceRealtimeNotifications() {
                if (typeof window.Echo === 'undefined') {
                    return false;
                }

                const channelName = 'user-notifications.{{ auth()->id() }}';

                if (window.__financeNotificationChannelInitialized === channelName) {
                    financeRealtimeUiBound = true;
                    return true;
                }

                if (window.__financeNotificationChannelInitialized && window.__financeNotificationChannelInitialized !== channelName) {
                    window.Echo.leave(window.__financeNotificationChannelInitialized);
                }

                window.Echo.private(channelName)
                    .subscribed(function () {
                        console.info('[Finance Realtime] subscribed to', channelName);
                    })
                    .error(function (error) {
                        console.error('[Finance Realtime] subscription error', error);
                    })
                    .listen('.notification.created', function (data) {
                        window.dispatchEvent(new CustomEvent('app-notification-received', {
                            detail: data
                        }));
                    });

                window.__financeNotificationChannelInitialized = channelName;
                financeRealtimeUiBound = true;

                return true;
            }

            if (!initFinanceRealtimeNotifications()) {
                let retryCount = 0;
                const retryTimer = setInterval(function () {
                    retryCount++;

                    if (initFinanceRealtimeNotifications() || retryCount >= 20) {
                        clearInterval(retryTimer);
                    }
                }, 500);
            }

            window.addEventListener('load', initFinanceRealtimeNotifications);
            document.addEventListener('livewire:navigated', initFinanceRealtimeNotifications);

            if (typeof window.Echo !== 'undefined'
                && window.Echo.connector
                && window.Echo.connector.pusher
                && window.Echo.connector.pusher.connection) {
                window.Echo.connector.pusher.connection.bind('connected', function () {
                    console.info('[Finance Realtime] websocket connected');
                    initFinanceRealtimeNotifications();
                });

                window.Echo.connector.pusher.connection.bind('error', function (error) {
                    console.error('[Finance Realtime] websocket error', error);
                });
            }

            function financeShowToast(title, desc) {
                let container = document.getElementById('finance-rt-toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'finance-rt-toast-container';
                    container.style.cssText = 'position:fixed;left:12px;right:12px;bottom:12px;z-index:9999;display:flex;flex-direction:column-reverse;align-items:flex-end;gap:10px;pointer-events:none;';
                    document.body.appendChild(container);
                }

                let toast = document.createElement('div');
                toast.style.cssText = [
                    'pointer-events:auto',
                    'display:flex',
                    'align-items:flex-start',
                    'gap:12px',
                    'background:#fff',
                    'border:1px solid #e2e8f0',
                    'border-left:4px solid #3b82f6',
                    'border-radius:14px',
                    'padding:14px 18px',
                    'box-shadow:0 10px 40px rgba(0,0,0,.13)',
                    'width:min(100%,360px)',
                    'min-width:0',
                    'max-width:100%',
                    'position:relative',
                    'overflow:hidden',
                    'opacity:0',
                    'transform:translateX(40px) scale(.96)',
                    'transition:opacity .35s ease,transform .35s ease'
                ].join(';');

                toast.innerHTML = `
                    <div style="flex-shrink:0;width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#dbeafe,#bfdbfe);display:flex;align-items:center;justify-content:center;">
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='#2563eb' style='width:20px;height:20px;'>
                            <path d='M12 2.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.06 1.06a.75.75 0 101.06 1.06l1.06-1.06zM5.466 19.084a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 011.06-1.06l1.06 1.06a.75.75 0 010 1.06zM19.98 12a.75.75 0 00-.75-.75h-1.5a.75.75 0 000 1.5h1.5a.75.75 0 00.75-.75zM4.77 12a.75.75 0 00-.75-.75h-1.5a.75.75 0 000 1.5h1.5a.75.75 0 00.75-.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.06 1.06l1.06 1.06zM6.166 5.466a.75.75 0 010-1.06l1.06-1.06a.75.75 0 011.06 1.06l-1.06 1.06a.75.75 0 01-1.06 0zM12 18.75a.75.75 0 00-.75.75v1.5a.75.75 0 001.5 0v-1.5a.75.75 0 00-.75-.75z'/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.85rem;font-weight:700;color:#1e293b;margin-bottom:3px;">${title}</div>
                        <div style="font-size:.78rem;color:#64748b;line-height:1.5;">${desc}</div>
                    </div>
                    <div style="position:absolute;bottom:0;left:0;height:3px;background:linear-gradient(90deg,#3b82f6,#60a5fa);width:100%;transform-origin:left;animation:financeBarShrink 5s linear forwards;border-radius:0 0 0 14px;"></div>
                `;

                if (!document.getElementById('finance-toast-style')) {
                    let s = document.createElement('style');
                    s.id = 'finance-toast-style';
                    s.textContent = '@keyframes financeBarShrink{from{transform:scaleX(1)}to{transform:scaleX(0)}}';
                    document.head.appendChild(s);
                }

                container.appendChild(toast);
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        toast.style.opacity = '1';
                        toast.style.transform = 'translateX(0) scale(1)';
                    });
                });

                setTimeout(function () {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(40px) scale(.96)';
                    setTimeout(() => toast.remove(), 400);
                }, 5000);
            }

            function financeUpdateBadge() {
                let badge = document.getElementById('bell-red-badge');
                const mobileIndicatorHost = document.querySelector('#mobile-menu-btn .relative');
                const mobileMenuLinkBadge = document.querySelector('#mobile-menu-dropdown [data-mobile-unread-badge]');
                const mobileMenuLinkPill = document.querySelector('#mobile-menu-dropdown [data-mobile-unread-pill]');

                function nextBadgeCountFromElement(element) {
                    const current = parseInt((element?.textContent || '').trim(), 10) || 0;
                    const next = current + 1;
                    return next > 99 ? '99+' : String(next);
                }

                if (mobileIndicatorHost && !mobileIndicatorHost.querySelector('.mobile-trigger-notif-dot')) {
                    const dot = document.createElement('span');
                    dot.className = 'mobile-trigger-notif-dot absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#343E4E]';
                    dot.textContent = '1';
                    mobileIndicatorHost.appendChild(dot);
                } else if (mobileIndicatorHost) {
                    mobileIndicatorHost.querySelector('.mobile-trigger-notif-dot').textContent = nextBadgeCountFromElement(mobileIndicatorHost.querySelector('.mobile-trigger-notif-dot'));
                }

                if (mobileMenuLinkBadge) {
                    mobileMenuLinkBadge.textContent = nextBadgeCountFromElement(mobileMenuLinkBadge);
                }

                if (mobileMenuLinkPill) {
                    const current = parseInt((mobileMenuLinkPill.textContent || '').trim(), 10) || 0;
                    const next = current + 1;
                    mobileMenuLinkPill.textContent = `${next > 99 ? '99+' : next} Baru`;
                }

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
                badge.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#343E4E] animate-bounce';
                badge.style.animationDuration = '2s';
                badge.textContent = '1';
                bellBtn.appendChild(badge);

                const ping = document.createElement('span');
                ping.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40';
                bellBtn.appendChild(ping);

            }

            function financeInsertRealtimeNotification(title, desc) {
                const dropdown = document.getElementById('bell-dropdown');
                if (!dropdown) return;

                const emptyState = document.getElementById('finance-bell-empty-state');
                if (emptyState) emptyState.remove();

                let list = document.getElementById('finance-bell-list');
                if (!list) {
                    list = document.createElement('ul');
                    list.id = 'finance-bell-list';
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
                    window.location = '{{ route('finance.notifikasi') }}';
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
                if (titleEl) titleEl.innerHTML = title;
                if (descEl) descEl.innerHTML = desc;

                list.prepend(item);

                while (list.children.length > 2) {
                    list.removeChild(list.lastElementChild);
                }

                // -- Mobile dedicated notif-dropdown --
                const mobileNotifDropdown = document.getElementById('mobile-notif-dropdown');
                if (!mobileNotifDropdown) return;

                const mobileEmpty = document.getElementById('finance-mobile-notif-empty');
                if (mobileEmpty) mobileEmpty.style.display = 'none';

                const mobileList = document.getElementById('finance-mobile-notif-list');
                if (!mobileList) return;

                const mobileItem = document.createElement('li');
                mobileItem.className = 'px-4 py-3.5 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer';
                mobileItem.onclick = function () { window.location = '{{ route('finance.notifikasi') }}'; };
                mobileItem.innerHTML = `
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold text-gray-800 leading-snug"></p>
                        <p class="mt-0.5 text-[11px] text-gray-500 leading-relaxed"></p>
                        <p class="mt-1 text-[10px] text-[#14b8a6] font-medium">Baru saja</p>
                    </div>
                `;
                const mobileTitleEl = mobileItem.querySelectorAll('p')[0];
                const mobileDescEl  = mobileItem.querySelectorAll('p')[1];
                if (mobileTitleEl) mobileTitleEl.innerHTML = title;
                if (mobileDescEl)  mobileDescEl.innerHTML  = desc;

                mobileList.prepend(mobileItem);
                while (mobileList.children.length > 5) mobileList.removeChild(mobileList.lastElementChild);
            }

            function financeShowBellPopup() {
                const isMobileActive = window.matchMedia('(max-width: 1023px)').matches;
                // Mobile: buka panel notifikasi khusus
                const bellDropdown = document.getElementById(isMobileActive ? 'mobile-notif-dropdown' : 'bell-dropdown');
                if (!bellDropdown) return;

                clearTimeout(financeBellPopupTimeout);
                clearTimeout(financeBellCleanupTimeout);

                document.querySelectorAll('.dropdown-panel').forEach(el => hideDropdownPanel(el));
                showDropdownPanel(bellDropdown, isMobileActive);

                financeBellPopupTimeout = setTimeout(function () {
                    bellDropdown.style.opacity = '0';
                    bellDropdown.style.transform = isMobileActive ? 'translateY(-8px) scale(.98)' : 'scale(0.86) translateY(-8px)';

                    financeBellCleanupTimeout = setTimeout(function () {
                        hideDropdownPanel(bellDropdown);
                    }, 350);
                }, 4500);
            }
        });
    </script>
    @livewireScripts
    {{ $scripts ?? '' }}

    {{-- FOOTER --}}
    @if(request()->routeIs('finance.dashboard'))
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
                <a href="{{ route('finance.dashboard') }}" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Dashboard</a>
                <a href="{{ route('finance.permintaan_validasi') }}" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Validasi</a>
                <a href="{{ route('finance.riwayat') }}" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Riwayat</a>
            </div>

            {{-- Bagian Kanan: Copyright --}}
            <div class="text-center md:text-right text-[0.75rem] text-white/30 leading-[1.6]">
                &copy; {{ date('Y') }} IDP Dashboard. All rights reserved.
            </div>
        </div>
    </footer>
    @endif
</body>

</html>
