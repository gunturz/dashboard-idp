@props([
    'title' => 'PDC Admin – Individual Development Plan',
    'user' => null,
    'hideSidebar' => false,
    'hideNavbar' => false,
])

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

        /* ══ Premium Stats Cards ══ */
        .prem-stat-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 24px;
        }

        .prem-stat {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 20px 18px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .prem-stat.clickable {
            cursor: pointer;
        }

        a.prem-stat:hover,
        button.prem-stat:hover,
        .prem-stat.clickable:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.09);
            border-color: #e2e8f0;
        }

        /* Always-visible top accent border */
        .prem-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3.5px;
            border-radius: 16px 16px 0 0;
        }

        /* Colors – accent always visible */
        .prem-stat-teal::before {
            background: linear-gradient(90deg, #14b8a6, #2dd4bf);
        }

        .prem-stat-blue::before {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .prem-stat-amber::before {
            background: linear-gradient(90deg, #f59e0b, #fcd34d);
        }

        .prem-stat-green::before {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .prem-stat-purple::before {
            background: linear-gradient(90deg, #8b5cf6, #a78bfa);
        }

        .prem-stat-red::before {
            background: linear-gradient(90deg, #ef4444, #f87171);
        }

        .prem-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-bottom: 14px;
        }

        .prem-stat-icon svg {
            width: 22px;
            height: 22px;
        }

        .si-teal {
            background: rgba(20, 184, 166, 0.12);
            color: #14b8a6;
        }

        .si-blue {
            background: rgba(59, 130, 246, 0.12);
            color: #3b82f6;
        }

        .si-amber {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
        }

        .si-green {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
        }

        .si-purple {
            background: rgba(139, 92, 246, 0.12);
            color: #8b5cf6;
        }

        .si-red {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .prem-stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .prem-stat-label {
            font-size: 0.82rem;
            color: #64748b;
            font-weight: 500;
        }

        /* ══ Page Header ══ */
        .page-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-header-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #2e3746 0%, #3d4f65 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(46, 55, 70, 0.25);
            flex-shrink: 0;
            color: white;
        }

        .page-header-icon svg {
            width: 26px;
            height: 26px;
        }

        .page-header-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.15;
        }

        .page-header-sub {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 3px;
            font-weight: 400;
        }

        /* ══ Premium Card ══ */
        .prem-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .prem-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            gap: 12px;
            flex-wrap: wrap;
        }

        .prem-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .9rem;
            font-weight: 700;
            color: #1e293b;
        }

        .prem-card-title svg {
            width: 18px;
            height: 18px;
            color: #14b8a6;
            flex-shrink: 0;
        }

        /* ══ Premium Buttons ══ */
        .btn-prem {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-prem:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .btn-prem svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .btn-teal {
            background: #14b8a6;
            color: #fff;
            box-shadow: 0 2px 6px rgba(20, 184, 166, 0.25);
        }

        .btn-teal:hover {
            background: #0d9488;
            color: #fff;
        }

        .btn-ghost {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .btn-ghost:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .btn-red {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.25);
        }

        .btn-red:hover {
            background: #dc2626;
            color: #fff;
        }

        .btn-dark {
            background: #475569;
            color: #fff;
        }

        .btn-dark:hover {
            background: #334155;
            color: #fff;
        }

        /* ══ Badges ══ */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .badge-teal {
            background: rgba(20, 184, 166, 0.12);
            color: #0d9488;
            border: 1px solid rgba(20, 184, 166, 0.25);
        }

        .badge-amber {
            background: rgba(245, 158, 11, 0.12);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .badge-green {
            background: rgba(16, 185, 129, 0.12);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .badge-red {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .badge-blue {
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
            border: 1px solid rgba(59, 130, 246, 0.25);
        }

        .badge-gray {
            background: rgba(100, 116, 139, 0.1);
            color: #475569;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        /* ══ Empty State ══ */
        .empty-prem {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 24px;
            text-align: center;
            gap: 12px;
        }

        .empty-prem svg {
            width: 56px;
            height: 56px;
            color: #cbd5e1;
        }

        .empty-prem h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #475569;
            margin: 0;
        }

        .empty-prem p {
            font-size: 0.82rem;
            color: #94a3b8;
            margin: 0;
        }

        /* ══ Page Header Actions ══ */
        .page-header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        /* ══ Premium Table ══ */
        .prem-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .prem-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-align: center;
            padding: 11px 14px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .prem-table td {
            padding: 13px 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
            text-align: center;
        }

        .prem-table tbody tr:last-child td {
            border-bottom: none;
        }

        .prem-table tbody tr:hover td {
            background: #f0fdfa;
        }

        /* ══ Filter Bar ══ */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .03);
        }

        .filter-input {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 0.83rem;
            color: #334155;
            outline: none;
            background: #f8fafc;
            transition: border-color .2s, box-shadow .2s;
        }

        .filter-input:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
            background: #fff;
        }

        /* ══ Company Section Title ══ */
        .company-section-title {
            font-size: 1rem;
            font-weight: 800;
            color: #1e293b;
            padding: 4px 0 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .company-section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 18px;
            background: linear-gradient(180deg, #14b8a6, #0d9488);
            border-radius: 99px;
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

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #232d3a 0%, #2a3444 60%, #243040 100%);
            position: fixed;
            top: 80px;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 8px;
            z-index: 40;
            border-right: 1px solid rgba(20, 184, 166, 0.15);
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
        }

        /* Glowing right border accent */
        .sidebar::after {
            content: '';
            position: absolute;
            top: 10%;
            right: 0;
            bottom: 10%;
            width: 2px;
            background: linear-gradient(180deg, transparent 0%, #14b8a6 30%, #0d9488 70%, transparent 100%);
            opacity: 0.5;
            border-radius: 99px;
        }

        .sidebar.collapsed {
            width: 72px;
            overflow: visible;
        }

        /* Section label */
        .sidebar-section-label {
            padding: 4px 20px 6px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(20, 184, 166, 0.5);
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-section-label {
            display: none;
        }

        /* Sidebar items */
        .sidebar-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 20px 11px 24px;
            margin: 2px 10px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.65);
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-item {
            padding: 11px 0 !important;
            margin: 2px 0 !important;
            border-radius: 0 !important;
            justify-content: center;
            gap: 0;
        }

        .sidebar-item:hover {
            color: #5eead4;
            background: rgba(20, 184, 166, 0.08);
        }

        .sidebar-item:hover .sidebar-icon {
            color: #5eead4;
        }

        /* Active state: teal left bar + teal tint */
        .sidebar-item.active {
            color: #ffffff;
            background: rgba(20, 184, 166, 0.14);
            font-weight: 600;
        }

        .sidebar-item.active .sidebar-icon {
            color: #14b8a6;
        }

        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: linear-gradient(180deg, #5eead4 0%, #14b8a6 100%);
            border-radius: 0 3px 3px 0;
            box-shadow: 0 0 8px rgba(20, 184, 166, 0.7);
        }

        .sidebar.collapsed .sidebar-item.active::before {
            top: 0;
            bottom: 0;
        }

        /* Icon color */
        .sidebar-icon {
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.22s;
            flex-shrink: 0;
        }

        .sidebar-label {
            transition: opacity 0.2s;
            opacity: 1;
        }

        .sidebar.collapsed .sidebar-label {
            display: none !important;
            opacity: 0;
            pointer-events: none;
            width: 0;
            overflow: hidden;
        }

        /* Toggle Button */
        .toggle-btn {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding: 10px 18px;
            color: rgba(255, 255, 255, 0.35);
            cursor: pointer;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .sidebar.collapsed .toggle-btn {
            justify-content: center;
            padding: 10px 0;
            width: 72px;
        }

        .toggle-btn:hover {
            color: #14b8a6;
        }

        /* Sidebar footer */
        .sidebar-footer {
            margin-top: auto;
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .sidebar.collapsed .sidebar-footer {
            justify-content: center;
            padding: 14px 0;
        }

        .sidebar-footer-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #14b8a6, #0d9488);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.35);
        }

        .sidebar-footer-info {
            overflow: hidden;
        }

        .sidebar-footer-info p {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-footer-info span {
            font-size: 10px;
            color: #14b8a6;
            font-weight: 500;
        }

        .sidebar.collapsed .sidebar-footer-info {
            display: none;
        }

        .sidebar.no-transition,
        #main-content.no-transition,
        #toggle-icon.no-transition {
            transition: none !important;
        }

        #main-content {
            margin-left: 260px;
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #main-content.collapsed {
            margin-left: 72px;
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

            /* Paksa label tampil di mobile meski sidebar punya class collapsed */
            .sidebar.mobile-open .sidebar-label {
                display: block !important;
                opacity: 1 !important;
                width: auto !important;
                overflow: visible !important;
                pointer-events: auto !important;
            }

            .sidebar.mobile-open .sidebar-item {
                padding: 11px 20px 11px 24px !important;
                margin: 2px 10px !important;
                border-radius: 12px !important;
                justify-content: flex-start !important;
                gap: 14px !important;
            }

            .sidebar.mobile-open .toggle-btn {
                display: none;
                /* Hide desktop toggle on mobile */
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

<body class="bg-white min-h-screen {{ $hideNavbar ? '' : 'pt-[60px] lg:pt-[80px]' }}">
    <script>
        (function() {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                const style = document.createElement('style');
                style.innerHTML = `
                    .sidebar { width: 72px !important; transition: none !important; }
                    #main-content { margin-left: 72px !important; transition: none !important; }
                    #toggle-icon { transform: rotate(180deg) !important; transition: none !important; }
                    .sidebar-label { display: none !important; }
                `;
                document.head.appendChild(style);

                window.addEventListener('DOMContentLoaded', () => {
                    const sb = document.getElementById('sidebar');
                    const mc = document.getElementById('main-content');
                    const ti = document.getElementById('toggle-icon');
                    if (sb) sb.classList.add('collapsed');
                    if (mc) mc.classList.add('collapsed');
                    if (ti) ti.style.transform = 'rotate(180deg)';
                    style.remove();
                });
            }
        })();
    </script>

    {{-- Overlay responsive --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-30 hidden lg:hidden"
        onclick="toggleMobileSidebar()"></div>
    @if (!$hideNavbar)
        @include('components.pdc_admin.navbar', [
            'user' => $user ?? auth()->user(),
            'hideSidebar' => $hideSidebar,
        ])
    @endif

    {{-- SIDEBAR --}}
    @if (!$hideSidebar)
        <div class="sidebar" id="sidebar">

            {{-- Toggle Collapse --}}
            <div class="toggle-btn" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300"
                    id="toggle-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </div>

            {{-- Dashboard --}}
            <a href="{{ route('pdc_admin.dashboard') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="sidebar-label">Dashboard</span>
            </a>

            {{-- Progress Talent --}}
            <a href="{{ route('pdc_admin.progress_talent') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.progress_talent') ? 'active' : '' }}"
                title="Progress Talent">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span class="sidebar-label">Progress Talent</span>
            </a>

            {{-- Kompetensi --}}
            <a href="{{ route('pdc_admin.kompetensi') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.kompetensi') ? 'active' : '' }}"
                title="Kompetensi">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="sidebar-label">Kompetensi</span>
            </a>

            {{-- Company Management --}}
            <a href="{{ route('pdc_admin.company_management') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.company_management') ? 'active' : '' }}"
                title="Company Management">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
                <span class="sidebar-label">Company Management</span>
            </a>

            {{-- User Management --}}
            <a href="{{ route('pdc_admin.user_management') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.user_management') ? 'active' : '' }}"
                title="User Management">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <span class="sidebar-label">User Management</span>
            </a>

            {{-- Finance Validation --}}
            <a href="{{ route('pdc_admin.finance_validation') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.finance_validation') ? 'active' : '' }}"
                title="Finance Validation">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="sidebar-label">Finance Validation</span>
            </a>

            {{-- Panelis Review --}}
            <a href="{{ route('pdc_admin.panelis_review') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.panelis_review') ? 'active' : '' }}"
                title="Panelis Review">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                </svg>
                <span class="sidebar-label">Panelis Review</span>
            </a>

            {{-- Progress Archive --}}
            <a href="{{ route('pdc_admin.export') }}"
                class="sidebar-item {{ request()->routeIs('pdc_admin.export') ? 'active' : '' }}"
                title="Progress Archive">
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <span class="sidebar-label">Progress Archive</span>
            </a>

        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main id="main-content" class="px-4 lg:px-6 py-8 {{ $hideSidebar ? '!ml-0' : '' }}">

        {{-- GLOBAL FLASH MESSAGES --}}
        {{-- Flash messages are handled inside individual views, e.g., panelis-review.blade.php --}}

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

        // Persistent sidebar state check (handled early by inline script, but this keeps it consistent)
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleIcon = document.getElementById('toggle-icon');

            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
                toggleIcon.style.transform = 'rotate(180deg)';
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

            if (!sidebar) return;

            sidebar.classList.toggle('mobile-open');
            if (sidebar.classList.contains('mobile-open')) {
                overlay.classList.remove('hidden');
            } else {
                overlay.classList.add('hidden');
            }
        }
    </script>
    <script>
        // Custom scripts block has been removed for SweetAlert
    </script>
    {{ $scripts ?? '' }}
</body>

</html>
