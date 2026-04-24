@php $mobileCollapsible = $mobileCollapsible ?? false; @endphp

<style>
    /* ── Talent Profile Hero Card ── */
    .talent-prof-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #2a4060 100%);
        padding: 28px 32px;
        display: flex;
        align-items: stretch;
        gap: 0;
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        margin: 16px 16px 0 16px;
    }
    .talent-prof-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(20, 184, 166, 0.08);
        pointer-events: none;
    }
    .talent-prof-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 30%;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        pointer-events: none;
    }

    /* Avatar */
    .talent-hero-avatar-wrap { position: relative; flex-shrink: 0; }
    .talent-hero-avatar-img {
        width: 96px; height: 96px;
        border-radius: 20px;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 20px rgba(0,0,0,0.25);
    }
    .talent-hero-avatar-placeholder {
        width: 96px; height: 96px;
        border-radius: 20px;
        background: rgba(255,255,255,0.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.4rem; font-weight: 800;
        color: white;
        border: 3px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        letter-spacing: -1px;
    }

    /* ── 3-Column Sections — equal width ── */
    .talent-hero-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
        padding: 0 28px;
        position: relative;
        z-index: 1;
    }
    /* Section 1: avatar + info */
    .talent-hero-section-1 {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 0 28px 0 0;
        position: relative; z-index: 1;
    }
    /* Section divider */
    .talent-hero-divider {
        width: 1px;
        align-self: stretch;
        background: rgba(255,255,255,0.15);
        flex-shrink: 0;
        margin: 4px 0;
    }

    /* Info block */
    .talent-hero-info { min-width: 0; }
    .talent-hero-name {
        font-size: 1.35rem; font-weight: 800;
        color: #ffffff; line-height: 1.2;
    }
    .talent-hero-sub { font-size: 0.82rem; color: rgba(255,255,255,0.55); margin-top: 3px; }
    .talent-hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(20,184,166,0.18);
        border: 1px solid rgba(20,184,166,0.3);
        color: #5eead4;
        font-size: 0.75rem; font-weight: 700;
        padding: 4px 12px; border-radius: 99px;
        margin-top: 10px; letter-spacing: .04em;
    }
    .talent-hero-badge::before {
        content: ''; width: 7px; height: 7px; border-radius: 50%;
        background: #14b8a6;
        animation: pulse-dot-hero 2s ease infinite;
    }
    @keyframes pulse-dot-hero { 0%,100%{opacity:1} 50%{opacity:.4} }

    /* Meta items inside sections */
    .talent-hero-meta-label {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.5);
        font-weight: 500;
        line-height: 1.2;
    }
    .talent-hero-meta-value {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.92);
        font-weight: 700;
        margin-top: 1px;
        line-height: 1.3;
    }
    .talent-hero-meta-row { display: flex; flex-direction: column; }

    /* Mobile compact toggle header */
    .talent-hero-mobile-header {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 16px; cursor: pointer;
        position: relative; z-index: 1;
    }
    .talent-hero-mobile-avatar {
        width: 46px; height: 46px; border-radius: 12px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.25);
        flex-shrink: 0;
    }
    .talent-hero-mobile-avatar-placeholder {
        width: 46px; height: 46px; border-radius: 12px;
        background: rgba(255,255,255,0.12);
        display: flex; align-items: center; justify-content: center;
        border: 2px solid rgba(255,255,255,0.2); flex-shrink: 0;
        font-size: 1.15rem; font-weight: 800; color: white;
    }
    .mobile-profile-detail-panel {
        max-height: 0; overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .mobile-profile-detail-panel.open { max-height: 500px !important; }

    @media (max-width: 1024px) {
        .talent-hero-section { padding: 0 16px; }
        .talent-hero-section-1 { padding: 0 16px 0 0; }
    }
    @media (max-width: 768px) {
        .talent-prof-hero {
            flex-direction: column; align-items: stretch;
            gap: 0; padding: 20px 20px;
            margin: 12px 12px 0 12px;
        }
        .talent-hero-section, .talent-hero-section-1 { flex: none; }
        .talent-hero-section-1 { padding: 0 0 16px 0; flex-direction: row; align-items: center; }
        .talent-hero-divider { width: auto; height: 1px; align-self: auto; margin: 0; }
        .talent-hero-section { padding: 16px 0 0 0; }
    }
</style>

@php
    /* Shared data helpers */
    $mentorNames = collect(optional($user->promotion_plan)->mentor_models)->pluck('nama')->join(', ')
        ?: (optional($user->mentor)->nama ?? '-');
    $periode = (optional($user->promotion_plan)->start_date
                    ? \Carbon\Carbon::parse($user->promotion_plan->start_date)->format('d/m/Y') : '-')
             . ' – '
             . (optional($user->promotion_plan)->target_date
                    ? \Carbon\Carbon::parse($user->promotion_plan->target_date)->format('d/m/Y') : '-');
@endphp

@if($mobileCollapsible)
    {{-- ===== DESKTOP VIEW: 3-section hero ===== --}}
    <div class="hidden md:flex talent-prof-hero fade-up fade-up-1" style="box-shadow:0 8px 32px rgba(15,23,42,0.35);">

        {{-- Section 1: Avatar + Identity --}}
        <div class="talent-hero-section-1">
            <div class="talent-hero-avatar-wrap">
                @if ($user->foto ?? false)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="talent-hero-avatar-img">
                @else
                    <div class="talent-hero-avatar-placeholder">{{ strtoupper(substr($user->nama ?? $user->name ?? 'T', 0, 1)) }}</div>
                @endif
            </div>
            <div class="talent-hero-info">
                <div class="talent-hero-name">{{ $user->nama ?? $user->name }}</div>
                <div class="talent-hero-badge">{{ ucfirst($user->role->role_name ?? 'Talent') }}</div>
            </div>
        </div>

        <div class="talent-hero-divider"></div>

        {{-- Section 2: Perusahaan, Departemen, Posisi --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Perusahaan</span>
                <span class="talent-hero-meta-value">{{ optional($user->company)->nama_company ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Departemen</span>
                <span class="talent-hero-meta-value">{{ optional($user->department)->nama_department ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Posisi yang Dituju</span>
                <span class="talent-hero-meta-value">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
            </div>
        </div>

        <div class="talent-hero-divider"></div>

        {{-- Section 3: Mentor, Atasan, Periode --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Mentor</span>
                <span class="talent-hero-meta-value">{{ $mentorNames }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Atasan</span>
                <span class="talent-hero-meta-value">{{ optional($user->atasan)->nama ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Periode</span>
                <span class="talent-hero-meta-value">{{ $periode }}</span>
            </div>
        </div>

    </div>

    {{-- ===== MOBILE VIEW: compact + collapsible ===== --}}
    <div class="md:hidden relative overflow-hidden fade-up fade-up-1" style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 70%,#2a4060 100%);border-radius:16px;margin:12px 12px 0 12px;box-shadow:0 8px 24px rgba(15,23,42,0.35);">
        <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full" style="background:rgba(20,184,166,0.08);filter:blur(40px);pointer-events:none"></div>
        <div class="talent-hero-mobile-header" onclick="toggleMobileProfile()">
            @if ($user->foto ?? false)
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto" class="talent-hero-mobile-avatar">
            @else
                <div class="talent-hero-mobile-avatar-placeholder">{{ strtoupper(substr($user->nama ?? $user->name ?? 'T', 0, 1)) }}</div>
            @endif
            <div class="flex-1 min-w-0">
                <p class="text-white font-bold text-base leading-tight truncate">{{ $user->nama ?? $user->name }}</p>
                <p class="text-white/50 text-sm mt-0.5">{{ ucfirst($user->role->role_name ?? 'Talent') }}</p>
            </div>
            <svg id="mobile-profile-chevron" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/40 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div id="mobile-profile-detail" class="mobile-profile-detail-panel">
            {{-- Group 1 --}}
            <div class="px-4 pb-4 pt-2 space-y-3 border-t border-white/10">
                <div><p class="text-white/50 text-xs font-semibold">Perusahaan</p><p class="text-white text-sm font-bold mt-0.5">{{ optional($user->company)->nama_company ?? '-' }}</p></div>
                <div><p class="text-white/50 text-xs font-semibold">Departemen</p><p class="text-white text-sm font-bold mt-0.5">{{ optional($user->department)->nama_department ?? '-' }}</p></div>
                <div><p class="text-white/50 text-xs font-semibold">Posisi yang Dituju</p><p class="text-white text-sm font-bold mt-0.5">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</p></div>
            </div>
            {{-- Group 2 --}}
            <div class="px-4 pb-4 pt-2 space-y-3 border-t border-white/10">
                <div><p class="text-white/50 text-xs font-semibold">Mentor</p><p class="text-white text-sm font-bold mt-0.5">{{ $mentorNames }}</p></div>
                <div><p class="text-white/50 text-xs font-semibold">Atasan</p><p class="text-white text-sm font-bold mt-0.5">{{ optional($user->atasan)->nama ?? '-' }}</p></div>
                <div><p class="text-white/50 text-xs font-semibold">Periode</p><p class="text-white text-sm font-bold mt-0.5">{{ $periode }}</p></div>
            </div>
        </div>
    </div>

@else
    {{-- ===== OTHER PAGES: 3-section hero, fully responsive ===== --}}
    <div class="talent-prof-hero fade-up fade-up-1" style="box-shadow:0 8px 32px rgba(15,23,42,0.35);">

        {{-- Section 1: Avatar + Identity --}}
        <div class="talent-hero-section-1">
            <div class="talent-hero-avatar-wrap">
                @if ($user->foto ?? false)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="talent-hero-avatar-img">
                @else
                    <div class="talent-hero-avatar-placeholder">{{ strtoupper(substr($user->nama ?? $user->name ?? 'T', 0, 1)) }}</div>
                @endif
            </div>
            <div class="talent-hero-info">
                <div class="talent-hero-name">{{ $user->nama ?? $user->name }}</div>
                <div class="talent-hero-sub">{{ $user->email }}</div>
                <div class="talent-hero-badge">{{ ucfirst($user->role->role_name ?? 'Talent') }}</div>
            </div>
        </div>

        <div class="talent-hero-divider"></div>

        {{-- Section 2: Perusahaan, Departemen, Posisi --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Perusahaan</span>
                <span class="talent-hero-meta-value">{{ optional($user->company)->nama_company ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Departemen</span>
                <span class="talent-hero-meta-value">{{ optional($user->department)->nama_department ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Posisi yang Dituju</span>
                <span class="talent-hero-meta-value">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
            </div>
        </div>

        <div class="talent-hero-divider"></div>

        {{-- Section 3: Mentor, Atasan, Periode --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Mentor</span>
                <span class="talent-hero-meta-value">{{ $mentorNames }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Atasan</span>
                <span class="talent-hero-meta-value">{{ optional($user->atasan)->nama ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Periode</span>
                <span class="talent-hero-meta-value">{{ $periode }}</span>
            </div>
        </div>

    </div>
@endif
