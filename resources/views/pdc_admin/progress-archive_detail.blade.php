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
                background: #cbd5e1;
                border-radius: 20px;
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

            @media (max-width: 1024px) {
                .talent-hero-section {
                    padding: 0 16px;
                }

                .talent-hero-section-1 {
                    padding: 0 16px 0 0;
                }
            }

            @media (max-width: 768px) {
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
                padding-left: 14px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 24px;
            }

            .section-title::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 18px;
            }

            .sub-section-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 16px;
                margin-top: 16px;
            }

            /* Logbook Specific */
            .logbook-pill {
                background: #0f172a;
                color: white;
                padding: 6px 16px;
                border-radius: 99px;
                font-size: 0.75rem;
                font-weight: 700;
                display: inline-block;
                margin-bottom: 16px;
                margin-top: 24px;
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

            .filter-pills {
                display: flex;
                background: #e2e8f0;
                padding: 4px;
                border-radius: 9999px;
                width: fit-content;
                margin-bottom: 20px;
            }

            .pill {
                padding: 8px 32px;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 700;
                color: #475569;
                cursor: pointer;
                transition: all 0.2s;
            }

            .pill:hover {
                background: #cbd5e1;
                color: #1e293b;
            }

            .pill.active {
                background: #0f172a;
                color: white;
                box-shadow: 0 2px 12px rgba(15, 23, 42, 0.22);
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
                font-size: 0.8125rem;
            }

            .heatmap-table th,
            .heatmap-table td {
                border: 1px solid #e2e8f0;
                padding: 8px 12px;
                text-align: center;
            }

            .heatmap-table .th-main {
                background: #f8fafc;
                font-weight: 700;
                color: #1e293b;
                font-size: 0.90rem;
            }

            .heatmap-table .th-sub {
                font-size: 0.80rem;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                background: #f8fafc;
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
                padding: 4px;
                border-radius: 4px;
                font-weight: 700;
                min-width: 40px;
            }

            .gap-none {
                background: #f1f5f9;
                color: #64748b;
            }

            .gap-positive {
                background: #6293ff;
                color: white;
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

            /* IDP Donut */
            .donut-container {
                background: white;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                padding: 32px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02);
                flex-wrap: wrap;
                gap: 24px;
                margin-bottom: 32px;
            }

            /* Normalize card spacing: make top/bottom margins consistent with side spacing */
            .bg-slate-50.p-6.rounded-xl.border.border-slate-200,
            .bg-white.p-6.rounded-xl.border.border-slate-200,
            .border.border-slate-200.rounded-xl {
                margin-top: 16px !important;
                margin-bottom: 16px !important;
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

                .filter-pills {
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    padding: 4px;
                }

                .pill {
                    flex: 1;
                    text-align: center;
                    padding: 6px 2px;
                    font-size: 0.75rem;
                    white-space: nowrap;
                }
            }
        </style>
    </x-slot>

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

    <div class="talent-prof-hero">

        {{-- Section 1: Avatar + Identity --}}
        <div class="talent-hero-section-1">
            <div class="talent-hero-avatar-wrap">
                @if ($talent->foto ?? false)
                    <img src="{{ asset('storage/' . $talent->foto) }}" alt="Foto Profil" class="talent-hero-avatar-img">
                @else
                    <div class="talent-hero-avatar-placeholder">{{ $initials }}</div>
                @endif
            </div>
            <div class="talent-hero-info">
                <div class="talent-hero-name">{{ $namaTalent }}</div>
                <div class="talent-hero-badge">Talent</div>
            </div>
        </div>

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

        <div class="section-title mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd"
                    d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                    clip-rule="evenodd" />
            </svg>
            TOP 3 GAP Kompetensi
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-4 mt-4">
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

        <div class="section-title mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd"
                    d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                    clip-rule="evenodd" />
            </svg>
            Heatmap Kompetensi
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4">
            <div class="heatmap-container overflow-x-auto m-0">
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
                                    $cls =
                                        $gap > 0
                                            ? 'gap-positive'
                                            : ($gap == 0
                                                ? 'gap-none'
                                                : ($gap <= -1.5
                                                    ? 'gap-large'
                                                    : 'gap-small'));
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
                                $avgCls =
                                    $avgGap > 0
                                        ? 'gap-positive'
                                        : ($avgGap == 0
                                            ? 'gap-none'
                                            : ($avgGap <= -1.5
                                                ? 'gap-large'
                                                : 'gap-small'));
                            @endphp
                            <tr class="font-bold bg-[#f1f5f9] border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>{{ number_format(collect($standards)->avg() ?: 0, 1) }}</td>
                                <td>{{ number_format($avgT, 1) }}</td>
                                <td>{{ number_format($avgA, 1) }}</td>
                                <td>{{ number_format(($avgT + $avgA) / 2, 1) }}</td>
                                <td class="text-center p-2"><span
                                        class="font-bold text-[#334155]">{{ number_format($avgGap, 1) }}</span>
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
                                <td class="text-center p-2"><span class="gap-badge gap-positive">0.5</span></td>
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
                            <tr class="font-bold bg-[#f1f5f9] border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>3.9</td>
                                <td>2.8</td>
                                <td>3.1</td>
                                <td>3.0</td>
                                <td class="text-center p-2"><span class="font-bold text-[#334155]">-0.95</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================================= SECTION: IDP MONITORING ================================= --}}
    <div id="section-idp" class="tab-section" style="display: none;">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
                <path
                    d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
            </svg>
            IDP Monitoring
        </div>
        @foreach ($talents as $talent)
            <div class="idp-card-container">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                        class="w-14 h-14 rounded-full" alt="">
                    <div>
                        <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                        <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} -
                            {{ optional($talent->department)->nama_department }}</p>
                    </div>
                </div>

                <div class="donut-container">
                    @php
                        $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
                        $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
                        $learningCount = $talent->idpActivities->where('type_idp', 3)->count();

                        $idpChartData = [
                            'Exposure' => [
                                'done' => min($exposureCount ?? 0, 6),
                                'total' => 6,
                                'from' => '#334155',
                                'to' => '#334155',
                                'id' => 'grad-exposure',
                                'btn_color' =>
                                    'bg-slate-700 shadow-[0_4px_12px_-2px_rgba(51,65,85,0.4)] hover:shadow-lg',
                            ],
                            'Mentoring' => [
                                'done' => min($mentoringCount ?? 0, 6),
                                'total' => 6,
                                'from' => '#f59e0b',
                                'to' => '#f59e0b',
                                'id' => 'grad-mentoring',
                                'btn_color' =>
                                    'bg-amber-500 shadow-[0_4px_12px_-2px_rgba(245,158,11,0.4)] hover:shadow-lg',
                            ],
                            'Learning' => [
                                'done' => min($learningCount ?? 0, 6),
                                'total' => 6,
                                'from' => '#0d9488',
                                'to' => '#0d9488',
                                'id' => 'grad-learning',
                                'btn_color' =>
                                    'bg-teal-600 shadow-[0_4px_12px_-2px_rgba(13,148,136,0.4)] hover:shadow-lg',
                            ],
                        ];
                        $r = 38;
                        $circ = 2 * M_PI * $r; // ≈ 238.76
                    @endphp
                    @foreach ($idpChartData as $label => $d)
                        @php
                            $pct = $d['done'] / $d['total'];
                            $filled = $pct * $circ;
                            $empty = $circ - $filled;
                        @endphp
                        <div class="flex flex-col items-center gap-3">
                            <div class="relative w-48 h-48 drop-shadow-sm">
                                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                    <defs>
                                        <linearGradient id="{{ $d['id'] }}" x1="0%" y1="0%"
                                            x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="{{ $d['from'] }}" />
                                            <stop offset="100%" stop-color="{{ $d['to'] }}" />
                                        </linearGradient>
                                    </defs>
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="#f1f5f9" stroke-width="10" />
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="url(#{{ $d['id'] }})" stroke-width="10" stroke-linecap="round"
                                        stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                        style="transition: stroke-dasharray 0.8s ease;" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-4xl font-bold"
                                        style="color:{{ $d['from'] }};">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <a href="{{ route('pdc_admin.talent.logbook', $talent->id) }}#{{ strtolower($label) }}"
                                class="{{ $d['btn_color'] }} text-white px-8 py-2 rounded-[10px] transition-all flex items-center justify-center gap-2 group active:scale-95 hover:-translate-y-0.5 cursor-pointer"
                                title="Lihat logbook {{ $label }}">
                                <span class="text-sm font-bold tracking-wide">{{ $label }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 relative transition-transform group-hover:translate-x-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
    </div>

    </div>

    {{-- ===== LOGBOOK SUB-PAGE (halaman tersendiri, muncul saat tombol donut diklik) ===== --}}
    <div id="section-idp-logbook" class="tab-section" style="display: none;">

        {{-- Header + judul --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="section-title" style="margin: 0 0 0 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                LogBook
            </div>
        </div>

        {{-- Filter Pills --}}
        <div class="filter-pills">
            <div class="pill active" id="lb-pill-exposure" onclick="switchLogbookTable('exposure', this)">Exposure
            </div>
            <div class="pill" id="lb-pill-mentoring" onclick="switchLogbookTable('mentoring', this)">Mentoring
            </div>
            <div class="pill" id="lb-pill-learning" onclick="switchLogbookTable('learning', this)">Learning</div>
        </div>

        {{-- Exposure Logbook --}}
        @php $exposureActivities = $talent->idpActivities->filter(fn($a) => str_contains(strtolower(optional($a->type)->type_name ?? ''), 'exposure')); @endphp
        <div id="logbook-exposure" class="logbook-table-container" style="display: block;">
            <div class="overflow-x-auto w-full mt-4">
                <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden min-w-[600px]">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Mentor</th>
                            <th style="width: 25%;">Tema</th>
                            <th style="width: 15%;">Tanggal Pengiriman</th>
                            <th style="width: 15%;">Tanggal Pelaksanaan</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureActivities as $act)
                            @php
                                $statusColor = match (strtolower($act->status ?? '')) {
                                    'approved' => 'text-green-600',
                                    'rejected' => 'text-red-600',
                                    default => 'text-yellow-600',
                                };
                                $dotColor = match (strtolower($act->status ?? '')) {
                                    'approved' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-yellow-500',
                                };
                            @endphp
                            <tr>
                                <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                                <td>{{ $act->theme ?? '-' }}</td>
                                <td>{{ $act->updated_at ? $act->updated_at->format('d/m/Y') : '-' }}</td>
                                <td>{{ $act->activity_date ?? '-' }}</td>
                                <td><span
                                        class="text-[0.7rem] font-bold {{ $statusColor }} flex items-center justify-center gap-1.5"><span
                                            class="w-1.5 h-1.5 {{ $dotColor }} rounded-full"></span>{{ ucfirst($act->status ?? 'Pending') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-xs font-bold text-white hover:bg-[#0d9488] hover:border-[#0d9488] transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="6" class="text-center text-slate-400 text-sm py-4">Belum ada aktivitas
                                    Exposure</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mentoring Logbook --}}
        @php $mentoringActivities = $talent->idpActivities->filter(fn($a) => str_contains(strtolower(optional($a->type)->type_name ?? ''), 'mentor')); @endphp
        <div id="logbook-mentoring" class="logbook-table-container" style="display: none;">
            <div class="overflow-x-auto w-full mt-4">
                <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden min-w-[600px]">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Mentor</th>
                            <th style="width: 25%;">Tema</th>
                            <th style="width: 15%;">Tanggal Pengiriman</th>
                            <th style="width: 15%;">Tanggal Pelaksanaan</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringActivities as $act)
                            @php
                                $statusColor = match (strtolower($act->status ?? '')) {
                                    'approved' => 'text-green-600',
                                    'rejected' => 'text-red-600',
                                    default => 'text-yellow-600',
                                };
                                $dotColor = match (strtolower($act->status ?? '')) {
                                    'approved' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-yellow-500',
                                };
                            @endphp
                            <tr>
                                <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                                <td>{{ $act->theme ?? '-' }}</td>
                                <td>{{ $act->updated_at ? $act->updated_at->format('d/m/Y') : '-' }}</td>
                                <td>{{ $act->activity_date ?? '-' }}</td>
                                <td><span
                                        class="text-[0.7rem] font-bold {{ $statusColor }} flex items-center justify-center gap-1.5"><span
                                            class="w-1.5 h-1.5 {{ $dotColor }} rounded-full"></span>{{ ucfirst($act->status ?? 'Pending') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-xs font-bold text-white hover:bg-[#0d9488] hover:border-[#0d9488] transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="6" class="text-center text-slate-400 text-sm py-4">Belum ada aktivitas
                                    Mentoring</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Learning Logbook --}}
        @php $learningActivities = $talent->idpActivities->filter(fn($a) => str_contains(strtolower(optional($a->type)->type_name ?? ''), 'learn')); @endphp
        <div id="logbook-learning" class="logbook-table-container" style="display: none;">
            <div class="overflow-x-auto w-full mt-4">
                <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden min-w-[600px]">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Sumber</th>
                            <th style="width: 25%;">Tema</th>
                            <th style="width: 15%;">Tanggal Pengiriman</th>
                            <th style="width: 15%;">Tanggal Pelaksanaan</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningActivities as $act)
                            @php
                                $statusColor = match (strtolower($act->status ?? '')) {
                                    'approved' => 'text-green-600',
                                    'rejected' => 'text-red-600',
                                    default => 'text-yellow-600',
                                };
                                $dotColor = match (strtolower($act->status ?? '')) {
                                    'approved' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-yellow-500',
                                };
                            @endphp
                            <tr>
                                <td>{{ $act->platform ?? '-' }}</td>
                                <td>{{ $act->theme ?? '-' }}</td>
                                <td>{{ $act->updated_at ? $act->updated_at->format('d/m/Y') : '-' }}</td>
                                <td>{{ $act->activity_date ?? '-' }}</td>
                                <td><span
                                        class="text-[0.7rem] font-bold {{ $statusColor }} flex items-center justify-center gap-1.5"><span
                                            class="w-1.5 h-1.5 {{ $dotColor }} rounded-full"></span>{{ ucfirst($act->status ?? 'Pending') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-xs font-bold text-white hover:bg-[#0d9488] hover:border-[#0d9488] transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="6" class="text-center text-slate-400 text-sm py-4">Belum ada aktivitas
                                    Learning</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================================= SECTION: FINANCE VALIDATION ================================= --}}
    <div id="section-finance" class="tab-section" style="display: none;">
        <div class="section-title">Finance Validation</div>

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
                            {{ $project->verify_at ? $project->verify_at->translatedFormat('d F Y') : '-' }}
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
                class="block md:hidden bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-4 w-full overflow-hidden">
                <div class="flex justify-end mb-4">
                    <div class="finance-pill">
                        Tanggal &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $project->verify_at ? $project->verify_at->translatedFormat('d F Y') : '-' }}
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
        <div class="section-title mb-2">Panelis Review</div>
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

        <div class="bg-white rounded-xl border border-slate-200 mt-2 shadow-sm overflow-hidden p-0 w-full">
            <div class="overflow-x-auto w-full">
                <table class="logbook-table mb-0 border-none min-w-[900px]">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th style="width: 22%;" class="border-0 border-r border-slate-200">Panelis</th>
                            <th style="width: 22%;" class="border-0 border-r border-slate-200">Perusahaan</th>
                            <th style="width: 9%;" class="border-0 border-r border-slate-200">Skor</th>
                            <th style="width: 20%;" class="border-0 border-r border-slate-200">Feedback</th>
                            <th style="width: 17%;" class="border-0 border-r border-slate-200">Status</th>
                            <th style="width: 10%;" class="border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($talent->panelisAssessments as $idx => $assessment)
                            @php
                                $rekomen = $assessment->panelis_rekomendasi ?? '';
                                $rekomenDesc = '';
                                if (str_contains($rekomen, 'Ready Now')) {
                                    $rekomenDesc = 'Siap dipromosikan dalam < 6 bulan';
                                } elseif (str_contains($rekomen, '1')) {
                                    $rekomenDesc = 'Siap dengan pengembangan terarah';
                                } elseif (str_contains($rekomen, '2')) {
                                    $rekomenDesc = 'Masih membutuhkan pengembangan signifikan';
                                } elseif (str_contains($rekomen, 'Not Ready')) {
                                    $rekomenDesc = 'Belum direkomendasikan untuk jalur suksesi';
                                }
                            @endphp
                            <tr class="border-b border-slate-200">
                                <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">
                                    {{ optional($assessment->panelis)->nama ?? '-' }}</td>
                                <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">
                                    {{ optional(optional($assessment->panelis)->company)->nama_company ?? '-' }}</td>
                                <td class="font-bold text-slate-800 border-0 border-r border-slate-200">
                                    {{ $assessment->panelis_score ?? '-' }} / 50</td>
                                <td class="text-slate-700 border-0 border-r border-slate-200 text-xs">
                                    {{ Str::limit($assessment->panelis_komentar ?? '-', 60) }}</td>
                                <td class="border-0 border-r border-slate-200 text-left px-4">
                                    @if ($rekomen)
                                        <div class="font-bold text-slate-800 text-[0.8rem]">{{ $rekomen }}</div>
                                        @if ($rekomenDesc)
                                            <div class="text-[0.65rem] text-slate-500 mt-0.5">{{ $rekomenDesc }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="border-0 text-center px-4">
                                    <!-- Desktop Button -->
                                    <button onclick="openPanelisModal({{ $idx }})"
                                        class="hidden md:inline-flex items-center gap-1.5 bg-[#14b8a6] hover:bg-[#0d9488] text-white text-xs font-bold px-4 py-1.5 rounded-xl border-none transition-all whitespace-nowrap">
                                        Lihat Detail
                                    </button>
                                    <!-- Mobile Button -->
                                    <button onclick="openPanelisModal({{ $idx }})"
                                        class="md:hidden mx-auto whitespace-nowrap inline-flex items-center gap-1.5 bg-[#14b8a6] hover:bg-[#0d9488] text-white text-xs font-bold px-4 py-1.5 rounded-xl border-none transition-all w-max">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-400 text-sm py-6">Belum ada penilaian
                                    Panelis</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
                document.getElementById('bottom-navigation-container').style.display = 'none';
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
                document.getElementById('bottom-navigation-container').style.display = 'flex';
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
                switchSection('kompetensi', document.querySelector('.tab-item.active'));
            });

            function switchSection(sectionId, element) {
                // Hide all tab-sections (termasuk logbook sub-page)
                document.querySelectorAll('.tab-section').forEach(el => {
                    el.style.display = 'none';
                });
                document.querySelectorAll('.tab-item').forEach(el => {
                    el.classList.remove('active');
                });
                document.getElementById('section-' + sectionId).style.display = 'block';
                if (element) {
                    element.classList.add('active');
                } else {
                    document.querySelector('.tab-item:nth-child(' + (sections.indexOf(sectionId) + 1) + ')').classList.add(
                        'active');
                }
                currentSectionIndex = sections.indexOf(sectionId);
                const nextBtn = document.getElementById('btnNextSection');
                if (nextBtn) {
                    nextBtn.style.display = currentSectionIndex === sections.length - 1 ? 'none' : 'inline-flex';
                }
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function openLogbookPage(tableId) {
                document.getElementById('section-idp').style.display = 'none';
                document.getElementById('section-idp-logbook').style.display = 'block';
                switchLogbookTable(tableId);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function closeLogbookPage() {
                document.getElementById('section-idp-logbook').style.display = 'none';
                document.getElementById('section-idp').style.display = 'block';
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function switchLogbookTable(tableId, element) {
                document.querySelectorAll('.logbook-table-container').forEach(el => {
                    el.style.display = 'none';
                });
                document.querySelectorAll('#section-idp-logbook .filter-pills .pill').forEach(el => {
                    el.classList.remove('active');
                });
                document.getElementById('logbook-' + tableId).style.display = 'block';
                if (element) {
                    element.classList.add('active');
                } else {
                    const pill = document.getElementById('lb-pill-' + tableId);
                    if (pill) pill.classList.add('active');
                }
            }
        </script>
    </x-slot>

</x-pdc_admin.layout>
