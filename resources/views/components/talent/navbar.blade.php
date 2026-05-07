<div class="navbar-outer">
    <a href="{{ route('talent.dashboard') }}"
        class="flex items-center gap-3 hover:opacity-90 transition-opacity flex-shrink-0">
        <div
            class="hidden sm:flex items-center justify-center w-11 h-11 lg:w-12 lg:h-12 bg-white rounded-xl shadow-md flex-shrink-0 ring-2 ring-white/20">
            <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-8 h-8 lg:w-9 lg:h-9 object-contain"
                style="max-width: 36px; max-height: 36px; width: 100%; height: auto;">
        </div>
        <div class="hidden sm:block">
            <h1 class="text-white font-extrabold text-lg lg:text-xl leading-tight tracking-wide">Individual
                Development Plan</h1>
        </div>
        <h1 class="text-white text-base font-bold tracking-wide whitespace-nowrap sm:hidden flex items-center gap-2.5">
            <div
                class="flex items-center justify-center w-11 h-11 bg-white rounded-lg shadow-md flex-shrink-0 ring-2 ring-white/20">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 object-contain"
                    style="max-width: 32px; max-height: 32px; width: 100%; height: auto;">
            </div>
            IDP Talent
        </h1>
    </a>

    <div class="hidden lg:flex items-center gap-8 flex-1 justify-end pr-8">
        <a href="{{ route('talent.dashboard') }}#Kompetensi"
            class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150"
            data-section="Kompetensi">Kompetensi</a>
        <a href="{{ route('talent.dashboard') }}#IDP Monitoring"
            class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150"
            data-section="IDP Monitoring">IDP</a>
        <a href="{{ route('talent.dashboard') }}#Project Improvement"
            class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150"
            data-section="Project Improvement">Project Improvement</a>
        <a href="{{ route('talent.dashboard') }}#Riwayat"
            class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150"
            data-section="Riwayat">Riwayat</a>
    </div>

    @php
        $nama = $user->nama ?? ($user->name ?? 'Talent');
        $parts = explode(' ', trim($nama));
        $initials = strtoupper(
            substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''),
        );
        $avatarUrl = !empty($user?->foto)
            ? asset('storage/' . $user->foto) . '?v=' . (optional($user->updated_at)->timestamp ?? time())
            : null;

        $unreadNotifications = isset($notifications) && $notifications
            ? (is_array($notifications) ? collect($notifications)->where('is_read', false) : $notifications->where('is_read', false))
            : collect();
        $unreadCount = $unreadNotifications->count();
        $displayCount = $unreadCount > 99 ? '99+' : $unreadCount;
        $hasUnreadNotif = $unreadCount > 0;
    @endphp

    <div
        class="flex items-center space-x-2 sm:space-x-3 pl-0 lg:pl-4 border-l-0 lg:border-l border-white/20 lg:ml-0 ml-auto flex-shrink-0">
        <!-- Mobile Dropdown Menu -->
        <div class="relative block lg:hidden" id="mobile-menu-wrapper">
            {{-- Mobile: Hanya tampilkan avatar (tanpa nama) --}}
            <button
                class="flex items-center gap-1.5 p-1.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-[1.02] active:scale-95"
                aria-label="Profil dan notifikasi" id="mobile-menu-btn"
                onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                <div class="relative">
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $nama }}"
                            class="w-9 h-9 rounded-xl object-cover border border-white/15 flex-shrink-0">
                    @else
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
                            style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                            {{ $initials }}
                        </div>
                    @endif
                    @if($hasUnreadNotif)
                        <span
                            class="mobile-trigger-notif-dot absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a]">{{ $displayCount }}</span>
                    @endif
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white/70 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            {{-- Dropdown: ukuran lebih kecil di mobile --}}
            <div id="mobile-menu-dropdown" style="display:none;"
                class="dropdown-panel hidden absolute right-0 mt-3 w-[290px] max-w-[calc(100vw-1rem)] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
                {{-- Dropdown Header --}}
                <div class="px-5 py-5 bg-gradient-to-br from-[#0f172a] to-[#38475a]">
                    <div class="flex items-center gap-3.5">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $nama }}"
                                    class="w-12 h-12 rounded-xl object-cover border border-white/15 flex-shrink-0 shadow-[0_4px_12px_rgba(20,184,166,0.4)]">
                            @else
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-base"
                                    style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                    {{ $initials }}
                                </div>
                            @endif
                        <div class="overflow-hidden">
                            <p class="text-[14px] font-bold text-white truncate">
                                {{ $user->nama ?? ($user->name ?? '-') }}
                            </p>
                            <p class="text-[11px] text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                            <span
                                class="inline-block mt-1.5 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Talent</span>
                        </div>
                    </div>
                </div>

                <div class="py-2.5">
                    {{-- Quick Action: Notifikasi --}}
                    <div class="px-3 mb-1">
                        <a href="{{ route('talent.notifikasi') }}"
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
                                @if($hasUnreadNotif)
                                    <span data-mobile-unread-badge
                                        class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-white">{{ $displayCount }}</span>
                                @endif
                            </div>
                            <span class="font-medium">Notifikasi</span>
                            @if($hasUnreadNotif)
                                <span data-mobile-unread-pill
                                    class="ml-auto bg-[#f97316]/10 text-[#f97316] text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $displayCount }}
                                    Baru</span>
                            @endif
                        </a>
                    </div>

                    <div class="mx-4 border-t border-gray-100 my-1.5"></div>

                    {{-- Section: Dashboard Menu --}}
                    <div class="px-3 space-y-0.5">
                        <a href="{{ route('talent.dashboard') }}#Kompetensi"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium">Kompetensi</span>
                        </a>
                        <a href="{{ route('talent.dashboard') }}#IDP Monitoring"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                </svg>
                            </div>
                            <span class="font-medium">IDP Monitoring</span>
                        </a>
                        <a href="{{ route('talent.dashboard') }}#Project Improvement"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                </svg>
                            </div>
                            <span class="font-medium">Project Improvement</span>
                        </a>
                        <a href="{{ route('talent.dashboard') }}#Riwayat"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-gray-600 hover:bg-gray-50 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium">Lihat Profil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] text-red-500 hover:bg-red-50 transition-colors group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-red-500 group-hover:text-white transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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

            {{-- ── Mobile Notif Dropdown (realtime, dedicated) ── --}}
            <div id="mobile-notif-dropdown" style="display:none;"
                class="dropdown-panel hidden fixed top-[72px] left-3 right-3 w-auto sm:absolute sm:top-auto sm:left-auto sm:right-0 sm:mt-3 sm:w-[340px] bg-white rounded-[1.25rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-gray-100 overflow-hidden z-50 sm:origin-top-right">
                {{-- Header --}}
                <div class="px-5 py-4 bg-gradient-to-r from-[#0f172a] to-[#38475a] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                            <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                        <span class="text-[13px] font-bold text-white">Notifikasi Baru</span>
                    </div>
                    <a href="{{ route('talent.notifikasi') }}"
                        class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">Lihat
                        Semua</a>
                </div>
                {{-- Notification List (populated by JS) --}}
                <ul id="talent-mobile-notif-list" class="divide-y divide-gray-50 max-h-64 overflow-y-auto"></ul>
                {{-- Empty state (default, hidden when items exist) --}}
                <div id="talent-mobile-notif-empty" class="flex flex-col items-center py-8 text-center px-4">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi baru</p>
                </div>
                {{-- Footer --}}
                <div class="px-5 py-3 border-t border-gray-100 text-center">
                    <a href="{{ route('talent.notifikasi') }}"
                        class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">Lihat semua
                        notifikasi →</a>
                </div>
            </div>
        </div>

        <div class="relative hidden lg:block" id="bell-wrapper">
            <button id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')" aria-label="Notifikasi"
                class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                </svg>
                @if($hasUnreadNotif)
                    @php
                        $unreadCount = $unreadNotifications->count();
                        $displayCount = $unreadCount > 99 ? '99+' : $unreadCount;
                    @endphp
                    <span id="bell-red-badge"
                        class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] animate-bounce"
                        style="animation-duration: 2s;">
                        {{ $displayCount }}
                    </span>
                    <span
                        class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40"></span>
                @endif
            </button>

            <div id="bell-dropdown" style="display:none;"
                class="dropdown-panel hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                <div class="px-5 py-3.5 bg-gradient-to-r from-[#0f172a] to-[#38475a] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                            <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                        <span class="text-sm font-bold text-white">Notifikasi</span>
                    </div>
                    <form action="{{ route('talent.notifikasi.markAllRead') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                            Tandai semua
                        </button>
                    </form>
                </div>

                @if($hasUnreadNotif)
                    <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto" id="talent-bell-list">
                        @foreach($unreadNotifications->take(3) as $notif)
                            <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer"
                                onclick="window.location='{{ route('talent.notifikasi') }}'">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                    <div class="flex flex-col items-center py-10 text-center px-4" id="talent-bell-empty-state">
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
                    <a href="{{ route('talent.notifikasi') }}"
                        class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                        Lihat semua notifikasi →
                    </a>
                </div>
            </div>
        </div>

        <div class="relative hidden lg:block" id="profile-wrapper">
            <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')" aria-label="Profil"
                class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                @if($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="{{ $nama }}"
                        class="w-8 h-8 rounded-lg object-cover border border-white/15 flex-shrink-0">
                @else
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                        {{ $initials }}
                    </div>
                @endif
                <div class="hidden lg:block text-left">
                    <p class="text-white text-sm font-semibold leading-tight max-w-[120px] truncate">
                        {{ $nama }}
                    </p>
                    <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">Talent</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white/60 hidden lg:block flex-shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="profile-dropdown" style="display:none;"
                class="dropdown-panel hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                <div class="px-4 py-4 bg-gradient-to-br from-[#0f172a] to-[#38475a]">
                    <div class="flex items-center gap-3">
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $nama }}"
                                class="w-11 h-11 rounded-xl object-cover border border-white/15 flex-shrink-0 shadow-[0_4px_12px_rgba(20,184,166,0.4)]">
                        @else
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-sm"
                                style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                                {{ $initials }}
                            </div>
                        @endif
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-white truncate">{{ $user->nama ?? ($user->name ?? '-') }}
                            </p>
                            <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                            <span
                                class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">Talent</span>
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
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
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
                                <div
                                    class="w-7 h-7 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
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
