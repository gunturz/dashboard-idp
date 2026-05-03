<x-panelis.layout title="Riwayat Penilaian – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .page-title {
                font-size: 1.35rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 24px;
            }

            /* ── Company divider ── */
            .company-divider {
                text-align: center;
                font-size: 0.92rem;
                font-weight: 700;
                color: #1e293b;
                margin: 28px 0 16px 0;
            }
            .company-divider:first-of-type { margin-top: 0; }

            /* ── Card ── */
            .hist-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                overflow: hidden;
                margin-bottom: 14px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }
            .hist-card:last-child { margin-bottom: 0; }

            /* ── Card Header ── */
            .hist-header {
                display: flex;
                align-items: center;
                padding: 16px 22px;
                gap: 14px;
                cursor: pointer;
            }
            .hist-avatar {
                width: 48px; height: 48px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }
            .hist-meta { flex: 1; min-width: 0; }
            .hist-name {
                font-size: 0.92rem;
                font-weight: 800;
                color: #1e293b;
                display: block;
            }
            .hist-role {
                font-size: 0.73rem;
                color: #64748b;
                display: block;
                margin-top: 1px;
            }
            .hist-date {
                font-size: 0.7rem;
                color: #94a3b8;
                display: block;
                margin-top: 1px;
            }
            .hist-project-title {
                font-size: 0.82rem;
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
                padding: 5px 15px;
                border: 1.5px solid #14b8a6;
                border-radius: 20px;
                font-size: 0.75rem;
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
                background: #f8fafc;
                font-size: 0.78rem;
                font-weight: 700;
                color: #1e293b;
                padding: 11px 16px;
                text-align: center;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .aspek-tbl th:first-child { text-align: left; }
            .aspek-tbl th:last-child  { border-right: none; }
            .aspek-tbl td {
                padding: 11px 16px;
                font-size: 0.8rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }
            .aspek-tbl td:last-child  { border-right: none; text-align: center; }
            .aspek-tbl tbody tr:last-child td { border-bottom: none; }

            .score-ro {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 32px; height: 32px;
                border-radius: 7px;
                background: #14b8a6;
                color: white;
                font-weight: 800;
                font-size: 0.88rem;
                box-shadow: 0 2px 6px rgba(20,184,166,0.25);
            }

            /* ── Komentar ── */
            .komentar-wrap {
                padding: 14px 16px;
                border-top: 1px solid #f1f5f9;
            }
            .komentar-label {
                font-size: 0.8rem;
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
                font-size: 0.8rem;
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
                font-size: 0.8rem;
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
                font-size: 0.8rem;
                font-weight: 700;
                color: #1e293b;
            }
            .skor-val {
                border: 1.5px solid #e2e8f0;
                border-radius: 7px;
                padding: 5px 18px;
                font-size: 0.85rem;
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
                font-size: 0.78rem;
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
                background: #64748b;
                color: white;
                font-size: 0.78rem;
                font-weight: 700;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
                transition: background 0.2s;
                display: inline-flex;
                align-items: center;
                text-decoration: none;
            }
            .btn-edit:hover { background: #475569; color: white; }

            /* ── Empty ── */
            .empty-state {
                text-align: center;
                color: #94a3b8;
                padding: 60px;
                font-size: 0.9rem;
            }
        </style>
    </x-slot>

    <p class="page-title">Riwayat Penilaian</p>

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
            'Refleksi Peran sebagai GM',
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
        <div class="empty-state">Belum ada riwayat penilaian.</div>
    @else
        @foreach($grouped as $companyName => $companyProjects)
            <div class="company-divider">{{ $companyName }}</div>

            @foreach($companyProjects as $idx => $assessment)
                @php
                    $talent    = $assessment->talent;
                    $latestProject = $talent ? $talent->improvementProjects->sortByDesc('updated_at')->first() : null;
                    $cardId    = 'hc-' . $assessment->id;
                    $expanded  = false;
                    $scoreArr  = $assessment->panelis_scores_json ?? [];
                    $totalScore = $assessment->panelis_score ?? 0;
                    $maxScore   = 50;

                    // Determine rekomendasi dot color
                    $rekomenColor = 'yellow';
                    if (str_contains($assessment->panelis_rekomendasi ?? '', 'Ready Now'))       $rekomenColor = 'green';
                    elseif (str_contains($assessment->panelis_rekomendasi ?? '', 'Not Ready'))   $rekomenColor = 'red';
                @endphp

                <div class="hist-card">
                    {{-- Header --}}
                    <div class="hist-header" onclick="toggleHist('{{ $cardId }}')">
                        <img class="hist-avatar"
                             src="{{ optional($talent)->foto ? asset('storage/'.$talent->foto) : 'https://ui-avatars.com/api/?name='.urlencode(optional($talent)->nama ?? 'T').'&background=e0f2fe&color=0284c7&bold=true' }}"
                             alt="{{ optional($talent)->nama }}">
                        <div class="hist-meta">
                            <span class="hist-name">{{ optional($talent)->nama ?? '-' }}</span>
                            <span class="hist-role">
                                {{ $talent->position->position_name ?? '-' }}
                                &rarr;
                                {{ $talent->promotion_plan->targetPosition->position_name ?? '?' }}
                            </span>
                            <span class="hist-role">
                                {{ optional(optional($talent)->department)->nama_department ?? 'Human Resources' }}
                            </span>
                            <span class="hist-date">Dinilai: {{ $assessment->panelis_tanggal_penilaian ? \Carbon\Carbon::parse($assessment->panelis_tanggal_penilaian)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <span class="hist-project-title">{{ $latestProject->title ?? 'Judul Project' }}</span>
                        <span class="badge-done">Done Review</span>
                        <svg class="hist-arrow {{ $expanded ? 'open' : '' }}" id="arr-{{ $cardId }}"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
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
                                <textarea class="komentar-ta" readonly>{{ $assessment->panelis_komentar ?? '' }}</textarea>
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
                                    <a href="{{ route('files.preview', ['path' => $latestProject->document_path]) }}" target="_blank" class="btn-preview">Preview File</a>
                                @else
                                    <span class="btn-preview" style="opacity:0.4;cursor:default;">Preview File</span>
                                @endif
                                <a href="{{ route('panelis.penilaian', optional($talent)->id) }}" class="btn-edit">Edit</a>
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
