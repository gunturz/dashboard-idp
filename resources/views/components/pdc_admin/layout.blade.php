@props([
    'title' => 'PDC Admin – Individual Development Plan',
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
        }

        /* ── Navbar notification badge ── */
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

        /* ── Icon buttons ── */
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

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #2e3746;
            position: fixed;
            top: 80px;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 10px;
            z-index: 40;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 28px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-item {
            padding-left: 0;
            padding-right: 0;
            justify-content: center;
            gap: 0;
        }

        .sidebar-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.08);
        }

        .sidebar-item.active {
            color: white;
            background: rgba(255, 255, 255, 0.12);
        }

        .sidebar-label {
            transition: opacity 0.2s, transform 0.2s;
            opacity: 1;
        }

        .sidebar.collapsed .sidebar-label {
            opacity: 0;
            pointer-events: none;
            width: 0;
            display: inline-block;
            overflow: hidden;
        }

        /* Toggle Button */
        .toggle-btn {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: color 0.2s;
        }

        .sidebar.collapsed .toggle-btn {
            justify-content: center;
            padding: 12px 0;
            width: 80px;
        }

        .toggle-btn:hover {
            color: white;
        }

        /* Main Content adjustment */
        #main-content {
            margin-left: 260px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #main-content.collapsed {
            margin-left: 80px;
        }
        
        /* Dropdown panel */
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
    </style>
    {{ $styles ?? '' }}
</head>

<body class="bg-gray-50 min-h-screen pt-[80px]">

    <div class="navbar-outer">
        <a href="{{ route('pdc_admin.dashboard') }}" class="flex items-center gap-4 flex-shrink-0 hover:opacity-90 transition-opacity">
            <div class="bg-white p-2 rounded-[10px] shadow-sm flex items-center justify-center w-14 h-14">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white text-xl font-bold tracking-wide whitespace-nowrap">
                Individual Development Plan
            </h1>
        </a>

        <div class="flex items-center space-x-3 ml-auto pr-6">
            {{-- Notification --}}
            <div class="relative" id="bell-wrapper">
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

            {{-- Profile --}}
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

    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300" id="toggle-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </div>
        
        <a href="{{ route('pdc_admin.dashboard') }}"
            class="sidebar-item {{ request()->routeIs('pdc_admin.dashboard') ? 'active' : '' }}"
            title="Progress Talent">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="sidebar-label">Progress Talent</span>
        </a>
        <a href="{{ route('pdc_admin.development_plan') }}"
            class="sidebar-item {{ request()->routeIs('pdc_admin.development_plan') ? 'active' : '' }}"
            title="Development Plan">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span class="sidebar-label">Development Plan</span>
        </a>
        <a href="#" class="sidebar-item" title="GAP & Prioritas IDP">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-label">GAP & Prioritas IDP</span>
        </a>
        <a href="#" class="sidebar-item" title="Mentor">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="sidebar-label">Mentor</span>
        </a>
        <a href="#" class="sidebar-item" title="Schedule">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="sidebar-label">Schedule</span>
        </a>
        <a href="#" class="sidebar-item" title="Finance Validation">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-label">Finance Validation</span>
        </a>
        <a href="#" class="sidebar-item" title="Export">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span class="sidebar-label">Export</span>
        </a>
    </div>

    {{-- MAIN CONTENT --}}
    <main id="main-content" class="p-8">
        {{ $slot }}
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleIcon = document.getElementById('toggle-icon');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.style.transform = 'rotate(180deg)';
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                toggleIcon.style.transform = 'rotate(0deg)';
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        }

        // Persistent sidebar state
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                toggleSidebar();
            }
        });

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
    </script>
    {{ $scripts ?? '' }}
</body>

</html>
