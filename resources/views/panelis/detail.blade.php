<x-panelis.layout title="Detail Talent Panelis – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Page Header ── */
            .page-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 24px;
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
            }

            .page-header-icon svg {
                width: 26px;
                height: 26px;
            }

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

            /* ── Scrollbar ── */
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

            /* ── Back button ── */
            .btn-back {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 9px 20px;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                background: white;
                color: #475569;
                font-weight: 600;
                font-size: 0.85rem;
                text-decoration: none;
                transition: all 0.2s;
                white-space: nowrap;
            }

            .btn-back:hover {
                background: #f8fafc;
                border-color: #94a3b8;
                color: #1e293b;
                transform: translateX(-2px);
            }





            /* ── Heatmap table ── */
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
            }

            .heatmap-table .td-left {
                text-align: left;
                font-weight: 600;
                color: #334155;
                white-space: nowrap;
            }

            .gap-badge {
                display: block;
                width: 100%;
                height: 100%;
                padding: 4px;
                border-radius: 4px;
                font-weight: 700;
                color: white;
            }

            .gap-none {
                background: #f1f5f9;
                color: #64748b;
            }

            .gap-positive {
                background: #3b82f6;
                color: white;
            }

            .gap-ok {
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

            .legend {
                display: flex;
                gap: 16px;
                font-size: 0.65rem;
                font-weight: 700;
                color: #64748b;
                margin-bottom: 12px;
                text-transform: uppercase;
                flex-wrap: wrap;
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

            /* ── TOP 3 GAP ── */
            .gap-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 16px;
                border-radius: 99px;
                margin-bottom: 10px;
                font-size: 0.875rem;
                font-weight: 600;
            }

            .gap-item.prio-1 {
                border: 1.5px solid #b91c1c;
                color: #991b1b;
                background: #fef2f2;
            }

            .gap-item.prio-2 {
                border: 1.5px solid #c2410c;
                color: #9a3412;
                background: #fff7ed;
            }

            .gap-item.prio-3 {
                border: 1.5px solid #1d4ed8;
                color: #1e40af;
                background: #eff6ff;
            }

            .gap-number {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.75rem;
                margin-right: 12px;
                font-weight: 800;
            }

            .gap-item.prio-1 .gap-number {
                background: #b91c1c;
            }

            .gap-item.prio-2 .gap-number {
                background: #c2410c;
            }

            .gap-item.prio-3 .gap-number {
                background: #1d4ed8;
            }

            .catatan-admin-box {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 12px 16px;
                margin-bottom: 16px;
                font-size: 0.82rem;
                color: #475569;
            }

            .catatan-admin-box span {
                font-weight: 700;
                color: #1e293b;
            }

            /* ── IDP Donut ── */
            .donut-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                padding: 28px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
                flex-wrap: wrap;
                gap: 24px;
            }

            /* ── Project Table (matched to admin pdc-custom-table) ── */
            .proj-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #d1d5db;
            }

            .proj-table th {
                background: #f1f5f9;
                padding: 12px 16px;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
                font-size: 0.8rem;
                font-weight: 700;
                color: #1e293b;
                text-align: center;
            }

            .proj-table th:last-child {
                border-right: none;
            }

            .proj-table td {
                padding: 12px 16px;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                font-size: 0.88rem;
                text-align: center;
                color: #334155;
                vertical-align: middle;
            }

            .proj-table td:last-child {
                border-right: none;
            }

            .proj-table tbody tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            /* ── Card Wrappers (matched to admin) ── */
            .section-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                margin-bottom: 24px;
                overflow: hidden;
            }

            .idp-card-container {
                background: #f8fafc;
                border-radius: 16px;
                padding: 24px;
                border: 1px solid #e2e8f0;
                margin-bottom: 24px;
            }

            .donut-container {
                background: white;
                border-radius: 16px;
                padding: 30px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                flex-wrap: wrap;
                gap: 24px;
            }

            /* ── LogBook summary ── */
            /* Using inline tailwind classes */

            /* ── Pill Nav Tabs ── */
            .pill-nav-wrapper {
                display: flex;
                align-items: center;
                width: 100%;
            }

            .pill-nav-tabs {
                display: flex;
                flex: 1;
                background: #e5e7eb;
                border-radius: 9999px;
                padding: 4px;
                gap: 0;
            }

            .pill-tab {
                flex: 1;
                text-align: center;
                padding: 8px 12px;
                border-radius: 9999px;
                font-size: 0.8rem;
                font-weight: 600;
                color: #6b7280;
                cursor: pointer;
                transition: all 0.2s;
                white-space: nowrap;
                background: transparent;
            }

            .pill-tab:hover {
                color: #1e293b;
                background: rgba(255, 255, 255, 0.5);
            }

            .pill-tab.active {
                background: #0f172a;
                color: white;
                font-weight: 700;
                box-shadow: 0 2px 8px rgba(15, 23, 42, 0.22);
            }

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .no-scrollbar {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }

            @media (max-width: 768px) {
                .donut-container {
                    flex-direction: column;
                }
            }

            /* --- PDC Admin Alignment --- */
            .section-title::before {
                display: none;
            }

            .section-title {
                gap: 14px;
                font-size: 1.25rem;
                margin-top: 24px;
                margin-bottom: 20px;
            }

            .section-title svg {
                width: 28px;
                height: 28px;
                color: #0f172a;
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

            .sub-section-title svg {
                width: 18px;
                height: 18px;
                color: #0f172a;
                flex-shrink: 0;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Detail Talent</div>
            <div class="page-header-sub">Informasi lengkap dan rekap perkembangan talent</div>
        </div>
    </div>

    {{-- Profile Card (Using Shared Component) --}}
    @include('components.talent.profile-card', ['user' => $talent, 'mobileCollapsible' => false])


    {{-- ====== NAV TABS (PC) ====== --}}
    <div class="pill-nav-wrapper mb-6 mt-8 hidden md:flex">
        <div class="pill-nav-tabs">
            <div class="pill-tab active pill-tab-kompetensi" onclick="setTab('kompetensi')">Kompetensi</div>
            <div class="pill-tab pill-tab-idp" onclick="setTab('idp')">IDP Monitoring</div>
            <div class="pill-tab pill-tab-project" onclick="setTab('project')">Project Improvement</div>
        </div>
    </div>

    {{-- ====== NAV TABS (MOBILE) ====== --}}
    <div class="pill-nav-wrapper mb-6 mt-6 flex md:hidden overflow-x-auto no-scrollbar">
        <div class="pill-nav-tabs" style="min-width: max-content; width: 100%;">
            <div class="pill-tab active pill-tab-kompetensi" onclick="setTab('kompetensi')">Kompetensi</div>
            <div class="pill-tab pill-tab-idp" onclick="setTab('idp')">IDP Monitoring</div>
            <div class="pill-tab pill-tab-project" onclick="setTab('project')">Project Improvement</div>
        </div>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                    clip-rule="evenodd" />
            </svg>
            Kompetensi
        </div>

        {{-- ====== TOP 3 GAP ====== --}}
        <div class="sub-section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                    clip-rule="evenodd" />
            </svg>
            TOP 3 GAP Kompetensi
        </div>

        @if ($talent->assessmentSession && $talent->assessmentSession->details->count())
            @php
                $firstDetail = $talent->assessmentSession->details->first();
                $noteText =
                    collect($talent->assessmentSession->details)
                        ->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))
                        ->map(fn($d) => explode('|', $d->notes)[1] ?? '')
                        ->filter()
                        ->first() ?? null;
            @endphp
            @if ($noteText)
                <div class="catatan-admin-box">
                    <span>Catatan dari Admin:</span> {{ $noteText }}
                </div>
            @endif
        @endif

        @forelse($gaps as $index => $gap)
            <div class="gap-item prio-{{ $index + 1 }}">
                <div class="flex items-center">
                    <span class="gap-number">{{ $index + 1 }}</span>
                    {{ optional($gap->competence)->name ?? '-' }}
                </div>
                <span>{{ number_format($gap->gap_score, 1) }}</span>
            </div>
        @empty
            @for ($i = 1; $i <= 3; $i++)
                <div class="gap-item" style="border:1px solid #e2e8f0;background:#f8fafc;color:#94a3b8;">
                    <div class="flex items-center">
                        <span class="gap-number" style="background:#cbd5e1;">{{ $i }}</span> -
                    </div>
                    <span>0</span>
                </div>
            @endfor
        @endforelse

        {{-- ====== HEATMAP KOMPETENSI ====== --}}
        <div class="sub-section-title mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                    clip-rule="evenodd" />
            </svg>
            Heatmap Kompetensi
        </div>

        {{-- ====== LEGEND (PC) ====== --}}
        <div class="hidden md:flex gap-4 text-[0.65rem] font-bold text-slate-500 mb-3 uppercase flex-wrap">
            <span>Keterangan GAP</span>
            <div class="legend-item">
                <div class="legend-box" style="background:#3b82f6;"></div> Di Atas Standar (> 0)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#f1f5f9;border:1px solid #e2e8f0;"></div> Sesuai Standar (0)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#f97316;"></div> Gap Kecil (-0.1 s/d -1.5)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#ef4444;"></div> Gap Besar (< -1.5)
            </div>
        </div>

        {{-- ====== LEGEND (MOBILE) ====== --}}
        <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-[0.65rem] font-bold text-slate-500 mb-4 uppercase md:hidden">
            <div class="flex items-center col-span-2 mb-1">
                <span>Keterangan GAP</span>
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#f1f5f9;border:1px solid #e2e8f0;"></div> Sesuai Standar (0)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#3b82f6;"></div> Di Atas Standar (> 0)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#ef4444;"></div> Gap Besar (< -1.5)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#f97316;"></div> Gap Kecil (-0.1 s/d -1.5)
            </div>
        </div>

            <div class="heatmap-container overflow-x-auto">
                <table class="heatmap-table">
                    <thead>
                        <tr>
                            <th class="th-main w-[380px]">Kompetensi</th>
                            <th class="th-main w-[80px]">Standar</th>
                            <th class="th-main">Skor Talent</th>
                            <th class="th-main">Skor Atasan</th>
                            <th class="th-main">Final Score</th>
                            <th class="th-main">GAP</th>
                        </tr>
                    </thead>
                    <tbody>
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

                                $cls = 'gap-none';
                                if ($gap > 0) {
                                    $cls = 'gap-positive';
                                } elseif ($gap < -1.5) {
                                    $cls = 'gap-large';
                                } elseif ($gap < 0) {
                                    $cls = 'gap-small';
                                }
                            @endphp
                            <tr>
                                <td class="td-left">{{ $comp->name }}</td>
                                <td>{{ number_format((float) $standard, 1) }}</td>
                                <td>{{ $sT ?: '-' }}</td>
                                <td>{{ $sA ?: '-' }}</td>
                                <td>{{ $final ?: '-' }}</td>
                                <td class="p-1"><span
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

                            $avgCls = 'gap-none';
                            if ($avgGap > 0) {
                                $avgCls = 'gap-positive';
                            } elseif ($avgGap < -1.5) {
                                $avgCls = 'gap-large';
                            } elseif ($avgGap < 0) {
                                $avgCls = 'gap-small';
                            }
                        @endphp
                        <tr class="font-bold bg-gray-50">
                            <td class="td-left">Nilai Rata-Rata</td>
                            <td>{{ number_format($standards->avg() ?: 0, 1) }}</td>
                            <td>{{ number_format($avgT, 1) }}</td>
                            <td>{{ number_format($avgA, 1) }}</td>
                            <td>{{ number_format(($avgT + $avgA) / 2, 1) }}</td>
                            <td class="p-1"><span
                                    class="font-bold text-[#334155]">{{ number_format($avgGap, 1) }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ================================= SECTION: IDP & LOGBOOK ================================= --}}
        <div id="section-idp" style="display: none;">
            {{-- ====== IDP MONITORING ====== --}}
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

            @php
                $idpChartData = [
                    'Exposure' => [
                        'done' => min($exposureCount ?? 0, 6),
                        'total' => 6,
                        'from' => '#334155',
                        'to' => '#334155',
                        'id' => 'grad-exposure',
                        'btn_color' => 'bg-slate-700 shadow-[0_4px_12px_-2px_rgba(51,65,85,0.4)] hover:shadow-lg',
                    ],
                    'Mentoring' => [
                        'done' => min($mentoringCount ?? 0, 6),
                        'total' => 6,
                        'from' => '#f59e0b',
                        'to' => '#f59e0b',
                        'id' => 'grad-mentoring',
                        'btn_color' => 'bg-amber-500 shadow-[0_4px_12px_-2px_rgba(245,158,11,0.4)] hover:shadow-lg',
                    ],
                    'Learning' => [
                        'done' => min($learningCount ?? 0, 6),
                        'total' => 6,
                        'from' => '#0d9488',
                        'to' => '#0d9488',
                        'id' => 'grad-learning',
                        'btn_color' => 'bg-teal-600 shadow-[0_4px_12px_-2px_rgba(13,148,136,0.4)] hover:shadow-lg',
                    ],
                ];
                $r = 38;
                $circ = 2 * M_PI * $r;
            @endphp
            <div class="idp-card-container">
                <div class="donut-container" style="box-shadow: none; padding: 24px;">
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
                                    <span
                                        class="text-2xl font-extrabold text-[#1e293b]">{{ round($pct * 100) }}%</span>
                                    <span
                                        class="text-xs font-bold text-gray-400">{{ $d['done'] }}/{{ $d['total'] }}</span>
                                </div>
                            </div>
                            <a href="{{ route('panelis.logbook', $talent->id) }}#{{ strtolower($label) }}"
                                class="{{ $d['btn_color'] }} text-white px-8 py-2 rounded-[10px] transition-all flex items-center justify-center gap-2 group active:scale-95 hover:-translate-y-0.5 cursor-pointer">
                                <span class="text-sm font-bold tracking-wide">{{ $label }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 relative transition-transform group-hover:translate-x-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ================================= SECTION: PROJECT ================================= --}}
    <div id="section-project" style="display: none;">
        {{-- ====== PROJECT IMPROVEMENT ====== --}}
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M19.5 6h-6.879a1.5 1.5 0 0 1-1.06-.44l-.622-.62A1.5 1.5 0 0 0 9.88 4.5H6A2.25 2.25 0 0 0 3.75 6.75v10.5A2.25 2.25 0 0 0 6 19.5h13.5a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 19.5 6Z" />
            </svg>
            Project Improvement
        </div>

        <div class="section-card bg-transparent !shadow-none !border-0 !p-0">
            {{-- PC View --}}
            <div class="hidden md:block rounded-xl overflow-hidden border border-gray-200 mt-4">
                <table class="w-full text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-left">Judul Project Improvement
                            </th>
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
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                </path>
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

            {{-- Mobile View --}}
            <div class="block md:hidden overflow-x-auto mt-4 rounded-xl border border-gray-200">
                <table class="w-full text-left bg-white" style="min-width: 480px;">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-[11px] font-bold text-slate-700 text-left">Judul Project Improvement
                            </th>
                            <th class="py-3 px-4 text-[11px] font-bold text-slate-700 text-center w-32">File</th>
                            <th class="py-3 px-4 text-[11px] font-bold text-slate-700 text-center w-32">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($talent->improvementProjects as $proj)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-3 px-4 font-bold text-[12px] text-slate-800 text-left">
                                    {{ $proj->title }}
                                    <div class="text-[10px] text-gray-400 font-normal mt-0.5">
                                        {{ \Carbon\Carbon::parse($proj->created_at)->locale('id')->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center w-32">
                                    @if ($proj->document_path)
                                        <a href="{{ route('files.preview', ['path' => $proj->document_path]) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-white border border-gray-200 rounded-lg text-[10px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all"
                                            title="Lihat/Download File Project">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                </path>
                                            </svg>
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-[10px] italic">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center w-32">
                                    @php
                                        $projectStatus = $proj->status === 'Verified' ? 'Approved' : $proj->status;
                                    @endphp
                                    @if ($projectStatus === 'Approved')
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[10px] font-bold bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($projectStatus === 'Rejected')
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[10px] font-bold bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[10px] font-bold bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-8 px-4 text-center text-gray-400 text-[11px]" colspan="3">
                                    Belum ada project yang disubmit.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>



    <x-slot name="scripts">
        <script>
            function setTab(tabId) {
                // Remove active class from all tabs
                document.querySelectorAll('.pill-tab').forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                document.querySelectorAll('.pill-tab-' + tabId).forEach(t => t.classList.add('active'));

                // Hide all sections
                document.getElementById('section-kompetensi').style.display = 'none';
                document.getElementById('section-idp').style.display = 'none';
                document.getElementById('section-project').style.display = 'none';

                // Show selected section
                if (tabId === 'idp') {
                    document.getElementById('section-idp').style.display = 'block';
                } else {
                    document.getElementById('section-' + tabId).style.display = 'block';
                }
            }
        </script>
    </x-slot>

</x-panelis.layout>
