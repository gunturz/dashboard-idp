@props([
    'title' => 'Individual Development Plan',
    'bodyClass' => 'bg-white min-h-screen flex flex-col pt-[80px]',
    'showProfileCard' => true,
    'mobileCollapsible' => false,
    'user' => null,
    'notifications' => null
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
            background: #2e3746;
            padding: 1rem 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-outer.nav-hidden {
            transform: translateY(-110%);
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

        /* ── Icon buttons (bell & user) ── */
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
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
            transition: color 0.2s, font-weight 0.2s;
        }

        .nav-menu-link.active {
            color: #ffffff;
            font-weight: 700;
        }

        /* Mobile Dropdown Nav Links Overlay */
        .dropdown-panel .nav-menu-link {
            color: #475569;
            font-weight: 500;
        }
        .dropdown-panel .nav-menu-link:hover {
            color: #005ba1;
            background-color: #f8fafc;
        }
        .dropdown-panel .nav-menu-link.active {
            color: #005ba1;
            font-weight: 700;
            background-color: #f8fafc;
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
    </style>
    
    {{ $styles ?? '' }}
</head>

<body class="{{ $bodyClass }}">

    {{-- NAVBAR --}}
    @include('components.talent.navbar', ['user' => $user ?? auth()->user(), 'notifications' => $notifications ?? collect([])])

    {{-- PROFILE CARD --}}
    @if($showProfileCard)
        @include('components.talent.profile-card', ['user' => $user ?? auth()->user(), 'mobileCollapsible' => $mobileCollapsible])
    @endif

    {{-- MAIN CONTENT --}}
    {{ $slot }}

    {{-- FOOTER --}}
    <footer class="mt-auto bg-[#2e3746] py-5 text-center w-full">
        <span class="text-white text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>

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
            const isHidden = dropdown.classList.contains('hidden');

            // Tutup semua dropdown lain dulu
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));

            if (isHidden) {
                dropdown.classList.remove('hidden');
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
                document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
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
                if (path.includes('/talent/logbook')) {
                    links.forEach(l => {
                        if (l.getAttribute('data-section') === 'LogBook') l.classList.add('active');
                        else l.classList.remove('active');
                    });
                    return;
                }
                if (path.includes('/talent/idp-monitoring')) {
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

            if (path.includes('/talent/logbook')) {
                links.forEach(l => {
                    if (l.getAttribute('data-section') === 'LogBook') l.classList.add('active');
                    else l.classList.remove('active');
                });
            } else if (path.includes('/talent/idp-monitoring')) {
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
    </script>
    
    {{ $scripts ?? '' }}
</body>
</html>
