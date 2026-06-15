<x-pdc_admin.layout title="Detail Archive Talent – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* Scrollbar */
            ::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #14b8a6;
                border-radius: 20px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #0d9488;
            }

            /* Next button */
            .btn-next-bottom {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 32px;
                border: none;
                border-radius: 10px;
                background: #14b8a6;
                color: white;
                font-weight: 600;
                font-size: 0.85rem;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-next-bottom:hover {
                background: #0d9488;
            }

            /* Profile header card - Talent Hero Style */
            .talent-prof-hero {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #2a4060 100%);
                padding: 28px 32px;
                display: flex;
                align-items: stretch;
                gap: 0;
                position: relative;
                overflow: hidden;
                border-radius: 20px;
                margin-bottom: 28px;
                box-shadow: 0 8px 32px rgba(15, 23, 42, 0.35);
            }

            .talent-prof-hero::before {
                content: '';
                position: absolute;
                top: -40px;
                right: -40px;
                width: 220px;
                height: 220px;
                border-radius: 50%;
                background: rgba(20, 184, 166, 0.08);
                pointer-events: none;
            }

            .talent-prof-hero::after {
                content: '';
                position: absolute;
                bottom: -60px;
                left: 30%;
                width: 280px;
                height: 280px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.04);
                pointer-events: none;
            }

            .talent-hero-avatar-wrap {
                position: relative;
                flex-shrink: 0;
            }

            .talent-hero-avatar-img {
                width: 96px;
                height: 96px;
                border-radius: 20px;
                object-fit: cover;
                border: 3px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            }

            .talent-hero-avatar-placeholder {
                width: 96px;
                height: 96px;
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.12);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.4rem;
                font-weight: 800;
                color: white;
                border: 3px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                letter-spacing: -1px;
            }

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

            .talent-hero-section-1 {
                flex: 1;
                display: flex;
                align-items: center;
                gap: 20px;
                padding: 0 28px 0 0;
                position: relative;
                z-index: 1;
            }

            .talent-hero-divider {
                width: 1px;
                align-self: stretch;
                background: rgba(255, 255, 255, 0.15);
                flex-shrink: 0;
                margin: 4px 0;
            }

            .talent-hero-info {
                min-width: 0;
            }

            .talent-hero-name {
                font-size: 1.35rem;
                font-weight: 800;
                color: #ffffff;
                line-height: 1.2;
            }

            .talent-hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(20, 184, 166, 0.18);
                border: 1px solid rgba(20, 184, 166, 0.3);
                color: #5eead4;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 4px 12px;
                border-radius: 99px;
                margin-top: 10px;
                letter-spacing: .04em;
            }

            .talent-hero-badge::before {
                content: '';
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #14b8a6;
                animation: pulse-dot-hero 2s ease infinite;
            }

            @keyframes pulse-dot-hero {

                0%,
                100% {
                    opacity: 1
                }

                50% {
                    opacity: .4
                }
            }

            .talent-hero-meta-label {
                font-size: 0.78rem;
                color: rgba(255, 255, 255, 0.5);
                font-weight: 500;
                line-height: 1.2;
            }

            .talent-hero-meta-value {
                font-size: 0.9rem;
                color: rgba(255, 255, 255, 0.92);
                font-weight: 700;
                margin-top: 1px;
                line-height: 1.3;
            }

            .talent-hero-meta-row {
                display: flex;
                flex-direction: column;
            }

            .mobile-profile-detail-panel {
                display: flex;
                flex: 2;
            }

            @media (max-width: 1024px) {
                .mobile-profile-detail-panel {
                    flex-direction: column;
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                }
                .mobile-profile-detail-panel.open {
                    max-height: 500px !important;
                }
            }

            @media (max-width: 1024px) {
                .talent-hero-section {
                    padding: 0 16px;
                }

                .talent-hero-section-1 {
                    padding: 0 16px 0 0;
                }
            }

            @media (max-width: 1024px) {
                .talent-prof-hero {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 0;
                    padding: 20px 20px;
                }

                .talent-hero-section,
                .talent-hero-section-1 {
                    flex: none;
                }

                .talent-hero-section-1 {
                    padding: 0;
                    flex-direction: row;
                    align-items: center;
                }

                .talent-hero-divider {
                    width: auto;
                    height: 1px;
                    align-self: auto;
                    margin: 16px 0;
                }

                .talent-hero-section {
                    padding: 0;
                }
            }

            /* Legacy classes for compatibility */
            .profile-card {
                display: none;
            }

            /* Nav Tabs */
            .nav-tabs-container {
                display: flex;
                justify-content: center;
                margin-bottom: 32px;
                width: 100%;
            }

            .nav-tabs {
                display: flex;
                background: #e2e8f0;
                padding: 4px;
                border-radius: 99px;
                width: 100%;
                max-width: 900px;
                overflow-x: auto;
                -ms-overflow-style: none;
                /* IE and Edge */
                scrollbar-width: none;
                /* Firefox */
            }

            .nav-tabs::-webkit-scrollbar {
                display: none;
                /* Chrome, Safari and Opera */
            }

            .tab-item {
                flex: 1;
                text-align: center;
                padding: 10px 0;
                font-size: 0.85rem;
                font-weight: 700;
                color: #475569;
                cursor: pointer;
                border-radius: 99px;
                transition: all 0.2s;
            }

            @media(max-width: 768px) {
                .tab-item {
                    flex: 0 0 auto;
                    padding: 10px 24px;
                    white-space: nowrap;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            }

            .tab-item.active {
                background: #0f172a;
                color: white;
            }

            /* Section title */
            .section-title {
                position: relative;
                padding-left: 0;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 24px;
            }

            .section-title::before {
                content: none;
            }

            .section-title svg {
                width: 22px;
                height: 22px;
                color: #0f172a;
                flex-shrink: 0;
            }

            .sub-section-title {
                position: relative;
                padding-left: 0;
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 1rem;
                font-weight: 800;
                color: #475569;
                margin-bottom: 16px;
                margin-top: 16px;
            }

            .sub-section-title::before {
                content: none;
            }

            .sub-section-title svg {
                width: 18px;
                height: 18px;
                color: #0f172a;
                flex-shrink: 0;
            }

            .logbook-table {
                width: 100%;
                border-collapse: collapse;
            }

            .logbook-table th {
                padding: 12px 16px;
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
                font-size: 0.8rem;
                text-align: center;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }

            .logbook-table th:last-child {
                border-right: none;
            }

            .logbook-table td {
                padding: 12px 16px;
                color: #334155;
                font-size: 0.88rem;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
                text-align: center;
            }

            .logbook-table td:last-child {
                border-right: none;
            }

            .logbook-table tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .logbook-table tr:hover td {
                background: #f8fafc;
            }

            .empty-row td {
                padding: 24px !important;
                color: #cbd5e1 !important;
                text-align: center;
            }

            /* Finance Specific */
            .finance-box {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 24px;
            }

            .finance-row {
                display: grid;
                grid-template-columns: 200px 1fr;
                gap: 16px;
                margin-bottom: 16px;
                align-items: center;
                font-size: 0.85rem;
            }

            .finance-row strong {
                color: #1e293b;
                font-weight: 800;
            }

            .finance-row span {
                color: #475569;
            }

            .finance-textarea-box {
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px;
                min-height: 80px;
                color: #475569;
                font-size: 0.85rem;
                font-weight: 500;
            }

            .finance-header-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 24px;
            }

            .finance-info-grid {
                display: grid;
                gap: 12px;
            }

            .finance-pill {
                background: #0d9488;
                color: white;
                padding: 6px 16px;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            /* Heatmap table */
            .heatmap-container {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                margin-top: 16px;
            }

            .heatmap-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.88rem;
            }

            .heatmap-table th,
            .heatmap-table td {
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                padding: 12px 16px;
                text-align: center;
            }

            .heatmap-table th {
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
                font-size: 0.90rem;
            }

            .heatmap-table th:last-child {
                border-right: none;
            }

            .heatmap-table td:last-child {
                border-right: none;
            }

            .heatmap-table .th-main {
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
            }

            .heatmap-table .th-sub {
                font-size: 0.80rem;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                background: #f1f5f9;
            }

            .heatmap-table .td-left {
                text-align: left;
                font-weight: 600;
                color: #334155;
            }

            .gap-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 6px 16px;
                border-radius: 5px;
                font-weight: 700;
                min-width: 56px;
            }

            .gap-none {
                background: #f1f5f9;
                color: #64748b;
            }

            .gap-ok {
                background: #cbd5e1;
                color: #1e293b;
            }

            .gap-small {
                background: #f97316;
                color: white;
            }

            .gap-large {
                background: #ef4444;
                color: white;
            }

            /* TOP 3 GAP */
            .gap-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 14px 24px;
                border-radius: 99px;
                margin-bottom: 12px;
                font-size: 1rem;
                font-weight: 700;
                background: white;
                border: 1px solid #e2e8f0;
            }

            .gap-item.prio-1 {
                border: 1.5px solid #ef4444;
                color: #1e293b;
            }

            .gap-item.prio-2 {
                border: 1.5px solid #f97316;
                color: #1e293b;
            }

            .gap-item.prio-3 {
                border: 1.5px solid #8b5cf6;
                color: #1e293b;
            }

            .gap-number {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.85rem;
                margin-right: 16px;
                font-weight: 800;
            }

            .gap-item.prio-1 .gap-number {
                background: #ef4444;
            }

            .gap-item.prio-2 .gap-number {
                background: #f97316;
            }

            .gap-item.prio-3 .gap-number {
                background: #8b5cf6;
            }

            @media (max-width: 768px) {
                .gap-item {
                    border-radius: 16px !important;
                    padding: 12px 16px !important;
                    font-size: 0.9rem !important;
                }
                .gap-number {
                    margin-right: 12px !important;
                }
            }

            /* IDP Donut */
            .donut-container {
                background: white;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                padding: 24px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02);
                flex-wrap: wrap;
                gap: 24px;
                margin-bottom: 0;
            }

            .idp-chart-button {
                border: 0;
                cursor: pointer;
            }

            .idp-chart-button.is-active {
                outline: 4px solid rgba(15, 23, 42, 0.12);
                transform: translateY(-2px) scale(1.02);
            }

            .panelis-archive-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
                border: 1px solid #e2e8f0;
            }

            .panelis-archive-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                white-space: nowrap;
            }

            .panelis-archive-table td {
                text-align: center;
                padding: 18px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
                min-height: 60px;
            }

            .panelis-archive-table td.text-left-cell {
                text-align: left;
            }

            .panelis-status-text {
                font-weight: 700;
                font-size: 0.85rem;
                display: inline-flex;
                align-items: center;
                padding: 5px 10px;
                border-radius: 999px;
            }

            .panelis-status-sub {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 5px;
            }

            .panelis-status-ready-now {
                background: #dcfce7;
                color: #16a34a;
            }

            .panelis-status-ready-1-2 {
                background: #dbeafe;
                color: #2563eb;
            }

            .panelis-status-ready-over-2 {
                background: #fef3c7;
                color: #d97706;
            }

            .panelis-status-not-ready {
                background: #fee2e2;
                color: #dc2626;
            }

            .panelis-detail-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 7px 12px;
                border-radius: 10px;
                background: #f59e0b;
                border: 1px solid #f59e0b;
                color: white;
                font-size: 0.75rem;
                font-weight: 700;
                box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
                transition: all 0.2s;
                white-space: nowrap;
            }

            .panelis-detail-btn:hover {
                background: #d97706;
                border-color: #d97706;
                transform: translateY(-1px);
            }

            .panelis-detail-btn svg {
                width: 14px;
                height: 14px;
                flex-shrink: 0;
            }

            @media(max-width:768px) {
                .profile-card {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }

                .profile-col-1,
                .profile-col-general:nth-child(2) {
                    border-right: none;
                    padding-right: 0;
                    border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
                    padding-bottom: 16px;
                }

                .meta-item {
                    grid-template-columns: 1fr;
                    gap: 4px;
                }

                .finance-row {
                    grid-template-columns: 1fr;
                    gap: 4px;
                    margin-bottom: 12px;
                }

                .finance-box {
                    padding: 16px;
                }
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-6">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path
                    d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                <path fill-rule="evenodd"
                    d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Detail Progress Archive</div>
            <div class="page-header-sub">Ringkasan arsip pengembangan talent dan validasi akhir program.</div>
        </div>
    </div>

    {{-- Talent Profile Header - Hero Style --}}
    @php
        $namaTalent = $talent->nama ?? '-';
        $parts = explode(' ', trim($namaTalent));
        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

        $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
        if (!empty($mentorIds)) {
            $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->implode(', ');
        } else {
            $mentorNames = optional($talent->mentor)->nama ?? '-';
        }

        $startDate = optional($talent->promotion_plan)->start_date;
        $targetDate = optional($talent->promotion_plan)->target_date;
        $periodeStr =
            ($startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '-') .
            ' – ' .
            ($targetDate ? \Carbon\Carbon::parse($targetDate)->format('d/m/Y') : '-');
    @endphp

    <div class="flex talent-prof-hero">

        {{-- Section 1: Avatar + Identity --}}
        <div class="talent-hero-section-1">
            <div class="flex items-center gap-4 flex-1 min-w-0">
                <div class="talent-hero-avatar-wrap">
                    @if ($talent->foto ?? false)
                        <img src="{{ asset('storage/' . $talent->foto) }}" alt="Foto Profil" class="talent-hero-avatar-img">
                    @else
                        <div class="talent-hero-avatar-placeholder">{{ $initials }}</div>
                    @endif
                </div>
                <div class="talent-hero-info flex-1 min-w-0">
                    <div class="talent-hero-name truncate">{{ $namaTalent }}</div>
                    <div class="talent-hero-badge">Talent</div>
                </div>
            </div>
            {{-- Chevron: toggle on mobile --}}
            <button type="button" onclick="toggleMobileProfile()"
                class="lg:hidden flex items-center justify-center p-1 focus:outline-none">
                <svg id="mobile-profile-chevron" xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-white/40 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <div id="mobile-profile-detail" class="mobile-profile-detail-panel">
            <div class="talent-hero-divider"></div>

        {{-- Section 2: Perusahaan, Departemen, Posisi --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Perusahaan</span>
                <span class="talent-hero-meta-value">{{ optional($talent->company)->nama_company ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Departemen</span>
                <span class="talent-hero-meta-value">{{ optional($talent->department)->nama_department ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Posisi yang Dituju</span>
                <span
                    class="talent-hero-meta-value">{{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
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
                <span class="talent-hero-meta-value">{{ optional($talent->atasan)->nama ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Periode</span>
                <span class="talent-hero-meta-value">{{ $periodeStr }}</span>
            </div>
            </div>
        </div>

    </div>

    {{-- Nav Tabs --}}
    <div class="nav-tabs-container">
        <div class="nav-tabs">
            <div class="tab-item active" onclick="switchSection('kompetensi', this)">Kompetensi</div>
            <div class="tab-item" onclick="switchSection('idp', this)">IDP Monitoring</div>
            <div class="tab-item" onclick="switchSection('finance', this)">Finance Validation</div>
            <div class="tab-item" onclick="switchSection('panelis', this)">Panelis Review</div>
        </div>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi" class="tab-section" style="display: block;">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                    clip-rule="evenodd" />
            </svg>
            Kompetensi
        </div>

        <div class="sub-section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                    clip-rule="evenodd" />
            </svg>
            TOP 3 GAP Kompetensi
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8 mt-4">
            @if (isset($gaps) && count($gaps) > 0)
                @foreach ($gaps as $index => $gap)
                    <div class="gap-item prio-{{ $index + 1 }}">
                        <div class="flex items-center">
                            <span class="gap-number">{{ $index + 1 }}</span>
                            {{ optional($gap->competence)->name ?? '-' }}
                        </div>
                        <span>{{ number_format($gap->gap_score, 1) }}</span>
                    </div>
                @endforeach
            @else
                <!-- MOCKUP matching image -->
                <div class="gap-item prio-1">
                    <div class="flex items-center"><span class="gap-number">1</span>Integrity</div><span>-2</span>
                </div>
                <div class="gap-item prio-2">
                    <div class="flex items-center"><span class="gap-number">2</span>Problem Solving & Decision Making
                    </div>
                    <span>-1.5</span>
                </div>
                <div class="gap-item prio-3">
                    <div class="flex items-center"><span class="gap-number">3</span>Leadership</div><span>-1</span>
                </div>
            @endif
        </div>

        <hr class="border-t-2 border-slate-200 my-8">

        <div class="sub-section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                    clip-rule="evenodd" />
            </svg>
            Heatmap Kompetensi
        </div>

        <div class="heatmap-container overflow-x-auto mt-4">
                <table class="heatmap-table">
                    <thead>
                        <tr>
                            <th class="th-main" style="width:300px;">Kompetensi</th>
                            <th class="th-main" style="width:70px;">Standar</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Skor Talent</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Skor Atasan</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Final Score</th>
                            <th class="th-sub bg-[#ef4444] border-[#ef4444] text-white" style="width: 120px;">Gap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($competencies) && count($competencies) > 0)
                            @foreach ($competencies as $comp)
                                @php
                                    $standard = $standards[$comp->id] ?? 0;
                                    $detail = $talent->assessmentSession
                                        ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id)
                                        : null;
                                    $sT = $detail->score_talent ?? 0;
                                    $sA = $detail->score_atasan ?? 0;
                                    $gap = $detail->gap_score ?? 0;
                                    $final = $sA > 0 ? ($sT + $sA) / 2 : ($sT > 0 ? $sT : 0);
                                    $cls = $gap >= 0 ? 'gap-none' : ($gap <= -1.5 ? 'gap-large' : 'gap-small');
                                @endphp
                                <tr>
                                    <td class="td-left">{{ $comp->name }}</td>
                                    <td>{{ number_format((float) $standard, 1) }}</td>
                                    <td><span class="font-bold">{{ $sT ?: '-' }}</span></td>
                                    <td><span class="font-bold">{{ $sA ?: '-' }}</span></td>
                                    <td><span class="font-bold">{{ $final ?: '-' }}</span></td>
                                    <td class="text-center p-2"><span
                                            class="gap-badge {{ $cls }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Average row --}}
                            @php
                                $sess = $talent->assessmentSession;
                                $avgT = $sess ? $sess->details->avg('score_talent') ?? 0 : 0;
                                $avgA = $sess ? $sess->details->avg('score_atasan') ?? 0 : 0;
                                $avgGap = $sess ? $sess->details->avg('gap_score') ?? 0 : 0;
                                $avgCls = $avgGap >= 0 ? 'gap-none' : ($avgGap <= -1.5 ? 'gap-large' : 'gap-small');
                            @endphp
                            <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>{{ number_format(collect($standards)->avg() ?: 0, 1) }}</td>
                                <td>{{ number_format($avgT, 1) }}</td>
                                <td>{{ number_format($avgA, 1) }}</td>
                                <td>{{ number_format(($avgT + $avgA) / 2, 1) }}</td>
                                <td class="text-center p-2"><span
                                        class="gap-badge {{ $avgCls }}">{{ number_format($avgGap, 1) }}</span>
                                </td>
                            </tr>
                        @else
                            <!-- MOCKUP matching image -->
                            <tr>
                                <td class="td-left">Integrity</td>
                                <td>5</td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">4</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-none">0</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Communication</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Innovation & Creativity</td>
                                <td>3</td>
                                <td><span class="font-bold">4</span></td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-none">0</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Customer Orientation</td>
                                <td>3</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-none">0</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Teamwork</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Leadership</td>
                                <td>4</td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">4</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Bussiness Acumen</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Problem Solving & Decision Making</td>
                                <td>4</td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">2.5</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1.5</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Achievement Orientation</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Strategic Thinking</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>3.9</td>
                                <td>2.8</td>
                                <td>3.1</td>
                                <td>3.0</td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-0.95</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
    </div>

    {{-- ================================= SECTION: IDP MONITORING ================================= --}}
    <div id="section-idp" class="tab-section" style="display: none;">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
                <path
                    d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
            </svg>
            IDP Monitoring
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-8 w-full overflow-hidden">
            <div class="donut-container">
                @php
                    $idpChartData = [
                        'Exposure' => [
                            'done' => min($exposureCount ?? 0, 6),
                            'total' => 6,
                            'from' => '#334155',
                            'to' => '#334155',
                            'id' => 'archive-grad-exposure',
                            'target' => 'exposure',
                            'btn_color' =>
                                'bg-slate-700 hover:bg-slate-800 shadow-[0_4px_14px_rgba(51,65,85,0.25)] hover:shadow-lg',
                        ],
                        'Mentoring' => [
                            'done' => min($mentoringCount ?? 0, 6),
                            'total' => 6,
                            'from' => '#f59e0b',
                            'to' => '#f59e0b',
                            'id' => 'archive-grad-mentoring',
                            'target' => 'mentoring',
                            'btn_color' =>
                                'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_14px_rgba(245,158,11,0.28)] hover:shadow-lg',
                        ],
                        'Learning' => [
                            'done' => min($learningCount ?? 0, 6),
                            'total' => 6,
                            'from' => '#0d9488',
                            'to' => '#0d9488',
                            'id' => 'archive-grad-learning',
                            'target' => 'learning',
                            'btn_color' =>
                                'bg-teal-600 hover:bg-teal-700 shadow-[0_4px_14px_rgba(13,148,136,0.28)] hover:shadow-lg',
                        ],
                    ];
                    $r = 38;
                    $circ = 2 * M_PI * $r;
                @endphp
                @foreach ($idpChartData as $label => $chart)
                    @php
                        $pct = $chart['done'] / $chart['total'];
                        $filled = $pct * $circ;
                        $empty = $circ - $filled;
                    @endphp
                    <div class="flex flex-col items-center gap-3">
                        <div class="relative w-48 h-48 drop-shadow-sm">
                            <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                <defs>
                                    <linearGradient id="{{ $chart['id'] }}" x1="0%" y1="0%"
                                        x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="{{ $chart['from'] }}" />
                                        <stop offset="100%" stop-color="{{ $chart['to'] }}" />
                                    </linearGradient>
                                </defs>
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                    stroke="#f1f5f9" stroke-width="10" />
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                    stroke="url(#{{ $chart['id'] }})" stroke-width="10" stroke-linecap="round"
                                    stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                    style="transition: stroke-dasharray 0.8s ease;" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl font-extrabold text-[#1e293b]">{{ round($pct * 100) }}%</span>
                                <span class="text-xs font-bold text-gray-400">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                            </div>
                        </div>
                        <a href="{{ route('pdc_admin.progress_archive.logbook', ['talent_id' => $talent->id, 'session_id' => $sessionId]) }}#{{ $chart['target'] }}"
                            class="idp-chart-button {{ $chart['btn_color'] }} text-white px-8 py-2 rounded-[10px] transition-all flex items-center justify-center gap-2 group active:scale-95 hover:-translate-y-0.5"
                            title="Lihat logbook {{ $label }}">
                            <span class="text-sm font-bold tracking-wide">{{ $label }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 relative transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================================= SECTION: FINANCE VALIDATION ================================= --}}
    <div id="section-finance" class="tab-section" style="display: none;">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
            </svg>
            Finance Validation
        </div>

        @php $projects = $talent->improvementProjects; @endphp

        @forelse($projects as $project)
            @php
                $verifier = $project->verifier;
                // Determine status based on finance_feedback (same as PdcFinanceValidationTable)
                $financeStatus = 'Pending';
                if (!empty($project->finance_feedback)) {
                    if (str_starts_with($project->finance_feedback, '[Approved]')) {
                        $financeStatus = 'Approved';
                    } elseif (str_starts_with($project->finance_feedback, '[Rejected]')) {
                        $financeStatus = 'Rejected';
                    }
                }

                $statusBadgeColor = match (strtolower($financeStatus)) {
                    'approved' => 'border-green-500 text-green-600 bg-green-50/50',
                    'rejected' => 'border-red-500 text-red-600 bg-red-50/50',
                    'pending' => 'border-yellow-500 text-yellow-600 bg-yellow-50/50',
                    default => 'border-slate-400 text-slate-600 bg-slate-50',
                };
                $dotBadgeColor = match (strtolower($financeStatus)) {
                    'approved' => 'bg-green-500',
                    'rejected' => 'bg-red-500',
                    'pending' => 'bg-yellow-500',
                    default => 'bg-slate-400',
                };
            @endphp
            <!-- ================= DESKTOP VIEW ================= -->
            <div class="hidden md:block bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-4">
                <div class="finance-box shadow-sm">
                    <div class="finance-header-row">
                        <div class="finance-info-grid">
                            <div class="finance-row"><strong>Nama
                                    Finance</strong><span>{{ optional($verifier)->nama ?? '-' }}</span></div>
                            <div class="finance-row">
                                <strong>Email</strong><span>{{ optional($verifier)->email ?? '-' }}</span>
                            </div>
                            <div class="finance-row">
                                <strong>Perusahaan</strong><span>{{ optional($talent->company)->nama_company ?? '-' }}</span>
                            </div>
                            <div class="finance-row mb-0"><strong>Judul
                                    Project</strong><span>{{ $project->title ?? '-' }}</span></div>
                        </div>
                        <div class="finance-pill">
                            Tanggal &nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $project->verify_at ? $project->verify_at->locale('id')->translatedFormat('d M Y') : '-' }}
                        </div>
                    </div>

                    <div class="mt-4 mb-2"><strong class="text-[0.8rem] text-slate-800">Catatan Admin</strong></div>
                    <div class="finance-textarea-box">{{ $project->feedback ?? '-' }}</div>

                    <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Feedback Finance</strong>
                    </div>
                    <div class="finance-textarea-box">
                        {{ preg_replace('/^\[(?:Approved|Rejected|Batal)\]\s*/i', '', $project->finance_feedback ?? '-') }}
                    </div>

                    <hr class="border-t border-slate-200 my-6">

                    <div class="flex items-center justify-between">
                        @if ($project->document_path)
                            <a href="{{ route('files.preview', ['path' => $project->document_path]) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                    </path>
                                </svg>
                                Preview File
                            </a>
                        @else
                            <span class="text-xs text-slate-400">-</span>
                        @endif
                        <div
                            class="px-8 py-2 border rounded-full font-bold text-[0.8rem] flex items-center gap-2 shadow-sm {{ $statusBadgeColor }}">
                            <span class="w-2 h-2 rounded-full {{ $dotBadgeColor }}"></span>
                            {{ ucfirst($financeStatus ?? 'Pending') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= MOBILE VIEW ================= -->
            <div
                class="block md:hidden bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-8 w-full overflow-hidden">
                <div class="flex justify-end mb-4">
                    <div class="finance-pill">
                        Tanggal &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $project->verify_at ? $project->verify_at->locale('id')->translatedFormat('d M Y') : '-' }}
                    </div>
                </div>
                <div class="finance-box shadow-sm">
                    <div class="finance-info-grid">
                        <div class="finance-row"><strong>Nama
                                Finance</strong><span>{{ optional($verifier)->nama ?? '-' }}</span></div>
                        <div class="finance-row">
                            <strong>Email</strong><span>{{ optional($verifier)->email ?? '-' }}</span>
                        </div>
                        <div class="finance-row">
                            <strong>Perusahaan</strong><span>{{ optional($talent->company)->nama_company ?? '-' }}</span>
                        </div>
                        <div class="finance-row mb-0"><strong>Judul
                                Project</strong><span>{{ $project->title ?? '-' }}</span></div>
                    </div>

                    <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Catatan Admin</strong></div>
                    <div class="finance-textarea-box">{{ $project->feedback ?? '-' }}</div>

                    <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Feedback Finance</strong>
                    </div>
                    <div class="finance-textarea-box">
                        {{ preg_replace('/^\[(?:Approved|Rejected|Batal)\]\s*/i', '', $project->finance_feedback ?? '-') }}
                    </div>

                    <hr class="border-t border-slate-200 my-6">

                    <div class="flex flex-row items-center justify-between gap-2">
                        @if ($project->document_path)
                            <a href="{{ route('files.preview', ['path' => $project->document_path]) }}"
                                target="_blank"
                                class="inline-flex justify-center items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all flex-1 mr-1 sm:mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Preview File</span>
                            </a>
                        @else
                            <span class="text-xs text-slate-400 flex-1">-</span>
                        @endif
                        <div
                            class="shrink-0 px-4 sm:px-8 py-2 border rounded-full font-bold text-[0.75rem] sm:text-[0.8rem] flex justify-center items-center gap-1.5 sm:gap-2 shadow-sm {{ $statusBadgeColor }}">
                            <span class="w-2 h-2 rounded-full shrink-0 {{ $dotBadgeColor }}"></span>
                            <span class="whitespace-nowrap">{{ ucfirst($financeStatus ?? 'Pending') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-4 text-center text-slate-400">
                Belum ada Project Improvement
            </div>
        @endforelse
    </div>

    {{-- ================================= SECTION: PANELIS REVIEW ================================= --}}
    <div id="section-panelis" class="tab-section" style="display: none;">
        <div class="section-title mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                    clip-rule="evenodd" />
            </svg>
            Panelis Review
        </div>
        @php
            $latestProject = $talent->improvementProjects->sortByDesc('updated_at')->first();
            $panelisAspects = [
                [
                    'name' => 'Pemahaman Bisnis & Strategi',
                    'indicator' => 'Memahami konteks industri, Business proses dan arah perusahaan',
                ],
                [
                    'name' => 'Identifikasi Masalah',
                    'indicator' => 'Masalah yang diangkat relevan, kritis, dan berbasis data',
                ],
                [
                    'name' => 'Analisis Akar Masalah',
                    'indicator' => "Penggunaan tools (Fishbone, 5 Why's atau yang lain), logis dan mendalam",
                ],
                [
                    'name' => 'Solusi yang Ditawarkan',
                    'indicator' => 'Solusi konkret, realistis, dan menjawab akar masalah',
                ],
                [
                    'name' => 'Rencana Implementasi',
                    'indicator' => 'Timeline jelas, tahapan logis, melibatkan stakeholder',
                ],
                [
                    'name' => 'Target Dampak & KPI',
                    'indicator' => 'Indikator keberhasilan terukur, baseline–target jelas',
                ],
                ['name' => 'Risiko & Mitigasi', 'indicator' => 'Mengenali risiko dan menyusun strategi antisipasi'],
                [
                    'name' => 'Gaya Presentasi & Penguasaan Materi',
                    'indicator' => 'Komunikatif, percaya diri, menjawab pertanyaan',
                ],
                [
                    'name' => 'Refleksi Peran sebagai GM',
                    'indicator' =>
                        'Menunjukkan kesiapan mindset kepemimpinan, Strategic Thingking dan Conceptual thinking.',
                ],
                ['name' => 'Nilai Tambah', 'indicator' => 'Inisiatif ekstra, kolaborasi, atau insight mendalam'],
            ];
        @endphp
        <p class="text-slate-600 mb-6 text-[1rem]">{{ optional($latestProject)->title ?? '-' }}</p>

        {{-- Card-based Panelis Review Layout --}}
        <style>
            .panelis-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 20px 24px;
                margin-bottom: 14px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                transition: box-shadow 0.18s, border-color 0.18s;
            }
            .panelis-card:hover {
                box-shadow: 0 4px 18px rgba(20, 184, 166, 0.10);
                border-color: #99f6e4;
            }
            .panelis-card-header {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }
            .panelis-card-name {
                font-size: 0.92rem;
                font-weight: 800;
                color: #1e293b;
            }
            .panelis-card-dot {
                width: 5px;
                height: 5px;
                border-radius: 50%;
                background: #94a3b8;
                flex-shrink: 0;
                display: inline-block;
            }
            .panelis-card-company {
                font-size: 0.82rem;
                font-weight: 500;
                color: #94a3b8;
                font-style: italic;
            }
            .panelis-card-feedback {
                font-size: 0.84rem;
                color: #475569;
                line-height: 1.6;
                word-wrap: break-word;
                overflow-wrap: break-word;
                word-break: break-word;
            }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .btn-expand {
                display: inline-block;
                color: #14b8a6;
                font-size: 0.8rem;
                font-weight: 800;
                cursor: pointer;
                border: none;
                background: none;
                padding: 0;
                margin-top: 2px;
                transition: color 0.2s;
                text-align: left;
            }
            .btn-expand:hover {
                color: #0d9488;
                text-decoration: underline;
            }
            .btn-expand.hidden {
                display: none;
            }
            .panelis-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 4px;
            }
            /* Base pill */
            .panelis-status-pill {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 6px 18px;
                border: 1.5px solid #cbd5e1;
                border-radius: 999px;
                font-size: 0.78rem;
                font-weight: 700;
                color: #475569;
                background: #fff;
                white-space: nowrap;
            }
            /* Pill variants */
            .panelis-status-pill.pill-ready-now    { border-color: #16a34a; color: #16a34a; }
            .panelis-status-pill.pill-ready-1-2    { border-color: #2563eb; color: #2563eb; }
            .panelis-status-pill.pill-ready-over-2 { border-color: #ea580c; color: #ea580c; }
            .panelis-status-pill.pill-not-ready    { border-color: #dc2626; color: #dc2626; }

            .panelis-score-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 52px;
                height: 52px;
                border-radius: 999px;
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
                color: #fff;
                font-size: 1.05rem;
                font-weight: 800;
                box-shadow: 0 4px 14px rgba(20, 184, 166, 0.30);
                padding: 0 14px;
                flex-shrink: 0;
            }
            .panelis-avg-card {
                background: #14b8a6;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 8px 28px;
                display: inline-flex;
                align-items: center;
                gap: 32px;
                margin-top: 6px;
            }
            .panelis-avg-label {
                font-size: 0.88rem;
                font-weight: 800;
                color: #fff;
            }
            .panelis-avg-value {
                font-size: 1.15rem;
                font-weight: 800;
                color: #fff;
            }

            @media (max-width: 1024px) {
                .panelis-card {
                    padding: 16px;
                    width: 100%;
                    box-sizing: border-box;
                    min-width: 0;
                }
                .panelis-card-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 4px;
                }
                .panelis-card-dot {
                    display: none;
                }
                .panelis-card-footer {
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 12px;
                }
                .panelis-status-pill {
                    max-width: 100%;
                    width: fit-content;
                    white-space: normal;
                    text-align: left;
                }
                .panelis-avg-card {
                    width: 100%;
                    box-sizing: border-box;
                    justify-content: space-between;
                    gap: 16px;
                }
                .panelis-card-name,
                .panelis-card-company {
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    word-break: break-word;
                }
            }
        </style>

        <div class="mb-8">
            @php
                $totalScore = 0;
                $countAssessments = $talent->panelisAssessments->count();
            @endphp

            @forelse($talent->panelisAssessments as $idx => $assessment)
                @php
                    $rekomen = $assessment->panelis_rekomendasi ?? '';
                    $rekomenLabel = $rekomen ?: '-';
                    $score = ($assessment->panelis_score ?? 0) * 2;
                    $totalScore += $score;

                    // Tentukan class warna pill berdasarkan rekomendasi
                    if (str_contains($rekomen, 'Ready Now')) {
                        $pillClass = 'pill-ready-now';
                    } elseif (str_contains($rekomen, '> 2') || str_contains($rekomen, '>2') || str_contains($rekomen, 'over 2') || str_contains($rekomen, 'Over 2')) {
                        $pillClass = 'pill-ready-over-2';
                    } elseif (str_contains($rekomen, '1') || str_contains($rekomen, '2') || str_contains(strtolower($rekomen), '1-2')) {
                        $pillClass = 'pill-ready-1-2';
                    } elseif (str_contains(strtolower($rekomen), 'not ready')) {
                        $pillClass = 'pill-not-ready';
                    } else {
                        $pillClass = '';
                    }
                @endphp
                <div class="panelis-card">
                    {{-- Header: Nama & Perusahaan --}}
                    <div class="panelis-card-header">
                        <span class="panelis-card-name">{{ optional($assessment->panelis)->nama ?? '-' }}</span>
                        <span class="panelis-card-dot"></span>
                        <span class="panelis-card-company">
                            {{ optional(optional($assessment->panelis)->company)->nama_company ?? '-' }}
                        </span>
                    </div>

                    {{-- Feedback / Komentar --}}
                    <div class="panelis-card-feedback line-clamp-2">
                        {{ $assessment->panelis_komentar ?? '-' }}
                    </div>
                    <button type="button" class="btn-expand hidden" onclick="toggleExpandFeedback(this)">Lihat Selengkapnya</button>

                    {{-- Footer: Status Pill + Skor Badge --}}
                    <div class="panelis-card-footer">
                        <span class="panelis-status-pill {{ $pillClass }}">
                            {{ $rekomenLabel }}
                        </span>
                        <span class="panelis-score-badge">
                            {{ $score }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 border border-slate-200 rounded-xl px-6 py-8 text-center text-slate-400 text-sm">
                    Belum ada penilaian Panelis
                </div>
            @endforelse

            @if($countAssessments > 0)
                @php
                    $avgScore = round($totalScore / $countAssessments);
                @endphp
                <div class="panelis-avg-card">
                    <span class="panelis-avg-label">Rata Rata Skor</span>
                    <span class="panelis-avg-value">{{ $avgScore }}</span>
                </div>
            @endif
        </div>

        {{-- ======= DATA JSON untuk modal (pass dari PHP ke JS) ======= --}}
        @php
            $panelisModalDataRaw = $talent->panelisAssessments
                ->map(function ($a) {
                    return [
                        'nama' => optional($a->panelis)->nama ?? '-',
                        'perusahaan' => optional(optional($a->panelis)->company)->nama_company ?? '-',
                        'score' => $a->panelis_score ?? 0,
                        'scores_json' => is_string($a->panelis_scores_json)
                            ? json_decode($a->panelis_scores_json, true)
                            : $a->panelis_scores_json ?? [],
                        'komentar' => $a->panelis_komentar ?? '',
                        'rekomendasi' => $a->panelis_rekomendasi ?? '',
                        'tanggal' => $a->panelis_tanggal_penilaian
                            ? $a->panelis_tanggal_penilaian->format('d/m/Y')
                            : '-',
                    ];
                })
                ->values();
        @endphp
        <script>
            const panelisModalData = @json($panelisModalDataRaw);

            const panelisAspects = @json($panelisAspects);

            const talentInfo = {
                nama: "{{ $talent->nama ?? '-' }}",
                foto: "{{ $talent->foto ? asset('storage/' . $talent->foto) : '' }}",
                perusahaan: "{{ optional($talent->company)->nama_company ?? '-' }}",
                departemen: "{{ optional($talent->department)->nama_department ?? '-' }}",
                jabatan: "{{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}",
                mentor: "{{ optional($talent->mentor)->nama ?? '-' }}",
                atasan: "{{ optional($talent->atasan)->nama ?? '-' }}",
                project: "{{ optional($latestProject)->title ?? '-' }}",
            };

            function openPanelisModal(idx) {
                const data = panelisModalData[idx];
                const el = id => document.getElementById(id);

                let scores = [];
                if (Array.isArray(data.scores_json)) {
                    scores = data.scores_json;
                } else if (typeof data.scores_json === 'string') {
                    try {
                        scores = JSON.parse(data.scores_json);
                    } catch (e) {}
                } else if (typeof data.scores_json === 'object' && data.scores_json !== null) {
                    scores = Object.values(data.scores_json);
                }

                // Set project title
                el('pm-project').textContent = talentInfo.project;

                // Tabel aspek
                let rows = '';
                panelisAspects.forEach((asp, i) => {
                    const s = parseInt(scores[i]) || 0;
                    rows += `<tr>
                        <td class="text-left px-5 py-4 text-[0.85rem] font-bold text-slate-700 border-b border-slate-200">${asp.name}</td>
                        <td class="text-left px-5 py-4 text-[0.85rem] text-slate-600 border-b border-l border-slate-200">${asp.indicator}</td>
                        <td class="text-center px-4 py-4 border-b border-l border-slate-200">
                            ${s > 0 ? `<span class="inline-flex items-center justify-center w-10 h-10 rounded-[6px] bg-[#14b8a6] text-white font-bold text-[1.1rem]">${s}</span>` : '<span class="text-slate-300 text-sm">-</span>'}
                        </td>
                    </tr>`;
                });
                el('pm-aspek-rows').innerHTML = rows;

                // Komentar, rekomendasi, skor
                el('pm-komentar').textContent = data.komentar || '-';
                el('pm-skor').textContent = data.score + ' / 50';

                const rekomen = data.rekomendasi || '';
                let rekomenDesc = '';
                if (rekomen.includes('Ready Now')) rekomenDesc = 'Siap dipromosikan dalam < 6 bulan';
                else if (rekomen.includes('1')) rekomenDesc = 'Siap dengan pengembangan terarah';
                else if (rekomen.includes('2')) rekomenDesc = 'Masih membutuhkan pengembangan signifikan';
                else if (rekomen.includes('Not Ready')) rekomenDesc = 'Belum direkomendasikan';
                el('pm-rekomen').innerHTML = rekomen ?
                    `<span class="inline-flex items-center gap-3"><span class="w-6 h-6 rounded bg-[#14b8a6] inline-block flex-shrink-0"></span> <strong>${rekomen}</strong> <span class="text-slate-500 font-normal">(${rekomenDesc})</span></span>` :
                    '-';

                // Show detail page, hide others
                document.getElementById('section-panelis').style.display = 'none';
                document.getElementById('bottom-navigation-container')?.style.setProperty('display', 'none');
                document.querySelector('.nav-tabs-container').style.display = 'none'; // hide tabs
                document.getElementById('section-panelis-detail').style.display = 'block';

                // Scroll to top of content
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function closePanelisModal() {
                document.getElementById('section-panelis-detail').style.display = 'none';
                document.getElementById('section-panelis').style.display = 'block';
                document.getElementById('bottom-navigation-container')?.style.setProperty('display', 'flex');
                document.querySelector('.nav-tabs-container').style.display = ''; // show tabs

                // Scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        </script>
    </div>

    {{-- ======= PANELIS DETAIL VIEW ======= --}}
    <div id="section-panelis-detail" style="display: none;">
        <div class="bg-white p-2">
            <p id="pm-project" class="font-bold text-slate-800 text-[1.05rem] mb-5"></p>

            {{-- Aspek Table --}}
            <div class="overflow-x-auto overflow-y-hidden rounded-xl border border-slate-200 mb-5 w-full bg-white">
                <table class="w-full text-sm border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left px-5 py-4 font-bold text-slate-700 w-[30%]">Aspek yang Dinilai</th>
                            <th class="text-left px-5 py-4 font-bold text-slate-700 border-l border-slate-200">
                                Indikator
                                Penilaian</th>
                            <th
                                class="text-center px-4 py-4 font-bold text-slate-700 border-l border-slate-200 w-[200px]">
                                Skor Penilaian</th>
                        </tr>
                    </thead>
                    <tbody id="pm-aspek-rows"></tbody>
                </table>
            </div>

            {{-- Komentar --}}
            <div class="border border-slate-200 rounded-xl mb-6 overflow-hidden">
                <div class="bg-slate-50 px-5 py-3 text-[0.85rem] font-bold text-slate-800 border-b border-slate-200">
                    Komentar / Catatan Panelis:</div>
                <div id="pm-komentar" class="px-5 py-6 text-[0.85rem] text-slate-600 bg-white min-h-[90px]"></div>
            </div>

            {{-- Rekomendasi & Skor --}}
            <div class="border border-slate-200 rounded-xl p-5 mb-5 flex flex-col gap-4 bg-white">
                <div id="pm-rekomen" class="text-[0.85rem] text-slate-700 w-full mb-2"></div>
                <hr class="border-t border-slate-100">
                <div class="flex items-center gap-4 text-[0.85rem] font-bold text-slate-700">
                    Skor <span id="pm-skor"
                        class="border border-slate-200 text-teal-600 rounded-lg px-6 py-2 bg-white font-bold text-[0.95rem] min-w-[85px] text-center"></span>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const sections = ['kompetensi', 'idp', 'finance', 'panelis'];
            let currentSectionIndex = 0;

            document.addEventListener("DOMContentLoaded", function() {
                // Ensure correct initial state
                switchSection('kompetensi', document.querySelector('.tab-item.active'));
            });

            function switchSection(sectionId, element) {
                // hide all sections
                document.querySelectorAll('.tab-section').forEach(el => {
                    el.style.display = 'none';
                });

                // remove active class from all tabs
                document.querySelectorAll('.tab-item').forEach(el => {
                    el.classList.remove('active');
                });

                // show target section
                document.getElementById('section-' + sectionId).style.display = 'block';

                if (sectionId === 'panelis') {
                    initFeedbackExpand();
                }

                // set active tab
                if (element) {
                    element.classList.add('active');
                } else {
                    document.querySelector('.tab-item:nth-child(' + (sections.indexOf(sectionId) + 1) + ')').classList.add(
                        'active');
                }

                currentSectionIndex = sections.indexOf(sectionId);

                const nextBtn = document.getElementById('btnNextSection');
                if (nextBtn) {
                    if (currentSectionIndex === sections.length - 1) {
                        nextBtn.style.display = 'none';
                    } else {
                        nextBtn.style.display = 'inline-flex';
                    }
                }

                // Scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function toggleMobileProfile() {
                const detail = document.getElementById('mobile-profile-detail');
                const chevron = document.getElementById('mobile-profile-chevron');
                if (!detail) return;
                detail.classList.toggle('open');
                if (chevron) {
                    chevron.style.transform = detail.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            }

            function toggleExpandFeedback(btn) {
                const feedbackEl = btn.previousElementSibling;
                if (feedbackEl) {
                    if (feedbackEl.classList.contains('line-clamp-2')) {
                        feedbackEl.classList.remove('line-clamp-2');
                        btn.textContent = 'Sembunyikan';
                    } else {
                        feedbackEl.classList.add('line-clamp-2');
                        btn.textContent = 'Lihat Selengkapnya';
                    }
                }
            }

            function initFeedbackExpand() {
                document.querySelectorAll('.panelis-card-feedback').forEach(el => {
                    if (el.scrollHeight > el.clientHeight) {
                        const btn = el.nextElementSibling;
                        if (btn && btn.classList.contains('btn-expand')) {
                            btn.classList.remove('hidden');
                        }
                    }
                });
            }

            // Removed nextSection and prevSection as they are no longer needed
        </script>
    </x-slot>

</x-pdc_admin.layout>
