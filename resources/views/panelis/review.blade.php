<x-panelis.layout title="Review Panelis – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Review Card ── */
            .review-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                margin-bottom: 28px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                transition: box-shadow 0.2s;
            }
            .review-card:hover {
                box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            }

            /* ── Card Header ── */
            .review-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 24px;
                border-bottom: 1px solid #f1f5f9;
                flex-wrap: wrap;
                gap: 12px;
                cursor: pointer;
            }

            .talent-header-info {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .talent-avatar {
                width: 52px;
                height: 52px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }

            .talent-avatar-placeholder {
                width: 52px;
                height: 52px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 1.1rem;
                color: #0284c7;
                flex-shrink: 0;
                border: 2px solid #e2e8f0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }

            .talent-meta .talent-name {
                font-weight: 700;
                font-size: 1rem;
                color: #1e293b;
                display: block;
            }
            .talent-meta .talent-detail {
                font-size: 0.78rem;
                color: #64748b;
                display: block;
                margin-top: 2px;
            }
            .talent-meta .talent-detail em {
                background: #fef3c7;
                color: #92400e;
                padding: 1px 8px;
                border-radius: 4px;
                font-style: normal;
                font-weight: 600;
                font-size: 0.72rem;
            }
            .talent-meta .talent-date {
                font-size: 0.72rem;
                color: #94a3b8;
                display: block;
                margin-top: 2px;
            }

            .badge-pending {
                display: inline-flex;
                align-items: center;
                padding: 5px 16px;
                border: 2px solid #fbbf24;
                border-radius: 20px;
                font-size: 0.78rem;
                font-weight: 700;
                color: #92400e;
                background: #fffbeb;
                white-space: nowrap;
            }

            .header-right {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .toggle-arrow {
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #14b8a6;
                transition: transform 0.3s ease;
            }
            .toggle-arrow.rotated {
                transform: rotate(180deg);
            }

            /* ── Card Body ── */
            .review-card-body {
                padding: 0 24px 24px 24px;
                display: none;
            }
            .review-card-body.open {
                display: block;
            }

            /* ── Assessment Table ── */
            .assessment-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                margin-top: 16px;
            }

            .assessment-table th {
                background: #f8fafc;
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
                padding: 14px 18px;
                text-align: left;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .assessment-table th:last-child {
                border-right: none;
                text-align: center;
            }

            .assessment-table td {
                padding: 14px 18px;
                font-size: 0.85rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }
            .assessment-table td:last-child {
                border-right: none;
                text-align: center;
            }

            .assessment-table tbody tr:last-child td {
                border-bottom: none;
            }

            .score-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 8px;
                background: #14b8a6;
                color: white;
                font-weight: 700;
                font-size: 0.9rem;
                box-shadow: 0 2px 6px rgba(20, 184, 166, 0.3);
            }

            .score-badge.high {
                background: #0d9488;
            }
            .score-badge.medium {
                background: #14b8a6;
            }
            .score-badge.low {
                background: #f59e0b;
            }

            /* ── Comment Section ── */
            .comment-section {
                margin-top: 24px;
            }
            .comment-label {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }
            .comment-textarea {
                width: 100%;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 14px 16px;
                font-size: 0.85rem;
                color: #334155;
                resize: vertical;
                min-height: 100px;
                outline: none;
                transition: border-color 0.2s;
            }
            .comment-textarea::placeholder {
                color: #94a3b8;
            }
            .comment-textarea:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
            }

            /* ── Readiness Indicator ── */
            .readiness-section {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-top: 20px;
                padding: 12px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                background: #f8fafc;
            }
            .readiness-dot {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                flex-shrink: 0;
            }
            .readiness-dot.green { background: #22c55e; }
            .readiness-dot.yellow { background: #f59e0b; }
            .readiness-dot.red { background: #ef4444; }
            .readiness-text {
                font-size: 0.85rem;
                color: #334155;
            }
            .readiness-text strong {
                font-weight: 700;
            }
            .readiness-text span {
                color: #64748b;
                font-size: 0.78rem;
            }

            /* ── Score Input ── */
            .score-section {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-top: 20px;
            }
            .score-label {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.9rem;
                white-space: nowrap;
            }
            .score-input {
                flex: 1;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 10px 16px;
                font-size: 0.85rem;
                color: #334155;
                outline: none;
                transition: border-color 0.2s;
            }
            .score-input::placeholder {
                color: #94a3b8;
            }
            .score-input:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
            }

            /* ── Action Buttons ── */
            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 16px;
                margin-top: 24px;
                flex-wrap: wrap;
            }
            .btn-preview {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 10px 32px;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                background: white;
                color: #334155;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-preview:hover {
                border-color: #14b8a6;
                color: #0d9488;
                background: #f0fdfa;
            }
            .btn-edit {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 10px 32px;
                border: none;
                border-radius: 10px;
                background: #94a3b8;
                color: white;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-edit:hover {
                background: #64748b;
            }
            .btn-penilaian {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 10px 32px;
                border: none;
                border-radius: 10px;
                background: #343E4E;
                color: white;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-penilaian:hover {
                background: #1e293b;
            }

            .empty-review-text {
                color: #14b8a6;
                text-align: center;
                font-size: 0.85rem;
                font-weight: 500;
                padding: 16px 0;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .review-card-header {
                    padding: 16px;
                }
                .review-card-body {
                    padding: 0 16px 16px 16px;
                }
                .talent-avatar, .talent-avatar-placeholder {
                    width: 42px;
                    height: 42px;
                }
                .action-buttons {
                    flex-direction: column;
                }
                .btn-preview, .btn-edit, .btn-penilaian {
                    width: 100%;
                    justify-content: center;
                }
                .score-section {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    </x-slot>

    {{-- Page Title --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h2 class="text-2xl font-extrabold text-[#2e3746] animate-title">Permintaan Penilaian</h2>
        
        {{-- Live Search --}}
        <div class="relative w-full sm:w-80">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent atau Judul Project…" 
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                oninput="filterReviews()">
        </div>
    </div>

    {{-- Review Cards --}}
    @forelse($projects as $idx => $project)
        @php
            $talent = $project->talent;
            $assessment = optional($talent)->assessmentSession;
            $details = $assessment ? $assessment->details : collect();
            $isFirstExpanded = ($idx === 0);
        @endphp

        <div class="review-card review-card-item" id="review-card-{{ $idx }}" 
             data-name="{{ strtolower(optional($talent)->nama ?? '') }}"
             data-project="{{ strtolower($project->title ?? '') }}">
            {{-- Card Header --}}
            <div class="review-card-header" onclick="toggleReviewCard({{ $idx }})">
                <div class="talent-header-info">
                    @if(optional($talent)->foto)
                        <img src="{{ asset('storage/' . $talent->foto) }}" alt="{{ $talent->nama }}" class="talent-avatar">
                    @else
                        <div class="talent-avatar-placeholder">
                            {{ strtoupper(substr(optional($talent)->nama ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div class="talent-meta">
                        <span class="talent-name">{{ optional($talent)->nama ?? '-' }}</span>
                        <span class="talent-detail">
                            {{ optional(optional($talent)->position)->position_name ?? '-' }} - Manager
                            <em>{{ optional(optional($talent)->department)->nama_department ?? 'Human Resources' }}</em>
                        </span>
                        <span class="talent-date">Dikirim: {{ $project->updated_at ? $project->updated_at->format('d F Y') : '-' }}</span>
                    </div>
                </div>
                <div class="header-right">
                    <span class="font-semibold text-sm text-gray-700">{{ $project->title ?? 'Judul Project' }}</span>
                    <span class="badge-pending">Pending Review</span>
                    <div class="toggle-arrow {{ $isFirstExpanded ? 'rotated' : '' }}" id="arrow-{{ $idx }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="review-card-body {{ $isFirstExpanded ? 'open' : '' }}" id="body-{{ $idx }}">
                {{-- Assessment Table --}}
                <table class="assessment-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Aspek yang Dinilai</th>
                            <th style="width: 50%;">Indikator Penilaian</th>
                            <th style="width: 20%;">Status Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $aspects = [
                                ['name' => 'Pemahaman Bisnis & Strategi', 'indicator' => 'Memahami konteks industri, Business proses dan arah perusahaan', 'score' => 4],
                                ['name' => 'Identifikasi Masalah', 'indicator' => 'Masalah yang diangkat relevan, kritis, dan berbasis data', 'score' => 4],
                                ['name' => 'Analisis Akar Masalah', 'indicator' => 'Penggunaan tools (Fishbone, 5 Why\'s atau yang lain), logis dan mendalam', 'score' => 3],
                                ['name' => 'Solusi yang Ditawarkan', 'indicator' => 'Solusi konkret, realistis, dan menjawab akar masalah', 'score' => 4],
                                ['name' => 'Rencana Implementasi', 'indicator' => 'Timeline jelas, tahapan logis, melibatkan stakeholder', 'score' => 4],
                                ['name' => 'Target Dampak & KPI', 'indicator' => 'Indikator keberhasilan terukur, baseline-target jelas', 'score' => 5],
                                ['name' => 'Risiko & Mitigasi', 'indicator' => 'Mengenali risiko dan menyusun strategi antisipasi', 'score' => 4],
                                ['name' => 'Gaya Presentasi & Penguasaan Materi', 'indicator' => 'Komunikatif, percaya diri, menjawab pertanyaan', 'score' => 3],
                                ['name' => 'Refleksi Peran sebagai GM', 'indicator' => 'Menunjukkan kesiapan mindset kepemimpinan, Strategic Thingking dan Conceptual thinking.', 'score' => 4],
                                ['name' => 'Nilai Tambah', 'indicator' => 'Inisiatif ekstra, kolaborasi, atau insight mendalam', 'score' => 3],
                            ];
                        @endphp
                        @foreach($aspects as $aspect)
                            <tr>
                                <td>{{ $aspect['name'] }}</td>
                                <td>{{ $aspect['indicator'] }}</td>
                                <td>
                                    <span class="score-badge {{ $aspect['score'] >= 5 ? 'high' : ($aspect['score'] >= 4 ? 'medium' : 'low') }}">
                                        {{ $aspect['score'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Comment Section --}}
                <div class="comment-section">
                    <p class="comment-label">Komentar / Catatan Penilai:</p>
                    <textarea class="comment-textarea" placeholder="Tambahkan komentar ke talent.."></textarea>
                </div>

                {{-- Readiness Indicator --}}
                <div class="readiness-section">
                    <div class="readiness-dot green"></div>
                    <div class="readiness-text">
                        <strong>Ready in 1 – 2 Years</strong> <span>(Siap dengan pengembangan terarah)</span>
                    </div>
                </div>

                {{-- Score Input --}}
                <div class="score-section">
                    <span class="score-label">Skor</span>
                    <input type="number" class="score-input" placeholder="Masukkan skor talent dari skala 1 - 100" min="1" max="100">
                </div>

                {{-- Action Buttons --}}
                <div class="action-buttons">
                    <button class="btn-preview">Preview File</button>
                    <button class="btn-edit">Edit</button>
                </div>
            </div>
        </div>
    @empty
        <div class="review-card">
            <div class="p-8 text-center text-gray-400">
                Belum ada permintaan penilaian.
            </div>
        </div>
    @endforelse

    <x-slot name="scripts">
        <script>
            function toggleReviewCard(idx) {
                const body = document.getElementById('body-' + idx);
                const arrow = document.getElementById('arrow-' + idx);
                
                if (body.classList.contains('open')) {
                    body.classList.remove('open');
                    arrow.classList.remove('rotated');
                } else {
                    body.classList.add('open');
                    arrow.classList.add('rotated');
                }
            }

            function filterReviews() {
                const searchTxt = document.getElementById('live-search-input').value.toLowerCase().trim();
                const cards = document.querySelectorAll('.review-card-item');

                cards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const project = card.getAttribute('data-project') || '';
                    
                    if (name.includes(searchTxt) || project.includes(searchTxt)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        </script>
    </x-slot>

</x-panelis.layout>
