<div>
    <div id="gap-modal" class="modal-overlay" onclick="closeModalOnOutside(event)">
        <div class="modal-content">
            <h3 class="modal-title">Pilih 3 GAP Prioritas IDP</h3>
            <p id="modal-talent-name" class="modal-subtitle">Nama Talent</p>

            <div class="alert-info-modal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Sistem menampilkan Top 3 GAP terbesar otomatis. PDC dapat mengubah sesuai konteks
                    strategis.</span>
            </div>

            <div id="modal-gap-list" class="gap-selection-list">
                <!-- Will be populated by JS -->
            </div>

            <label class="textarea-label">Alasan Mengesampingkan</label>
            <textarea class="modal-textarea"
                placeholder="cth: Leadership diprioritaskan karena kandidat akan acting sebagai PIC proyek..."></textarea>

            <div class="modal-footer">
                <button class="btn-modal btn-reset-auto flex items-center gap-2" onclick="resetGapToAuto()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Auto
                </button>
                <button class="btn-modal btn-cancel" onclick="closeGapModal()">Batal</button>
                <button class="btn-modal btn-save" id="btn-save-gap" onclick="saveTopGaps(this)">Simpan</button>
            </div>
        </div>
    </div>

    {{-- ── Page Header ── --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                <path fill-rule="evenodd"
                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-[#1f2937]">Detail Talent</h1>
            <p class="text-[13px] font-medium text-gray-500 mt-1">Informasi lengkap dan rekap perkembangan talent</p>
        </div>
    </div>

    <div class="mb-6 animate-title">
        {{-- Pill Navigation Tabs (top row) --}}
        <div class="pill-nav-wrapper mb-6">
            <div class="pill-nav-tabs">
                <div class="pill-tab {{ $activeTab === 'kompetensi' ? 'active' : '' }}" id="pill-kompetensi"
                    wire:click="setTab('kompetensi')">Kompetensi
                </div>
                <div class="pill-tab {{ str_starts_with($activeTab, 'idp') || $activeTab === 'logbook' ? 'active' : '' }}"
                    id="pill-idp" wire:click="setTab('idp')">IDP Monitoring</div>
                <div class="pill-tab {{ $activeTab === 'project' ? 'active' : '' }}" id="pill-project"
                    wire:click="setTab('project')">Project Improvement
                </div>
            </div>
        </div>

        {{-- Centered title block --}}
        <div class="text-center mb-8">
            <h2 class="text-xl font-extrabold text-[#1e293b]">{{ $targetPosition->position_name }} –
                {{ $company->nama_company }}</h2>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">{{ $talents->count() }} TALENT</p>
        </div>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    @if ($activeTab === 'kompetensi')
        <div id="section-kompetensi">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                        clip-rule="evenodd" />
                </svg>
                Kompetensi
            </div>

            <div class="sub-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
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
                        $gaps = collect();
                        if ($details) {
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
                    <div class="talent-card">
                        <div class="talent-header">
                            <div class="talent-info">
                                <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                                    class="talent-photo" alt="{{ $talent->nama }}">
                                <div class="talent-meta">
                                    <h4>{{ $talent->nama }}</h4>
                                    <p>{{ optional($talent->position)->position_name ?? 'Officer' }} -
                                        {{ optional($talent->department)->nama_department ?? '-' }}</p>
                                </div>
                            </div>
                            <button class="btn-pilih-gap" data-talent-name="{{ $talent->nama }}"
                                data-idx="{{ $loop->index }}"
                                onclick="openGapModal(this.dataset.talentName, allTalentGaps[this.dataset.idx])">Pilih 3
                                GAP</button>
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
                            <p>ATASAN : {{ strtoupper($talent->atasan->nama ?? '-') }}</p>
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
                                <div class="gap-item"
                                    style="border: 1px solid #e2e8f0; background: #f8fafc; color: #94a3b8;">
                                    <div class="flex items-center">
                                        <span class="gap-number"
                                            style="background: #cbd5e1;">{{ $i }}</span>
                                        -
                                    </div>
                                    <span>0</span>
                                </div>
                            @endfor
                        @endforelse
                    </div>
                @endforeach
            </div>

            <div class="sub-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z"
                        clip-rule="evenodd" />
                </svg>
                Heatmap Kompetensi
            </div>

            <div class="legend flex-wrap">
                <span>Keterangan GAP</span>
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
                                    <td>{{ number_format((float) $standard, 1) }}</td>
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
                                            $cls = 'gap-ok';
                                            if ($gap == 0) {
                                                $cls = 'gap-none';
                                            } elseif ($gap < -1.5) {
                                                $cls = 'gap-large';
                                            } elseif ($gap < 0) {
                                                $cls = 'gap-small';
                                            }
                                        @endphp
                                        <td>{{ $scoreTalent ?: '-' }}</td>
                                        <td>{{ $scoreAtasan ?: '-' }}</td>
                                        <td>{{ $finalScore ?: '-' }}</td>
                                        <td class="p-1"><span
                                                class="gap-badge {{ $cls }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            {{-- Nilai Rata-rata --}}
                            <tr class="font-bold bg-gray-50">
                                <td class="td-left">Nilai Rata-Rata</td>
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
                                            optional(optional($talent->assessmentSession)->details)->avg('gap_score') ?:
                                            0;
                                    @endphp
                                    <td>{{ number_format($avgSelf, 1) }}</td>
                                    <td>{{ number_format($avgAtasan, 1) }}</td>
                                    <td>{{ number_format(($avgSelf + $avgAtasan) / 2, 1) }}</td>
                                    <td class="p-1">
                                        @php
                                            $cls = 'gap-ok';
                                            if ($avgGap == 0) {
                                                $cls = 'gap-none';
                                            } elseif ($avgGap < -1.5) {
                                                $cls = 'gap-large';
                                            } elseif ($avgGap < 0) {
                                                $cls = 'gap-small';
                                            }
                                        @endphp
                                        <span
                                            class="gap-badge {{ $cls }}">{{ number_format($avgGap, 1) }}</span>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ================================= SECTION: IDP ================================= --}}
    @endif

    @if ($activeTab === 'idp' || $activeTab === 'logbook')
        <div id="section-idp">
            {{-- SECTION TITLE --}}
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
            @foreach ($talents as $talent)
                <div class="idp-card-container">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                            class="w-14 h-14 rounded-full" alt="">
                        <div>
                            <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                            <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} -
                                {{ optional($talent->department)->nama_department }}</p>
                        </div>
                    </div>

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
                                    'id' => 'grad-exposure',
                                    'btn_color' =>
                                        'bg-slate-700 shadow-[0_4px_12px_-2px_rgba(51,65,85,0.4)] hover:shadow-lg',
                                ],
                                'Mentoring' => [
                                    'done' => min($mentoringCount ?? 0, 6),
                                    'total' => 6,
                                    'from' => '#f59e0b',
                                    'to' => '#f59e0b',
                                    'id' => 'grad-mentoring',
                                    'btn_color' =>
                                        'bg-amber-500 shadow-[0_4px_12px_-2px_rgba(245,158,11,0.4)] hover:shadow-lg',
                                ],
                                'Learning' => [
                                    'done' => min($learningCount ?? 0, 6),
                                    'total' => 6,
                                    'from' => '#0d9488',
                                    'to' => '#0d9488',
                                    'id' => 'grad-learning',
                                    'btn_color' =>
                                        'bg-teal-600 shadow-[0_4px_12px_-2px_rgba(13,148,136,0.4)] hover:shadow-lg',
                                ],
                            ];
                            $r = 38;
                            $circ = 2 * M_PI * $r; // ≈ 238.76
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
                                            stroke="url(#{{ $d['id'] }})" stroke-width="10"
                                            stroke-linecap="round"
                                            stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                            style="transition: stroke-dasharray 0.8s ease;" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-2xl font-extrabold text-[#1e293b]">{{ round($pct * 100) }}%</span>
                                        <span class="text-xs font-bold text-gray-400">{{ $d['done'] }}/{{ $d['total'] }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('pdc_admin.talent.logbook', $talent->id) }}#{{ strtolower($label) }}"
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
            @endforeach
        </div>

        {{-- Modal Update Status Project Improvement --}}
        <div id="update-status-modal" class="modal-overlay" onclick="closeStatusModalOnOutside(event)">
            <div class="modal-content" style="max-width:480px; padding: 40px 36px 32px;"
                onclick="event.stopPropagation()">
                <div class="status-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-amber-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="status-modal-title">Update Status?</h3>
                <p class="status-modal-desc">Pilih status untuk Project Improvemen <strong
                        id="status-modal-talent-name">-</strong>.<br>Tindakan ini akan langsung memperbarui sistem pada
                    Talent</p>
                <div class="status-modal-actions">
                    <button class="btn-status-reject" onclick="submitProjectStatus('Rejected')">Reject</button>
                    <button class="btn-status-approve" onclick="submitProjectStatus('Approved')">Approve</button>
                </div>
                <button class="btn-status-batal" onclick="closeUpdateStatusModal()">Batal</button>
                <form id="update-status-form" method="POST" style="display:none;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" id="status-input-value">
                </form>
            </div>
        </div>

        {{-- ================================= SECTION: PROJECT IMPROVEMENT ================================= --}}
    @endif

    @if ($activeTab === 'project')
        <div id="section-project">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0f172a]" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                </svg>
                Project Improvement
            </div>

            @foreach ($talents as $talent)
                <div class="bg-white border text-center border-gray-200 rounded-2xl p-6 mb-20 shadow-sm">
                    <div class="flex justify-between items-center mb-16">
                        <div class="flex items-center gap-4 text-left">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                                class="w-14 h-14 rounded-full" alt="">
                            <div>
                                <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                                <p class="text-xs text-gray-400 italic">
                                    {{ optional($talent->position)->position_name }} -
                                    {{ optional($talent->department)->nama_department }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="rounded-xl overflow-hidden border border-gray-200 mt-4 mb-4 text-left">
                        <table class="w-full text-left bg-white">
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
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
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
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                    Pending
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
            @endforeach
        </div>

        {{-- ================================= SECTION: LOGBOOK ================================= --}}
    @endif

    @if ($activeTab === 'logbook')
        <div id="section-logbook">
            <div class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0f172a]" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                LogBook
            </div>

            <div class="filter-pills">
                <div class="pill {{ !$logbookFilterType || $logbookFilterType == 1 ? 'active' : '' }}"
                    wire:click="setLogbookFilter(1)">Exposure</div>
                <div class="pill {{ $logbookFilterType == 2 ? 'active' : '' }}" wire:click="setLogbookFilter(2)">
                    Mentoring</div>
                <div class="pill {{ $logbookFilterType == 3 ? 'active' : '' }}" wire:click="setLogbookFilter(3)">
                    Learning</div>
            </div>

            @foreach ($talents as $talent)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-20 shadow-sm">
                    <div class="flex items-center gap-4 mb-16">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                            class="w-14 h-14 rounded-full" alt="">
                        <div>
                            <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                            <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} -
                                {{ optional($talent->department)->nama_department }}</p>
                        </div>
                    </div>

                    {{-- Logbook Content Area --}}
                    <div class="logbook-content-wrapper" data-talent-id="{{ $talent->id }}">

                        {{-- EXPOSURE TABLE --}}
                        @if (!$logbookFilterType || $logbookFilterType == 1)
                            <div class="log-table-type exposure-table">
                                <div class="rounded-xl overflow-hidden border border-gray-200">
                                    <table class="w-full table-auto text-left bg-white">
                                        <thead class="bg-slate-50 border-b border-gray-200">
                                            <tr>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">
                                                    Mentor</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema
                                                </th>
                                                <th
                                                    class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                                    Tanggal Pengiriman/Update</th>
                                                <th
                                                    class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                                    Tanggal Pelaksanaan</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">
                                                    Status</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $expActivities = $talent->idpActivities->where('type_idp', 1); @endphp
                                            @forelse($expActivities as $act)
                                                <tr
                                                    class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                                    <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                                        {{ $act->verifier->nama ?? '-' }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                                        {{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                                    <td
                                                        class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                        {{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->locale('id')->translatedFormat('d F Y') : '-' }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($act->activity_date)->locale('id')->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td class="py-4 px-6 text-center w-32">
                                                        @if (in_array($act->status, ['Approve', 'Approved']))
                                                            <span
                                                                class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                                Approved
                                                            </span>
                                                        @elseif (in_array($act->status, ['Reject', 'Rejected']))
                                                            <span
                                                                class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                                Rejected
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                                {{ $act->status ?: 'Pending' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-6 text-center">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-[12px] font-semibold text-white hover:bg-[#0d9488] hover:border-[#0d9488] shadow-sm transition-all"
                                                                title="Detail">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="py-12 px-6 text-center text-gray-400">
                                                        Belum ada aktivitas Exposure yang dicatat.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- MENTORING TABLE --}}
                        @endif
                        @if ($logbookFilterType == 2)
                            <div class="log-table-type mentoring-table">
                                <div class="rounded-xl overflow-hidden border border-gray-200">
                                    <table class="w-full table-auto text-left bg-white">
                                        <thead class="bg-slate-50 border-b border-gray-200">
                                            <tr>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">
                                                    Mentor</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema
                                                </th>
                                                <th
                                                    class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                                    Tanggal Pengiriman/Update</th>
                                                <th
                                                    class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                                    Tanggal Pelaksanaan</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">
                                                    Status</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $menActivities = $talent->idpActivities->where('type_idp', 2); @endphp
                                            @forelse($menActivities as $act)
                                                <tr
                                                    class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                                    <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                                        {{ $act->verifier->nama ?? '-' }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                                        {{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                                    <td
                                                        class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                        {{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->locale('id')->translatedFormat('d F Y') : '-' }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($act->activity_date)->locale('id')->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td class="py-4 px-6 text-center w-32">
                                                        @if (in_array($act->status, ['Approve', 'Approved']))
                                                            <span
                                                                class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                                Approved
                                                            </span>
                                                        @elseif (in_array($act->status, ['Reject', 'Rejected']))
                                                            <span
                                                                class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                                Rejected
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                                {{ $act->status ?: 'Pending' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-6 text-center">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-[12px] font-semibold text-white hover:bg-[#0d9488] hover:border-[#0d9488] shadow-sm transition-all"
                                                                title="Detail">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="py-12 px-6 text-center text-gray-400">
                                                        Belum ada aktivitas Mentoring yang dicatat.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- LEARNING TABLE --}}
                        @endif
                        @if ($logbookFilterType == 3)
                            <div class="log-table-type learning-table">
                                <div class="rounded-xl overflow-hidden border border-gray-200">
                                    <table class="w-full table-auto text-left bg-white">
                                        <thead class="bg-slate-50 border-b border-gray-200">
                                            <tr>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">
                                                    Sumber</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema
                                                </th>
                                                <th
                                                    class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                                    Tanggal Pengiriman/Update</th>
                                                <th
                                                    class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                                    Tanggal Pelaksanaan</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">
                                                    Status</th>
                                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $leaActivities = $talent->idpActivities->where('type_idp', 3); @endphp
                                            @forelse($leaActivities as $act)
                                                <tr
                                                    class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                                    <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                                        {{ $act->activity }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                                        {{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                                    <td
                                                        class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                        {{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->locale('id')->translatedFormat('d F Y') : '-' }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($act->activity_date)->locale('id')->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td class="py-4 px-6 text-center w-32">
                                                        @if (in_array($act->status, ['Approve', 'Approved', 'Verified']))
                                                            <span
                                                                class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                                {{ $act->status === 'Verified' ? 'Verified' : 'Approved' }}
                                                            </span>
                                                        @elseif (in_array($act->status, ['Reject', 'Rejected']))
                                                            <span
                                                                class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                                Rejected
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                                <span
                                                                    class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                                {{ $act->status ?: 'Pending' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-6 text-center">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-[12px] font-semibold text-white hover:bg-[#0d9488] hover:border-[#0d9488] shadow-sm transition-all"
                                                                title="Detail">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="py-12 px-6 text-center text-gray-400">
                                                        Belum ada aktivitas Learning yang dicatat.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            @endforeach
        </div>



    @endif

    <script>
        const allTalentGaps = {!! json_encode($allTalentGapsData) !!};
        let currentTalentEditId = null;
        const csrfToken = '{{ csrf_token() }}';

        function openGapModal(talentName, talentData) {
            // Guard: jika talentData null/kosong/bukan object, tampilkan pesan
            if (!talentData || Array.isArray(talentData) || !talentData.talent_id) {
                alert('Data kompetensi talent ini belum tersedia. Pastikan talent sudah mengisi penilaian kompetensi.');
                return;
            }

            currentTalentEditId = talentData.talent_id;
            document.getElementById('modal-talent-name').textContent = talentName;

            const textarea = document.querySelector('.modal-textarea');
            textarea.value = talentData.reason || '';

            const listContainer = document.getElementById('modal-gap-list');
            listContainer.innerHTML = '';

            if (!talentData.gaps || talentData.gaps.length === 0) {
                listContainer.innerHTML =
                    '<p style="color:#94a3b8;font-size:0.875rem;text-align:center;padding:24px">Belum ada data gap untuk talent ini.</p>';
                document.getElementById('gap-modal').classList.add('active');
                return;
            }

            const mappedGaps = [...talentData.gaps];

            // Sort: selected first by priority, then unselected by gap ascending
            mappedGaps.sort((a, b) => {
                if (a.selected && !b.selected) return -1;
                if (!a.selected && b.selected) return 1;
                if (a.selected && b.selected) return a.priority - b.priority;
                return a.gap - b.gap;
            });

            mappedGaps.forEach((g) => {
                const item = document.createElement('div');
                item.className = 'gap-select-item gap-select-item-card';
                item.dataset.id = g.id;
                item.onclick = function() {
                    toggleCheck(this);
                };

                const scoreDisplay = (typeof g.score === 'number') ? (g.score % 1 === 0 ? g.score : g.score.toFixed(
                    1)) : g.score;
                const gapDisplay = (typeof g.gap === 'number') ? (g.gap == 0 ? '0' : g.gap.toFixed(1)) : g.gap;

                let gapClass = 'gap-ok';
                const gapVal = parseFloat(g.gap);
                if (gapVal === 0) {
                    gapClass = 'gap-none';
                } else if (gapVal < -1.5) {
                    gapClass = 'gap-large';
                } else if (gapVal < 0) {
                    gapClass = 'gap-small';
                }

                item.innerHTML = `
                    <input type="checkbox" ${g.selected ? 'checked' : ''} onclick="event.stopPropagation(); updatePriorityStyles();">
                    <div class="gap-name-modal">${g.name}</div>
                    <div class="gap-score-modal">${scoreDisplay}/${g.standard}</div>
                    <div class="gap-value-badge ${gapClass}">${gapDisplay}</div>
                `;
                listContainer.appendChild(item);
            });

            document.getElementById('gap-modal').classList.add('active');
            updatePriorityStyles();
        }

        function toggleCheck(item) {
            const checkbox = item.querySelector('input');
            const checkedCount = document.querySelectorAll('#modal-gap-list input:checked').length;

            if (!checkbox.checked && checkedCount >= 3) {
                return; // Limit to 3
            }

            checkbox.checked = !checkbox.checked;
            updatePriorityStyles();
        }

        function updatePriorityStyles() {
            const items = document.querySelectorAll('.gap-select-item-card');
            let checkedIdx = 0;
            items.forEach(item => {
                const cb = item.querySelector('input');
                item.classList.remove('priority-1', 'priority-2', 'priority-3');
                if (cb.checked) {
                    checkedIdx++;
                    if (checkedIdx <= 3) {
                        item.classList.add('priority-' + checkedIdx);
                    }
                }
            });
        }

        function closeGapModal() {
            document.getElementById('gap-modal').classList.remove('active');
            currentTalentEditId = null;
        }

        async function saveTopGaps(btn) {
            if (!currentTalentEditId) return;

            const checkedItems = document.querySelectorAll('.gap-select-item-card input:checked');
            if (checkedItems.length !== 3) {
                alert('Tolong pilih tepat 3 prioritas GAP.');
                return;
            }

            const reason = document.querySelector('.modal-textarea').value.trim();
            const competenceIds = Array.from(checkedItems).map(cb => parseInt(cb.closest('.gap-select-item-card')
                .dataset.id));

            btn.textContent = 'Menyimpan...';
            btn.disabled = true;

            try {
                const response = await fetch('/pdc-admin/top-gaps/' + currentTalentEditId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        competence_ids: competenceIds,
                        reason: reason
                    })
                });

                const result = await response.json();
                if (result.success) {
                    window.location.reload();
                } else {
                    alert('Gagal menyimpan Top 3 GAP: ' + (result.message || 'Unknown error'));
                    btn.textContent = 'Simpan';
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan sistem.');
                btn.textContent = 'Simpan';
                btn.disabled = false;
            }
        }

        function resetGapToAuto() {
            const items = Array.from(document.querySelectorAll('.gap-select-item-card'));

            // Sort by gap value ascending (most negative first)
            items.sort((a, b) => {
                const gapA = parseFloat(a.querySelector('.gap-value-badge').textContent);
                const gapB = parseFloat(b.querySelector('.gap-value-badge').textContent);
                return gapA - gapB;
            });

            items.forEach((item, idx) => {
                item.querySelector('input').checked = (idx < 3);
            });
            document.querySelector('.modal-textarea').value = '';

            updatePriorityStyles();
        }

        function closeModalOnOutside(e) {
            if (e.target.id === 'gap-modal') closeGapModal();
        }

        // --- FINANCE MODAL FUNCTIONS ---
        function openFinanceModal(talentName, deptName, posName, companyName, projId, projTitle, projFileUrl) {
            document.getElementById('fin-talent-name').textContent = talentName || '-';
            document.getElementById('fin-dept-name').textContent = deptName || '-';
            document.getElementById('fin-pos-name').textContent = posName || '-';
            document.getElementById('fin-company-name').textContent = companyName || '-';

            document.getElementById('finance-proj-id').value = projId;
            document.getElementById('finance-proj-title').value = projTitle;
            document.getElementById('finance-proj-file').href = projFileUrl;

            document.getElementById('finance-modal').classList.add('active');
        }

        function closeFinanceModal() {
            document.getElementById('finance-modal').classList.remove('active');
        }

        // Close on backdrop
        window.onclick = function(event) {
            const gapModal = document.getElementById('gap-modal');
            const financeModal = document.getElementById('finance-modal');
            const statusModal = document.getElementById('update-status-modal');
            if (event.target == gapModal) closeGapModal();
            if (event.target == financeModal) closeFinanceModal();
            if (event.target == statusModal) closeUpdateStatusModal();
        }

        // --- UPDATE STATUS MODAL FUNCTIONS ---
        let currentProjectId = null;

        function openUpdateStatusModal(talentName, projId) {
            if (!projId || projId === 'null') {
                alert('Talent ini belum memiliki project improvement.');
                return;
            }
            currentProjectId = projId;
            document.getElementById('status-modal-talent-name').textContent = talentName;
            document.getElementById('update-status-modal').classList.add('active');
        }

        function closeUpdateStatusModal() {
            document.getElementById('update-status-modal').classList.remove('active');
            currentProjectId = null;
        }

        function closeStatusModalOnOutside(event) {
            if (event.target.id === 'update-status-modal') closeUpdateStatusModal();
        }

        function submitProjectStatus(status) {
            if (!currentProjectId) return;
            const form = document.getElementById('update-status-form');
            form.action = '/pdc-admin/finance-validation/' + currentProjectId;
            document.getElementById('status-input-value').value = status;
            form.submit();
        }
    </script>

    {{-- ================================= MODAL: FINANCE VALIDATION ================================= --}}
    <div id="finance-modal" class="modal-overlay @if ($errors->any()) active @endif">
        <div class="modal-content finance-modal-content" style="max-height: 95vh; overflow-y: auto;">
            <div class="finance-header">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-[#1e293b]">Kirim Permintaan Validasi Finance</h3>
                </div>
                <button onclick="closeFinanceModal()"
                    class="text-gray-400 hover:text-gray-600 p-2 border border-gray-100 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('pdc_admin.finance.request') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" id="finance-proj-id">

                <div class="finance-body">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada input yang terlewat:</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="finance-alert">
                        <div class="bg-yellow-100 p-2 rounded-lg shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="finance-alert-text">Sistem secara otomatis mengirim catatan kepada finance untuk
                            segera direview. Harap isi pada catatan sesuai dengan kebutuhan Anda.</p>
                    </div>

                    <div class="finance-form-grid">
                        <div>
                            <label class="finance-field-label">Talent</label>
                            <div id="fin-talent-name" class="finance-readonly-box">Rudi Santiago</div>
                        </div>
                        <div>
                            <label class="finance-field-label">Perusahaan</label>
                            <div id="fin-company-name" class="finance-readonly-box">PT. Tiga Serangkai Pustaka
                                Mandiri</div>
                        </div>
                        <div>
                            <label class="finance-field-label">Departemen</label>
                            <div id="fin-dept-name" class="finance-readonly-box">Human Resource</div>
                        </div>
                        <div>
                            <label class="finance-field-label">Posisi yang dituju</label>
                            <div id="fin-pos-name" class="finance-readonly-box">Manager</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="finance-field-label">Judul Project Improvement</label>
                            <input type="text" id="finance-proj-title"
                                class="finance-input bg-gray-50 border-gray-200 text-gray-500 font-semibold cursor-not-allowed"
                                readonly placeholder="Masukkan judul project...">
                        </div>
                        <div>
                            <label class="finance-field-label">Lampiran</label>
                            <div class="finance-input bg-gray-50 border-gray-200 flex items-center px-3 py-[9px]">
                                <a id="finance-proj-file" href="#" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path fill-rule="evenodd"
                                            d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Lihat File
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col h-full">
                            <label
                                class="text-[#0f172a] font-extrabold text-sm md:text-base mb-3 tracking-wide uppercase">Catatan</label>
                            <textarea name="notes" required
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-[13px] text-gray-500 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none flex-grow min-h-[130px]"
                                placeholder="cth: Pada slide ke 17 apakah sudah memenuhi standar kriteria untuk melakukan bisnis. . ."></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label
                                class="text-[#0f172a] font-extrabold text-sm md:text-base mb-3 tracking-wide uppercase">Kirim
                                Kepada</label>
                            <div class="relative">
                                <select name="assigned_finance_id" required
                                    class="w-full appearance-none rounded-xl border border-gray-300 bg-white px-4 py-3 text-[13px] text-gray-500 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 pr-10">
                                    <option value="" disabled selected>Pilih nama finance yang terdaftar</option>
                                    @foreach ($financeUsers as $finUser)
                                        <option value="{{ $finUser->id }}" class="text-gray-700">
                                            {{ $finUser->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-teal-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="finance-footer">
                    <button type="button" onclick="closeFinanceModal()" class="btn-finance-cancel">Batal</button>
                    <button type="submit" class="btn-finance-submit"
                        onclick="this.innerHTML='Mengirim...';">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
