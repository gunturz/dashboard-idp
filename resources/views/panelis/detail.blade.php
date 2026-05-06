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
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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
                font-size: 0.8rem;
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
                font-size: 0.65rem;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                background: #f1f5f9;
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


    {{-- ====== NAV TABS ====== --}}
    <div class="pill-nav-wrapper mb-6 mt-8">
        <div class="pill-nav-tabs">
            <div class="pill-tab active" id="pill-kompetensi" onclick="setTab('kompetensi')">Kompetensi</div>
            <div class="pill-tab" id="pill-idp" onclick="setTab('idp')">IDP Monitoring</div>
            <div class="pill-tab" id="pill-project" onclick="setTab('project')">Project Improvement</div>
        </div>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi">
        {{-- ====== TOP 3 GAP ====== --}}
        <div class="section-title">
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
        <div class="section-title mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                    clip-rule="evenodd" />
            </svg>
            Heatmap Kompetensi
        </div>

        <div class="legend">
            <span>Keterangan GAP</span>
            <div class="legend-item">
                <div class="legend-box" style="background:#f1f5f9;border:1px solid #e2e8f0;"></div> Sesuai Standar (0)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#f97316;"></div> Gap Kecil (-0.1 s/d -1.5)
            </div>
            <div class="legend-item">
                <div class="legend-box" style="background:#ef4444;"></div> Gap Besar (< -1.5)</div>
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

                                $cls = 'gap-ok';
                                if ($gap == 0) {
                                    $cls = 'gap-none';
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

                            $avgCls = 'gap-ok';
                            if ($avgGap == 0) {
                                $avgCls = 'gap-none';
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
                                    class="gap-badge {{ $avgCls }}">{{ number_format($avgGap, 1) }}</span></td>
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
                $charts = [
                    ['label' => 'Exposure', 'done' => min($exposureCount, 6), 'total' => 6, 'color' => '#334155'],
                    ['label' => 'Mentoring', 'done' => min($mentoringCount, 6), 'total' => 6, 'color' => '#f59e0b'],
                    ['label' => 'Learning', 'done' => min($learningCount, 6), 'total' => 6, 'color' => '#0d9488'],
                ];
                $r = 38;
                $circ = 2 * M_PI * $r;
            @endphp
            <div class="idp-card-container">
                <div class="donut-container">
                    @foreach ($charts as $chart)
                        @php
                            $pct = $chart['done'] / $chart['total'];
                            $filled = $pct * $circ;
                            $empty = $circ - $filled;
                        @endphp
                        <div class="flex flex-col items-center gap-3">
                            <div class="relative w-36 h-36">
                                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="#f1f5f9" stroke-width="10" />
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="{{ $chart['color'] }}" stroke-width="10" stroke-linecap="round"
                                        stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span
                                        class="text-2xl font-extrabold text-[#1e293b]">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                    <span class="text-xs font-bold text-gray-400">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <a href="{{ route('panelis.logbook', $talent->id) }}#{{ strtolower($chart['label']) }}"
                                class="flex items-center justify-center transition-colors hover:brightness-90 text-white px-5 py-2.5 rounded-xl shadow-md font-bold text-sm min-w-[130px]"
                                style="background-color: {{ $chart['color'] }};">
                                {{ $chart['label'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 max-w-full"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
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

        <div class="section-card">
            <table class="proj-table">
                <thead>
                    <tr>
                        <th class="w-1/2">Judul Project Improvement</th>
                        <th>File</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($talent->improvementProjects as $proj)
                        <tr>
                            <td class="text-left font-semibold">{{ $proj->title }}</td>
                            <td>
                                @if ($proj->document_path)
                                    <a href="{{ route('files.preview', ['path' => $proj->document_path]) }}"
                                        target="_blank"
                                        class="text-blue-500 underline text-xs font-bold uppercase">Lihat File</a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-2">
                                    <div
                                        class="w-2 h-2 rounded-full {{ $proj->status === 'Verified' ? 'bg-green-500' : 'bg-orange-400' }}">
                                    </div>
                                    <span
                                        class="font-semibold">{{ $proj->status === 'Verified' ? 'Approve' : ($proj->status ?: 'Pending') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-gray-400 py-8">Belum ada project improvement.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>



    <x-slot name="scripts">
        <script>
            function setTab(tabId) {
                // Remove active class from all tabs
                document.querySelectorAll('.pill-tab').forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                document.getElementById('pill-' + tabId).classList.add('active');

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
