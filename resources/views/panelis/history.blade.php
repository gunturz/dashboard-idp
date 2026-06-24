<x-panelis.layout title="Riwayat Penilaian – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ── Company divider ── */
            .company-divider {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 1.2rem;
                font-weight: 800;
                color: #1e293b;
                margin: 36px 0 16px 0;
                text-align: left;
            }
            .company-divider::before {
                content: '';
                display: inline-block;
                width: 4px;
                height: 18px;
                background: linear-gradient(180deg, #14b8a6, #0d9488);
                border-radius: 99px;
            }
            .company-divider:first-of-type { margin-top: 0; }

            /* ── Card ── */
            .hist-card {
                background: #f9fafb;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                overflow: hidden;
                margin-bottom: 16px;
                box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            }
            .hist-card:last-child { margin-bottom: 0; }

            /* ── Card Header ── */
            .hist-header {
                display: flex;
                flex-direction: column;
                padding: 16px;
                cursor: pointer;
            }
            @media (min-width: 768px) {
                .hist-header {
                    flex-direction: row;
                    align-items: center;
                    padding: 16px 22px;
                    gap: 14px;
                }
            }
            .hist-header-top {
                display: flex;
                align-items: center;
                gap: 14px;
                flex: 1;
                min-width: 0;
            }
            .hist-header-bottom {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px solid #f1f5f9;
            }
            @media (min-width: 768px) {
                .hist-header-bottom {
                    margin-top: 0;
                    padding-top: 0;
                    border-top: none;
                    justify-content: flex-end;
                    flex-shrink: 0;
                }
            }
            .hist-avatar {
                width: 56px; height: 56px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
                display: none;
            }
            @media (min-width: 768px) {
                .hist-avatar {
                    display: block;
                }
            }
            .hist-avatar-mobile {
                display: block;
                width: 36px; height: 36px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 4px rgba(0,0,0,0.06);
            }
            @media (min-width: 768px) {
                .hist-avatar-mobile {
                    display: none;
                }
            }
            .hist-name-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 4px;
            }
            .hist-meta { flex: 1; min-width: 0; }
            .hist-name {
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                display: block;
            }
            .hist-role {
                font-size: 0.8rem;
                color: #64748b;
                display: block;
                margin-top: 1px;
            }
            .hist-date {
                font-size: 0.78rem;
                color: #94a3b8;
                display: block;
                margin-top: 1px;
            }
            .hist-project-title {
                font-size: 0.88rem;
                font-weight: 600;
                color: #475569;
                flex: 1;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .badge-done {
                display: inline-flex;
                align-items: center;
                padding: 6px 16px;
                border: 1.5px solid #14b8a6;
                border-radius: 20px;
                font-size: 0.78rem;
                font-weight: 700;
                color: #0f766e;
                background: #f0fdfa;
                white-space: nowrap;
                flex-shrink: 0;
            }
            .hist-arrow {
                width: 22px; height: 22px;
                color: #64748b;
                flex-shrink: 0;
                transition: transform 0.28s ease;
            }
            .hist-arrow.open { transform: rotate(180deg); }

            /* ── Card Body ── */
            .hist-body {
                display: none;
                padding: 4px 22px 22px 22px;
            }
            .hist-body.open { display: block; }

            /* ── Inner container (white box with shadow) ── */
            .hist-inner {
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                overflow: hidden;
            }

            /* ── Aspek Table ── */
            .aspek-tbl {
                width: 100%;
                border-collapse: collapse;
            }
            .aspek-tbl th {
                background: #f1f5f9;
                font-size: 0.75rem;
                font-weight: 700;
                color: #1e293b;
                padding: 12px 16px;
                text-align: center;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }
            .aspek-tbl th:first-child { text-align: left; }
            .aspek-tbl th:last-child  { border-right: none; }
            .aspek-tbl td {
                padding: 12px 16px;
                font-size: 0.82rem;
                color: #334155;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
            }
            .aspek-tbl td:last-child  { border-right: none; text-align: center; }
            .aspek-tbl tbody tr:last-child td { border-bottom: 1px solid #d1d5db; }

            .score-ro {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 32px; height: 32px;
                border-radius: 7px;
                background: #14b8a6;
                color: white;
                font-weight: 800;
                font-size: 0.82rem;
                box-shadow: 0 2px 6px rgba(20,184,166,0.25);
            }

            /* ── Komentar ── */
            .komentar-wrap {
                padding: 16px 18px;
                border-top: 1px solid #f1f5f9;
            }
            .komentar-label {
                font-size: 0.88rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 8px;
            }
            .komentar-ta {
                width: 100%;
                min-height: 80px;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 10px 13px;
                font-size: 0.88rem;
                color: #334155;
                resize: vertical;
                font-family: 'Poppins', sans-serif;
                outline: none;
                background: #fcfcfc;
            }
            .komentar-ta::placeholder { color: #94a3b8; }

            /* ── Readiness ── */
            .readiness-wrap {
                padding: 12px 16px;
                border-top: 1px solid #f1f5f9;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .rd-dot {
                width: 20px; height: 20px;
                border-radius: 4px;
                flex-shrink: 0;
            }
            .rd-dot.green  { background: #22c55e; }
            .rd-dot.yellow { background: #f59e0b; }
            .rd-dot.red    { background: #ef4444; }
            .rd-text {
                font-size: 0.88rem;
                color: #334155;
            }
            .rd-text strong { font-weight: 700; }
            .rd-text span   { color: #64748b; }

            /* ── Skor ── */
            .skor-wrap {
                padding: 12px 16px;
                border-top: 1px solid #f1f5f9;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .skor-lbl {
                font-size: 0.88rem;
                font-weight: 700;
                color: #1e293b;
            }
            .skor-val {
                border: 1.5px solid #e2e8f0;
                border-radius: 7px;
                padding: 5px 18px;
                font-size: 0.95rem;
                font-weight: 800;
                color: #1e293b;
                background: white;
            }

            /* ── Action buttons ── */
            .actions-wrap {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                padding: 14px 16px;
                border-top: 1px solid #f1f5f9;
                flex-wrap: wrap;
            }
            .btn-preview {
                padding: 8px 22px;
                border: 1.5px solid #e2e8f0;
                border-radius: 7px;
                background: white;
                color: #475569;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
                transition: all 0.2s;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }
            .btn-preview:hover { border-color: #14b8a6; color: #0d9488; }
            .btn-edit {
                padding: 8px 24px;
                border: none;
                border-radius: 7px;
                background: #0f172a;
                color: white;
                font-size: 0.85rem;
                font-weight: 700;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
                transition: background 0.2s;
                display: inline-flex;
                align-items: center;
                text-decoration: none;
            }
            .btn-edit:hover { background: #1e293b; color: white; }

            /* ── Empty ── */
            .empty-state {
                text-align: center;
                color: #94a3b8;
                padding: 60px;
                font-size: 0.9rem;
            }
        </style>
    </x-slot>

    @if (session('success'))
        <div id="panelis-success-alert" class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700" style="transition: opacity 0.5s ease, transform 0.5s ease;">
            <strong class="font-bold">Berhasil!</strong>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            (function() {
                function dismissPanelisAlert() {
                    var el = document.getElementById('panelis-success-alert');
                    if (!el) return;
                    setTimeout(function() {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(function() {
                            el.remove();
                        }, 500);
                    }, 3000);
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', dismissPanelisAlert);
                } else {
                    dismissPanelisAlert();
                }
            })();
        </script>
    @endif

    <div class="page-header animate-title mb-8">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Riwayat Penilaian</div>
            <div class="page-header-sub">Individual Development Plan – Panelis</div>
        </div>
    </div>

    @php
        $aspectNames = [
            'Pemahaman Bisnis & Strategi',
            'Identifikasi Masalah',
            'Analisis Akar Masalah',
            'Solusi yang Ditawarkan',
            'Rencana Implementasi',
            'Target Dampak & KPI',
            'Risiko & Mitigasi',
            'Gaya Presentasi & Penguasaan Materi',
            'Refleksi Peran sebagai Posisi yang Dituju',
            'Nilai Tambah',
        ];
        $aspectIndicators = [
            'Memahami konteks industri, Business proses dan arah perusahaan',
            'Masalah yang diangkat relevan, kritis, dan berbasis data',
            "Penggunaan tools (Fishbone, 5 Why's atau yang lain), logis dan mendalam",
            'Solusi konkret, realistis, dan menjawab akar masalah',
            'Timeline jelas, tahapan logis, melibatkan stakeholder',
            'Indikator keberhasilan terukur, baseline–target jelas',
            'Mengenali risiko dan menyusun strategi antisipasi',
            'Komunikatif, percaya diri, menjawab pertanyaan',
            'Menunjukkan kesiapan mindset kepemimpinan, Strategic Thingking dan Conceptual thinking.',
            'Inisiatif ekstra, kolaborasi, atau insight mendalam',
        ];

        $grouped = $assessments->groupBy(fn($a) => optional(optional($a->talent)->company)->nama_company ?? 'Lainnya');
    @endphp

    @if($assessments->isEmpty())
        <div class="empty-prem" style="border: none; padding: 20px;">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3>Belum Ada Riwayat Penilaian</h3>
            <p>Data riwayat penilaian akan muncul setelah Anda memberikan penilaian kepada talent.</p>
        </div>
    @else
        @foreach($grouped as $companyName => $companyProjects)
            <div class="company-divider">{{ $companyName }}</div>

            @foreach($companyProjects as $idx => $assessment)
                @php
                    $talent    = $assessment->talent;
                    $latestProject = $assessment->developmentSession
                        ? $assessment->developmentSession->improvementProjects->sortByDesc('updated_at')->first()
                        : null;
                    $cardId    = 'hc-' . $assessment->id;
                    $expanded  = false;
                    $scoreArr  = $assessment->panelis_scores_json ?? [];
                    $totalScore = $assessment->panelis_score ?? 0;
                    $maxScore   = 50;
                    $sourcePositionName = optional(optional($assessment->developmentSession)->sourcePosition)->position_name
                        ?? optional(optional($assessment->talent)->position)->position_name
                        ?? '-';
                    $targetPositionName = optional(optional(optional($assessment->developmentSession)->promotionPlan)->targetPosition)->position_name
                        ?? optional(optional(optional($assessment->talent)->promotion_plan)->targetPosition)->position_name
                        ?? '?';

                    // Determine rekomendasi dot color
                    $rekomenColor = 'yellow';
                    if (str_contains($assessment->panelis_rekomendasi ?? '', 'Ready Now'))       $rekomenColor = 'green';
                    elseif (str_contains($assessment->panelis_rekomendasi ?? '', 'Not Ready'))   $rekomenColor = 'red';

                    // Determine if talent is in Progress Archive
                    $finalStatuses = ['Promoted', 'Not Promoted', 'Ready in 1-2 Years', 'Ready in > 2 Years', 'Not Ready'];
                    $isArchived = false;
                    $devSession = $assessment->developmentSession;
                    if ($devSession) {
                        if (in_array($devSession->status, $finalStatuses) || !$devSession->is_active) {
                            $isArchived = true;
                        }
                    } elseif ($talent && optional($talent->promotion_plan)->status_promotion) {
                        if (in_array($talent->promotion_plan->status_promotion, $finalStatuses) || !optional($talent->promotion_plan)->is_active) {
                            $isArchived = true;
                        }
                    }
                @endphp

                <div class="hist-card">
                    {{-- Header --}}
                    <div class="hist-header" onclick="toggleHist('{{ $cardId }}')">
                        <div class="hist-header-top">
                            <img class="hist-avatar"
                                 src="{{ optional($talent)->foto ? asset('storage/'.$talent->foto) : 'https://ui-avatars.com/api/?name='.urlencode(optional($talent)->nama ?? 'T').'&background=e0f2fe&color=0284c7&bold=true' }}"
                                 alt="{{ optional($talent)->nama }}">
                            <div class="hist-meta">
                                <div class="hist-name-wrapper">
                                    <img class="hist-avatar-mobile"
                                         src="{{ optional($talent)->foto ? asset('storage/'.$talent->foto) : 'https://ui-avatars.com/api/?name='.urlencode(optional($talent)->nama ?? 'T').'&background=e0f2fe&color=0284c7&bold=true' }}"
                                         alt="{{ optional($talent)->nama }}">
                                    <span class="hist-name" style="margin: 0;">{{ optional($talent)->nama ?? '-' }}</span>
                                </div>
                                <span class="hist-role">
                                    {{ $sourcePositionName }}
                                    &rarr;
                                    {{ $targetPositionName }}
                                </span>
                                <span class="hist-role">
                                    {{ optional(optional($talent)->department)->nama_department ?? 'Human Resources' }}
                                </span>
                                <span class="hist-date">Dinilai: {{ $assessment->panelis_tanggal_penilaian ? \Carbon\Carbon::parse($assessment->panelis_tanggal_penilaian)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                                <span class="hist-date">Diupdate: {{ $assessment->updated_at ? \Carbon\Carbon::parse($assessment->updated_at)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                            </div>
                        </div>
                        <div class="hist-header-bottom">
                            <span class="hist-project-title">{{ $latestProject->title ?? 'Judul Project' }}</span>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span class="badge-done">Done Review</span>
                                <svg class="hist-arrow {{ $expanded ? 'open' : '' }}" id="arr-{{ $cardId }}"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="hist-body {{ $expanded ? 'open' : '' }}" id="{{ $cardId }}">
                        <div class="hist-inner">
                            {{-- Aspek table --}}
                            <div class="overflow-x-auto">
                                <table class="aspek-tbl">
                                    <thead>
                                        <tr>
                                            <th style="width:26%;">Aspek yang Dinilai</th>
                                            <th style="width:55%;">Indikator Penilaian</th>
                                            <th style="width:19%;">Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aspectNames as $ai => $aspName)
                                            <tr>
                                                <td>{{ $aspName }}</td>
                                                <td>{{ $aspectIndicators[$ai] }}</td>
                                                <td><span class="score-ro">{{ $scoreArr[$ai] ?? '-' }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Komentar --}}
                            <div class="komentar-wrap">
                                <p class="komentar-label">Komentar / Catatan Penilai:</p>
                                <div class="komentar-ta whitespace-pre-wrap break-words">{{ $assessment->panelis_komentar ?? '' }}</div>
                            </div>

                            {{-- Readiness --}}
                            <div class="readiness-wrap">
                                <div class="rd-dot {{ $rekomenColor }}"></div>
                                <div class="rd-text">
                                    <strong>{{ $assessment->panelis_rekomendasi ?? '-' }}</strong>
                                </div>
                            </div>

                            {{-- Skor --}}
                            <div class="skor-wrap">
                                <span class="skor-lbl">Total Skor</span>
                                <span class="skor-val">{{ $totalScore }} / {{ $maxScore }}</span>
                            </div>

                            {{-- Actions --}}
                            <div class="actions-wrap">
                                @if($latestProject && $latestProject->document_path)
                                    <a href="{{ route('files.preview', ['path' => $latestProject->document_path]) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        Preview File
                                    </a>
                                @else
                                    <span class="btn-preview" style="opacity:0.4;cursor:default;">Preview File</span>
                                @endif
                                @if($isArchived)
                                    <span class="btn-edit" style="background:#94a3b8; cursor:not-allowed; opacity:0.7;" title="Talent sudah berada di Progress Archive">Edit</span>
                                @else
                                    <a href="{{ route('panelis.penilaian', optional($talent)->id) }}" class="btn-edit">Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @endif

    <x-slot name="scripts">
        <script>
            function toggleHist(id) {
                const body  = document.getElementById(id);
                const arrow = document.getElementById('arr-' + id);
                const open  = body.classList.contains('open');
                body.classList.toggle('open', !open);
                arrow.classList.toggle('open', !open);
            }
        </script>
    </x-slot>

</x-panelis.layout>
