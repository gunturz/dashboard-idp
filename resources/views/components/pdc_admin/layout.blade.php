@props([
    'title' => 'PDC Admin – Individual Development Plan',
    'user' => null,
    'hideSidebar' => false,
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
            background: #2e3746;
            padding: 0 1.75rem;
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

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px !important;
                top: 60px !important;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .sidebar.mobile-open .sidebar-label {
                opacity: 1 !important;
                width: auto !important;
                pointer-events: auto !important;
            }
            .sidebar.mobile-open .sidebar-item {
                padding: 12px 28px !important;
                justify-content: flex-start !important;
                gap: 16px !important;
            }
            .sidebar.mobile-open .toggle-btn {
                display: none; /* Hide desktop toggle on mobile */
            }
            #main-content {
                margin-left: 0 !important;
                padding: 16px !important;
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
        }
    </style>
    {{ $styles ?? '' }}
</head>

<body class="bg-white min-h-screen pt-[60px] lg:pt-[80px]">

    {{-- Overlay responsive --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-30 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

    @include('components.pdc_admin.navbar', ['user' => $user ?? auth()->user() ])

    {{-- SIDEBAR --}}
    @if(!$hideSidebar)
    <div class="sidebar" id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300" id="toggle-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </div>
        
        <a href="{{ route('pdc_admin.dashboard') }}"
            class="sidebar-item {{ request()->routeIs('pdc_admin.dashboard') ? 'active' : '' }}"
            title="Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="sidebar-label">Dashboard</span>
        </a>

        <a href="{{ route('pdc_admin.progress_talent') }}"
            class="sidebar-item {{ request()->routeIs('pdc_admin.progress_talent') ? 'active' : '' }}"
            title="Progress Talent">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="sidebar-label">Progress Talent</span>
        </a>



        <a href="{{ route('pdc_admin.kompetensi') }}" class="sidebar-item {{ request()->routeIs('pdc_admin.kompetensi') ? 'active' : '' }}" title="Kompetensi">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-label">Kompetensi</span>
        </a>

        <a href="{{ route('pdc_admin.mentor') }}" class="sidebar-item {{ request()->routeIs('pdc_admin.mentor') ? 'active' : '' }}" title="User Management">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="sidebar-label">User Management</span>
        </a>



        <a href="{{ route('pdc_admin.finance_validation') }}" class="sidebar-item {{ request()->routeIs('pdc_admin.finance_validation') ? 'active' : '' }}" title="Finance Validation">
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
    @endif

    {{-- MAIN CONTENT --}}
    <main id="main-content" class="p-8 {{ $hideSidebar ? '!ml-0' : '' }}">
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

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('mobile-open');
            if (sidebar.classList.contains('mobile-open')) {
                overlay.classList.remove('hidden');
            } else {
                overlay.classList.add('hidden');
            }
        }
    </script>
    {{ $scripts ?? '' }}
</body>

</html>
