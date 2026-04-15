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

            .log-table-container {
                background: white; border-radius: 16px; border: 1px solid #e2e8f0;
                overflow: hidden; position: relative; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .pdc-log-table { width: 100%; border-collapse: collapse; }
            .pdc-log-table th {
                padding: 24px 32px; background: #f8fafc; font-weight: 800; color: #475569;
                font-size: 0.95rem; text-align: center; white-space: nowrap;
            }
            .pdc-log-table td {
                padding: 32px; color: #64748b; font-size: 0.9rem; border-top: 1px solid #f1f5f9;
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

            .section-title {
                display: flex; align-items: center; gap: 12px; font-size: 1.25rem;
                font-weight: 800; color: #1e293b; margin-top: 40px; margin-bottom: 24px;
            }

            /* IDP Donut Charts */
            .idp-card-container {
                background: #f8fafc; border-radius: 16px; padding: 24px;
                border: 1px solid #e2e8f0;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .donut-container {
                background: white; border-radius: 16px; padding: 30px;
                display: flex; justify-content: space-evenly; align-items: center;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                width: 100%;
            }

            /* Tables */
            .pdc-custom-table {
                width: 100%; border-collapse: collapse; background: white;
                border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;
            }
            .pdc-custom-table th {
                background: #f8fafc; padding: 12px; border: 1px solid #e2e8f0;
                font-size: 0.85rem; font-weight: 800; color: #1e293b;
            }
            .pdc-custom-table td {
                padding: 12px; border: 1px solid #e2e8f0; font-size: 0.85rem;
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
                display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
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
                .talent-gap-grid {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }
                .talent-card {
                    padding: 16px;
                    border-radius: 12px;
                }
                .talent-photo {
                    width: 48px;
                    height: 48px;
                }
                .talent-meta h4 {
                    font-size: 0.95rem;
                }
                .section-title {
                    font-size: 1.05rem;
                    margin-top: 24px;
                    margin-bottom: 16px;
                }
                .heatmap-container {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }
                .heatmap-table {
                    min-width: 700px;
                }
                .legend {
                    flex-wrap: wrap;
                    gap: 8px;
                }
                .donut-container {
                    flex-wrap: wrap;
                    gap: 16px;
                    padding: 16px;
                }
                .donut-container .relative.w-48.h-48 {
                    width: 120px !important;
                    height: 120px !important;
                }
                .donut-container .text-3xl {
                    font-size: 1.25rem !important;
                }
                .idp-card-container {
                    padding: 16px;
                    border-radius: 12px;
                }
                .filter-pills {
                    padding: 3px;
                }
                .pill {
                    padding: 6px 20px;
                    font-size: 0.78rem;
                }
                .pdc-log-table th {
                    padding: 12px 16px;
                    font-size: 0.8rem;
                }
                .pdc-log-table td {
                    padding: 16px;
                    font-size: 0.8rem;
                }
                .pdc-custom-table th {
                    padding: 8px;
                    font-size: 0.75rem;
                }
                .pdc-custom-table td {
                    padding: 8px;
                    font-size: 0.78rem;
                }
            }
        </style>
    </x-slot>

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
    <div id="section-kompetensi" class="w-full">
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
                <div class="talent-card">
                    <div class="talent-header">
                        <div class="talent-info">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="talent-photo" alt="{{ $talent->nama }}">
                            <div class="talent-meta">
                                <h4>{{ $talent->nama }}</h4>
                                <p>{{ optional($talent->position)->position_name ?? 'Officer' }} - {{ optional($talent->department)->nama_department ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 text-xs font-bold text-gray-500">
                        <p>MENTOR :
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
                        <p>ATASAN : {{ strtoupper($user->nama ?? '-') }}</p>
                    </div>

                    <span class="top-gap-label">TOP 3 GAP</span>
                    @forelse($gaps as $index => $gap)
                        <div class="gap-item prio-{{ $index + 1 }}">
                            <div class="flex items-center">
                                <span class="gap-number">{{ $index + 1 }}</span>
                                {{ $gap->competence->name }}
                            </div>
                            <span>{{ number_format($gap->gap_score, 1) }}</span>
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
                                    
                                    $finalScore = ($scoreTalent + $scoreAtasan) / 2;
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
                    {{-- Nilai Rata-rata --}}
                    <tr class="font-bold bg-gray-50">
                        <td class="td-left">Nilai Rata-Rata</td>
                        <td>{{ number_format($standards->avg() ?: 0, 1) }}</td>
                        @foreach ($talents as $talent)
                            @php
                                $avgSelf = optional(optional($talent->assessmentSession)->details)->avg('score_talent') ?: 0;
                                $avgAtasan = optional(optional($talent->assessmentSession)->details)->avg('score_atasan') ?: 0;
                                $avgGap = optional(optional($talent->assessmentSession)->details)->avg('gap_score') ?: 0;
                            @endphp
                            <td>{{ number_format($avgSelf, 1) }}</td>
                            <td>{{ number_format($avgAtasan, 1) }}</td>
                            <td>{{ number_format(($avgSelf + $avgAtasan) / 2, 1) }}</td>
                            <td class="p-1">
                                @php
                                    $cls = 'gap-ok';
                                    if ($avgGap == 0) $cls = 'gap-none';
                                    elseif ($avgGap < -1.5) $cls = 'gap-large';
                                    elseif ($avgGap < 0) $cls = 'gap-small';
                                @endphp
                                <span class="gap-badge {{ $cls }}">{{ number_format($avgGap, 1) }}</span>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================================= SECTION: IDP ================================= --}}
    <div id="section-idp" class="hidden w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full">
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
                        $r = 38; $circ = 2 * M_PI * $r;
                    @endphp

                    @foreach($charts as $chart)
                        @php $pct = $chart['done'] / $chart['total']; $filled = $pct * $circ; $empty = $circ - $filled; @endphp
                        <div class="flex flex-col items-center gap-3">
                            <div class="relative w-48 h-48 drop-shadow-sm">
                                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="10" />
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}" stroke-width="10" stroke-linecap="round" stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" style="transition: stroke-dasharray 0.8s ease;" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-extrabold" style="color: #1e293b">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                    <span class="text-sm font-bold text-gray-400 mt-[-4px]">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 px-5 py-1.5 rounded-[10px] shadow-sm">
                                <span class="text-sm font-bold text-gray-800">{{ $chart['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
    </div>

    {{-- ================================= SECTION: PROJECT IMPROVEMENT ================================= --}}
    <div id="section-project" class="hidden w-full">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
            </svg>
            Project Improvement
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full mb-8">
            @foreach ($talents as $talent)
                <div class="bg-white border text-center border-gray-200 rounded-2xl p-6 shadow-sm h-full flex flex-col justify-between">
                <div class="flex justify-between items-center mb-10">
                    <div class="flex items-center gap-4 text-left">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                        <div>
                            <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                            <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                        </div>
                    </div>
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
            </div>
        @endforeach
        </div>
    </div>

    {{-- ================================= SECTION: LOGBOOK ================================= --}}
    <div id="section-logbook" class="hidden w-full">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full mb-8">
            @foreach ($talents as $talent)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm h-full flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-10">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                    <div>
                        <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                        <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                    </div>
                </div>

                <div class="logbook-content-wrapper" data-talent-id="{{ $talent->id }}">

                    {{-- EXPOSURE TABLE --}}
                    <div class="log-table-type exposure-table" data-type="1">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table w-full">
                                <thead>
                                    <tr>
                                        <th>Mentor</th><th>Tema</th><th>Tgl. Pengiriman/Update</th><th>Tgl. Pelaksanaan</th><th>Status</th><th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $expActivities = $talent->idpActivities->where('type_idp', 1); @endphp
                                    @forelse($expActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->verifier->nama ?? '-' }}</td>
                                            <td class="text-center font-bold text-[#1e293b]" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center">
                                                @if(in_array($act->status, ['Approve', 'Approved']))
                                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $act->status ?: 'Pending' }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('atasan.logbook.detail', $act->id) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg> 
                                                        Detail
                                                    </a>
                                                    <div class="hidden logbook-detail-html">
                                                        <div class="space-y-3 text-left">
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Mentor</span><div class="text-[14px] text-gray-800">{{ $act->verifier->nama ?? '-' }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $act->theme }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</span><div class="text-[14px] text-gray-800">{{ $act->location }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Aktivitas</span><div class="text-[14px] text-gray-800">{{ $act->activity }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $act->description ?? '-' }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Dokumentasi</span>
                                                                @php
                                                                    $dPaths = []; $dNames = [];
                                                                    if($act->document_path){
                                                                        if(str_starts_with($act->document_path, '["')) {
                                                                            $dPaths = json_decode($act->document_path, true);
                                                                            $dNames = explode(', ', $act->file_name);
                                                                        } else {
                                                                            $dPaths = [$act->document_path]; $dNames = [$act->file_name];
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(count($dPaths) > 0)
                                                                    <div class="flex flex-col gap-1 mt-1">
                                                                        @foreach($dPaths as $di => $dp)
                                                                            <a href="{{ asset('storage/'.$dp) }}" target="_blank" class="text-xs text-teal-600 hover:underline flex items-center gap-1">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                {{ $dNames[$di] ?? 'Dokumen' }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-gray-400 text-xs">-</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="py-12 px-6 text-gray-400">Belum ada aktivitas Exposure yang dicatat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- MENTORING TABLE --}}
                    <div class="log-table-type mentoring-table hidden" data-type="2">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table w-full">
                                <thead>
                                    <tr>
                                        <th>Mentor</th><th>Tema</th><th>Tgl. Pengiriman/Update</th><th>Tgl. Pelaksanaan</th><th>Status</th><th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $menActivities = $talent->idpActivities->where('type_idp', 2); @endphp
                                    @forelse($menActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->verifier->nama ?? '-' }}</td>
                                            <td class="text-center font-bold text-[#1e293b]" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center">
                                                @if(in_array($act->status, ['Approve', 'Approved']))
                                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $act->status ?: 'Pending' }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('atasan.logbook.detail', $act->id) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg> 
                                                        Detail
                                                    </a>
                                                    <div class="hidden logbook-detail-html">
                                                        <div class="space-y-3 text-left">
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Mentor</span><div class="text-[14px] text-gray-800">{{ $act->verifier->nama ?? '-' }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $act->theme }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</span><div class="text-[14px] text-gray-800">{{ $act->location }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $act->description ?? '-' }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Action Plan</span><div class="text-[14px] text-gray-800">{{ $act->action_plan ?? '-' }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Dokumentasi</span>
                                                                @php
                                                                    $dPaths = []; $dNames = [];
                                                                    if($act->document_path){
                                                                        if(str_starts_with($act->document_path, '["')) {
                                                                            $dPaths = json_decode($act->document_path, true);
                                                                            $dNames = explode(', ', $act->file_name);
                                                                        } else {
                                                                            $dPaths = [$act->document_path]; $dNames = [$act->file_name];
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(count($dPaths) > 0)
                                                                    <div class="flex flex-col gap-1 mt-1">
                                                                        @foreach($dPaths as $di => $dp)
                                                                            <a href="{{ asset('storage/'.$dp) }}" target="_blank" class="text-xs text-teal-600 hover:underline flex items-center gap-1">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                {{ $dNames[$di] ?? 'Dokumen' }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-gray-400 text-xs">-</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="py-12 px-6 text-gray-400">Belum ada aktivitas Mentoring yang dicatat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- LEARNING TABLE --}}
                    <div class="log-table-type learning-table hidden" data-type="3">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table w-full">
                                <thead>
                                    <tr>
                                        <th>Sumber</th><th>Tema</th><th>Tgl. Pengiriman/Update</th><th>Tgl. Pelaksanaan</th><th>Status</th><th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $leaActivities = $talent->idpActivities->where('type_idp', 3); @endphp
                                    @forelse($leaActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->activity }}</td>
                                            <td class="text-center font-bold text-[#1e293b]" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center">
                                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('atasan.logbook.detail', $act->id) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg> 
                                                        Detail
                                                    </a>
                                                    <div class="hidden logbook-detail-html">
                                                        <div class="space-y-3 text-left">
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Sumber</span><div class="text-[14px] text-gray-800">{{ $act->activity }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $act->theme }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Platform</span><div class="text-[14px] text-gray-800">{{ $act->platform }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $act->description ?? '-' }}</div></div>
                                                            <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Dokumentasi</span>
                                                                @php
                                                                    $dPaths = []; $dNames = [];
                                                                    if($act->document_path){
                                                                        if(str_starts_with($act->document_path, '["')) {
                                                                            $dPaths = json_decode($act->document_path, true);
                                                                            $dNames = explode(', ', $act->file_name);
                                                                        } else {
                                                                            $dPaths = [$act->document_path]; $dNames = [$act->file_name];
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(count($dPaths) > 0)
                                                                    <div class="flex flex-col gap-1 mt-1">
                                                                        @foreach($dPaths as $di => $dp)
                                                                            <a href="{{ asset('storage/'.$dp) }}" target="_blank" class="text-xs text-teal-600 hover:underline flex items-center gap-1">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                {{ $dNames[$di] ?? 'Dokumen' }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-gray-400 text-xs">-</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="py-12 px-6 text-gray-400">Belum ada aktivitas Learning yang dicatat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        </div>
    </div>

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

    <!-- Generic Logbook Detail Modal -->
    <div id="logbookDetailModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-[500px] p-7 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="logbookDetailModalContent">
            <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-[#1e293b]">Detail Logbook</h3>
                <button onclick="closeLogbookDetailModal()" class="text-gray-400 hover:text-gray-600 bg-gray-50 rounded-full p-2 hover:bg-gray-200 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="text-sm" id="detailModalBody"></div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <button onclick="closeLogbookDetailModal()" class="w-full bg-[#f1f5f9] text-[#64748b] font-bold py-2.5 rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
            </div>
        </div>
    </div>
    <script>
        function openLogbookDetail(btn) {
            const htmlContent = btn.nextElementSibling.innerHTML;
            document.getElementById('detailModalBody').innerHTML = htmlContent;
            const modal = document.getElementById('logbookDetailModal');
            const content = document.getElementById('logbookDetailModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
        }
        function closeLogbookDetailModal() {
            const modal = document.getElementById('logbookDetailModal');
            const content = document.getElementById('logbookDetailModalContent');
            modal.classList.add('opacity-0'); content.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>
</x-atasan.layout>
