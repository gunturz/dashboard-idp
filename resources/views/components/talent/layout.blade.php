@props([
    'title' => 'Individual Development Plan',
    'bodyClass' => 'bg-[#ffffff] min-h-screen flex flex-col pt-[80px] relative',
    'showProfileCard' => false,
    'mobileCollapsible' => false,
    'user' => null,
    'notifications' => null
])

@php
    $unreadNotifications =
        isset($notifications) && $notifications
            ? (is_array($notifications)
                ? collect($notifications)->where('is_read', false)
                : $notifications->where('is_read', false))
            : collect();
    $hasUnreadNotif = $unreadNotifications->count() > 0;
@endphp

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
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #0d9488;
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0f766e;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #0d9488 transparent;
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

        /* ── Smooth entrance ── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeSlideUp 0.5s ease both;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.12s;
        }

        .fade-up-3 {
            animation-delay: 0.20s;
        }

        .fade-up-4 {
            animation-delay: 0.28s;
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
            background: #0f172a;
            padding: 1rem 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-outer.nav-hidden {
            transform: translateY(-110%);
        }

        /* ── Navbar padding ── */

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

        /* ── Nav menu links (active bold) ── */
        .nav-menu-link {
            transition: color 0.2s, border-color 0.2s;
        }

        .nav-menu-link.active {
            color: #ffffff !important;
            border-bottom-width: 2px !important;
            border-bottom-color: #14b8a6 !important;
            border-bottom-style: solid !important;
        }

        /* Mobile Dropdown Nav Links Overlay */
        .dropdown-panel .nav-menu-link {
            color: #475569;
            font-weight: 500;
            border-bottom: none;
            padding-bottom: 0.75rem;
        }
        .dropdown-panel .nav-menu-link:hover {
            color: #0d9488;
            background-color: #f8fafc;
        }
        .dropdown-panel .nav-menu-link.active {
            color: #0d9488;
            font-weight: 700;
            background-color: #f8fafc;
            border-bottom: none;
        }

        /* ── Mobile profile collapsible ── */
        .mobile-profile-detail-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-profile-detail-panel.open {
            max-height: 400px !important;
        }
        @media (min-width: 768px) {
            /* Make the main hero card a 5-column grid:
               [section1] [divider] [section2] [divider] [section3] */
            .talent-prof-hero {
                display: grid;
                grid-template-columns: 1fr auto 1fr auto 1fr;
                align-items: stretch;
            }
            /* Panel becomes "invisible" — its children join the grid directly */
            .mobile-profile-detail-panel {
                max-height: none !important;
                overflow: visible;
                display: contents;
            }
            .talent-hero-section-1 {
                display: flex;
                align-items: center;
            }
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .navbar-outer {
                padding: 12px 16px;
            }
            .nav-icon-btn {
                width: 38px;
                height: 38px;
            }
            .notif-badge {
                width: 7px;
                height: 7px;
            }
            body.pt-\[80px\] {
                padding-top: 60px !important;
            }
        }

            /* ── Mobile: prevent horizontal page scroll ── */
            @media (max-width: 767px) {
                html, body {
                    overflow-x: hidden !important;
                    max-width: 100vw;
                }
            }

            /* ── Page Header (Admin Style) ── */
            .page-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 28px;
            }
            .page-header-icon {
                width: 52px;
                height: 52px;
                border-radius: 18px;
                background: #0f172a;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 8px 16px -4px rgba(30, 41, 59, 0.3);
                flex-shrink: 0;
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .page-header-icon:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px -6px rgba(30, 41, 59, 0.35);
                background: #1e293b;
            }
            .page-header-icon svg { width: 26px; height: 26px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
            .page-header-title {
                font-size: 1.75rem;
                font-weight: 800;
                color: #0f172a;
                line-height: 1.15;
                letter-spacing: -0.025em;
            }
            .page-header-sub {
                font-size: 0.8rem;
                color: #64748b;
                margin-top: 3px;
                font-weight: 400;
            }

            /* ── Section Title (Admin Style) ── */
            .section-title {
                font-size: 1.1rem;
                font-weight: 800;
                color: #1e293b;
                padding: 4px 0 10px;
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 12px;
            }
            .section-title::before {
                content: '';
                display: inline-block;
                width: 5px;
                height: 20px;
                background: linear-gradient(180deg, #10b981, #059669);
                border-radius: 9999px;
                box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
            }

            /* ── Premium Card Style ── */
            .prem-card {
                background: #f9fafb;
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 24px;
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .prem-card:hover {
                background: #f9fafb;
                transform: translateY(-2px);
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

<body class="{{ $bodyClass }}">

    <div class="bg-decoration">
    </div>

    {{-- NAVBAR --}}
    @include('components.talent.navbar', ['user' => $user ?? auth()->user(), 'notifications' => $notifications ?? collect([])])

    {{-- PROFILE CARD --}}
    @if($showProfileCard)
        @include('components.talent.profile-card', ['user' => $user ?? auth()->user(), 'mobileCollapsible' => $mobileCollapsible])
    @endif

    {{-- MAIN CONTENT --}}
    {{ $slot }}

    {{-- FOOTER --}}
    @if(request()->routeIs('talent.dashboard'))
    <footer class="mt-auto w-full relative z-10 border-t border-white/5 bg-[#0f172a] py-[50px] px-8">
        <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row items-center justify-between gap-[20px]">
            {{-- Bagian Kiri: Logo & Deskripsi --}}
            <div class="flex items-center gap-[12px]">
                <img src="{{ asset('asset/logo%20ts.png') }}" alt="Logo" class="h-[52px] w-[52px] object-contain bg-white p-[6px] rounded-xl" style="max-width: 52px; max-height: 52px; width: 100%; height: auto;">
                <div class="text-left text-[0.75rem] text-white/30 leading-[1.6]">
                    <strong class="text-white/50 text-[0.8rem]">IDP Dashboard</strong><br>
                    Platform Individual Development Plan
                </div>
            </div>
            
            {{-- Bagian Tengah: Links --}}
            <div class="flex flex-wrap justify-center gap-6 text-[0.78rem]">
                <a href="{{ route('talent.dashboard') }}#Kompetensi" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Kompetensi</a>
                <a href="{{ route('talent.dashboard') }}#IDP Monitoring" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">IDP</a>
                <a href="{{ route('talent.dashboard') }}#Project Improvement" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Project Improvement</a>
                <a href="{{ route('talent.riwayat') }}" class="text-white/40 hover:text-emerald-400 transition-colors" style="text-decoration:none;">Riwayat</a>
            </div>

            {{-- Bagian Kanan: Copyright --}}
            <div class="text-center md:text-right text-[0.75rem] text-white/30 leading-[1.6]">
                &copy; {{ date('Y') }} IDP Dashboard. All rights reserved.
            </div>
        </div>
    </footer>
    @endif

    <script>
        // Hide navbar on scroll down, show on scroll up
        (function() {
            const navbar = document.querySelector('.navbar-outer');
            let lastScrollY = window.scrollY;
            let ticking = false;

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        const currentScrollY = window.scrollY;
                        if (currentScrollY > lastScrollY && currentScrollY > 80) {
                            // Scroll down — hide navbar
                            navbar.classList.add('nav-hidden');
                        } else {
                            // Scroll up — show navbar
                            navbar.classList.remove('nav-hidden');
                        }
                        lastScrollY = currentScrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        })();

        // ── Dropdown toggle (bell & profile) ──
        function toggleDropdown(dropdownId, btnId) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;

            const isHidden = dropdown.classList.contains('hidden');

            // Tutup semua dropdown lain dulu
            document.querySelectorAll('.dropdown-panel').forEach(el => {
                el.classList.add('hidden');
                el.style.display = 'none';
            });

            if (isHidden) {
                dropdown.classList.remove('hidden');
                dropdown.style.display = '';
            }
        }

        // Klik di luar → tutup semua dropdown
        document.addEventListener('click', function(e) {
            const wrappers = ['bell-wrapper', 'profile-wrapper', 'mobile-menu-wrapper'];
            const clickedInside = wrappers.some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!clickedInside) {
                document.querySelectorAll('.dropdown-panel').forEach(el => {
                    el.classList.add('hidden');
                    el.style.display = 'none';
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.dropdown-panel').forEach(el => {
                el.classList.add('hidden');
                el.style.display = 'none';
            });

            const shouldShowTalentNotifPopup = @json(session()->pull('talent_just_logged_in', false) && $hasUnreadNotif && config('app.env') !== 'testing');

            if (shouldShowTalentNotifPopup) {
                setTimeout(function () {
                    const bellDropdown = document.getElementById('bell-dropdown');
                    if (!bellDropdown) return;

                    bellDropdown.classList.remove('hidden');
                    bellDropdown.style.display = '';
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
                                bellDropdown.style.display = 'none';
                                bellDropdown.style.transform = '';
                                bellDropdown.style.opacity = '';
                                bellDropdown.style.transition = '';
                                bellDropdown.style.transformOrigin = '';
                            }, 500);
                        }
                    }, 5000);
                }, 250);
            }
        });

        // ── Toggle mobile profile detail ──
        function toggleMobileProfile() {
            const detail = document.getElementById('mobile-profile-detail');
            const chevron = document.getElementById('mobile-profile-chevron');
            if (!detail) return;
            detail.classList.toggle('open');
            if (chevron) {
                chevron.style.transform = detail.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }

        // ── Active nav menu on scroll ──
        (function() {
            const links = document.querySelectorAll('.nav-menu-link');
            if (!links.length) return;

            // On click, immediately set active
            links.forEach(link => {
                link.addEventListener('click', function() {
                    links.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // On scroll, detect which section is in view
            function updateActiveOnScroll() {
                // If on separate pages, keep those highlighted
                const path = window.location.pathname;
                if (path.includes('/profile') || path.includes('/profil')) {
                    links.forEach(l => l.classList.remove('active'));
                    return;
                }
                if (path.includes('/talent/riwayat')) {
                    links.forEach(l => {
                        if (l.getAttribute('data-section') === 'Riwayat') l.classList.add('active');
                        else l.classList.remove('active');
                    });
                    return;
                }
                if (path.includes('/talent/idp-monitoring') || path.includes('/talent/logbook')) {
                    links.forEach(l => {
                        if (l.getAttribute('data-section') === 'IDP Monitoring') l.classList.add('active');
                        else l.classList.remove('active');
                    });
                    return;
                }
                if (path.includes('/talent/competency')) {
                    links.forEach(l => {
                        if (l.getAttribute('data-section') === 'Kompetensi') l.classList.add('active');
                        else l.classList.remove('active');
                    });
                    return;
                }

                let currentSection = '';
                links.forEach(link => {
                    const sectionName = link.getAttribute('data-section');
                    const section = document.getElementById(sectionName);
                    if (section) {
                        const rect = section.getBoundingClientRect();
                        if (rect.top <= 150) currentSection = sectionName;
                    }
                });
                
                if (currentSection) {
                    links.forEach(link => {
                        if (link.getAttribute('data-section') === currentSection) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                }
            }

            window.addEventListener('scroll', updateActiveOnScroll);

            // Set initial active from URL hash or path
            const hash = decodeURIComponent(window.location.hash.replace('#', ''));
            const path = window.location.pathname;

            if (path.includes('/profile') || path.includes('/profil')) {
                links.forEach(l => l.classList.remove('active'));
            } else if (path.includes('/talent/riwayat')) {
                links.forEach(l => {
                    if (l.getAttribute('data-section') === 'Riwayat') l.classList.add('active');
                    else l.classList.remove('active');
                });
            } else if (path.includes('/talent/idp-monitoring') || path.includes('/talent/logbook')) {
                links.forEach(l => {
                    if (l.getAttribute('data-section') === 'IDP Monitoring') l.classList.add('active');
                    else l.classList.remove('active');
                });
            } else if (path.includes('/talent/competency')) {
                links.forEach(l => {
                    if (l.getAttribute('data-section') === 'Kompetensi') l.classList.add('active');
                    else l.classList.remove('active');
                });
            } else if (hash) {
                links.forEach(l => {
                    if (l.getAttribute('data-section') === hash) l.classList.add('active');
                });
            } else {
                links[0].classList.add('active');
            }
        })();

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

            let talentBellPopupTimeout = null;
            let talentBellCleanupTimeout = null;

            window.Echo.private('user-notifications.{{ auth()->id() }}')
                .listen('.notification.created', function (data) {
                    window.dispatchEvent(new CustomEvent('app-notification-received', {
                        detail: data
                    }));
                    talentUpdateBadge();
                    talentInsertRealtimeNotification(data.title || 'Notifikasi Baru', data.desc || '');
                    talentShowBellPopup();
                    talentShowToast(data.title || 'Notifikasi Baru', data.desc || '');
                });

            function talentShowToast(title, desc) {
                let container = document.getElementById('talent-rt-toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'talent-rt-toast-container';
                    container.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column-reverse;gap:10px;pointer-events:none;';
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
                    'border-left:4px solid #10b981',
                    'border-radius:14px',
                    'padding:14px 18px',
                    'box-shadow:0 10px 40px rgba(0,0,0,.13)',
                    'min-width:300px',
                    'max-width:360px',
                    'position:relative',
                    'overflow:hidden',
                    'opacity:0',
                    'transform:translateX(40px) scale(.96)',
                    'transition:opacity .35s ease,transform .35s ease'
                ].join(';');

                toast.innerHTML = `
                    <div style="flex-shrink:0;width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;">
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='#059669' style='width:20px;height:20px;'>
                            <path d='M12 2.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.06 1.06a.75.75 0 101.06 1.06l1.06-1.06zM5.466 19.084a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 011.06-1.06l1.06 1.06a.75.75 0 010 1.06zM19.98 12a.75.75 0 00-.75-.75h-1.5a.75.75 0 000 1.5h1.5a.75.75 0 00.75-.75zM4.77 12a.75.75 0 00-.75-.75h-1.5a.75.75 0 000 1.5h1.5a.75.75 0 00.75-.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.06 1.06l1.06 1.06zM6.166 5.466a.75.75 0 010-1.06l1.06-1.06a.75.75 0 011.06 1.06l-1.06 1.06a.75.75 0 01-1.06 0zM12 18.75a.75.75 0 00-.75.75v1.5a.75.75 0 001.5 0v-1.5a.75.75 0 00-.75-.75z'/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.85rem;font-weight:700;color:#1e293b;margin-bottom:3px;">${title}</div>
                        <div style="font-size:.78rem;color:#64748b;line-height:1.5;">${desc}</div>
                    </div>
                    <div style="position:absolute;bottom:0;left:0;height:3px;background:linear-gradient(90deg,#059669,#34d399);width:100%;transform-origin:left;animation:talentBarShrink 5s linear forwards;border-radius:0 0 0 14px;"></div>
                `;

                if (!document.getElementById('talent-toast-style')) {
                    let s = document.createElement('style');
                    s.id = 'talent-toast-style';
                    s.textContent = '@keyframes talentBarShrink{from{transform:scaleX(1)}to{transform:scaleX(0)}}';
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

            function talentUpdateBadge() {
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

            function talentInsertRealtimeNotification(title, desc) {
                const dropdown = document.getElementById('bell-dropdown');
                if (!dropdown) return;

                const emptyState = document.getElementById('talent-bell-empty-state');
                if (emptyState) emptyState.remove();

                let list = document.getElementById('talent-bell-list');
                if (!list) {
                    list = document.createElement('ul');
                    list.id = 'talent-bell-list';
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
                    window.location = '{{ route('talent.notifikasi') }}';
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

                while (list.children.length > 3) {
                    list.removeChild(list.lastElementChild);
                }
            }

            function talentShowBellPopup() {
                const bellDropdown = document.getElementById('bell-dropdown');
                if (!bellDropdown) return;

                clearTimeout(talentBellPopupTimeout);
                clearTimeout(talentBellCleanupTimeout);

                bellDropdown.classList.remove('hidden');
                bellDropdown.style.display = '';
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

                talentBellPopupTimeout = setTimeout(function () {
                    bellDropdown.style.opacity = '0';
                    bellDropdown.style.transform = 'scale(0.86) translateY(-8px)';

                    talentBellCleanupTimeout = setTimeout(function () {
                        bellDropdown.classList.add('hidden');
                        bellDropdown.style.display = 'none';
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
