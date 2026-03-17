<x-pdc_admin.layout title="Detail Progress Talent – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .btn-back {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 500;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s;
            }

            .btn-back:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            .nav-tabs {
                display: flex;
                gap: 12px;
            }

            .tab-item {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 600;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                cursor: pointer;
                transition: all 0.2s;
            }
            .tab-item:hover { background: #f1f5f9; }
            .tab-item.active {
                background: #f1f5f9;
                border-color: #94a3b8;
                color: #1e293b;
            }

            .section-title {
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-top: 40px;
                margin-bottom: 24px;
            }

            /* --- IDP DONUT CHARTS --- */
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
            }
            .donut-wrapper {
                position: relative;
                width: 160px;
                height: 160px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .donut-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }
            .donut-label-box {
                margin-top: 15px;
                padding: 4px 20px;
                border: 1px solid #e2e8f0;
                border-radius: 99px;
                font-size: 0.875rem;
                font-weight: 600;
                color: #475569;
            }

            /* --- TABLES --- */
            .pdc-custom-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e2e8f0;
            }
            .pdc-custom-table th {
                background: #f8fafc;
                padding: 12px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                font-weight: 800;
                color: #1e293b;
            }
            .pdc-custom-table td {
                padding: 12px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
            }

            .btn-status-action {
                padding: 6px 16px;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 700;
                transition: all 0.2s;
            }
            .btn-reject { border: 1.5px solid #ef4444; color: #ef4444; background: white; }
            .btn-approve { border: 1.5px solid #22c55e; color: #22c55e; background: white; }
            .btn-reject:hover { background: #ef4444; color: white; }
            .btn-approve:hover { background: #22c55e; color: white; }

            .btn-audit {
                background: #2e3746;
                color: white;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 700;
            }

            .filter-pills {
                display: flex;
                background: #e2e8f0;
                padding: 4px;
                border-radius: 12px;
                width: fit-content;
                margin-bottom: 20px;
            }
            .pill {
                padding: 8px 32px;
                border-radius: 10px;
                font-size: 0.875rem;
                font-weight: 700;
                color: #475569;
                cursor: pointer;
            }
            .pill.active {
                background: #2e3746;
                color: white;
            }

            /* --- HEATMAP & COMPETENCY --- */
            .talent-gap-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
                gap: 24px;
                margin-bottom: 48px;
            }
            .talent-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            .talent-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 20px;
            }
            .talent-info {
                display: flex;
                gap: 16px;
            }
            .talent-photo {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #f1f5f9;
            }
            .talent-meta h4 {
                font-size: 1.125rem;
                font-weight: 700;
                color: #1e293b;
            }
            .talent-meta p {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
            }
            .btn-pilih-gap {
                padding: 6px 12px;
                background: #2e3746;
                color: white;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: 6px;
            }
            .top-gap-label {
                text-align: right;
                font-size: 0.75rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 12px;
                display: block;
            }
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
            .gap-item:nth-child(1) { border: 1px solid #ef4444; color: #ef4444; background: #fef2f2; }
            .gap-item:nth-child(2) { border: 1px solid #f97316; color: #f97316; background: #fff7ed; }
            .gap-item:nth-child(3) { border: 1px solid #3b82f6; color: #3b82f6; background: #eff6ff; }
            .gap-number {
                width: 24px; height: 24px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                color: white; font-size: 0.75rem; margin-right: 12px;
            }
            .gap-item:nth-child(1) .gap-number { background: #ef4444; }
            .gap-item:nth-child(2) .gap-number { background: #f97316; }
            .gap-item:nth-child(3) .gap-number { background: #3b82f6; }

            .heatmap-container {
                background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;
            }
            .heatmap-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
            .heatmap-table th, .heatmap-table td { border: 1px solid #e2e8f0; padding: 8px 12px; text-align: center; }
            .heatmap-table .th-main { background: #f8fafc; font-weight: 700; color: #1e293b; }
            .heatmap-table .th-sub { font-size: 0.65rem; font-weight: 700; color: #475569; text-transform: uppercase; background: #f8fafc; }
            .heatmap-table .td-left { text-align: left; font-weight: 600; color: #334155; }
            .gap-badge { display: block; width: 100%; height: 100%; padding: 4px; border-radius: 4px; font-weight: 700; color: white; }
            .gap-none { background-color: #f1f5f9; color: #64748b; }
            .gap-ok { background-color: #cbd5e1; color: #1e293b; }
            .gap-small { background-color: #f97316; color: white; }
            .gap-large { background-color: #ef4444; color: white; }
            .legend { display: flex; gap: 16px; font-size: 0.65rem; font-weight: 700; color: #64748b; margin-bottom: 12px; text-transform: uppercase; }
            .legend-item { display: flex; align-items: center; gap: 4px; }
            .legend-box { width: 12px; height: 12px; border-radius: 2px; }

            .hidden { display: none !important; }
        </style>
    </x-slot>

    {{-- Header Navigation --}}
    <div class="flex justify-between items-center mb-10">
        <a href="{{ route('pdc_admin.dashboard') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
            </svg>
            <span class="text-[#2e3746]">Kembali</span>
        </a>

        <div class="nav-tabs">
            <div class="tab-item active" onclick="switchSection('kompetensi', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Kompetensi
            </div>
            <div class="tab-item" onclick="switchSection('idp', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
                IDP
            </div>
            <div class="tab-item" onclick="switchSection('project', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                </svg>
                Project Improvement
            </div>
            <div class="tab-item" onclick="switchSection('logbook', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                Logbook
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="text-center mb-12">
        <h2 class="text-2xl font-extrabold text-[#1e293b]">{{ $targetPosition->position_name }} - {{ $company->nama_company }}</h2>
        <p class="text-xs font-bold text-gray-400 mt-1 uppercase">{{ $talents->count() }} TALENT</p>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
            </svg>
            TOP 3 GAP Kompetensi
        </div>

        <div class="talent-gap-grid">
            @foreach ($talents as $talent)
                @php
                    $details = optional($talent->assessmentSession)->details;
                    $gaps = $details ? $details->sortBy('gap_score')->take(3) : collect();
                @endphp
                <div class="talent-card">
                    <div class="talent-header">
                        <div class="talent-info">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="talent-photo" alt="{{ $talent->nama }}">
                            <div class="talent-meta">
                                <h4>{{ $talent->nama }}</h4>
                                <p>{{ optional($talent->position)->position_name ?? 'Officer' }} - {{ optional($talent->department)->nama_department ?? '-' }}</p>
                            </div>
                        </div>
                        <button class="btn-pilih-gap">Pilih 3 GAP</button>
                    </div>

                    <div class="mb-4 text-xs font-bold text-gray-500">
                        <p>MENTOR : {{ strtoupper($talent->mentor->nama ?? '-') }}</p>
                        <p>ATASAN : {{ strtoupper($talent->atasan->nama ?? '-') }}</p>
                    </div>

                    <span class="top-gap-label">TOP 3 GAP</span>
                    @forelse($gaps as $index => $gap)
                        <div class="gap-item">
                            <div class="flex items-center">
                                <span class="gap-number">{{ $index + 1 }}</span>
                                {{ $gap->competence->name }}
                            </div>
                            <span>{{ number_format($gap->gap_score, 1) }}</span>
                        </div>
                    @empty
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="gap-item" style="border: 1px solid #e2e8f0; background: #f8fafc; color: #94a3b8;">
                                <div class="flex items-center">
                                    <span class="gap-number" style="background: #cbd5e1;">{{ $i }}</span>
                                    -
                                </div>
                                <span>0</span>
                            </div>
                        @endfor
                    @endforelse
                </div>
            @endforeach
        </div>

        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z" clip-rule="evenodd" />
            </svg>
            Heatmap Kompetensi
        </div>

        <div class="legend">
            <span>Keterangan GAP</span>
            <div class="legend-item"><div class="legend-box" style="background: #f1f5f9; border: 1px solid #e2e8f0;"></div> Sesuai Standar (0)</div>
            <div class="legend-item"><div class="legend-box" style="background: #f97316;"></div> Gap Kecil (-0.1 s/d -1.5)</div>
            <div class="legend-item"><div class="legend-box" style="background: #ef4444;"></div> Gap Besar (< -1.5)</div>
        </div>

        <div class="heatmap-container overflow-x-auto">
            <table class="heatmap-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="th-main w-[250px]">KOMPETENSI</th>
                        <th rowspan="2" class="th-main w-[80px]">STANDAR</th>
                        @foreach ($talents as $talent)
                            <th colspan="4" class="th-main">{{ strtoupper($talent->nama) }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($talents as $talent)
                            <th class="th-sub">Skor Talent</th>
                            <th class="th-sub">Skor Atasan</th>
                            <th class="th-sub">Final Score</th>
                            <th class="th-sub">GAP</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencies as $comp)
                        @php $standard = $standards[$comp->id] ?? 0; @endphp
                        <tr>
                            <td class="td-left">{{ $comp->name }}</td>
                            <td>{{ $standard }}</td>
                            @foreach ($talents as $talent)
                                @php
                                    $detail = $talent->assessmentSession ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id) : null;
                                    $scoreTalent = $detail->score_talent ?? 0;
                                    $scoreAtasan = $detail->score_atasan ?? 0;
                                    $gap = $detail->gap_score ?? 0;
                                    $finalScore = $scoreTalent > 0 && $scoreAtasan > 0 ? ($scoreTalent + $scoreAtasan) / 2 : ($scoreTalent ?: ($scoreAtasan ?: 0));
                                    $cls = 'gap-ok';
                                    if ($gap == 0) $cls = 'gap-none';
                                    elseif ($gap < -1.5) $cls = 'gap-large';
                                    elseif ($gap < 0) $cls = 'gap-small';
                                @endphp
                                <td>{{ $scoreTalent ?: '-' }}</td>
                                <td>{{ $scoreAtasan ?: '-' }}</td>
                                <td>{{ $finalScore ?: '-' }}</td>
                                <td class="p-1"><span class="gap-badge {{ $cls }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span></td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================================= SECTION: IDP ================================= --}}
    <div id="section-idp" class="hidden">
        @foreach ($talents as $talent)
            <div class="idp-card-container">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                    <div>
                        <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                        <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                    </div>
                </div>

                <div class="donut-container">
                    @php
                        $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
                        $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
                        $learningCount = $talent->idpActivities->where('type_idp', 3)->count();
                        
                        $charts = [
                            ['label' => 'Exposure', 'done' => min($exposureCount, 6), 'total' => 6, 'color' => '#334155'],
                            ['label' => 'Mentoring', 'done' => min($mentoringCount, 6), 'total' => 6, 'color' => '#f59e0b'],
                            ['label' => 'Learning', 'done' => min($learningCount, 6), 'total' => 6, 'color' => '#0d9488']
                        ];
                        $r = 70; $circ = 2 * M_PI * $r;
                    @endphp

                    @foreach($charts as $chart)
                        @php $pct = $chart['done'] / $chart['total']; $filled = $pct * $circ; $empty = $circ - $filled; @endphp
                        <div class="donut-wrapper">
                            <svg viewBox="0 0 160 160" class="w-full h-full -rotate-90">
                                <circle cx="80" cy="80" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="20" />
                                <circle cx="80" cy="80" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}" stroke-width="20" stroke-linecap="round" stroke-dasharray="{{ $filled }} {{ $empty }}" />
                            </svg>
                            <div class="donut-text">
                                <span class="text-3xl font-extrabold" style="color: #1e293b">{{ $chart['done'] }}/{{ $chart['total'] }}</span><br>
                                <span class="text-sm font-bold text-gray-400">{{ round($pct * 100) }}%</span>
                            </div>
                            <div class="donut-label-box">{{ $chart['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================================= SECTION: PROJECT IMPROVEMENT ================================= --}}
    <div id="section-project" class="hidden">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
            </svg>
            Project Improvement
        </div>

        @foreach ($talents as $talent)
            <div class="bg-white border text-center border-gray-200 rounded-2xl p-6 mb-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-4 text-left">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                        <div>
                            <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                            <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                        </div>
                    </div>
                    <button class="btn-audit">Validasi Finance</button>
                </div>

                <table class="pdc-custom-table">
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
                                <td class="font-bold">{{ $proj->title }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $proj->document_path) }}" class="text-blue-500 underline uppercase font-bold text-xs" target="_blank">Lihat File</a>
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $proj->status === 'Verified' ? 'bg-green-500' : 'bg-orange-500' }}"></div>
                                        <span class="font-bold">{{ $proj->status === 'Verified' ? 'Approve' : ($proj->status ?: 'Pending') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-gray-400 py-8">Belum ada project improvement yang diunggah.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-end gap-3 mt-4">
                    <button class="btn-status-action btn-reject">Rejected</button>
                    <button class="btn-status-action btn-approve">Approved</button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================================= SECTION: LOGBOOK ================================= --}}
    <div id="section-logbook" class="hidden">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            LogBook
        </div>

        <div class="filter-pills">
            <div class="pill active" onclick="filterLog(1, this)">Exposure</div>
            <div class="pill" onclick="filterLog(2, this)">Mentoring</div>
            <div class="pill" onclick="filterLog(3, this)">Learning</div>
        </div>

        @foreach ($talents as $talent)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-8 shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                    <div>
                        <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                        <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                    </div>
                </div>

                <table class="pdc-custom-table log-table" data-talent="{{ $talent->id }}">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($talent->idpActivities as $act)
                            <tr class="log-row type-{{ $act->type_idp }} {{ $act->type_idp != 1 ? 'hidden' : '' }}">
                                <td>{{ $talent->mentor->nama ?? '-' }}</td>
                                <td class="font-bold">{{ $act->theme }}</td>
                                <td>{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                <td>{{ $act->location }}</td>
                                <td>{{ $act->activity }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-gray-400 py-8">Belum ada aktivitas tercatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <script>
        function switchSection(targetId, el) {
            // Hide all sections
            document.getElementById('section-kompetensi').classList.add('hidden');
            document.getElementById('section-idp').classList.add('hidden');
            document.getElementById('section-project').classList.add('hidden');
            document.getElementById('section-logbook').classList.add('hidden');

            // Show target section
            document.getElementById('section-' + targetId).classList.remove('hidden');

            // Update active tab
            document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
            el.classList.add('active');
        }

        function filterLog(typeId, el) {
            // Update active pill
            document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');

            // Filter rows
            document.querySelectorAll('.log-row').forEach(row => {
                if (row.classList.contains('type-' + typeId)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }
    </script>
</x-pdc_admin.layout>
