<x-atasan.layout title="Riwayat Detail – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Animations (aligned with talent dashboard) ── */
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

            .animate-title {
                animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
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

            .detail-container {
                width: 100%;
            }

            /* --- Section Titles --- */
            .section-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 24px;
                margin-top: 48px;
            }

            .section-header:first-of-type {
                margin-top: 0;
            }

            .section-header svg {
                width: 24px;
                height: 24px;
                color: #0f172a;
            }

            .section-header h3 {
                font-size: 1.125rem;
                font-weight: 800;
                color: #1e293b;
                text-transform: capitalize;
                letter-spacing: 0.5px;
            }

            /* --- Sub Section Title (matches admin) --- */
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

            /* --- Top 3 GAP Items (matches admin) --- */
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

            /* --- Heatmap Table --- */
            .heatmap-container {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
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
                white-space: nowrap;
            }

            .heatmap-table .td-left {
                text-align: left;
                font-weight: 600;
                color: #334155;
                white-space: nowrap;
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

            .legend {
                display: flex;
                gap: 16px;
                font-size: 0.65rem;
                font-weight: 700;
                color: #64748b;
                margin-bottom: 12px;
                text-transform: uppercase;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .legend-box {
                width: 12px;
                height: 12px;
                border-radius: 2px;
            }

            .row-summary td {
                background: #f1f5f9;
                font-weight: 800;
                border-top: 2px solid #cbd5e1;
            }

            /* --- IDP Monitoring --- */
            .idp-monitoring-box {
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 16px;
                padding: 32px;
                display: flex;
                justify-content: space-around;
                align-items: center;
            }

            .chart-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 16px;
            }

            .donut-static {
                position: relative;
                width: 140px;
                height: 140px;
            }

            .donut-text {
                position: absolute;
                inset: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .donut-value {
                font-size: 1.5rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1;
            }

            .donut-pct {
                font-size: 0.75rem;
                color: #94a3b8;
                font-weight: 600;
            }

            .label-pill {
                padding: 4px 20px;
                border: 1px solid #e2e8f0;
                border-radius: 99px;
                font-size: 0.813rem;
                font-weight: 700;
                color: #475569;
            }

            /* --- Project Improvement Table --- */
            .project-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
                border: 1px solid #e2e8f0;
            }

            .project-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                white-space: nowrap;
            }

            .project-table td {
                text-align: center;
                padding: 18px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
                min-height: 60px;
            }

            .status-approve {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                color: #16a34a;
                font-weight: 700;
                font-size: 0.813rem;
            }

            .status-approve::before {
                content: '';
                width: 8px;
                height: 8px;
                background: #22c55e;
                border-radius: 50%;
            }

            .project-section-title {
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 1.25rem;
                font-weight: 800;
            }

            .project-section-icon {
                width: 44px;
                height: 44px;
                border-radius: 16px;
                background: #0f172a;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
                flex-shrink: 0;
            }

            .project-section-icon svg {
                width: 22px;
                height: 22px;
            }

            .project-improvement-table {
                width: 100%;
                table-layout: fixed;
                border-collapse: collapse;
            }

            .project-improvement-table th,
            .project-improvement-table td {
                vertical-align: middle;
            }

            .project-improvement-table th:nth-child(1),
            .project-improvement-table td:nth-child(1) {
                width: 50%;
                text-align: left;
            }

            .project-improvement-table th:nth-child(2),
            .project-improvement-table td:nth-child(2),
            .project-improvement-table th:nth-child(3),
            .project-improvement-table td:nth-child(3) {
                width: 25%;
                text-align: center;
            }

            .project-improvement-table td:nth-child(2),
            .project-improvement-table td:nth-child(3) {
                padding-left: 12px;
                padding-right: 12px;
            }

            .project-title-cell {
                font-weight: 800;
                color: #1e293b;
                text-align: left;
                word-break: break-word;
            }

            .project-action-cell,
            .project-status-cell {
                text-align: center;
            }

            .project-file-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                min-width: 128px;
            }

            /* --- LogBook Section --- */
            .logbook-section {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logbook-info h4 {
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 4px;
            }

            .logbook-info p {
                font-size: 0.813rem;
                color: #64748b;
            }

            .btn-lihat-detail {
                background: #22c55e;
                color: white;
                padding: 10px 24px;
                border-radius: 8px;
                font-size: 0.813rem;
                font-weight: 700;
                text-decoration: none;
                transition: background 0.2s;
            }

            .btn-lihat-detail:hover {
                background: #16a34a;
            }

            /* --- PDC Admin Alignment --- */
            .prem-card-title {
                font-size: 1.25rem !important;
                gap: 14px !important;
            }

            .prem-card-title svg {
                width: 28px !important;
                height: 28px !important;
                color: #0f172a !important;
            }

            /* --- Admin Detail Style Tabs --- */
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
                scrollbar-width: none;
            }

            .nav-tabs::-webkit-scrollbar {
                display: none;
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
                white-space: nowrap;
                border: none;
                background: transparent;
                font-family: inherit;
            }

            .tab-item.active {
                background: #0f172a;
                color: white;
            }

            .tab-section {
                animation: fadeSlideUp 0.35s ease both;
            }

            .section-title {
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-top: 24px;
                margin-bottom: 24px;
            }

            .section-title svg {
                width: 24px;
                height: 24px;
                color: #0f172a;
                flex-shrink: 0;
            }

            @media (max-width: 1024px) {
                .header-info-card {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 24px;
                }

                .header-profile {
                    border-right: none;
                    padding-right: 0;
                }

                .header-details {
                    grid-template-columns: repeat(2, 1fr);
                    width: 100%;
                }

                .idp-monitoring-box {
                    flex-direction: column;
                    gap: 32px;
                }
            }

            @media (max-width: 768px) {
                .tab-item {
                    flex: 0 0 auto;
                    padding: 10px 24px;
                }
            }

            /* Custom Scrollbar & Logbook Table */
            .custom-scrollbar::-webkit-scrollbar {
                height: 8px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f8fafc;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #0d9488;
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #0f766e;
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                position: relative;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .pdc-log-table {
                width: 100%;
                border-collapse: collapse;
            }

            .pdc-log-table th {
                padding: 12px 16px;
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
                font-size: 0.8rem;
                text-align: center;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
                text-transform: capitalize;
            }

            .pdc-log-table th:last-child {
                border-right: none;
            }

            .pdc-log-table td {
                padding: 12px 16px;
                color: #334155;
                font-size: 0.88rem;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
            }

            .pdc-log-table td:last-child {
                border-right: none;
            }

            .pdc-log-table tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .pdc-log-table tr:hover td {
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
                border: none;
                background: transparent;
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

            /* --- Donut Container (IDP Monitoring) --- */
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
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title flex items-center mb-6">
        <div class="flex items-center gap-4">
            <div class="page-header-icon"
                style="background: #0f172a; color: white; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 14px; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd"
                        d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h1 class="page-header-title"
                    style="font-size: 1.6rem; font-weight: 800; color: #1e293b; line-height: 1.1;">Riwayat Progress
                    Talent</h1>
                <p class="page-header-sub"
                    style="font-size: 0.875rem; color: #64748b; margin-top: 4px; font-weight: 500;">Individual
                    Development Plan – Monitoring Talent</p>
            </div>
        </div>
    </div>

    <div class="detail-container">
        {{-- Header Info (Match Talent Dashboard) --}}
        <div class="mb-10" style="--hero-margin:0;">
            <style>
                .detail-container .talent-prof-hero {
                    margin: 0 !important;
                    border-radius: 20px;
                }
            </style>
            @include('components.talent.profile-card', ['user' => $talent, 'mobileCollapsible' => true])
        </div>

        {{-- Nav Tabs (match admin detail style) --}}
        <div class="nav-tabs-container">
            <div class="nav-tabs">
                <button type="button" class="tab-item active" data-section="kompetensi"
                    onclick="switchRiwayatSection('kompetensi', this)">Kompetensi</button>
                <button type="button" class="tab-item" data-section="idp"
                    onclick="switchRiwayatSection('idp', this)">IDP Monitoring</button>
                <button type="button" class="tab-item" data-section="project"
                    onclick="switchRiwayatSection('project', this)">Project Improvement</button>
            </div>
        </div>

        <div id="section-kompetensi" class="tab-section">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                        clip-rule="evenodd" />
                </svg>
                Kompetensi
            </div>

            {{-- TOP 3 GAP Kompetensi --}}
            <div class="sub-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                        clip-rule="evenodd" />
                </svg>
                TOP 3 GAP Kompetensi
            </div>

            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8 mt-4">
                @php
                    $details = optional($talent->assessmentSession)->details;
                    $gaps = collect();
                    if ($details && $details->sum('score_atasan') > 0) {
                        $overrides = $details
                            ->filter(function ($d) {
                                return str_starts_with($d->notes ?? '', 'priority_');
                            })
                            ->sortBy(function ($d) {
                                return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
                            });

                        if ($overrides->count() > 0) {
                            $gaps = $overrides->values();
                        } else {
                            $gaps = $details->sortBy('gap_score')->take(3)->values();
                        }
                    }
                @endphp

                @forelse($gaps as $index => $gap)
                    <div class="gap-item prio-{{ $index + 1 }}">
                        <div class="flex items-center">
                            <span class="gap-number">{{ $index + 1 }}</span>
                            {{ optional($gap->competence)->name ?? '-' }}
                        </div>
                        <span>{{ number_format($gap->gap_score, 1) }}</span>
                    </div>
                @empty
                    @foreach ([1, 2, 3] as $n)
                        <div class="gap-item" style="border-color: #cbd5e1; color: #cbd5e1;">
                            <div class="flex items-center">
                                <span class="gap-number" style="background: #cbd5e1;">{{ $n }}</span>
                                <span>–</span>
                            </div>
                            <span>–</span>
                        </div>
                    @endforeach
                @endforelse
            </div>

            {{-- Heatmap Kompetensi --}}
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
                        @foreach ($competencies as $comp)
                            @php
                                $detail = $details ? $details->firstWhere('competence_id', $comp->id) : null;
                                $standard = (float) ($standards[$comp->id] ?? 0);
                                $scoreTalent = (float) ($detail->score_talent ?? 0);
                                $scoreAtasan = (float) ($detail->score_atasan ?? 0);
                                $finalScore =
                                    $scoreAtasan > 0
                                        ? ($scoreTalent + $scoreAtasan) / 2
                                        : ($scoreTalent > 0
                                            ? $scoreTalent
                                            : 0);
                                $gap = $detail->gap_score ?? $finalScore - $standard;
                                $gapClass = $gap >= 0 ? 'gap-none' : ($gap <= -1.5 ? 'gap-large' : 'gap-small');
                            @endphp
                            <tr>
                                <td class="td-left">{{ $comp->name }}</td>
                                <td>{{ number_format($standard, 1) }}</td>
                                <td><span class="font-bold">{{ $scoreTalent ?: '-' }}</span></td>
                                <td><span class="font-bold">{{ $scoreAtasan ?: '-' }}</span></td>
                                <td><span
                                        class="font-bold">{{ $finalScore ? ($finalScore % 1 == 0 ? (int) $finalScore : number_format($finalScore, 1)) : '-' }}</span>
                                </td>
                                <td class="text-center p-2">
                                    <span
                                        class="gap-badge {{ $gapClass }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                </td>
                            </tr>
                        @endforeach
                        {{-- Average Row --}}
                        @php
                            $sess = $talent->assessmentSession;
                            $avgT = $sess ? $sess->details->avg('score_talent') ?? 0 : 0;
                            $avgA = $sess ? $sess->details->avg('score_atasan') ?? 0 : 0;
                            $avgGap = $sess ? $sess->details->avg('gap_score') ?? 0 : 0;
                            $avgStandard = $standards->avg() ?: 0;
                            $avgCls = $avgGap >= 0 ? 'gap-none' : ($avgGap <= -1.5 ? 'gap-large' : 'gap-small');
                        @endphp
                        <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                            <td class="td-left">Nilai Rata-Rata</td>
                            <td>{{ number_format($avgStandard, 1) }}</td>
                            <td>{{ number_format($avgT, 1) }}</td>
                            <td>{{ number_format($avgA, 1) }}</td>
                            <td>{{ number_format(($avgT + $avgA) / 2, 1) }}</td>
                            <td class="text-center p-2">
                                <span class="gap-badge {{ $avgCls }}">{{ number_format($avgGap, 1) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        {{-- IDP Monitoring --}}
        <div id="section-idp" class="tab-section" style="display: none;">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
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
                        $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
                        $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
                        $learningCount = $talent->idpActivities->where('type_idp', 3)->count();

                        $idpChartData = [
                            'Exposure' => [
                                'done' => min($exposureCount ?? 0, 6),
                                'total' => 6,
                                'from' => '#334155',
                                'to' => '#334155',
                                'id' => 'riwayat-grad-exposure',
                                'btn_color' =>
                                    'bg-slate-700 hover:bg-slate-800 shadow-[0_4px_14px_rgba(51,65,85,0.25)] hover:shadow-lg',
                            ],
                            'Mentoring' => [
                                'done' => min($mentoringCount ?? 0, 6),
                                'total' => 6,
                                'from' => '#f59e0b',
                                'to' => '#f59e0b',
                                'id' => 'riwayat-grad-mentoring',
                                'btn_color' =>
                                    'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_14px_rgba(245,158,11,0.28)] hover:shadow-lg',
                            ],
                            'Learning' => [
                                'done' => min($learningCount ?? 0, 6),
                                'total' => 6,
                                'from' => '#0d9488',
                                'to' => '#0d9488',
                                'id' => 'riwayat-grad-learning',
                                'btn_color' =>
                                    'bg-teal-600 hover:bg-teal-700 shadow-[0_4px_14px_rgba(13,148,136,0.28)] hover:shadow-lg',
                            ],
                        ];
                        $r = 38;
                        $circ = 2 * M_PI * $r;
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
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-2xl font-extrabold text-[#1e293b]">{{ round($pct * 100) }}%</span>
                                    <span class="text-xs font-bold text-gray-400">{{ $d['done'] }}/{{ $d['total'] }}</span>
                                </div>
                            </div>
                            <a href="{{ route('atasan.riwayat.logbook', ['talentId' => $talent->id, 'tab' => strtolower($label), 'session_id' => $sessionId]) }}"
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

        {{-- Project Improvement --}}
        <div id="section-project" class="tab-section" style="display: none;">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path
                        d="M19.5 6h-6.879a1.5 1.5 0 0 1-1.06-.44l-.622-.62A1.5 1.5 0 0 0 9.88 4.5H6A2.25 2.25 0 0 0 3.75 6.75v10.5A2.25 2.25 0 0 0 6 19.5h13.5a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 19.5 6Z" />
                </svg>
                Project Improvement
            </div>

            <div class="rounded-xl overflow-x-auto border border-gray-200 mt-4 custom-scrollbar">
                <table class="w-full min-w-[700px] text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-left">Judul Project
                                Improvement</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-48">File</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-48">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($talent->improvementProjects as $proj)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-left">
                                    {{ $proj->title }}
                                    <div class="text-xs text-gray-400 font-normal mt-0.5">
                                        {{ \Carbon\Carbon::parse($proj->created_at)->locale('id')->translatedFormat('d F Y') }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center w-48">
                                    @if ($proj->document_path)
                                        <a href="{{ route('files.preview', ['path' => $proj->document_path]) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all"
                                            title="Lihat/Download File Project">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center w-48">
                                    @php
                                        $projectStatus = $proj->status === 'Verified' ? 'Approved' : $proj->status;
                                    @endphp
                                    @if ($projectStatus === 'Approved')
                                        <span
                                            class="inline-flex items-center gap-1.5 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($projectStatus === 'Rejected')
                                        <span
                                            class="inline-flex items-center gap-1.5 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-12 px-6 text-center text-gray-400 text-xs" colspan="3">
                                    Belum ada project yang disubmit.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function switchRiwayatSection(section, trigger) {
            document.querySelectorAll('.tab-section').forEach((panel) => {
                panel.style.display = panel.id === `section-${section}` ? 'block' : 'none';
            });

            document.querySelectorAll('.tab-item').forEach((tab) => {
                tab.classList.toggle('active', tab === trigger);
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
    </script>
</x-atasan.layout>
