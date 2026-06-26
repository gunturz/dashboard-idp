<div>
    {{-- Pill Navigation Tabs (top row) --}}
    <div class="pill-nav-wrapper mb-6">
        <div class="pill-nav-tabs">
            <button wire:click="switchSection('kompetensi')"
                class="pill-tab {{ $activeSection === 'kompetensi' ? 'active' : '' }}">
                Kompetensi
            </button>
            <button wire:click="switchSection('idp')"
                class="pill-tab {{ in_array($activeSection, ['idp', 'logbook']) ? 'active' : '' }}">
                IDP Monitoring
            </button>
            <button wire:click="switchSection('project')"
                class="pill-tab {{ $activeSection === 'project' ? 'active' : '' }}">
                Project Improvement
            </button>
        </div>
    </div>
    {{-- Centered title block --}}
    <div class="text-center mb-8">
        @php
            $headerTalent = $talents->first();
            $headerRoute = $headerTalent
                ? (optional($headerTalent->position)->position_name ?? '-') .
                    ' → ' .
                    (optional(optional($headerTalent->promotion_plan)->targetPosition)->position_name ?? '-')
                : '- → -';
        @endphp

        {{-- Baris 1: Posisi sekarang → Posisi tujuan --}}
        <h2 class="text-[1.35rem] font-extrabold text-[#1e293b] leading-snug">
            {{ $headerRoute }}
        </h2>

        {{-- Baris 2: Perusahaan --}}
        <p class="text-[1.20rem] font-extrabold text-[#1e293b] leading-snug mt-1">
            {{ optional($user->company)->nama_company ?? 'Nama Perusahaan' }}
        </p>

        {{-- Baris 3: Jumlah talent --}}
        <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mt-1">{{ $talents->count() }}
            TALENT</p>
    </div>

    @if ($talents->isEmpty())
        <div class="text-center py-20 bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mb-5"
                style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-teal-600" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-700 mb-0">Belum Ada Talent</h3>
            <p class="text-sm text-gray-500 mt-1 max-w-sm leading-relaxed">Belum ada talent yang tersedia
                untuk dimonitor saat ini.</p>
        </div>
    @else
        {{-- KOMPETENSI --}}
        @if ($activeSection === 'kompetensi')
            <div class="w-full animate-fade-in">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-slate-800">
                        <path fill-rule="evenodd"
                            d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                    Kompetensi
                </div>

                <div class="flex items-center gap-2 text-base font-extrabold text-slate-600 mb-4 mt-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-slate-800">
                        <path fill-rule="evenodd"
                            d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                            clip-rule="evenodd" />
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
                                $overrides = $details
                                    ->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))
                                    ->sortBy(fn($d) => (int) explode('|', str_replace('priority_', '', $d->notes))[0]);
                                $gaps =
                                    $overrides->count() > 0
                                        ? $overrides->values()
                                        : $details->sortBy('gap_score')->take(3)->values();
                            }
                        @endphp
                        <div class="talent-card">
                            <div class="talent-header">
                                <div class="talent-info items-center">
                                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) }}"
                                        class="talent-photo border border-gray-200" alt="{{ $talent->nama }}">
                                    <div class="talent-meta">
                                        <h4 class="text-xl">{{ $talent->nama }}</h4>
                                        <p class="text-sm">{{ optional($talent->position)->position_name ?? 'Officer' }}
                                            - {{ optional($talent->department)->nama_department ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-4 text-xs font-bold text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <p class="mb-1">MENTOR:
                                    @php
                                        $mIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                                        if (!empty($mIds)) {
                                            echo strtoupper(
                                                implode(
                                                    ', ',
                                                    \App\Models\User::whereIn('id', $mIds)->pluck('nama')->toArray(),
                                                ),
                                            ) ?:
                                                '-';
                                        } else {
                                            echo strtoupper($talent->mentor->nama ?? '-');
                                        }
                                    @endphp
                                </p>
                                <p>ATASAN: <span class="text-teal-700">{{ strtoupper($user->nama ?? '-') }}</span></p>
                            </div>

                            <span class="top-gap-label">TOP 3 GAP</span>
                            @forelse($gaps as $index => $gap)
                                <div class="gap-item prio-{{ $index + 1 }}">
                                    <div class="flex items-center"><span
                                            class="gap-number shadow-sm">{{ $index + 1 }}</span>
                                        {{ $gap->competence->name }}</div>
                                    <span class="font-bold">{{ number_format($gap->gap_score, 1) }}</span>
                                </div>
                            @empty
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="gap-item"
                                        style="border: 1px solid #e2e8f0; background: #ffffff; color: #94a3b8;">
                                        <div class="flex items-center"><span class="gap-number"
                                                style="background: #cbd5e1; color: white;">{{ $i }}</span>
                                            Belum dinilai Atasan</div>
                                        <span>-</span>
                                    </div>
                                @endfor
                            @endforelse
                        </div>
                    @endforeach
                </div>

                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                            clip-rule="evenodd" />
                    </svg>
                    Heatmap Kompetensi
                </div>
                <div class="legend flex-wrap">
                    <span>KETERANGAN GAP</span>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #6293ffff;"></div> Di Atas Standar (> 0)
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #f1f5f9; border: 1px solid #e2e8f0;"></div> Sesuai
                        Standar (0)
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #f97316;"></div> Gap Kecil (-0.1 s/d -1.5)
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #ef4444;"></div> Gap Besar (< -1.5) </div>
                    </div>

                    <div class="heatmap-container overflow-x-auto shadow-sm">
                        <table class="heatmap-table">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="th-main min-w-[200px]">Kompetensi</th>
                                    <th rowspan="2" class="th-main w-[80px]">Standar</th>
                                    @foreach ($talents as $talent)
                                        <th colspan="4" class="th-main">{{ ucwords(strtolower($talent->nama)) }}
                                        </th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($talents as $talent)
                                        <th class="th-sub" style="min-width:100px">Skor Talent</th>
                                        <th class="th-sub" style="min-width:100px">Skor Atasan</th>
                                        <th class="th-sub" style="min-width:100px">Final Score</th>
                                        <th class="th-sub" style="min-width:80px">GAP</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($competencies as $comp)
                                    @php $standard = $standards[$comp->id] ?? 0; @endphp
                                    <tr>
                                        <td class="td-left">{{ $comp->name }}</td>
                                        <td class="font-bold">{{ number_format((float) $standard, 1) }}</td>
                                        @foreach ($talents as $talent)
                                            @php
                                                $detail = $talent->assessmentSession
                                                    ? $talent->assessmentSession->details->firstWhere(
                                                        'competence_id',
                                                        $comp->id,
                                                    )
                                                    : null;
                                                $scoreTalent = $detail->score_talent ?? 0;
                                                $scoreAtasan = $detail->score_atasan ?? 0;
                                                $gap = $detail->gap_score ?? 0;
                                                $finalScore = ($scoreTalent + $scoreAtasan) / 2;
                                                $cls =
                                                    $gap == 0
                                                        ? 'gap-none'
                                                        : ($gap < -1.5
                                                            ? 'gap-large'
                                                            : ($gap < 0
                                                                ? 'gap-small'
                                                                : 'gap-ok'));
                                            @endphp
                                            <td>{{ $scoreTalent ?: '-' }}</td>
                                            <td>{{ $scoreAtasan ?: '-' }}</td>
                                            <td>{{ $finalScore ?: '-' }}</td>
                                            <td class="p-1"><span
                                                    class="gap-badge {{ $cls }} shadow-sm">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr class="font-bold bg-[#f1f5f9] border-t-2 border-slate-200">
                                    <td class="td-left text-teal-800">Nilai Rata-Rata</td>
                                    <td>{{ number_format($standards->avg() ?: 0, 1) }}</td>
                                    @foreach ($talents as $talent)
                                        @php
                                            $avgSelf =
                                                optional(optional($talent->assessmentSession)->details)->avg(
                                                    'score_talent',
                                                ) ?:
                                                0;
                                            $avgAtasan =
                                                optional(optional($talent->assessmentSession)->details)->avg(
                                                    'score_atasan',
                                                ) ?:
                                                0;
                                            $avgGap =
                                                optional(optional($talent->assessmentSession)->details)->avg(
                                                    'gap_score',
                                                ) ?:
                                                0;
                                        @endphp
                                        <td>{{ number_format($avgSelf, 1) }}</td>
                                        <td>{{ number_format($avgAtasan, 1) }}</td>
                                        <td>{{ number_format(($avgSelf + $avgAtasan) / 2, 1) }}</td>
                                        <td class="p-1 text-center font-bold text-[#1e293b]">
                                            {{ number_format($avgGap, 1) }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        @endif

        {{-- IDP --}}
        @if ($activeSection === 'idp')
            <div class="w-full flex flex-col gap-6 animate-fade-in">
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
                @foreach ($talents as $talent)
                    <div class="idp-card-container border border-slate-200" style="background:#f8fafc;">
                        <div class="flex items-center gap-4 mb-6 p-2">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random&color=fff&bold=true' }}"
                                class="w-16 h-16 rounded-full border-2 border-white shadow-sm bg-white"
                                alt="">
                            <div>
                                <h4 class="text-xl font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                                <p class="text-sm text-gray-400 italic font-medium">
                                    {{ optional($talent->position)->position_name }} -
                                    {{ optional($talent->department)->nama_department }}</p>
                            </div>
                        </div>
                        <div class="donut-container mt-4">
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
                                                'bg-slate-700 hover:bg-slate-800 shadow-[0_4px_14px_rgba(51,65,85,0.25)] hover:shadow-lg',
                                        ],
                                        'Mentoring' => [
                                            'done' => min($mentoringCount ?? 0, 6),
                                            'total' => 6,
                                            'from' => '#f59e0b',
                                            'to' => '#f59e0b',
                                            'id' => 'grad-mentoring',
                                            'btn_color' =>
                                                'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_14px_rgba(245,158,11,0.28)] hover:shadow-lg',
                                        ],
                                        'Learning' => [
                                            'done' => min($learningCount ?? 0, 6),
                                            'total' => 6,
                                            'from' => '#0d9488',
                                            'to' => '#0d9488',
                                            'id' => 'grad-learning',
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
                                                    <linearGradient id="{{ $d['id'] }}" x1="0%"
                                                        y1="0%" x2="100%" y2="100%">
                                                        <stop offset="0%" stop-color="{{ $d['from'] }}" />
                                                        <stop offset="100%" stop-color="{{ $d['to'] }}" />
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="50" cy="50" r="{{ $r }}"
                                                    fill="none" stroke="#f1f5f9" stroke-width="10" />
                                                <circle cx="50" cy="50" r="{{ $r }}"
                                                    fill="none" stroke="url(#{{ $d['id'] }})" stroke-width="10"
                                                    stroke-linecap="round"
                                                    stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                                    style="transition: stroke-dasharray 0.8s ease;" />
                                            </svg>
                                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                                <span class="text-2xl font-extrabold text-[#1e293b]">{{ round($pct * 100) }}%</span>
                                                <span class="text-xs font-bold text-gray-400">{{ $d['done'] }}/{{ $d['total'] }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('atasan.monitoring.logbook', ['talentId' => $talent->id, 'tab' => strtolower($label)]) }}"
                                            class="{{ $d['btn_color'] }} text-white px-8 py-2 rounded-[10px] transition-all flex items-center justify-center gap-2 group active:scale-95 hover:-translate-y-0.5 cursor-pointer"
                                            title="Lihat logbook {{ $label }}">
                                            <span class="text-sm font-bold tracking-wide">{{ $label }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 relative transition-transform group-hover:translate-x-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- PROJECT --}}
        @if ($activeSection === 'project')
            <div class="w-full animate-fade-in">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M19.5 6h-6.879a1.5 1.5 0 0 1-1.06-.44l-.622-.62A1.5 1.5 0 0 0 9.88 4.5H6A2.25 2.25 0 0 0 3.75 6.75v10.5A2.25 2.25 0 0 0 6 19.5h13.5a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 19.5 6Z" />
                    </svg>
                    Project Improvement
                </div>
                <div class="flex flex-col gap-6 w-full mb-8">
                    @foreach ($talents as $talent)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm overflow-hidden block">
                            <div class="flex items-center gap-4 mb-6">
                                <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) }}"
                                    class="w-14 h-14 rounded-full border border-gray-200 shadow-sm" alt="">
                                <div>
                                    <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                                    <p class="text-xs text-gray-400 italic">
                                        {{ optional($talent->position)->position_name }} -
                                        {{ optional($talent->department)->nama_department }}</p>
                                </div>
                            </div>
                            <div class="rounded-xl overflow-x-auto border border-gray-200 custom-scrollbar">
                                <table class="w-full min-w-[700px] table-auto text-left bg-white">
                                    <thead class="bg-slate-50 border-b border-gray-200">
                                        <tr>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-[50%]">
                                                Judul
                                                Project Improvement</th>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">File
                                            </th>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($talent->improvementProjects as $proj)
                                            <tr
                                                class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-left">
                                                    {{ $proj->title }}
                                                    <div class="text-xs text-gray-400 font-normal mt-0.5">
                                                        {{ \Carbon\Carbon::parse($proj->created_at)->locale('id')->translatedFormat('d F Y') }}
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-center w-48">
                                                    @if ($proj->document_path)
                                                        <a href="{{ route('files.preview', ['path' => $proj->document_path]) }}"
                                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all"
                                                            target="_blank" title="Lihat/Download File Project">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3.5 w-3.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
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
                                                        $projectStatus =
                                                            $proj->status === 'Verified' ? 'Approved' : $proj->status;
                                                    @endphp
                                                    @if ($projectStatus === 'Approved')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                            Approved
                                                        </span>
                                                    @elseif($projectStatus === 'Rejected')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                            Rejected
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1.5 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                            <span
                                                                class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3"
                                                    class="text-gray-400 py-8 text-center italic text-sm">Belum ada
                                                    project improvement.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- LOGBOOK --}}
        @if ($activeSection === 'logbook')
            <div class="w-full animate-fade-in">
                <div class="section-title">LogBook</div>
                <div
                    class="filter-pills bg-slate-100 p-1.5 mb-8 w-fit mx-auto lg:mx-0 rounded-full border border-slate-200">
                    <button wire:click="filterLog(1)"
                        class="pill {{ $activeLogbookType === 1 ? 'active bg-slate-900 text-white' : 'hover:bg-slate-200' }}">Exposure</button>
                    <button wire:click="filterLog(2)"
                        class="pill {{ $activeLogbookType === 2 ? 'active bg-slate-900 text-white' : 'hover:bg-slate-200' }}">Mentoring</button>
                    <button wire:click="filterLog(3)"
                        class="pill {{ $activeLogbookType === 3 ? 'active bg-slate-900 text-white' : 'hover:bg-slate-200' }}">Learning</button>
                </div>

                <div class="flex flex-col gap-6 w-full mb-8">
                    @foreach ($talents as $talent)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm overflow-hidden block">
                            <div class="flex items-center gap-4 mb-6">
                                <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) }}"
                                    class="w-14 h-14 rounded-full border border-slate-200" alt="">
                                <div>
                                    <h4 class="text-xl font-extrabold text-slate-800">{{ $talent->nama }}</h4>
                                    <p class="text-sm text-gray-500 font-medium">
                                        {{ optional($talent->position)->position_name }} -
                                        {{ optional($talent->department)->nama_department }}</p>
                                </div>
                            </div>

                            <div
                                class="log-table-container custom-scrollbar overflow-x-auto border border-slate-200 rounded-xl">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50 border-b border-slate-200">
                                        <tr>
                                            <th
                                                class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">
                                                {{ $activeLogbookType === 3 ? 'Sumber' : 'Mentor' }}</th>
                                            <th
                                                class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">
                                                Tema</th>
                                            <th
                                                class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">
                                                Tgl Update</th>
                                            <th
                                                class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">
                                                Tgl Pelaksanaan</th>
                                            <th
                                                class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">
                                                Status</th>
                                            <th
                                                class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($talent->idpActivities->where('type_idp', $activeLogbookType) as $act)
                                            <tr
                                                class="border-b border-gray-100 hover:bg-slate-50/50 transition duration-150">
                                                <td class="py-4 px-6 text-center text-sm font-bold text-slate-800">
                                                    {{ $activeLogbookType === 3 ? $act->activity : $act->verifier->nama ?? '-' }}
                                                </td>
                                                <td class="py-4 px-6 text-center text-sm font-semibold text-slate-800"
                                                    style="min-width: 15rem">
                                                    {{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                                <td
                                                    class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                    {{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->locale('id')->translatedFormat('d F Y') : '-' }}
                                                </td>
                                                <td
                                                    class="py-4 px-6 text-center text-sm font-medium text-slate-800 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($act->activity_date)->locale('id')->translatedFormat('d F Y') }}
                                                </td>
                                                <td class="py-4 px-6 text-center">
                                                    @if (in_array($act->status, ['Approve', 'Approved', 'Verified']))
                                                        <span
                                                            class="inline-flex items-center gap-1.5 text-emerald-700 text-xs font-bold bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200"><span
                                                                class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                            {{ in_array($act->status, ['Approve', 'Approved']) ? 'Approved' : 'Verified' }}</span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1.5 text-amber-700 text-xs font-bold bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200"><span
                                                                class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                            Pending</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 text-center">
                                                    <button type="button" onclick="openLogbookDetail(this)"
                                                        class="inline-flex items-center gap-1.5 font-bold text-xs bg-slate-100 text-slate-600 px-3 py-2 rounded-lg hover:bg-slate-200 transition-colors border border-slate-200">INFO</button>
                                                    <div class="hidden">
                                                        <div class="space-y-4 text-left">
                                                            <div
                                                                class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                <span
                                                                    class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">{{ $activeLogbookType === 3 ? 'Sumber' : 'Mentor' }}</span>
                                                                <div class="text-[14px] font-bold text-slate-800">
                                                                    {{ $activeLogbookType === 3 ? $act->activity : $act->verifier->nama ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                <span
                                                                    class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Tema</span>
                                                                <div class="text-[14px] font-bold text-slate-800">
                                                                    {{ $act->theme }}</div>
                                                            </div>
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div
                                                                    class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                    <span
                                                                        class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Tanggal</span>
                                                                    <div class="text-[14px] font-bold text-slate-800">
                                                                        {{ \Carbon\Carbon::parse($act->activity_date)->locale('id')->translatedFormat('d F Y') }}
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                    <span
                                                                        class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Lokasi/Platform</span>
                                                                    <div class="text-[14px] font-bold text-slate-800">
                                                                        {{ $act->location ?? ($act->platform ?? '-') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                <span
                                                                    class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Aktivitas</span>
                                                                <div class="text-[14px] font-medium text-slate-700">
                                                                    {{ $act->activity ?? '-' }}</div>
                                                            </div>
                                                            <div
                                                                class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                <span
                                                                    class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Deskripsi</span>
                                                                <div
                                                                    class="text-[14px] font-medium text-slate-700 leading-relaxed">
                                                                    {{ $act->description ?? '-' }}</div>
                                                            </div>
                                                            @if ($activeLogbookType === 2)
                                                                <div
                                                                    class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                                                                    <span
                                                                        class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Action
                                                                        Plan</span>
                                                                    <div
                                                                        class="text-[14px] font-medium text-slate-700 leading-relaxed">
                                                                        {{ $act->action_plan ?? '-' }}</div>
                                                                </div>
                                                            @endif
                                                            <div
                                                                class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                                                <span
                                                                    class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-2">Dokumentasi</span>
                                                                @php
                                                                    $dPaths = [];
                                                                    $dNames = [];
                                                                    if ($act->document_path) {
                                                                        if (
                                                                            str_starts_with($act->document_path, '["')
                                                                        ) {
                                                                            $dPaths = json_decode(
                                                                                $act->document_path,
                                                                                true,
                                                                            );
                                                                            $dNames = explode(', ', $act->file_name);
                                                                        } else {
                                                                            $dPaths = [$act->document_path];
                                                                            $dNames = [$act->file_name];
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if (count($dPaths) > 0)
                                                                    <div class="flex flex-col gap-2">
                                                                        @foreach ($dPaths as $di => $dp)
                                                                            <a href="{{ route('files.preview', ['path' => $dp]) }}"
                                                                                target="_blank"
                                                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    class="h-3.5 w-3.5 flex-shrink-0"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke="currentColor">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                                                    </path>
                                                                                </svg>
                                                                                {{ $dNames[$di] ?? 'Dokumen' }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span
                                                                        class="text-slate-400 text-sm font-medium italic">Tidak
                                                                        ada dokumen</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6"
                                                    class="py-12 px-6 text-center text-slate-400 italic">Belum ada
                                                    aktivitas yang dicatat.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
