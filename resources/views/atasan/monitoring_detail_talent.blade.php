<x-atasan.layout title="Monitoring Detail – Individual Development Plan" :user="$user">
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
                max-width: 1200px;
                margin: 0 auto;
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
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* --- Top 3 GAP --- */
            .gap-pills-container {
                display: flex;
                flex-direction: column;
                gap: 16px;
                margin-bottom: 32px;
            }

            .gap-pill {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 24px;
                border-radius: 99px;
                border: 1.5px solid #e2e8f0;
                background: white;
                position: relative;
            }

            .gap-pill.prio-1 {
                border-color: #ef4444;
            }

            .gap-pill.prio-2 {
                border-color: #f97316;
            }

            .gap-pill.prio-3 {
                border-color: #3b82f6;
            }

            .gap-pill-left {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .gap-rank {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.813rem;
                font-weight: 800;
            }

            .prio-1 .gap-rank {
                background: #ef4444;
            }

            .prio-2 .gap-rank {
                background: #f97316;
            }

            .prio-3 .gap-rank {
                background: #3b82f6;
            }

            .gap-name {
                font-size: 1rem;
                font-weight: 700;
                color: #1e293b;
            }

            .gap-score {
                font-size: 1.125rem;
                font-weight: 800;
                color: #475569;
            }

            /* --- Heatmap Table --- */
            .heatmap-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
            }

            .heatmap-table th {
                background: #f8fafc;
                padding: 12px;
                font-size: 0.75rem;
                font-weight: 800;
                color: #475569;
                text-transform: uppercase;
                border-bottom: 1.5px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                text-align: center;
            }

            .heatmap-table td {
                padding: 12px;
                font-size: 0.813rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                text-align: center;
            }

            .heatmap-table td:first-child {
                text-align: left;
                font-weight: 600;
                padding-left: 20px;
            }

            .gap-badge {
                display: block;
                padding: 6px;
                border-radius: 4px;
                font-weight: 800;
                color: white;
                min-width: 40px;
            }

            .gap-red {
                background: #ef4444;
            }

            .gap-orange {
                background: #f97316;
            }

            .gap-none {
                background: transparent;
                color: #334155;
            }

            .row-summary td {
                background: #f8fafc;
                font-weight: 800;
                border-top: 1.5px solid #e2e8f0;
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
                border-collapse: separate;
                border-spacing: 0;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
            }

            .project-table th {
                background: #f8fafc;
                padding: 16px;
                font-size: 0.813rem;
                font-weight: 800;
                color: #1e293b;
                text-align: center;
                border-bottom: 1.5px solid #e2e8f0;
            }

            .project-table td {
                padding: 16px;
                font-size: 0.875rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                text-align: center;
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
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <div class="flex items-center gap-3">
                <h1 class="page-header-title">Detail Progres Talent</h1>
                <span
                    class="px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-600 text-[10px] font-bold uppercase tracking-wider border border-teal-100">Monitoring
                    Mode</span>
            </div>
            <p class="page-header-sub">Pantau detail capaian kompetensi dan progres IDP individu secara real-time</p>
        </div>
    </div>

    <div class="detail-container">
        {{-- Header Info (Match Talent Dashboard) --}}
        <div class="mb-10 overflow-hidden rounded-2xl shadow-sm border border-gray-100">
            @include('components.talent.profile-card', ['user' => $talent, 'mobileCollapsible' => false])
        </div>

        {{-- TOP 3 GAP Kompetensi --}}
        <div class="prem-card mb-8 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="prem-card-header">
                <div class="prem-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                            clip-rule="evenodd" />
                    </svg>
                    TOP 3 GAP Kompetensi
                </div>
            </div>
            <div class="p-6">
                @php
                    $details = optional($talent->assessmentSession)->details;
                    $gaps = collect();
                    if ($details && $details->sum('score_atasan') > 0) {
                        // Check for manual overrides first (notes starting with priority_)
                        $overrides = $details->filter(function ($d) {
                            return str_starts_with($d->notes ?? '', 'priority_');
                        })->sortBy(function ($d) {
                            return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
                        });

                        if ($overrides->count() > 0) {
                            $gaps = $overrides->values();
                        } else {
                            $gaps = $details->sortBy('gap_score')->take(3)->values();
                        }
                    }
                @endphp

                <div class="gap-pills-container">
                    @forelse($gaps as $index => $gap)
                        <div class="gap-pill prio-{{ $index + 1 }}">
                            <div class="gap-pill-left">
                                <span class="gap-rank">{{ $index + 1 }}</span>
                                <span class="gap-name">{{ $gap->competence->name }}</span>
                            </div>
                            <span class="gap-score">{{ number_format($gap->gap_score, 1) }}</span>
                        </div>
                    @empty
                        <div
                            class="py-10 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-100 text-gray-400">
                            <p class="font-medium italic">Belum ada data GAP prioritas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Heatmap Kompetensi --}}
        <div class="prem-card mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="prem-card-header">
                <div class="prem-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                            clip-rule="evenodd" />
                    </svg>
                    Heatmap Kompetensi
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="heatmap-table">
                        <thead>
                            <tr>
                                <th class="w-[30%]">kompetensi</th>
                                <th>standar</th>
                                <th>Skor Talent</th>
                                <th>Skor Atasan</th>
                                <th>Final Score</th>
                                <th>GAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($competencies as $comp)
                                @php
                                    $detail = $details ? $details->firstWhere('competence_id', $comp->id) : null;
                                    $standard = (float) ($standards[$comp->id] ?? 0);
                                    $scoreTalent = (float) ($detail->score_talent ?? 0);
                                    $scoreAtasan = (float) ($detail->score_atasan ?? 0);
                                    $finalScore = ($scoreTalent + $scoreAtasan) / 2;
                                    $gap = $finalScore - $standard;

                                    $gapClass = 'gap-none';
                                    if ($gap <= -2)
                                        $gapClass = 'gap-red';
                                    elseif ($gap < 0)
                                        $gapClass = 'gap-orange';
                                @endphp
                                <tr>
                                    <td>{{ $comp->name }}</td>
                                    <td>{{ $standard % 1 == 0 ? (int) $standard : number_format($standard, 1) }}</td>
                                    <td>{{ $scoreTalent % 1 == 0 ? (int) $scoreTalent : number_format($scoreTalent, 1) }}
                                    </td>
                                    <td>{{ $scoreAtasan ?: '0' }}</td>
                                    <td>{{ $finalScore % 1 == 0 ? (int) $finalScore : number_format($finalScore, 1) }}</td>
                                    <td><span
                                            class="gap-badge {{ $gapClass }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @php
                            $avgStandard = $standards->avg() ?: 0;
                            $avgTalent = $details ? $details->avg('score_talent') : 0;
                            $avgAtasan = $details ? $details->avg('score_atasan') : 0;
                            $avgFinal = ($avgTalent + $avgAtasan) / 2;
                            $avgGap = $avgFinal - $avgStandard;

                            $avgGapClass = 'gap-none';
                            if ($avgGap <= -2)
                                $avgGapClass = 'gap-red';
                            elseif ($avgGap < 0)
                                $avgGapClass = 'gap-orange';
                        @endphp
                        <tfoot>
                            <tr class="row-summary">
                                <td>Nilai Rata-Rata</td>
                                <td>{{ number_format($avgStandard, 1) }}</td>
                                <td>{{ number_format($avgTalent, 1) }}</td>
                                <td>{{ number_format($avgAtasan, 1) }}</td>
                                <td>{{ number_format($avgFinal, 1) }}</td>
                                <td><span class="gap-badge {{ $avgGapClass }}">{{ number_format($avgGap, 2) }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- IDP Monitoring --}}
                <div class="prem-card mb-8 animate-fade-in" style="animation-delay: 0.3s;">
                    <div class="prem-card-header">
                        <div class="prem-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z"
                                    clip-rule="evenodd" />
                            </svg>
                            IDP Monitoring
                        </div>
                    </div>
                    <div class="p-8">
                        @php
                            $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
                            $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
                            $learningCount = $talent->idpActivities->where('type_idp', 3)->count();

                            $charts = [
                                ['label' => 'Exposure', 'done' => min($exposureCount, 6), 'total' => 6, 'color' => '#0f172a'],
                                ['label' => 'Mentoring', 'done' => min($mentoringCount, 6), 'total' => 6, 'color' => '#f59e0b'],
                                ['label' => 'Learning', 'done' => min($learningCount, 6), 'total' => 6, 'color' => '#0d9488']
                            ];
                            $r = 38;
                            $circ = 2 * M_PI * $r;
                        @endphp

                        <div class="flex flex-col md:flex-row justify-around items-center gap-10">
                            @foreach($charts as $chart)
                                @php
                                    $pct = $chart['done'] / $chart['total'];
                                    $filled = $pct * $circ;
                                    $empty = $circ - $filled;
                                @endphp
                                <div class="flex flex-col items-center gap-5">
                                    <div class="relative w-36 h-36">
                                        <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                            <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#f1f5f9"
                                                stroke-width="10" />
                                            <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}"
                                                stroke-width="10" stroke-linecap="round"
                                                stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" />
                                        </svg>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                                            <span
                                                class="text-2xl font-black text-[#1e293b] leading-none">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                            <span
                                                class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ round($pct * 100) }}%</span>
                                        </div>
                                    </div>
                                    <span
                                        class="px-5 py-1.5 bg-gray-50 border border-gray-100 rounded-full text-xs font-bold text-[#475569] shadow-sm">{{ $chart['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Project Improvement --}}
                <div class="prem-card mb-8 animate-fade-in" style="animation-delay: 0.4s;">
                    <div class="prem-card-header">
                        <div class="project-section-title">
                            <span class="project-section-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19.5 6h-6.879a1.5 1.5 0 0 1-1.06-.44l-.622-.62A1.5 1.5 0 0 0 9.88 4.5H6A2.25 2.25 0 0 0 3.75 6.75v10.5A2.25 2.25 0 0 0 6 19.5h13.5a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 19.5 6Z" />
                                </svg>
                            </span>
                            <span>Project Improvement</span>
                        </div>
                    </div>
                    <div class="p-0">
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="highlight-table project-improvement-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Judul Project Improvement</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($talent->improvementProjects as $proj)
                                        <tr>
                                            <td class="project-title-cell">{{ $proj->title }}</td>
                                            <td class="project-action-cell">
                                                <a href="{{ asset('storage/' . $proj->document_path) }}"
                                                    class="project-file-link font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                                    target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    Lihat File
                                                </a>
                                            </td>
                                            <td class="project-status-cell">
                                                @if($proj->status === 'Verified')
                                                    <span
                                                        class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 text-orange-600 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                                        {{ $proj->status ?: 'Pending' }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-12 text-center text-gray-400 font-medium italic">Belum
                                                ada project improvement yang diupload.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- LogBook --}}
                <div class="prem-card mb-12 animate-fade-in" style="animation-delay: 0.5s;">
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 border border-teal-100 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-[#1e293b] mb-1">Rekap Aktivitas LogBook</h4>
                                    <p class="text-sm text-gray-500 leading-relaxed md:max-w-md">Pantau progress
                                        Exposure, Mentoring, dan Learning secara lengkap melalui dashboard logbook
                                        terintegrasi.</p>
                                </div>
                            </div>
                            <a href="{{ route('atasan.monitoring.logbook', $talent->id) }}"
                                class="btn-prem btn-teal px-8 py-3 rounded-xl shadow-md whitespace-nowrap">
                                Lihat Detail Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <div class="h-8"></div>
            </div>
</x-atasan.layout>