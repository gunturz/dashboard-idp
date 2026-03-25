<div class="navbar-outer">
    <a href="{{ route('talent.dashboard') }}" class="flex items-center gap-4 flex-shrink-0 hover:opacity-90 transition-opacity">
        <div class="bg-white p-2 rounded-[10px] shadow-sm flex items-center justify-center w-14 h-14">
            <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
        </div>
        <h1 class="text-white text-xl font-bold tracking-wide whitespace-nowrap">
            Individual Development Plan
        </h1>
    </a>

    <div class="flex items-center space-x-14 text-white text-sm ml-auto pr-6">
        <a href="{{ route('talent.dashboard') }}#Kompetensi" class="nav-menu-link hover:text-white transition-colors duration-150" data-section="Kompetensi">Kompetensi</a>
        <a href="{{ route('talent.dashboard') }}#IDP Monitoring" class="nav-menu-link hover:text-white transition-colors duration-150" data-section="IDP Monitoring">IDP</a>
        <a href="{{ route('talent.dashboard') }}#Project Improvement" class="nav-menu-link hover:text-white transition-colors duration-150" data-section="Project Improvement">Project Improvement</a>
        <a href="{{ route('talent.dashboard') }}#LogBook" class="nav-menu-link hover:text-white transition-colors duration-150" data-section="LogBook">LogBook</a>
    </div>

    <div class="flex items-center space-x-3 pl-4 border-l border-white/20">
        <div class="relative" id="bell-wrapper">
            <button class="nav-icon-btn" aria-label="Notifikasi" id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')">
                @if ($notifications->where('is_read', false)->count() > 0)
                    <span class="notif-badge"></span>
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                </svg>
            </button>
            <div id="bell-dropdown" class="dropdown-panel hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-700">Notifikasi</span>
                    <form action="{{ route('talent.notifikasi.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-teal-500 font-semibold cursor-pointer hover:underline">Tandai semua</button>
                    </form>
                </div>
                <ul class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                    @foreach ($notifications as $notif)
                        <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('talent.notifikasi') }}'">
                            @if (!$notif['is_read'])
                                <span class="w-2 h-2 mt-1.5 rounded-full bg-teal-500 flex-shrink-0"></span>
                            @else
                                <span class="w-2 h-2 mt-1.5 rounded-full bg-gray-300 flex-shrink-0"></span>
                            @endif
                            <div>
                                <p class="text-sm {{ !$notif['is_read'] ? 'text-gray-700 font-medium' : 'text-gray-500' }}">
                                    {!! $notif['title'] !!}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $notif['time'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                    <a href="{{ route('talent.notifikasi') }}" class="text-xs text-gray-400 font-medium hover:text-teal-600 transition-colors">Lihat semua notifikasi</a>
                </div>
            </div>
        </div>

        <div class="relative" id="profile-wrapper">
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
