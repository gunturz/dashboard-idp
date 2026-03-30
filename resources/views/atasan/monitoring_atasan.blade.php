<x-atasan.layout title="Monitoring – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 5px; height: 5px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

            .custom-scrollbar::-webkit-scrollbar { height: 8px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #0d9488; border-radius: 10px; border: 2px solid #f8fafc; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #0f766e; }

            body { background-color: #f8fafc !important; }

            /* Match Logbook Main Container Width */
            .max-w-monitor { max-width: 72rem !important; margin-left: auto; margin-right: auto; }
            @media (min-width: 1280px) { .max-w-monitor { max-width: 80rem !important; } }
            @media (min-width: 1536px) { .max-w-monitor { max-width: 72rem !important; } }
            /* Force 6xl for precise alignment with Logbook */
            .logbook-width { max-width: 72rem !important; }

            .log-table-container {
                background: white; border-radius: 12px; border: 1px solid #e2e8f0;
                overflow: hidden; position: relative; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .pdc-log-table { width: 100%; border-collapse: collapse; }
            .pdc-log-table th {
                padding: 16px 20px; background: #f8fafc; font-weight: 700; color: #3d4f62;
                font-size: 0.85rem; text-align: center; white-space: nowrap;
                border-bottom: 1px solid #f1f5f9;
            }
            .pdc-log-table td {
                padding: 16px 20px; color: #475569; font-size: 0.825rem; border-top: 1px solid #f1f5f9;
            }
            .pdc-log-table tr:hover { background: #fafafa; }

            .nav-tabs { display: flex; gap: 12px; }
            .tab-item {
                padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: white;
                color: #475569; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center;
                gap: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); cursor: pointer; transition: all 0.2s;
            }
            .tab-item:hover { background: #f1f5f9; }
            .tab-item.active { background: #f1f5f9; border-color: #94a3b8; color: #1e293b; }

            .section-badge {
                display: inline-block; padding: 6px 24px; border-radius: 9999px;
                background: #2e3746; color: white; font-weight: 600;
                font-size: 0.875rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                margin-bottom: 1.5rem;
            }

            .talent-profile-card {
                background: white; border-radius: 1rem; padding: 2.5rem;
                border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
                margin-bottom: 3.5rem;
            }

            .talent-profile-header {
                display: flex; align-items: center; gap: 1.25rem; margin-bottom: 2.5rem;
            }
            .talent-profile-photo {
                width: 72px; height: 72px; border-radius: 9999px;
                object-fit: cover; border: 2px solid #f8fafc; shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }
            .talent-profile-name {
                font-size: 1.375rem; font-weight: 800; color: #1e293b; line-height: 1.25;
            }
            .talent-profile-meta {
                font-size: 0.875rem; color: #64748b; font-weight: 500;
            }

            /* IDP Donut Charts */
            .donut-container {
                background: white; border-radius: 16px; padding: 0px;
                display: flex; justify-content: space-around; align-items: center;
                gap: 2rem;
            }

            /* Tables */
            .pdc-custom-table {
                width: 100%; border-collapse: collapse; background: white;
                border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;
            }
            .pdc-custom-table th {
                background: #f8fafc; padding: 12px 16px; border: 1px solid #e2e8f0;
                font-size: 0.85rem; font-weight: 700; color: #1e293b; text-align: center;
            }
            .pdc-custom-table td {
                padding: 12px 16px; border: 1px solid #e2e8f0; font-size: 0.85rem; color: #4b5563;
            }

            .btn-status-action {
                padding: 6px 16px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; transition: all 0.2s;
            }
            .btn-reject { border: 1.5px solid #ef4444; color: #ef4444; background: white; }
            .btn-approve { border: 1.5px solid #22c55e; color: #22c55e; background: white; }
            .btn-reject:hover { background: #ef4444; color: white; }
            .btn-approve:hover { background: #22c55e; color: white; }

            .filter-pills {
                display: flex; background: #e2e8f0; padding: 4px; border-radius: 9999px;
                width: fit-content; margin-bottom: 20px;
            }
            .pill {
                padding: 8px 32px; border-radius: 9999px; font-size: 0.875rem; font-weight: 700;
                color: #475569; cursor: pointer; transition: all 0.2s;
            }
            .pill:hover { background: #cbd5e1; color: #1e293b; }
            .pill.active {
                background: #2e3746; color: white; box-shadow: 0 2px 12px rgba(46,55,70,0.22);
            }

            /* Heatmap */
            .talent-gap-grid {
                display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
                gap: 24px; margin-bottom: 48px;
            }
            .talent-card {
                background: white; border: 1px solid #e2e8f0; border-radius: 16px;
                padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            .talent-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
            .talent-info { display: flex; gap: 16px; }
            .talent-photo { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #f1f5f9; }
            .talent-meta h4 { font-size: 1.125rem; font-weight: 700; color: #1e293b; }
            .talent-meta p { font-size: 0.75rem; color: #64748b; font-style: italic; }

            .top-gap-label {
                text-align: right; font-size: 0.75rem; font-weight: 800; color: #1e293b;
                margin-bottom: 12px; display: block;
            }
            .gap-item {
                display: flex; justify-content: space-between; align-items: center;
                padding: 10px 16px; border-radius: 99px; margin-bottom: 10px;
                font-size: 0.875rem; font-weight: 600;
            }
            .gap-item.prio-1 { border: 1.5px solid #b91c1c; color: #991b1b; background: #fef2f2; }
            .gap-item.prio-2 { border: 1.5px solid #c2410c; color: #9a3412; background: #fff7ed; }
            .gap-item.prio-3 { border: 1.5px solid #1d4ed8; color: #1e40af; background: #eff6ff; }
            .gap-number {
                width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center;
                justify-content: center; color: white; font-size: 0.75rem; margin-right: 12px; font-weight: 800;
            }
            .gap-item.prio-1 .gap-number { background: #b91c1c; }
            .gap-item.prio-2 .gap-number { background: #c2410c; }
            .gap-item.prio-3 .gap-number { background: #1d4ed8; }

            .heatmap-container { background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
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


            /* ══ MOBILE ONLY — does NOT affect desktop ══ */
            @media (max-width: 767px) {
                .nav-tabs {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                    padding-bottom: 4px;
                }
                .tab-item {
                    padding: 6px 12px;
                    font-size: 0.75rem;
                    gap: 4px;
                    white-space: nowrap;
                    flex-shrink: 0;
                }
                .tab-item svg {
                    width: 18px;
                    height: 18px;
                }
                .filter-pills {
                    padding: 3px;
                }
                .pill {
                    padding: 6px 20px;
                    font-size: 0.78rem;
                }
                .talent-profile-card {
                    padding: 1.25rem !important;
                    margin-bottom: 2.5rem !important;
                    border-radius: 1.25rem !important;
                }
                .talent-profile-header {
                    margin-bottom: 1.5rem !important;
                    gap: 1rem !important;
                }
                .talent-profile-photo {
                    width: 56px !important;
                    height: 56px !important;
                }
                .talent-profile-name {
                    font-size: 1.125rem !important;
                }
                .talent-profile-meta {
                    font-size: 0.75rem !important;
                }
                .section-badge {
                    padding: 5px 20px !important;
                    font-size: 0.75rem !important;
                    margin-bottom: 1.25rem !important;
                }
                .donut-container {
                    flex-direction: column !important;
                    gap: 2.5rem !important;
                }
                .grid {
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 2rem !important;
                }
                .lg\:col-span-5, .lg\:col-span-12, .lg\:col-span-7 {
                    width: 100% !important;
                }
                .pdc-log-table th {
                    padding: 10px 12px;
                    font-size: 0.75rem;
                }
                .pdc-log-table td {
                    padding: 12px;
                    font-size: 0.75rem;
                }
                .pdc-custom-table th, .pdc-custom-table td {
                    padding: 8px 10px;
                    font-size: 0.75rem;
                }
            }
        </style>
    </x-slot>

    <div class="logbook-width mx-auto px-4 lg:px-0">
        {{-- Tab Navigation --}}
    <div class="flex justify-between items-center mb-10">
        <div></div>
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
        <h2 class="text-2xl font-extrabold text-[#1e293b]">Monitoring Talent</h2>
        <p class="text-xs font-bold text-gray-400 mt-1 uppercase">{{ $talents->count() }} TALENT</p>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi">
        @foreach ($talents as $talent)
            @php
                $details = optional($talent->assessmentSession)->details;
                $hasAtasanScored = $details && $details->sum('score_atasan') > 0;
                $gaps = collect();
                
                if ($details && $hasAtasanScored) {
                    $overrides = $details->filter(function($d) {
                        return str_starts_with($d->notes ?? '', 'priority_');
                    })->sortBy(function($d) {
                        return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
                    });
                    if ($overrides->count() > 0) {
                        $gaps = $overrides->values();
                    } else {
                        $gaps = $details->sortBy('gap_score')->take(3)->values();
                    }
                }
            @endphp

            <div class="talent-profile-card">
                {{-- Profile Header --}}
                <div class="talent-profile-header">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" 
                         class="talent-profile-photo" alt="{{ $talent->nama }}">
                    <div>
                        <h4 class="talent-profile-name">{{ $talent->nama }}</h4>
                        <p class="talent-profile-meta">
                            {{ optional($talent->position)->position_name ?? 'Officer' }} | 
                            <span class="italic text-gray-400 font-normal">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    {{-- TOP 3 GAP --}}
                    <div class="lg:col-span-5">
                        <div class="section-badge">TOP 3 GAP Kompetensi</div>
                        
                        <div class="space-y-3">
                            @forelse($gaps as $index => $gap)
                                <div class="gap-item prio-{{ $index + 1 }}">
                                    <div class="flex items-center">
                                        <span class="gap-number">{{ $index + 1 }}</span>
                                        {{ $gap->competence->name }}
                                    </div>
                                    <span class="font-bold text-lg">{{ number_format($gap->gap_score, 1) }}</span>
                                </div>
                            @empty
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="gap-item" style="border: 1px solid #e2e8f0; background: #ffffff; color: #94a3b8;">
                                        <div class="flex items-center">
                                            <span class="gap-number" style="background: #cbd5e1; color: white;">{{ $i }}</span>
                                            Belum dinilai Atasan
                                        </div>
                                        <span>-</span>
                                    </div>
                                @endfor
                            @endforelse
                        </div>

                        <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                             <div class="text-[11px] font-bold text-gray-400 uppercase mb-2 tracking-wider">Stakeholders</div>
                             <div class="space-y-1 text-xs">
                                 <p class="flex justify-between text-gray-600"><span class="font-medium">Mentor:</span> 
                                    @php
                                        $mIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                                        if (!empty($mIds)) {
                                            $mNames = \App\Models\User::whereIn('id', $mIds)->pluck('nama')->toArray();
                                            echo strtoupper(implode(', ', $mNames)) ?: '-';
                                        } else {
                                            echo strtoupper($talent->mentor->nama ?? '-');
                                        }
                                    @endphp
                                 </p>
                                 <p class="flex justify-between text-gray-600"><span class="font-medium">Atasan:</span> <span>{{ strtoupper($user->nama ?? '-') }}</span></p>
                             </div>
                        </div>
                    </div>

                    {{-- Heatmap / Competency Scores Individual --}}
                    <div class="lg:col-span-7">
                        <div class="section-badge">Tabel Skor Kompetensi</div>
                        
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table min-w-[500px]">
                                <thead>
                                    <tr>
                                        <th class="text-left">Kompetensi</th>
                                        <th class="w-20">Standar</th>
                                        <th class="w-16">Talent</th>
                                        <th class="w-16">Atasan</th>
                                        <th class="w-20">GAP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($competencies as $comp)
                                        @php 
                                            $standard = $standards[$comp->id] ?? 0;
                                            $detail = $talent->assessmentSession ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id) : null;
                                            $scoreTalent = $detail->score_talent ?? 0;
                                            $scoreAtasan = $detail->score_atasan ?? 0;
                                            $gap = $detail->gap_score ?? 0;
                                            
                                            $cls = 'gap-ok';
                                            if ($gap == 0) $cls = 'gap-none';
                                            elseif ($gap < -1.5) $cls = 'gap-large';
                                            elseif ($gap < 0) $cls = 'gap-small';
                                        @endphp
                                        <tr>
                                            <td class="font-semibold text-slate-700">{{ $comp->name }}</td>
                                            <td class="text-center font-bold">{{ $standard }}</td>
                                            <td class="text-center">{{ $scoreTalent ?: '-' }}</td>
                                            <td class="text-center">{{ $scoreAtasan ?: '-' }}</td>
                                            <td class="p-2">
                                                <span class="gap-badge {{ $cls }} text-[10px] py-1">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================================= SECTION: IDP ================================= --}}
    <div id="section-idp" class="hidden">
        @foreach ($talents as $talent)
            <div class="talent-profile-card">
                {{-- Profile Header --}}
                <div class="talent-profile-header">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" 
                         class="talent-profile-photo" alt="{{ $talent->nama }}">
                    <div>
                        <h4 class="talent-profile-name">{{ $talent->nama }}</h4>
                        <p class="talent-profile-meta">
                            {{ optional($talent->position)->position_name ?? 'Officer' }} | 
                            <span class="italic text-gray-400 font-normal">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <div class="section-badge">Monitoring IDP (Exposure, Mentoring, Learning)</div>

                <div class="donut-container py-4">
                    @php
                        $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
                        $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
                        $learningCount = $talent->idpActivities->where('type_idp', 3)->count();

                        $charts = [
                            ['label' => 'Exposure', 'done' => min($exposureCount, 6), 'total' => 6, 'color' => '#334155'],
                            ['label' => 'Mentoring', 'done' => min($mentoringCount, 6), 'total' => 6, 'color' => '#f59e0b'],
                            ['label' => 'Learning', 'done' => min($learningCount, 6), 'total' => 6, 'color' => '#0d9488']
                        ];
                        $r = 38; $circ = 2 * M_PI * $r;
                    @endphp

                    @foreach($charts as $chart)
                        @php $pct = $chart['done'] / $chart['total']; $filled = $pct * $circ; $empty = $circ - $filled; @endphp
                        <div class="flex flex-col items-center gap-4 group">
                            <div class="relative w-40 h-40 lg:w-48 lg:h-48 drop-shadow-md transform transition-transform group-hover:scale-105">
                                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="10" />
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}" stroke-width="10" stroke-linecap="round" stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" style="transition: stroke-dasharray 0.8s ease;" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-extrabold" style="color: #1e293b">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                    <span class="text-sm font-bold text-gray-400 mt-[-4px]">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 px-6 py-2 rounded-full shadow-sm">
                                <span class="text-[13px] font-bold text-slate-700 uppercase tracking-wide">{{ $chart['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================================= SECTION: PROJECT IMPROVEMENT ================================= --}}
    <div id="section-project" class="hidden">
        @foreach ($talents as $talent)
            <div class="talent-profile-card">
                {{-- Profile Header --}}
                <div class="talent-profile-header">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" 
                         class="talent-profile-photo" alt="{{ $talent->nama }}">
                    <div>
                        <h4 class="talent-profile-name">{{ $talent->nama }}</h4>
                        <p class="talent-profile-meta">
                            {{ optional($talent->position)->position_name ?? 'Officer' }} | 
                            <span class="italic text-gray-400 font-normal">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <div class="section-badge">Project Improvement</div>

                <div class="log-table-container custom-scrollbar overflow-x-auto">
                    <table class="pdc-custom-table w-full">
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
                                    <td class="font-bold text-slate-700">{{ $proj->title }}</td>
                                    <td class="text-center">
                                        <a href="{{ asset('storage/' . $proj->document_path) }}" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 font-bold text-[11px] hover:bg-blue-600 hover:text-white transition-colors" 
                                           target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            LIHAT FILE
                                        </a>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center gap-2">
                                            <div class="w-2 h-2 rounded-full {{ $proj->status === 'Verified' ? 'bg-green-500' : 'bg-orange-500' }}"></div>
                                            <span class="font-bold {{ $proj->status === 'Verified' ? 'text-green-600' : 'text-orange-600' }}">
                                                {{ $proj->status === 'Verified' ? 'Approve' : ($proj->status ?: 'Pending') }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-gray-400 py-10 text-center font-medium italic">Belum ada project improvement yang diunggah.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================================= SECTION: LOGBOOK ================================= --}}
    <div id="section-logbook" class="hidden">
        @foreach ($talents as $talent)
            <div class="talent-profile-card">
                {{-- Profile Header --}}
                <div class="talent-profile-header">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" 
                         class="talent-profile-photo" alt="{{ $talent->nama }}">
                    <div>
                        <h4 class="talent-profile-name">{{ $talent->nama }}</h4>
                        <p class="talent-profile-meta">
                            {{ optional($talent->position)->position_name ?? 'Officer' }} | 
                            <span class="italic text-gray-400 font-normal">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                    <div class="section-badge mb-0">LogBook Detail</div>
                    <div class="filter-pills">
                        <div class="pill active" onclick="filterLog(1, this)">Exposure</div>
                        <div class="pill" onclick="filterLog(2, this)">Mentoring</div>
                        <div class="pill" onclick="filterLog(3, this)">Learning</div>
                    </div>
                </div>

                <div class="logbook-content-wrapper" data-talent-id="{{ $talent->id }}">

                    {{-- EXPOSURE TABLE --}}
                    <div class="log-table-type exposure-table" data-type="1">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table min-w-[2000px]">
                                <thead>
                                    <tr>
                                        <th>Mentor</th><th>Tema</th><th>Tanggal</th><th>Lokasi</th>
                                        <th>Aktivitas</th><th>Deskripsi</th><th>Dokumentasi</th><th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $expActivities = $talent->idpActivities->where('type_idp', 1); @endphp
                                    @forelse($expActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->verifier->nama ?? '-' }}</td>
                                            <td class="text-center font-bold text-[#1e293b]">{{ $act->theme }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center">{{ $act->location }}</td>
                                            <td class="text-center">{{ $act->activity }}</td>
                                            <td class="text-center">{{ $act->description ?? '-' }}</td>
                                            <td class="text-center">
                                                @php
                                                    $paths = []; $names = [];
                                                    if($act->document_path) {
                                                        if(str_starts_with($act->document_path, '["')) { $paths = json_decode($act->document_path, true); $names = explode(', ', $act->file_name); }
                                                        else { $paths = [$act->document_path]; $names = [$act->file_name]; }
                                                    }
                                                @endphp
                                                @if(count($paths) > 0)
                                                    <div class="flex flex-col gap-1 items-center">
                                                        @foreach($paths as $index => $path)
                                                            <a href="{{ asset('storage/'.$path) }}" target="_blank" class="text-[10px] text-teal-600 hover:text-teal-800 hover:underline flex items-center gap-1 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100 max-w-[120px] truncate" title="{{ $names[$index] ?? 'Dokumen' }}">{{ $names[$index] ?? 'Dokumen' }}</a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($act->status, ['Approve', 'Approved']))
                                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-2 py-0.5 rounded-full border border-green-100"><span class="w-1 h-1 rounded-full bg-green-500"></span> Approved</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100"><span class="w-1 h-1 rounded-full bg-orange-400"></span> {{ $act->status ?: 'Pending' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="py-12 px-6 text-gray-400">Belum ada aktivitas Exposure yang dicatat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- MENTORING TABLE --}}
                    <div class="log-table-type mentoring-table hidden" data-type="2">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table min-w-[2000px]">
                                <thead>
                                    <tr>
                                        <th>Mentor</th><th>Tema</th><th>Tanggal</th><th>Lokasi</th>
                                        <th>Deskripsi</th><th>Action Plan</th><th>Dokumentasi</th><th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $menActivities = $talent->idpActivities->where('type_idp', 2); @endphp
                                    @forelse($menActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->verifier->nama ?? '-' }}</td>
                                            <td class="text-center font-bold text-[#1e293b]">{{ $act->theme }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center">{{ $act->location }}</td>
                                            <td class="text-center">{{ $act->description ?? '-' }}</td>
                                            <td class="text-center font-semibold text-[#0d9488]">{{ $act->action_plan ?? '-' }}</td>
                                            <td class="text-center">
                                                @php
                                                    $paths = []; $names = [];
                                                    if($act->document_path) {
                                                        if(str_starts_with($act->document_path, '["')) { $paths = json_decode($act->document_path, true); $names = explode(', ', $act->file_name); }
                                                        else { $paths = [$act->document_path]; $names = [$act->file_name]; }
                                                    }
                                                @endphp
                                                @if(count($paths) > 0)
                                                    <div class="flex flex-col gap-1 items-center">
                                                        @foreach($paths as $index => $path)
                                                            <a href="{{ asset('storage/'.$path) }}" target="_blank" class="text-[10px] text-teal-600 hover:text-teal-800 hover:underline flex items-center gap-1 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100 max-w-[120px] truncate" title="{{ $names[$index] ?? 'Dokumen' }}">{{ $names[$index] ?? 'Dokumen' }}</a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($act->status, ['Approve', 'Approved']))
                                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-2 py-0.5 rounded-full border border-green-100"><span class="w-1 h-1 rounded-full bg-green-500"></span> Approved</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100"><span class="w-1 h-1 rounded-full bg-orange-400"></span> {{ $act->status ?: 'Pending' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="py-12 px-6 text-gray-400">Belum ada aktivitas Mentoring yang dicatat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- LEARNING TABLE --}}
                    <div class="log-table-type learning-table hidden" data-type="3">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table min-w-[2000px]">
                                <thead>
                                    <tr>
                                        <th>Sumber</th><th>Tema</th><th>Tanggal</th><th>Platform</th>
                                        <th>Deskripsi</th><th>Dokumentasi</th><th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $leaActivities = $talent->idpActivities->where('type_idp', 3); @endphp
                                    @forelse($leaActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->activity }}</td>
                                            <td class="text-center font-bold text-[#1e293b]">{{ $act->theme }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center">{{ $act->platform }}</td>
                                            <td class="text-center">{{ $act->description ?? '-' }}</td>
                                            <td class="text-center">
                                                @php
                                                    $paths = []; $names = [];
                                                    if($act->document_path) {
                                                        if(str_starts_with($act->document_path, '["')) { $paths = json_decode($act->document_path, true); $names = explode(', ', $act->file_name); }
                                                        else { $paths = [$act->document_path]; $names = [$act->file_name]; }
                                                    }
                                                @endphp
                                                @if(count($paths) > 0)
                                                    <div class="flex flex-col gap-1 items-center">
                                                        @foreach($paths as $index => $path)
                                                            <a href="{{ asset('storage/'.$path) }}" target="_blank" class="text-[10px] text-teal-600 hover:text-teal-800 hover:underline flex items-center gap-1 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100 max-w-[120px] truncate" title="{{ $names[$index] ?? 'Dokumen' }}">{{ $names[$index] ?? 'Dokumen' }}</a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-2 py-0.5 rounded-full border border-green-100"><span class="w-1 h-1 rounded-full bg-green-500"></span> Verified</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="py-12 px-6 text-gray-400">Belum ada aktivitas Learning yang dicatat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    </div> {{-- Close logbook-width --}}

    <x-slot name="scripts">
        <script>
            function switchSection(targetId, el) {
                document.getElementById('section-kompetensi').classList.add('hidden');
                document.getElementById('section-idp').classList.add('hidden');
                document.getElementById('section-project').classList.add('hidden');
                document.getElementById('section-logbook').classList.add('hidden');

                document.getElementById('section-' + targetId).classList.remove('hidden');

                document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
                el.classList.add('active');
            }

            function filterLog(typeId, el) {
                document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
                el.classList.add('active');

                document.querySelectorAll('.log-table-type').forEach(tableDiv => {
                    if (tableDiv.getAttribute('data-type') == typeId) {
                        tableDiv.classList.remove('hidden');
                    } else {
                        tableDiv.classList.add('hidden');
                    }
                });
            }
        </script>
    </x-slot>

</x-atasan.layout>
