<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Development Plan – Portal Pengembangan Talent</title>
    <meta name="description" content="Platform manajemen Individual Development Plan (IDP) untuk mendorong pertumbuhan talent, monitoring kompetensi, dan pengembangan karir secara terstruktur.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --dark:      #0f172a;
            --dark-2:    #1e293b;
            --dark-3:    #2e3746;
            --slate:     #334155;
            --slate-2:   #475569;
            --muted:     #94a3b8;
            --border:    #e2e8f0;
            --teal:      #0d9488;
            --teal-2:    #0f766e;
            --green:     #10b981;
            --green-2:   #059669;
            --emerald:   #34d399;
            --white:     #ffffff;
            --off-white: #ffffffff;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--dark); }
        ::-webkit-scrollbar-thumb { background: var(--teal); border-radius: 99px; }

        /* ─── NOISE OVERLAY ─── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.4s ease;
        }
        .navbar.scrolled {
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .nav-logo img {
            height: 52px;
            width: 52px;
            object-fit: contain;
            background: var(--white);
            padding: 6px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .nav-logo-text { display: flex; flex-direction: column; line-height: 1.15; }
        .nav-logo-text span:first-child {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--emerald);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .nav-logo-text span:last-child {
            font-size: 1rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.3px;
        }
        .nav-cta {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-nav-ghost {
            padding: 8px 22px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 99px;
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 1);
            text-decoration: none;
            transition: all 0.25s;
        }
        .btn-nav-ghost:hover {
            border-color: var(--emerald);
            color: var(--emerald);
            background: rgba(52,211,153,0.07);
        }
        .btn-nav-primary {
            padding: 9px 24px;
            background: linear-gradient(135deg, var(--teal), var(--green));
            border-radius: 99px;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(13,148,136,0.4);
            transition: all 0.25s;
        }
        .btn-nav-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(13,148,136,0.5);
        }

        /* ─── HERO ─── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            padding: 120px 2rem 80px;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(135deg, rgba(15, 23, 42, 0.90) 0%, rgba(15, 23, 42, 0.40) 50%, rgba(15, 23, 42, 0.95) 100%),
                url("{{ asset('asset/Gambar%20TS.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }


        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 820px;
            margin: 0 auto;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(13,148,136,0.15);
            border: 1px solid rgba(13,148,136,0.4);
            border-radius: 99px;
            padding: 6px 16px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--emerald);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeInDown 0.8s ease-out both;
        }
        .hero-badge span.dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--emerald);
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

        .hero-title {
            font-size: clamp(2.4rem, 6vw, 4rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 24px;
            animation: fadeInUp 0.9s ease-out 0.1s both;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--teal) 50%, #22d3ee 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.05rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 1);
            line-height: 1.75;
            max-width: 580px;
            margin: 0 auto 40px;
            animation: fadeInUp 0.9s ease-out 0.2s both;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeInUp 0.9s ease-out 0.3s both;
        }
        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 36px;
            background: linear-gradient(135deg, var(--teal), var(--green));
            border-radius: 99px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(13,148,136,0.45);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-hero-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 18px 40px rgba(13,148,136,0.55); }
        .btn-hero-primary:hover::before { opacity: 1; }
        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 99px;
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 1);
            text-decoration: none;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.05);
            transition: all 0.3s;
        }
        .btn-hero-secondary:hover {
            border-color: var(--emerald);
            color: var(--emerald);
            background: rgba(52,211,153,0.08);
        }

        .hero-stats {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            gap: 48px;
            margin-top: 70px;
            padding-top: 50px;
            border-top: 1px solid rgba(255,255,255,0.08);
            animation: fadeInUp 0.9s ease-out 0.5s both;
            flex-wrap: wrap;
        }
        .stat-item { text-align: center; }
        .stat-num {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--white), var(--emerald));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }
        .stat-label { font-size: 0.75rem; font-weight: 600; color: var(--muted); margin-top: 6px; text-transform: uppercase; letter-spacing: 1px; }

        /* ─── SECTION BASE ─── */
        section { position: relative; z-index: 1; }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(13,148,136,0.12);
            border: 1px solid rgba(13,148,136,0.3);
            border-radius: 99px;
            padding: 5px 14px;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--emerald);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 900;
            letter-spacing: -0.8px;
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .section-sub {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 1);
            line-height: 1.7;
            max-width: 520px;
            margin: 0 auto;
        }

        /* ─── HOW IT WORKS – TIMELINE ─── */
        .steps-section {
            padding: 100px 2rem;
            background: linear-gradient(180deg, var(--dark) 0%, #0d1526 100%);
        }
        .steps-header { text-align: center; margin-bottom: 70px; }

        .timeline {
            position: relative;
            max-width: 860px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 36px;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, rgba(13,148,136,0.5) 10%, rgba(13,148,136,0.5) 90%, transparent);
        }

        .tl-item {
            display: flex;
            gap: 28px;
            padding: 0 0 40px 0;
            position: relative;
        }
        .tl-item:last-child { padding-bottom: 0; }

        .tl-dot {
            flex-shrink: 0;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(15,23,42,0.95);
            border: 1.5px solid rgba(13,148,136,0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            box-shadow: 0 0 0 6px rgba(13,148,136,0.05);
            transition: all 0.3s;
        }
        .tl-dot svg { width: 28px; height: 28px; color: var(--emerald); }
        .tl-item:hover .tl-dot {
            border-color: var(--teal);
            background: rgba(13,148,136,0.1);
            box-shadow: 0 0 0 8px rgba(13,148,136,0.08), 0 0 20px rgba(13,148,136,0.15);
        }

        .tl-body {
            flex: 1;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            padding: 24px 28px;
            margin-top: 12px;
            position: relative;
            transition: all 0.3s;
            overflow: hidden;
        }
        .tl-body::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--teal), var(--green));
            border-radius: 3px 0 0 3px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tl-item:hover .tl-body {
            border-color: rgba(13,148,136,0.25);
            background: rgba(13,148,136,0.04);
            transform: translateX(4px);
        }
        .tl-item:hover .tl-body::before { opacity: 1; }

        .tl-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.63rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--emerald);
            margin-bottom: 8px;
        }
        .tl-label .tl-dot-mini {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--emerald);
        }
        .tl-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 8px;
        }
        .tl-desc {
            font-size: 0.83rem;
            color: var(--muted);
            line-height: 1.7;
        }

        @media (max-width: 600px) {
            .timeline::before { left: 28px; }
            .tl-dot { width: 56px; height: 56px; }
            .tl-dot svg { width: 22px; height: 22px; }
            .tl-body { padding: 18px 20px; }
        }

        /* ─── FEATURES ─── */
        .features-section {
            padding: 100px 2rem;
            background: #0d1526;
        }
        .features-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .features-header { text-align: center; margin-bottom: 70px; }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        @media (max-width: 900px) { .features-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .features-grid { grid-template-columns: 1fr; } }

        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            padding: 32px 28px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(13,148,136,0.08), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }
        .feature-card:hover {
            border-color: rgba(13,148,136,0.35);
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(13,148,136,0.1);
        }
        .feature-card:hover::after { opacity: 1; }
        .feature-card.featured {
            background: linear-gradient(135deg, rgba(13,148,136,0.15) 0%, rgba(16,185,129,0.08) 100%);
            border-color: rgba(13,148,136,0.4);
            grid-column: span 1;
        }
        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
        }
        .feature-icon svg { width: 26px; height: 26px; }
        .f-teal { background: rgba(13,148,136,0.15); border: 1px solid rgba(13,148,136,0.3); color: var(--emerald); }
        .f-blue { background: rgba(59,130,246,0.12); border: 1px solid rgba(59,130,246,0.25); color: #60a5fa; }
        .f-purple { background: rgba(139,92,246,0.12); border: 1px solid rgba(139,92,246,0.25); color: #a78bfa; }
        .f-orange { background: rgba(249,115,22,0.12); border: 1px solid rgba(249,115,22,0.25); color: #fb923c; }
        .f-rose { background: rgba(244,63,94,0.12); border: 1px solid rgba(244,63,94,0.25); color: #fb7185; }
        .f-yellow { background: rgba(234,179,8,0.12); border: 1px solid rgba(234,179,8,0.25); color: #fbbf24; }

        .feature-title { font-size: 1rem; font-weight: 800; color: var(--white); margin-bottom: 10px; }
        .feature-desc { font-size: 0.82rem; color: var(--muted); line-height: 1.7; }
        .feature-tag {
            display: inline-block;
            margin-top: 16px;
            background: rgba(13,148,136,0.15);
            color: var(--emerald);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 99px;
            border: 1px solid rgba(13,148,136,0.3);
        }

        /* ─── ROLES ─── */
        .roles-section {
            padding: 100px 2rem;
            background: linear-gradient(180deg, #0d1526 0%, var(--dark) 100%);
        }
        .roles-inner { max-width: 1100px; margin: 0 auto; }
        .roles-header { text-align: center; margin-bottom: 70px; }
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
        }
        .role-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            padding: 28px 20px;
            text-align: center;
            transition: all 0.3s;
            cursor: default;
        }
        .role-card:hover {
            border-color: rgba(13,148,136,0.4);
            background: rgba(13,148,136,0.06);
            transform: translateY(-4px);
        }
        .role-avatar {
            width: 56px; height: 56px;
            border-radius: 50%;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .role-name { font-size: 0.85rem; font-weight: 800; color: var(--white); margin-bottom: 6px; }
        .role-desc { font-size: 0.72rem; color: var(--muted); line-height: 1.55; }

        /* ─── CTA SECTION ─── */
        .cta-section {
            padding: 100px 2rem;
            background: var(--dark);
            position: relative;
            overflow: hidden;
        }

        .cta-inner {
            position: relative;
            z-index: 2;
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 32px;
            padding: 64px 48px;
            backdrop-filter: blur(10px);
        }
        .cta-inner::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--teal), transparent);
        }
        .cta-title {
            font-size: clamp(1.8rem, 3.5vw, 2.4rem);
            font-weight: 900;
            letter-spacing: -0.8px;
            line-height: 1.2;
            margin-bottom: 18px;
        }
        .cta-desc {
            font-size: 0.92rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            margin-bottom: 36px;
        }
        .cta-btns {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        /* ─── FOOTER ─── */
        .footer {
            background: #080e1a;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 48px 2rem;
        }
        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .footer-logo img { 
            height: 52px; 
            width: 52px;
            object-fit: contain; 
            background: var(--white);
            padding: 6px;
            border-radius: 12px; 
        }
        .footer-text { font-size: 0.75rem; color: rgba(255,255,255,0.3); line-height: 1.6; }
        .footer-links { display: flex; gap: 24px; }
        .footer-links a {
            font-size: 0.78rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--emerald); }

        /* ─── DIVIDER ─── */
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.07), transparent);
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─── MOBILE ─── */
        @media (max-width: 640px) {
            .nav-logo-text span:last-child { font-size: 0.85rem; }
            .btn-nav-ghost { display: none; }
            .hero-stats { gap: 28px; }
            .cta-inner { padding: 40px 24px; }
            .footer-inner { flex-direction: column; text-align: center; }
            .footer-links { justify-content: center; }
        }

        /* ─── GRID DIVIDER LINES ─── */
        .steps-grid > .step-card {
            border-right: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .steps-grid > .step-card:nth-child(3n) {
            border-right: none;
        }
        .steps-grid > .step-card:nth-last-child(-n+3) {
            border-bottom: none;
        }
        @media (max-width: 900px) {
            .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid > .step-card { border-right: 1px solid rgba(255,255,255,0.05) !important; border-bottom: 1px solid rgba(255,255,255,0.05) !important; }
            .steps-grid > .step-card:nth-child(2n) { border-right: none !important; }
            .steps-grid > .step-card:nth-last-child(-n+2) { border-bottom: none !important; }
        }
        @media (max-width: 600px) {
            .steps-grid { grid-template-columns: 1fr; }
            .steps-grid > .step-card { border-right: none !important; border-bottom: 1px solid rgba(255,255,255,0.05) !important; }
            .steps-grid > .step-card:last-child { border-bottom: none !important; }
        }
    </style>
</head>
<body>

    <!-- ─── NAVBAR ─── -->
    <nav class="navbar" id="navbar">
        <a href="#" class="nav-logo">
            <img src="{{ asset('asset/logo%20ts.png') }}" alt="Logo">
            <div class="nav-logo-text">
                <span>Portal</span>
                <span>IDP Dashboard</span>
            </div>
        </a>
        <div class="nav-cta">
            <a href="{{ route('register') }}" class="btn-nav-ghost">Daftar</a>
            <a href="{{ route('login') }}" class="btn-nav-primary">Masuk →</a>
        </div>
    </nav>

    <!-- ─── HERO ─── -->
    <section class="hero" id="hero">
        <div class="hero-bg"></div>


        <div style="position: relative; z-index: 2; width: 100%;">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Platform Pengembangan Talent
                </div>

                <h1 class="hero-title">
                    Sistem Pengelolaan<br>Individual<br>Development Plan</span>
                </h1>

                <p class="hero-desc">
                    Sistem terintegrasi untuk merencanakan, memonitor, dan mengevaluasi
                    pengembangan kompetensi talent secara terstruktur dan berbasis data.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn-hero-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:18px;height:18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Masuk ke Dashboard
                    </a>
                    <a href="#fitur" class="btn-hero-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                        Lihat Fitur
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── HOW IT WORKS ─── -->
    <section class="steps-section" id="cara-kerja">
        <div class="steps-header reveal">
            <div class="section-tag">Cara Kerja</div>
            <h2 class="section-title">Alur Pengembangan Talent</h2>
            <p class="section-sub">Proses sistematis dari penilaian awal hingga pengembangan penuh.</p>
        </div>
        <div class="timeline">

            <div class="tl-item reveal">
                <div class="tl-dot">
                    <!-- Clipboard check - Registrasi -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.5 3.75a6 6 0 00-5.98 6.496A5.25 5.25 0 006.75 20.25H18a4.5 4.5 0 002.206-8.423 3.75 3.75 0 00-4.133-4.303A6.001 6.001 0 0010.5 3.75zm2.03 5.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.72-1.72v4.94a.75.75 0 001.5 0v-4.94l1.72 1.72a.75.75 0 101.06-1.06l-3-3z" clip-rule="evenodd" /></svg>
                </div>
                <div class="tl-body">
                    <div class="tl-label"><span class="tl-dot-mini"></span>Tahap 1</div>
                    <div class="tl-title">Registrasi &amp; Seleksi</div>
                    <div class="tl-desc">Kandidat mendaftar dan mengikuti proses seleksi untuk menjadi Talent program IDP.</div>
                </div>
            </div>

            <div class="tl-item reveal">
                <div class="tl-dot">
                    <!-- Chart bar - Asesmen -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" /></svg>
                </div>
                <div class="tl-body">
                    <div class="tl-label"><span class="tl-dot-mini"></span>Tahap 2</div>
                    <div class="tl-title">Asesmen Kompetensi</div>
                    <div class="tl-desc">Self-assessment dilengkapi penilaian 360° dari Atasan dan Panelis untuk gap analysis.</div>
                </div>
            </div>

            <div class="tl-item reveal">
                <div class="tl-dot">
                    <!-- Document text - Penyusunan IDP -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75-6.75a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" /><path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" /></svg>
                </div>
                <div class="tl-body">
                    <div class="tl-label"><span class="tl-dot-mini"></span>Tahap 3</div>
                    <div class="tl-title">Penyusunan IDP</div>
                    <div class="tl-desc">Talent menyusun rencana pengembangan melalui jalur Exposure, Mentoring, dan Learning.</div>
                </div>
            </div>

            <div class="tl-item reveal">
                <div class="tl-dot">
                    <!-- Pencil square - Logbook -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" /><path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" /></svg>
                </div>
                <div class="tl-body">
                    <div class="tl-label"><span class="tl-dot-mini"></span>Tahap 4</div>
                    <div class="tl-title">Logbook &amp; Aktivitas</div>
                    <div class="tl-desc">Talent mencatat setiap aktivitas pengembangan di logbook untuk diverifikasi Mentor dan Atasan.</div>
                </div>
            </div>

            <div class="tl-item reveal">
                <div class="tl-dot">
                    <!-- Presentation chart line - Monitoring -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.04 16.5l.5-1.5h6.42l.5 1.5H8.29zm7.46-12a.75.75 0 00-1.5 0v6a.75.75 0 001.5 0V7.5zm-3 2.25a.75.75 0 00-1.5 0v3.75a.75.75 0 001.5 0V9.75zm-3 2.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0V12z" clip-rule="evenodd" /></svg>
                </div>
                <div class="tl-body">
                    <div class="tl-label"><span class="tl-dot-mini"></span>Tahap 5</div>
                    <div class="tl-title">Monitoring Progress</div>
                    <div class="tl-desc">Atasan memantau perkembangan talent secara real-time dengan heatmap dan grafik interaktif.</div>
                </div>
            </div>

            <div class="tl-item reveal">
                <div class="tl-dot">
                    <!-- Trophy - Evaluasi & Panelis Review -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.743 1.346A6.707 6.707 0 019.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 000 4.5h9.75a2.25 2.25 0 000-4.5h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 01-1.112-3.173 6.73 6.73 0 002.743-1.347 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.077 47.077 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.798 49.798 0 00-6.093-.377.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.343v.256zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 01-2.863 3.207 6.72 6.72 0 00.857-3.294z" clip-rule="evenodd" /></svg>
                </div>
                <div class="tl-body">
                    <div class="tl-label"><span class="tl-dot-mini"></span>Tahap 6</div>
                    <div class="tl-title">Evaluasi &amp; Panelis Review</div>
                    <div class="tl-desc">Panelis melakukan evaluasi akhir dan memberikan rekomendasi promosi talent.</div>
                </div>
            </div>

        </div>
    </section>

    <div class="section-divider"></div>

    <!-- ─── FEATURES ─── -->
    <section class="features-section" id="fitur">
        <div class="features-inner">
            <div class="features-header reveal">
                <div class="section-tag">Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Anda Butuhkan</h2>
                <p class="section-sub">Fitur lengkap untuk manajemen pengembangan talent dari awal hingga akhir.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card featured reveal">
                    <div class="feature-icon f-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177A7.547 7.547 0 016.648 6.61a.75.75 0 00-1.152-.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248zM15.75 14.25a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="feature-title">Heatmap Kompetensi</div>
                    <div class="feature-desc">Visualisasi gap kompetensi seluruh talent dalam satu heatmap interaktif. Identifikasi prioritas pengembangan secara instan.</div>
                    <span class="feature-tag">Core Feature</span>
                </div>

                <div class="feature-card reveal">
                    <div class="feature-icon f-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" /></svg>
                    </div>
                    <div class="feature-title">Dashboard Real-time</div>
                    <div class="feature-desc">Pantau progress IDP, logbook, dan project improvement semua talent dari satu halaman monitoring.</div>
                </div>

                <div class="feature-card reveal">
                    <div class="feature-icon f-purple">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="feature-title">Multi-role System</div>
                    <div class="feature-desc">Sistem berbasis peran dengan akses terpisah untuk Talent, Mentor, Atasan, Panelis, dan Admin.</div>
                </div>

                <div class="feature-card reveal">
                    <div class="feature-icon f-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="feature-title">Logbook Digital</div>
                    <div class="feature-desc">Pencatatan aktivitas Exposure, Mentoring, dan Learning dengan sistem approval dan dokumentasi file.</div>
                </div>

                <div class="feature-card reveal">
                    <div class="feature-icon f-rose">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" /></svg>
                    </div>
                    <div class="feature-title">Project Improvement</div>
                    <div class="feature-desc">Kelola dan pantau project improvement talent lengkap dengan upload dokumen dan tracking status persetujuan.</div>
                </div>

                <div class="feature-card reveal">
                    <div class="feature-icon f-yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" /><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="feature-title">Finance Management</div>
                    <div class="feature-desc">Pengelolaan anggaran pengembangan dengan approval berlapis dan transparansi proses yang terjamin.</div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- ─── ROLES ─── -->
    <section class="roles-section" id="pengguna">
        <div class="roles-inner">
            <div class="roles-header reveal">
                <div class="section-tag">Peran Pengguna</div>
                <h2 class="section-title">Satu Platform, Banyak Peran</h2>
                <p class="section-sub">Setiap pemangku kepentingan memiliki akses dan tanggung jawab yang disesuaikan.</p>
            </div>
            <div class="roles-grid">
                <div class="role-card reveal">
                    <div class="role-avatar" style="background: linear-gradient(135deg, rgba(13,148,136,0.2), rgba(16,185,129,0.1)); border: 1px solid rgba(13,148,136,0.3); font-size: 1.5rem;">🎯</div>
                    <div class="role-name">Talent</div>
                    <div class="role-desc">Mengisi self-assessment, logbook, dan mengunggah project</div>
                </div>
                <div class="role-card reveal">
                    <div class="role-avatar" style="background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(96,165,250,0.1)); border: 1px solid rgba(59,130,246,0.3); font-size: 1.5rem;">🧭</div>
                    <div class="role-name">Mentor</div>
                    <div class="role-desc">Membimbing dan memverifikasi aktivitas logbook talent</div>
                </div>
                <div class="role-card reveal">
                    <div class="role-avatar" style="background: linear-gradient(135deg, rgba(139,92,246,0.2), rgba(167,139,250,0.1)); border: 1px solid rgba(139,92,246,0.3); font-size: 1.5rem;">👁️</div>
                    <div class="role-name">Atasan</div>
                    <div class="role-desc">Menilai kompetensi dan memonitor perkembangan talent</div>
                </div>
                <div class="role-card reveal">
                    <div class="role-avatar" style="background: linear-gradient(135deg, rgba(249,115,22,0.2), rgba(251,146,60,0.1)); border: 1px solid rgba(249,115,22,0.3); font-size: 1.5rem;">⚖️</div>
                    <div class="role-name">Panelis</div>
                    <div class="role-desc">Melakukan evaluasi akhir dan BOD review talent</div>
                </div>
                <div class="role-card reveal">
                    <div class="role-avatar" style="background: linear-gradient(135deg, rgba(234,179,8,0.2), rgba(251,191,36,0.1)); border: 1px solid rgba(234,179,8,0.3); font-size: 1.5rem;">💰</div>
                    <div class="role-name">Finance</div>
                    <div class="role-desc">Mengelola anggaran dan menyetujui permintaan dana</div>
                </div>
                <div class="role-card reveal">
                    <div class="role-avatar" style="background: linear-gradient(135deg, rgba(244,63,94,0.2), rgba(251,113,133,0.1)); border: 1px solid rgba(244,63,94,0.3); font-size: 1.5rem;">⚙️</div>
                    <div class="role-name">PDC Admin</div>
                    <div class="role-desc">Mengelola seluruh sistem, pengguna, dan konfigurasi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── CTA ─── -->
    <section class="cta-section">
        <div class="cta-inner reveal">
            <div class="section-tag" style="margin-bottom: 24px;">Mulai Sekarang</div>
            <h2 class="cta-title">
                Siap Memulai Perjalanan<br>
                <span style="background: linear-gradient(135deg, #34d399, #0d9488); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Pengembangan Talent?</span>
            </h2>
            <p class="cta-desc">
                Bergabunglah dengan program IDP dan wujudkan potensi terbaik Anda<br>
                bersama tim profesional kami.
            </p>
            <div class="cta-btns">
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                    Masuk ke Dashboard
                </a>
                <a href="{{ route('register') }}" class="btn-hero-secondary">
                    Daftar Akun Baru →
                </a>
            </div>
        </div>
    </section>

    <!-- ─── FOOTER ─── -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-logo">
                <img src="{{ asset('asset/logo%20ts.png') }}" alt="Logo">
                <div class="footer-text">
                    <strong style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">IDP Dashboard</strong><br>
                    Platform Individual Development Plan
                </div>
            </div>
            <div class="footer-links">
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>
            <div class="footer-text" style="text-align: right;">
                © {{ date('Y') }} IDP Dashboard. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // ─── Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // ─── Reveal on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ─── Smooth scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
            });
        });
    </script>
</body>
</html>
