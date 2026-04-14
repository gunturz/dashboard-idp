<div class="navbar-outer">
    <a href="{{ route('talent.dashboard') }}"
        class="flex items-center gap-3 hover:opacity-90 transition-opacity flex-shrink-0">
        <div class="hidden sm:flex items-center justify-center w-11 h-11 lg:w-12 lg:h-12 bg-white rounded-xl shadow-md flex-shrink-0 ring-2 ring-white/20">
            <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-8 h-8 lg:w-9 lg:h-9 object-contain">
        </div>
        <div class="hidden sm:block">
            <h1 class="text-white font-extrabold text-lg lg:text-xl leading-tight tracking-wide">Individual
                Development Plan</h1>
        </div>
        <h1 class="text-white font-bold text-base sm:hidden flex items-center gap-2">
            <div class="flex items-center justify-center w-8 h-8 bg-white rounded-lg shadow-md flex-shrink-0 ring-2 ring-white/20">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-5 h-5 object-contain">
            </div>
            IDP Talent
        </h1>
    </a>


    <div class="hidden xl:flex items-center gap-8 ml-auto pr-8">
        <a href="{{ route('talent.dashboard') }}#Kompetensi" class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150" data-section="Kompetensi">Kompetensi</a>
        <a href="{{ route('talent.dashboard') }}#IDP Monitoring" class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150" data-section="IDP Monitoring">IDP</a>
        <a href="{{ route('talent.dashboard') }}#Project Improvement" class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150" data-section="Project Improvement">Project Improvement</a>
        <a href="{{ route('talent.dashboard') }}#LogBook" class="nav-menu-link text-white/60 font-semibold text-sm pb-0.5 hover:text-white transition-colors duration-150" data-section="LogBook">LogBook</a>

    </div>

    <div class="flex items-center space-x-2 sm:space-x-3 pl-0 lg:pl-4 border-l-0 lg:border-l border-white/20 lg:ml-0 ml-auto">
        <!-- Mobile Dropdown Menu -->
        <div class="relative block lg:hidden" id="mobile-menu-wrapper">
            <button class="flex items-center justify-center w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 transition-colors mr-1 cursor-pointer" aria-label="Menu" id="mobile-menu-btn" onclick="toggleDropdown('mobile-menu-dropdown', 'mobile-menu-btn')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div id="mobile-menu-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-[300px] bg-white rounded-[1.25rem] shadow-[0_15px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 origin-top-right">
                <!-- Header Component adapted from image -->
                <div class="px-5 py-5 border-b border-gray-100 flex items-center justify-between bg-white relative">
                    <div class="flex items-center gap-3.5">
                        @if ($user->foto ?? false)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="w-[52px] h-[52px] rounded-full object-cover outline outline-1 outline-[#003865]/10 ring-[3px] ring-white shadow-sm">
                        @else
                            @php
                                $nameParts = explode(' ', $user->nama ?? $user->name);
                                $initials = count($nameParts) >= 2 ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1)) : strtoupper(substr($nameParts[0], 0, 2));
                            @endphp
                            <div class="w-[52px] h-[52px] rounded-full bg-[#466675] text-white flex items-center justify-center font-bold text-lg tracking-wide outline outline-1 outline-[#003865]/20 ring-[3px] ring-white shadow-sm flex-shrink-0">
                                {{ $initials }}
                            </div>
                        @endif
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
                
                <ul class="py-3 px-3">
                    <li class="mb-1">
                        <a href="{{ route('talent.notifikasi') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-[14px] text-[#475569] hover:bg-slate-50 transition-colors font-medium">
                            <span>Notifikasi</span>
                            @if ($notifications->where('is_read', false)->count() > 0)
                                <span class="bg-[#f97316] text-white text-[12px] font-bold px-3.5 py-1 rounded-[12px] shadow-sm tracking-wide">{{ $notifications->where('is_read', false)->count() }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('talent.dashboard') }}#Kompetensi" class="nav-menu-link block px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap" data-section="Kompetensi">
                            Kompetensi
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('talent.dashboard') }}#IDP Monitoring" class="nav-menu-link block px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap" data-section="IDP Monitoring">
                            IDP Monitoring
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('talent.dashboard') }}#Project Improvement" class="nav-menu-link block px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap" data-section="Project Improvement">
                            Project Improvement
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('talent.dashboard') }}#LogBook" class="nav-menu-link block px-4 py-3 rounded-xl text-[14px] transition-colors whitespace-nowrap" data-section="LogBook">
                            LogBook
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

        <div class="relative hidden lg:block" id="bell-wrapper">
            @php
                $unreadNotifications = isset($notifications) && $notifications
                    ? (is_array($notifications) ? collect($notifications)->where('is_read', false) : $notifications->where('is_read', false))
                    : collect();
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
                    <form action="{{ route('talent.notifikasi.markAllRead') }}" method="POST" class="m-0">
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
                                onclick="window.location='{{ route('talent.notifikasi') }}'">
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
                    <a href="{{ route('talent.notifikasi') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                        Lihat semua notifikasi →
                    </a>
                </div>
            </div>
        </div>

        <div class="relative hidden lg:block" id="profile-wrapper">
            @php
                $nama = $user->nama ?? ($user->name ?? 'Talent');
                $parts = explode(' ', trim($nama));
                $initials = strtoupper(
                    substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''),
                );
            @endphp
            <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')" aria-label="Profil"
                class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0"
                    style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                    {{ $initials }}
                </div>
                <div class="hidden lg:block text-left">
                    <p class="text-white text-sm font-semibold leading-tight max-w-[120px] truncate">
                        {{ $nama }}</p>
                    <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">Talent</p>
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
                            <p class="text-sm font-bold text-white truncate">{{ $user->nama ?? ($user->name ?? '-') }}</p>
                            <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                            <span class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">Talent</span>
                        </div>
                    </div>
                </div>

                <ul class="py-1.5">
                    <li>
                        <a href="{{ route('profile.edit') }}"
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
