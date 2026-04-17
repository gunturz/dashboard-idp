<x-pdc_admin.layout title="Detail Archive Talent – Individual Development Plan" :user="$user" :hideSidebar="true">
    <x-slot name="styles">
        <style>
            /* Scrollbar */
            ::-webkit-scrollbar { width: 5px; height: 5px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }

            /* Back button */
            .btn-back-bottom {
                display: inline-flex; align-items: center; gap: 8px;
                padding: 8px 32px; border: 1px solid #e2e8f0; border-radius: 10px;
                background: #f8fafc; color: #475569; font-weight: 600; font-size: 0.85rem;
                text-decoration: none; transition: all 0.2s;
            }
            .btn-back-bottom:hover { background: #cbd5e1; color: #1e293b; }

            /* Profile header card */
            .profile-card {
                background: #2e3746; border: none; border-radius: 16px;
                padding: 24px; margin-bottom: 24px;
                display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
                box-shadow: 0 4px 12px rgba(46, 55, 70, 0.15);
                color: white;
            }
            .profile-col-1 {
                display: flex; align-items: center; gap: 16px;
                border-right: 1px dashed rgba(255, 255, 255, 0.2); padding-right: 16px;
            }
            .profile-col-general {
                display: flex; flex-direction: column; justify-content: center; gap: 12px;
            }
            .profile-col-general:nth-child(2) {
                border-right: 1px dashed rgba(255, 255, 255, 0.2); padding-right: 16px;
            }
            .profile-avatar {
                width: 64px; height: 64px; border-radius: 50%; object-fit: cover;
                border: 2px solid rgba(255, 255, 255, 0.3); flex-shrink: 0;
            }
            .profile-info h3 { font-size: 1.1rem; font-weight: 800; color: white; margin-bottom: 2px; }
            .profile-info p { font-size: 0.78rem; color: #cbd5e1; font-style: italic; }
            .meta-item { font-size: 0.78rem; color: #cbd5e1; display: grid; grid-template-columns: 120px 1fr; gap: 8px; align-items: center; }
            .meta-item strong { color: white; font-weight: 700; }

            /* Nav Tabs */
            .nav-tabs-container {
                display: flex; justify-content: center; margin-bottom: 32px;
            }
            .nav-tabs {
                display: flex; background: #e2e8f0; padding: 4px; border-radius: 99px; width: 100%; max-width: 900px;
            }
            .tab-item {
                flex: 1; text-align: center; padding: 10px 0; font-size: 0.85rem; font-weight: 700;
                color: #475569; cursor: pointer; border-radius: 99px; transition: all 0.2s;
            }
            .tab-item.active { background: #2e3746; color: white; }

            /* Section title */
            .section-title {
                display: flex; align-items: center; gap: 10px;
                font-size: 1.25rem; font-weight: 800; color: #1e293b;
                margin-bottom: 24px;
            }
            .sub-section-title {
                display: flex; align-items: center; gap: 8px;
                font-size: 1rem; font-weight: 800; color: #475569;
                margin-bottom: 16px; margin-top: 16px;
            }

            /* Logbook Specific */
            .logbook-pill {
                background: #2e3746; color: white; padding: 6px 16px; border-radius: 99px;
                font-size: 0.75rem; font-weight: 700; display: inline-block; margin-bottom: 16px; margin-top: 24px;
            }
            .logbook-table {
                width: 100%; border-collapse: collapse; font-size: 0.8125rem; margin-bottom: 24px;
            }
            .logbook-table th {
                background: #f8fafc; font-weight: 700; color: #1e293b; text-align: center; padding: 12px;
                border: 1px solid #e2e8f0;
            }
            .logbook-table td {
                padding: 12px; border: 1px solid #e2e8f0; text-align: center; color: #475569;
            }
            .empty-row td { padding: 24px !important; color: #cbd5e1 !important; text-align: center; }

            /* Finance Specific */
            .finance-box {
                background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px;
            }
            .finance-row { display: grid; grid-template-columns: 200px 1fr; gap: 16px; margin-bottom: 16px; align-items: center; font-size: 0.85rem;}
            .finance-row strong { color: #1e293b; font-weight: 800; }
            .finance-row span { color: #475569; }
            .finance-textarea-box {
                border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; min-height: 80px; color: #475569; font-size: 0.85rem; font-weight: 500;
            }
            .finance-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;}
            .finance-info-grid { display: grid; gap: 12px; }
            .finance-pill { background: #0d9488; color: white; padding: 6px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;}

            /* Heatmap table */
            .heatmap-container { background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-top: 16px;}
            .heatmap-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
            .heatmap-table th, .heatmap-table td { border: 1px solid #e2e8f0; padding: 9px 14px; text-align: center; }
            .heatmap-table .th-main { background: #f8fafc; font-weight: 700; color: #1e293b; }
            .heatmap-table .th-sub  { font-size: 0.65rem; font-weight: 700; color: #475569; text-transform: uppercase; background: #f8fafc; }
            .heatmap-table .td-left { text-align: left; font-weight: 600; color: #334155; }
            .gap-badge { display:block; width:100%; height:100%; padding:4px; border-radius:4px; font-weight:700; color:white; }
            .gap-none  { background:#f1f5f9; color:#64748b; }
            .gap-ok    { background:#cbd5e1; color:#1e293b; }
            .gap-small { background:#f97316; color:white; }
            .gap-large { background:#ef4444; color:white; }

            /* TOP 3 GAP */
            .gap-item {
                display:flex; justify-content:space-between; align-items:center;
                padding: 14px 24px; border-radius: 99px; margin-bottom: 12px;
                font-size: 1rem; font-weight: 700; background: white; border: 1px solid #e2e8f0;
            }
            .gap-item.prio-1 { border: 1.5px solid #ef4444; color:#1e293b;  }
            .gap-item.prio-2 { border: 1.5px solid #f97316; color:#1e293b;  }
            .gap-item.prio-3 { border: 1.5px solid #8b5cf6; color:#1e293b;  }
            .gap-number {
                width:28px; height:28px; border-radius:50%; display:flex; align-items:center;
                justify-content:center; color:white; font-size:0.85rem; margin-right:16px; font-weight:800;
            }
            .gap-item.prio-1 .gap-number { background:#ef4444; }
            .gap-item.prio-2 .gap-number { background:#f97316; }
            .gap-item.prio-3 .gap-number { background:#8b5cf6; }

            /* IDP Donut */
            .donut-container {
                background: white; border-radius: 12px; border: 1px solid #e2e8f0;
                padding: 32px; display: flex; justify-content: space-around; align-items: center;
                box-shadow: 0 1px 4px rgba(0,0,0,0.02); flex-wrap: wrap; gap: 24px; margin-bottom: 32px;
            }

            @media(max-width:768px) {
                .profile-card { grid-template-columns: 1fr; gap: 16px; }
                .profile-col-1, .profile-col-general:nth-child(2) { border-right: none; padding-right: 0; border-bottom: 1px dashed rgba(255, 255, 255, 0.2); padding-bottom: 16px; }
                .meta-item { grid-template-columns: 1fr; gap: 4px; }
            }
        </style>
    </x-slot>

    {{-- Profile Card --}}
    <div class="profile-card">
        {{-- Kolom 1: Profil --}}
        <div class="profile-col-1">
            <img src="{{ isset($talent) && $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(isset($talent) ? $talent->nama : 'Yayang Guntur') . '&background=e0f2fe&color=0284c7' }}"
                alt="{{ $talent->nama ?? 'Yayang Guntur' }}" class="profile-avatar">
            <div class="profile-info">
                <h3>{{ $talent->nama ?? 'Yayang Guntur' }}</h3>
                <p>Talent</p>
            </div>
        </div>

        {{-- Kolom 2: Perusahaan & Mentor --}}
        <div class="profile-col-general">
            <div class="meta-item"><strong>Perusahaan</strong><span>{{ isset($talent) && optional($talent->company)->nama_company ? $talent->company->nama_company : 'Tiga Serangkai' }}</span></div>
            <div class="meta-item"><strong>Departemen</strong><span>{{ isset($talent) && optional($talent->department)->nama_department ? $talent->department->nama_department : 'Human Resource' }}</span></div>
            <div class="meta-item"><strong>Jabatan yang Dituju</strong><span>{{ isset($talent) && optional($talent->promotion_plan)->targetPosition ? $talent->promotion_plan->targetPosition->position_name : 'Manager' }}</span></div>
        </div>

        {{-- Kolom 3: Departemen & Atasan --}}
        <div class="profile-col-general">
            <div class="meta-item"><strong>Mentor</strong>
                <span>
                @php
                    if (isset($talent) && isset($talent->promotion_plan)) {
                        $mIds = $talent->promotion_plan->mentor_ids ?? [];
                        echo !empty($mIds)
                            ? \App\Models\User::whereIn('id', $mIds)->pluck('nama')->implode(', ')
                            : (optional($talent->mentor)->nama ?? 'Setyo');
                    } else {
                        echo 'Setyo';
                    }
                @endphp
                </span>
            </div>
            <div class="meta-item"><strong>Atasan</strong><span>{{ isset($talent) && optional($talent->atasan)->nama ? $talent->atasan->nama : 'Turgun' }}</span></div>
            <div class="meta-item"><strong>Periode</strong><span>01/01/2026 - 01/06/2026</span></div>
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
        <div class="section-title">Kompetensi</div>
        
        <div class="sub-section-title">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path></svg>
            TOP 3 GAP Kompetensi
        </div>
        
        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8 mt-4">
            @if(isset($gaps) && count($gaps) > 0)
                @foreach($gaps as $index => $gap)
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
                    <div class="flex items-center"><span class="gap-number">2</span>Problem Solving & Decision Making</div><span>-1.5</span>
                </div>
                <div class="gap-item prio-3">
                    <div class="flex items-center"><span class="gap-number">3</span>Leadership</div><span>-1</span>
                </div>
            @endif
        </div>

        <hr class="border-t-2 border-slate-200 my-8">

        <div class="sub-section-title">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
            Heatmap Kompetensi
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4">
            <div class="heatmap-container overflow-x-auto m-0">
                <table class="heatmap-table">
                    <thead>
                        <tr>
                            <th class="th-main" style="width:220px;">Kompetensi</th>
                            <th class="th-main" style="width:70px;">Standar</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Skor Talent</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Skor Atasan</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Final Score</th>
                            <th class="th-sub bg-[#ef4444] border-[#ef4444]"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($competencies) && count($competencies) > 0)
                            @foreach($competencies as $comp)
                                @php
                                    $standard  = $standards[$comp->id] ?? 0;
                                    $detail    = $talent->assessmentSession ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id) : null;
                                    $sT        = $detail->score_talent ?? 0;
                                    $sA        = $detail->score_atasan ?? 0;
                                    $gap       = $detail->gap_score ?? 0;
                                    $final     = $sA > 0 ? ($sT + $sA) / 2 : ($sT > 0 ? $sT : 0);
                                    $cls       = $gap == 0 ? 'gap-none' : ($gap < -1.5 ? 'gap-large' : 'gap-small');
                                @endphp
                                <tr>
                                    <td class="td-left">{{ $comp->name }}</td>
                                    <td>{{ $standard }}</td>
                                    <td><span class="font-bold">{{ $sT ?: '-' }}</span></td>
                                    <td><span class="font-bold">{{ $sA ?: '-' }}</span></td>
                                    <td><span class="font-bold">{{ $final ?: '-' }}</span></td>
                                    <td class="p-0"><span class="gap-badge {{ $cls }} rounded-none" style="position:relative; width:100%; height:100%; min-height: 38px; display:flex; align-items:center; justify-content:center;">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span></td>
                                </tr>
                            @endforeach
                            {{-- Average row --}}
                            @php
                                $sess     = $talent->assessmentSession;
                                $avgT     = $sess ? $sess->details->avg('score_talent') ?? 0 : 0;
                                $avgA     = $sess ? $sess->details->avg('score_atasan') ?? 0 : 0;
                                $avgGap   = $sess ? $sess->details->avg('gap_score') ?? 0 : 0;
                                $avgCls   = $avgGap == 0 ? 'gap-none' : ($avgGap < -1.5 ? 'gap-large' : 'gap-small');
                            @endphp
                            <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>{{ number_format(collect($standards)->avg() ?: 0, 1) }}</td>
                                <td>{{ number_format($avgT, 1) }}</td>
                                <td>{{ number_format($avgA, 1) }}</td>
                                <td>{{ number_format(($avgT + $avgA) / 2, 1) }}</td>
                                <td class="p-0"><span class="gap-badge {{ $avgCls }} rounded-none" style="position:relative; width:100%; height:100%; min-height: 38px; display:flex; align-items:center; justify-content:center;">{{ number_format($avgGap, 1) }}</span></td>
                            </tr>
                        @else
                            <!-- MOCKUP matching image -->
                            <tr><td class="td-left">Integrity</td><td>5</td><td><span class="font-bold">2</span></td><td><span class="font-bold">4</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-none rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]"></span></td></tr>
                            <tr><td class="td-left">Communication</td><td>4</td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1</span></td></tr>
                            <tr><td class="td-left">Innovation & Creativity</td><td>3</td><td><span class="font-bold">4</span></td><td><span class="font-bold">2</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-none rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">0</span></td></tr>
                            <tr><td class="td-left">Customer Orientation</td><td>3</td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-none rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">0</span></td></tr>
                            <tr><td class="td-left">Teamwork</td><td>4</td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1</span></td></tr>
                            <tr><td class="td-left">Leadership</td><td>4</td><td><span class="font-bold">2</span></td><td><span class="font-bold">4</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1</span></td></tr>
                            <tr><td class="td-left">Bussiness Acumen</td><td>4</td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1</span></td></tr>
                            <tr><td class="td-left">Problem Solving & Decision Making</td><td>4</td><td><span class="font-bold">2</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">2.5</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1.5</span></td></tr>
                            <tr><td class="td-left">Achievement Orientation</td><td>4</td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1</span></td></tr>
                            <tr><td class="td-left">Strategic Thinking</td><td>4</td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td><span class="font-bold">3</span></td><td class="p-0"><span class="gap-badge gap-small rounded-none flex items-center justify-center h-full w-full relative min-h-[38px]">-1</span></td></tr>
                            <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>3.9</td>
                                <td>2.8</td>
                                <td>3.1</td>
                                <td>3.0</td>
                                <td class="p-0"><span class="gap-badge gap-small rounded-none w-full h-full relative flex items-center justify-center min-h-[38px]">-0.95</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================================= SECTION: IDP MONITORING ================================= --}}
    <div id="section-idp" class="tab-section" style="display: none;">
        <div class="section-title">IDP Monitoring</div>
        
        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-8">
            <div class="sub-section-title m-0 mb-6">
                <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                IDP Monitoring
            </div>
            
            <div class="donut-container p-12">
                @php
                    $charts = [
                        ['label' => 'Exposure',  'done' => isset($exposureCount) ? min($exposureCount, 6) : 4,  'total' => 6, 'color' => '#475569'],
                        ['label' => 'Mentoring', 'done' => isset($mentoringCount) ? min($mentoringCount, 6) : 5, 'total' => 6, 'color' => '#eab308'],
                        ['label' => 'Learning',  'done' => isset($learningCount) ? min($learningCount, 6) : 6,  'total' => 6, 'color' => '#14b8a6'],
                    ];
                    $r = 44; $circ = 2 * M_PI * $r;
                @endphp
                @foreach($charts as $chart)
                    @php $pct = $chart['done'] / $chart['total']; $filled = $pct * $circ; $empty = $circ - $filled; @endphp
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative w-40 h-40">
                            <!-- Drop shadow SVG -->
                            <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90 absolute">
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" class="stroke-slate-200" stroke-width="12" />
                            </svg>
                            <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90 relative" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}" stroke-width="12"
                                    stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" stroke-linecap="butt" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white rounded-full m-3 border border-slate-100 shadow-inner">
                                <span class="text-[1.45rem] font-extrabold text-slate-800 tracking-tight">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                <span class="text-[0.7rem] font-bold text-slate-400 italic">{{ round($pct * 100) }}%</span>
                            </div>
                        </div>
                        <div class="border border-slate-300 bg-white px-6 py-1.5 rounded-full shadow-sm mt-2">
                            <span class="text-[0.8rem] font-bold text-slate-700">{{ $chart['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="border-t-2 border-slate-200 my-8">

        <div class="sub-section-title">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
            LogBook
        </div>

        {{-- Exposure --}}
        <div class="logbook-pill">Exposure</div>
        <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden">
            <thead>
                <tr>
                    <th style="width: 20%;">Mentor</th>
                    <th style="width: 25%;">Tema</th>
                    <th style="width: 15%;">Tanggal Pengiriman / Update</th>
                    <th style="width: 15%;">Tanggal Pelaksanaan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Empty rows mockup to match picture exactly -->
                <tr><td></td><td></td><td></td><td></td><td><span class="text-[0.7rem] font-bold text-yellow-600 flex items-center justify-center gap-1.5"><span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending</span></td><td><a href="#" class="text-xs font-bold text-slate-600 flex items-center justify-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Detail</a></td></tr>
                <tr class="empty-row"><td colspan="6" style="padding:16px;"></td></tr>
                <tr class="empty-row"><td colspan="6" style="padding:16px;"></td></tr>
            </tbody>
        </table>

        {{-- Mentoring --}}
        <div class="logbook-pill">Mentoring</div>
        <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden">
            <thead>
                <tr>
                    <th style="width: 20%;">Mentor</th>
                    <th style="width: 25%;">Tema</th>
                    <th style="width: 15%;">Tanggal Pengiriman / Update</th>
                    <th style="width: 15%;">Tanggal Pelaksanaan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td></td><td></td><td></td><td></td><td><span class="text-[0.7rem] font-bold text-yellow-600 flex items-center justify-center gap-1.5"><span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending</span></td><td><a href="#" class="text-xs font-bold text-slate-600 flex items-center justify-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Detail</a></td></tr>
                <tr class="empty-row"><td colspan="6" style="padding:16px;"></td></tr>
                <tr class="empty-row"><td colspan="6" style="padding:16px;"></td></tr>
            </tbody>
        </table>

        {{-- Learning --}}
        <div class="logbook-pill">Learning</div>
        <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden">
            <thead>
                <tr>
                    <th style="width: 20%;">Sumber</th>
                    <th style="width: 25%;">Tema</th>
                    <th style="width: 15%;">Tanggal Pengiriman / Update</th>
                    <th style="width: 15%;">Tanggal Pelaksanaan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td></td><td></td><td></td><td></td><td><span class="text-[0.7rem] font-bold text-yellow-600 flex items-center justify-center gap-1.5"><span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending</span></td><td><a href="#" class="text-xs font-bold text-slate-600 flex items-center justify-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Detail</a></td></tr>
                <tr class="empty-row"><td colspan="6" style="padding:16px;"></td></tr>
                <tr class="empty-row"><td colspan="6" style="padding:16px;"></td></tr>
            </tbody>
        </table>
    </div>

    {{-- ================================= SECTION: FINANCE VALIDATION ================================= --}}
    <div id="section-finance" class="tab-section" style="display: none;">
        <div class="section-title">Finance Validation</div>
        
        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-4">
            <div class="finance-box shadow-sm">
                <div class="finance-header-row">
                    <div class="finance-info-grid">
                        <div class="finance-row"><strong>Nama Finance</strong><span>Sugeng Riyadi</span></div>
                        <div class="finance-row"><strong>Email</strong><span>sugeng2@gmail.com</span></div>
                        <div class="finance-row"><strong>Perusahaan</strong><span>PT Tiga Serangkai Inti Corpora</span></div>
                        <div class="finance-row mb-0"><strong>Judul Project</strong><span>Pengembangan Pusat Informasi Pada PT Tiga Serangkai</span></div>
                    </div>
                    <div class="finance-pill">
                        Tanggal &nbsp;&nbsp;&nbsp;&nbsp; 01 Januari 2026
                    </div>
                </div>
                
                <div class="mt-4 mb-2"><strong class="text-[0.8rem] text-slate-800">Catatan Admin</strong></div>
                <div class="finance-textarea-box">Alasan pemilihan leadership dikarenakan akan kandidat kurang memiliki keahlian yang signifikan</div>
                
                <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Feedback Finance</strong></div>
                <div class="finance-textarea-box">Slide 10 Sudah Valid</div>

                <hr class="border-t border-slate-200 my-6">

                <div class="flex items-center justify-between">
                    <a href="#" class="px-6 py-2 border border-slate-300 bg-white rounded-lg text-xs font-bold flex items-center gap-2 hover:bg-slate-50 transition-colors text-slate-700 shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 6h16v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm4 2a1 1 0 00-1 1v2a1 1 0 001 1h8a1 1 0 001-1V9a1 1 0 00-1-1H6z" clip-rule="evenodd"></path></svg>
                        Preview File
                    </a>
                    <div class="px-8 py-2 border border-green-500 rounded-full font-bold text-[0.8rem] text-green-600 flex items-center gap-2 bg-green-50/50 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> Approved
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================================= SECTION: PANELIS REVIEW ================================= --}}
    <div id="section-panelis" class="tab-section" style="display: none;">
        <div class="section-title mb-2">Panelis Review</div>
        <p class="text-slate-600 mb-6 text-[1rem]">Pengembangan Pusat Informasi Pada PT Tiga Serangkai</p>
        
        <div class="bg-white rounded-xl border border-slate-200 mt-2 shadow-sm overflow-hidden p-0">
            <table class="logbook-table mb-0 border-none">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th style="width: 25%;" class="border-0 border-r border-slate-200">Panelis</th>
                        <th style="width: 25%;" class="border-0 border-r border-slate-200">Perusahaan</th>
                        <th style="width: 10%;" class="border-0 border-r border-slate-200">Skor</th>
                        <th style="width: 10%;" class="border-0 border-r border-slate-200">Feedback</th>
                        <th style="width: 20%;" class="border-0 border-r border-slate-200">Status</th>
                        <th style="width: 10%;" class="border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="border-b border-slate-200">
                        <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">Mahmud S.Kom, M.Kom</td>
                        <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">PT Tiga Serangkai Inti Corpora</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">38/50</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">Baik</td>
                        <td class="border-0 border-r border-slate-200">
                            <div class="font-bold text-slate-800 text-[0.8rem]">Ready in 1 - 2 Years</div>
                            <div class="text-[0.65rem] text-slate-500 mt-1">(Siap dengan pengembangan terarah)</div>
                        </td>
                        <td class="border-0"><a href="#" class="text-blue-600 font-bold hover:underline text-xs">Lihat Detail</a></td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">Mahmud S.Kom, M.Kom</td>
                        <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">PT Tiga Serangkai Pustaka Mandiri</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">38/50</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">Baik</td>
                        <td class="border-0 border-r border-slate-200">
                            <div class="font-bold text-slate-800 text-[0.8rem]">Ready in 1 - 2 Years</div>
                            <div class="text-[0.65rem] text-slate-500 mt-1">(Siap dengan pengembangan terarah)</div>
                        </td>
                        <td class="border-0"><a href="#" class="text-blue-600 font-bold hover:underline text-xs">Lihat Detail</a></td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">Mahmud S.Kom, M.Kom</td>
                        <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">K33 Distribusi</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">38/50</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">Baik</td>
                        <td class="border-0 border-r border-slate-200">
                            <div class="font-bold text-slate-800 text-[0.8rem]">Ready in 1 - 2 Years</div>
                            <div class="text-[0.65rem] text-slate-500 mt-1">(Siap dengan pengembangan terarah)</div>
                        </td>
                        <td class="border-0"><a href="#" class="text-blue-600 font-bold hover:underline text-xs">Lihat Detail</a></td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">Mahmud S.Kom, M.Kom</td>
                        <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">PT Wangsa Jatra Lestari</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">38/50</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">Baik</td>
                        <td class="border-0 border-r border-slate-200">
                            <div class="font-bold text-slate-800 text-[0.8rem]">Ready in 1 - 2 Years</div>
                            <div class="text-[0.65rem] text-slate-500 mt-1">(Siap dengan pengembangan terarah)</div>
                        </td>
                        <td class="border-0"><a href="#" class="text-blue-600 font-bold hover:underline text-xs">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">Mahmud S.Kom, M.Kom</td>
                        <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">Assalam Hypermarket</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">38/50</td>
                        <td class="font-bold text-slate-800 border-0 border-r border-slate-200">Baik</td>
                        <td class="border-0 border-r border-slate-200">
                            <div class="font-bold text-slate-800 text-[0.8rem]">Ready in 1 - 2 Years</div>
                            <div class="text-[0.65rem] text-slate-500 mt-1">(Siap dengan pengembangan terarah)</div>
                        </td>
                        <td class="border-0"><a href="#" class="text-blue-600 font-bold hover:underline text-xs">Lihat Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bottom Back Button --}}
    <div class="flex justify-end mt-8 mb-4">
        <a href="{{ route('pdc_admin.export') }}" class="btn-back-bottom shadow-sm">
            Kembali
        </a>
    </div>

    <x-slot name="scripts">
        <script>
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
                
                // set active tab
                if (element) {
                    element.classList.add('active');
                }
            }
        </script>
    </x-slot>

</x-pdc_admin.layout>
