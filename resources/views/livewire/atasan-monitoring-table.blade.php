<div>
    {{-- Pill Navigation Tabs (top row) --}}
    <div class="w-full mb-6">
        <div class="flex w-full bg-[#e5e7eb] rounded-full p-1">
            <button wire:click="switchSection('kompetensi')" class="flex-1 text-center py-2 px-3 rounded-full text-[13px] transition-all whitespace-nowrap {{ $activeSection === 'kompetensi' ? 'bg-[#0f172a] text-white font-bold shadow-md' : 'bg-transparent font-semibold text-gray-500 hover:text-slate-800 hover:bg-white/50' }}">
                Kompetensi
            </button>
            <button wire:click="switchSection('idp')" class="flex-1 text-center py-2 px-3 rounded-full text-[13px] transition-all whitespace-nowrap {{ $activeSection === 'idp' ? 'bg-[#0f172a] text-white font-bold shadow-md' : 'bg-transparent font-semibold text-gray-500 hover:text-slate-800 hover:bg-white/50' }}">
                IDP Monitoring
            </button>
            <button wire:click="switchSection('project')" class="flex-1 text-center py-2 px-3 rounded-full text-[13px] transition-all whitespace-nowrap {{ $activeSection === 'project' ? 'bg-[#0f172a] text-white font-bold shadow-md' : 'bg-transparent font-semibold text-gray-500 hover:text-slate-800 hover:bg-white/50' }}">
                Project Improvement
            </button>
        </div>
    </div>

    {{-- Centered title block --}}
    <div class="text-center mb-8">
        @php
            // Kumpulkan kombinasi posisi sekarang → posisi tujuan yang unik
            $positionRoutes = $talents->map(function($t) {
                $current = optional($t->position)->position_name ?? '-';
                $target  = optional(optional($t->promotion_plan)->targetPosition)->position_name ?? '-';
                return $current . ' → ' . $target;
            })->unique()->values();
        @endphp

        {{-- Baris 1: Posisi sekarang → Posisi tujuan --}}
        @foreach($positionRoutes as $route)
            <h2 class="text-[1.35rem] font-extrabold text-[#1e293b] leading-snug">
                {{ $route }}
            </h2>
        @endforeach

        {{-- Baris 2: Perusahaan --}}
        <p class="text-[1.20rem] font-extrabold text-[#1e293b] leading-snug mt-1">
            {{ optional($user->company)->nama_company ?? 'Nama Perusahaan' }}
        </p>

        {{-- Baris 3: Jumlah talent --}}
        <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mt-1">{{ $talents->count() }} TALENT</p>
    </div>

    @if($talents->isEmpty())
        <div class="text-center py-20 bg-white border border-gray-200 rounded-xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-700 mb-2">Talent tidak ditemukan</h3>
            <p class="text-gray-500 text-sm">Anda belum memiliki talent untuk dimonitor.</p>
        </div>
    @else

        {{-- KOMPETENSI --}}
        @if($activeSection === 'kompetensi')
            <div class="w-full animate-fade-in">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
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
                                $overrides = $details->filter(fn($d) => str_starts_with($d->notes ?? '', 'priority_'))->sortBy(fn($d) => (int) explode('|', str_replace('priority_', '', $d->notes))[0]);
                                $gaps = $overrides->count() > 0 ? $overrides->values() : $details->sortBy('gap_score')->take(3)->values();
                            }
                        @endphp
                        <div class="talent-card">
                            <div class="talent-header">
                                <div class="talent-info items-center">
                                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) }}" class="talent-photo border border-gray-200" alt="{{ $talent->nama }}">
                                    <div class="talent-meta">
                                        <h4 class="text-xl">{{ $talent->nama }}</h4>
                                        <p class="text-sm">{{ optional($talent->position)->position_name ?? 'Officer' }} - {{ optional($talent->department)->nama_department ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 text-xs font-bold text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <p class="mb-1">MENTOR:
                                    @php
                                        $mIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                                        if (!empty($mIds)) {
                                            echo strtoupper(implode(', ', \App\Models\User::whereIn('id', $mIds)->pluck('nama')->toArray())) ?: '-';
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
                                    <div class="flex items-center"><span class="gap-number shadow-sm">{{ $index + 1 }}</span> {{ $gap->competence->name }}</div>
                                    <span class="font-bold">{{ number_format($gap->gap_score, 1) }}</span>
                                </div>
                            @empty
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="gap-item" style="border: 1px solid #e2e8f0; background: #ffffff; color: #94a3b8;">
                                        <div class="flex items-center"><span class="gap-number" style="background: #cbd5e1; color: white;">{{ $i }}</span> Belum dinilai Atasan</div>
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
                <div class="legend">
                    <span>Keterangan GAP</span>
                    <div class="legend-item"><div class="legend-box" style="background: #f1f5f9; border: 1px solid #e2e8f0;"></div> Sesuai Standar (0)</div>
                    <div class="legend-item"><div class="legend-box" style="background: #f97316;"></div> Gap Kecil (-0.1 s/d -1.5)</div>
                    <div class="legend-item"><div class="legend-box" style="background: #ef4444;"></div> Gap Besar (< -1.5)</div>
                </div>

                <div class="heatmap-container overflow-x-auto shadow-sm">
                    <table class="heatmap-table">
                        <thead>
                            <tr>
                                <th rowspan="2" class="th-main min-w-[200px]">KOMPETENSI</th>
                                <th rowspan="2" class="th-main w-[80px]">STANDAR</th>
                                @foreach ($talents as $talent) <th colspan="4" class="th-main">{{ strtoupper($talent->nama) }}</th> @endforeach
                            </tr>
                            <tr>
                                @foreach ($talents as $talent)
                                    <th class="th-sub w-[60px]">Talent</th><th class="th-sub w-[60px]">Atasan</th><th class="th-sub w-[60px]">Final</th><th class="th-sub w-[60px]">GAP</th>
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
                                            $detail = $talent->assessmentSession ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id) : null;
                                            $scoreTalent = $detail->score_talent ?? 0;
                                            $scoreAtasan = $detail->score_atasan ?? 0;
                                            $gap = $detail->gap_score ?? 0;
                                            $finalScore = ($scoreTalent + $scoreAtasan) / 2;
                                            $cls = $gap == 0 ? 'gap-none' : ($gap < -1.5 ? 'gap-large' : ($gap < 0 ? 'gap-small' : 'gap-ok'));
                                        @endphp
                                        <td>{{ $scoreTalent ?: '-' }}</td><td>{{ $scoreAtasan ?: '-' }}</td><td>{{ $finalScore ?: '-' }}</td>
                                        <td class="p-1"><span class="gap-badge {{ $cls }} shadow-sm">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span></td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr class="font-bold bg-slate-50 border-t-2 border-slate-200">
                                <td class="td-left text-teal-800">Nilai Rata-Rata</td>
                                <td>{{ number_format($standards->avg() ?: 0, 1) }}</td>
                                @foreach ($talents as $talent)
                                    @php
                                        $avgSelf = optional(optional($talent->assessmentSession)->details)->avg('score_talent') ?: 0;
                                        $avgAtasan = optional(optional($talent->assessmentSession)->details)->avg('score_atasan') ?: 0;
                                        $avgGap = optional(optional($talent->assessmentSession)->details)->avg('gap_score') ?: 0;
                                        $cls = $avgGap == 0 ? 'gap-none' : ($avgGap < -1.5 ? 'gap-large' : ($avgGap < 0 ? 'gap-small' : 'gap-ok'));
                                    @endphp
                                    <td>{{ number_format($avgSelf, 1) }}</td><td>{{ number_format($avgAtasan, 1) }}</td><td>{{ number_format(($avgSelf + $avgAtasan) / 2, 1) }}</td>
                                    <td class="p-1"><span class="gap-badge {{ $cls }} shadow-sm">{{ number_format($avgGap, 1) }}</span></td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- IDP --}}
        @if($activeSection === 'idp')
            <div class="w-full flex flex-col gap-6 animate-fade-in">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                    IDP Monitoring
                </div>
                @foreach ($talents as $talent)
                    <div class="idp-card-container bg-white border border-gray-200">
                        <div class="flex items-center gap-4 mb-6 p-2">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random&color=fff&bold=true' }}" class="w-16 h-16 rounded-full border-2 border-white shadow-sm bg-white" alt="">
                            <div>
                                <h4 class="text-xl font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                                <p class="text-sm text-gray-400 italic font-medium">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                            </div>
                        </div>
                        <div class="donut-container !shadow-none !border !border-gray-50 !bg-[#f8fafc]">
                            @php
                                $charts = [
                                    ['label' => 'Exposure', 'done' => min($talent->idpActivities->where('type_idp', 1)->count(), 6), 'total' => 6, 'color' => '#1e293b'],
                                    ['label' => 'Mentoring', 'done' => min($talent->idpActivities->where('type_idp', 2)->count(), 6), 'total' => 6, 'color' => '#f59e0b'],
                                    ['label' => 'Learning', 'done' => min($talent->idpActivities->where('type_idp', 3)->count(), 6), 'total' => 6, 'color' => '#0f766e']
                                ];
                                $r = 38;
                                $circ = 2 * M_PI * $r;
                            @endphp
                            @foreach($charts as $chart)
                                @php $pct = $chart['done'] / $chart['total'];
                                    $filled = $pct * $circ;
                                $empty = $circ - $filled; @endphp
                                <div class="flex flex-col items-center justify-center gap-4 w-1/3">
                                    <div class="relative w-40 h-40 drop-shadow-md">
                                        <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                            <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#e2e8f0" stroke-width="12" />
                                            <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}" stroke-width="12" stroke-linecap="round" stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" style="transition: stroke-dasharray 0.8s ease;" />
                                        </svg>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center pt-1">
                                            <span class="text-[32px] font-extrabold" style="color: {{ $chart['color'] }}">{{ round($pct * 100) }}%</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('atasan.monitoring.logbook', ['talentId' => $talent->id, 'tab' => strtolower($chart['label'])]) }}" class="inline-flex items-center justify-center gap-2 text-white text-[14px] font-bold px-7 py-2 rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-md" style="background-color: {{ $chart['color'] }}">
                                        <span>{{ $chart['label'] }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
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
        @if($activeSection === 'project')
            <div class="w-full animate-fade-in">
                <div class="section-title">Project Improvement</div>
                <div class="flex flex-col gap-6 w-full mb-8">
                    @foreach ($talents as $talent)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm overflow-hidden block">
                            <div class="flex items-center gap-4 mb-6">
                                <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) }}" class="w-14 h-14 rounded-full border border-gray-200 shadow-sm" alt="">
                                <div><h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4><p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p></div>
                            </div>
                            <div class="rounded-xl overflow-hidden border border-gray-200">
                                <table class="w-full text-left bg-white">
                                    <thead class="bg-slate-50 border-b border-gray-200">
                                        <tr>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 w-[50%]">Judul Project Improvement</th>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">File</th>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($talent->improvementProjects as $proj)
                                            <tr class="border-b border-gray-100 hover:bg-slate-50/50 transition duration-150">
                                                <td class="py-4 px-6 font-bold text-sm text-slate-800">{{ $proj->title }}</td>
                                                <td class="py-4 px-6 text-center">
                                                    <a href="{{ route('files.preview', ['path' => $proj->document_path]) }}" class="inline-flex items-center gap-1.5 text-teal-600 hover:text-teal-700 hover:bg-teal-50 px-3 py-1.5 rounded-lg transition-colors font-bold text-xs" target="_blank">LIHAT</a>
                                                </td>
                                                <td class="py-4 px-6 text-center">
                                                    <div class="inline-flex items-center gap-2 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full">
                                                        @if(in_array($proj->status, ['Approved', 'Approve']))
                                                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                                            <span class="font-bold text-xs uppercase text-slate-700">Approved</span>
                                                        @elseif(in_array($proj->status, ['Rejected', 'Reject']))
                                                            <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                                            <span class="font-bold text-xs uppercase text-slate-700">Rejected</span>
                                                        @else
                                                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                                                            <span class="font-bold text-xs uppercase text-slate-700">Pending</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-gray-400 py-8 text-center italic text-sm">Belum ada project improvement.</td></tr>
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
        @if($activeSection === 'logbook')
            <div class="w-full animate-fade-in">
                <div class="section-title">LogBook</div>
                <div class="filter-pills bg-slate-100 p-1.5 mb-8 w-fit mx-auto lg:mx-0 rounded-full border border-slate-200">
                    <button wire:click="filterLog(1)" class="pill {{ $activeLogbookType === 1 ? 'active bg-slate-900 text-white' : 'hover:bg-slate-200' }}">Exposure</button>
                    <button wire:click="filterLog(2)" class="pill {{ $activeLogbookType === 2 ? 'active bg-slate-900 text-white' : 'hover:bg-slate-200' }}">Mentoring</button>
                    <button wire:click="filterLog(3)" class="pill {{ $activeLogbookType === 3 ? 'active bg-slate-900 text-white' : 'hover:bg-slate-200' }}">Learning</button>
                </div>

                <div class="flex flex-col gap-6 w-full mb-8">
                    @foreach ($talents as $talent)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm overflow-hidden block">
                            <div class="flex items-center gap-4 mb-6">
                                <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) }}" class="w-14 h-14 rounded-full border border-slate-200" alt="">
                                <div>
                                    <h4 class="text-xl font-extrabold text-slate-800">{{ $talent->nama }}</h4>
                                    <p class="text-sm text-gray-500 font-medium">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                                </div>
                            </div>

                            <div class="log-table-container custom-scrollbar overflow-x-auto border border-slate-200 rounded-xl">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50 border-b border-slate-200">
                                        <tr>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">{{ $activeLogbookType === 3 ? 'Sumber' : 'Mentor' }}</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Tema</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Tgl Update</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Tgl Pelaksanaan</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Status</th>
                                            <th class="py-4 px-6 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($talent->idpActivities->where('type_idp', $activeLogbookType) as $act)
                                            <tr class="border-b border-gray-100 hover:bg-slate-50/50 transition duration-150">
                                                <td class="py-4 px-6 text-center text-sm font-bold text-slate-800">{{ $activeLogbookType === 3 ? $act->activity : ($act->verifier->nama ?? '-') }}</td>
                                                <td class="py-4 px-6 text-center text-sm font-semibold text-slate-800" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                                <td class="py-4 px-6 text-center text-sm font-medium text-slate-800 whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                                <td class="py-4 px-6 text-center">
                                                    @if(in_array($act->status, ['Approve', 'Approved', 'Verified']))
                                                        <span class="inline-flex items-center gap-1.5 text-emerald-700 text-xs font-bold bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ in_array($act->status, ['Approve', 'Approved']) ? 'Approved' : 'Verified' }}</span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 text-amber-700 text-xs font-bold bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ $act->status ?: 'Pending' }}</span>
                                                        <span class="inline-flex items-center gap-1.5 text-amber-700 text-xs font-bold bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 text-center">
                                                    <button type="button" onclick="openLogbookDetail(this)" class="inline-flex items-center gap-1.5 font-bold text-xs bg-slate-100 text-slate-600 px-3 py-2 rounded-lg hover:bg-slate-200 transition-colors border border-slate-200">INFO</button>
                                                    <div class="hidden">
                                                        <div class="space-y-4 text-left">
                                                            <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">{{ $activeLogbookType === 3 ? 'Sumber' : 'Mentor' }}</span><div class="text-[14px] font-bold text-slate-800">{{ $activeLogbookType === 3 ? $act->activity : ($act->verifier->nama ?? '-') }}</div></div>
                                                            <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Tema</span><div class="text-[14px] font-bold text-slate-800">{{ $act->theme }}</div></div>
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Tanggal</span><div class="text-[14px] font-bold text-slate-800">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</div></div>
                                                                <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Lokasi/Platform</span><div class="text-[14px] font-bold text-slate-800">{{ $act->location ?? $act->platform ?? '-' }}</div></div>
                                                            </div>
                                                            <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Aktivitas</span><div class="text-[14px] font-medium text-slate-700">{{ $act->activity ?? '-' }}</div></div>
                                                            <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Deskripsi</span><div class="text-[14px] font-medium text-slate-700 leading-relaxed">{{ $act->description ?? '-' }}</div></div>
                                                            @if($activeLogbookType === 2)
                                                                <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl"><span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-1">Action Plan</span><div class="text-[14px] font-medium text-slate-700 leading-relaxed">{{ $act->action_plan ?? '-' }}</div></div>
                                                            @endif
                                                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                                                <span class="block text-[11px] font-extrabold text-slate-400 tracking-wider uppercase mb-2">Dokumentasi</span>
                                                                @php
                                                                    $dPaths = [];
                                                                    $dNames = [];
                                                                    if ($act->document_path) {
                                                                        if (str_starts_with($act->document_path, '["')) {
                                                                            $dPaths = json_decode($act->document_path, true);
                                                                            $dNames = explode(', ', $act->file_name);
                                                                        } else {
                                                                            $dPaths = [$act->document_path];
                                                                            $dNames = [$act->file_name];
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(count($dPaths) > 0)
                                                                    <div class="flex flex-col gap-2">
                                                                        @foreach($dPaths as $di => $dp)
                                                                            <a href="{{ route('files.preview', ['path' => $dp]) }}" target="_blank" class="text-sm font-bold text-teal-600 hover:text-teal-700 hover:underline flex items-center gap-2 p-2 bg-white rounded-lg border border-slate-200 shadow-sm">{{ $dNames[$di] ?? 'Dokumen' }}</a>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-slate-400 text-sm font-medium italic">Tidak ada dokumen</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="py-12 px-6 text-center text-slate-400 italic">Belum ada aktivitas yang dicatat.</td></tr>
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
