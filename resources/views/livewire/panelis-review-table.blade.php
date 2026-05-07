<div>
    {{-- ── Search Bar ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="relative w-full sm:w-80">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari Nama Talent atau Judul Project…"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
        </div>
        @if($search)
            <button wire:click="$set('search', '')" class="btn-prem btn-ghost text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Hapus Filter
            </button>
        @endif
    </div>

    {{-- ── Review Cards ── --}}
    @forelse($projects as $idx => $project)
        @php
            $talent = $project->talent;
            $assessment = optional($talent)->assessmentSession;
            $details = $assessment ? $assessment->details : collect();
            $isFirstExpanded = ($idx === 0 && !$this->search);
        @endphp

        <div class="review-card review-card-item" id="review-card-{{ $project->id }}">
            {{-- Card Header --}}
            <div class="review-card-header" onclick="toggleReviewCard('{{ $project->id }}')">
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
                        <span class="talent-date">Dikirim: {{ $project->created_at ? $project->created_at->format('d F Y') : '-' }}</span>
                    </div>
                </div>
                <div class="header-right">
                    <span class="font-semibold text-sm text-gray-700">{{ $project->title ?? 'Judul Project' }}</span>
                    <span class="badge-pending">Pending Review</span>
                    <div class="toggle-arrow {{ $isFirstExpanded ? 'rotated' : '' }}" id="arrow-{{ $project->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="review-card-body {{ $isFirstExpanded ? 'open' : '' }}" id="body-{{ $project->id }}">
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
                                ['name' => 'Analisis Akar Masalah', 'indicator' => "Penggunaan tools (Fishbone, 5 Why's atau yang lain), logis dan mendalam", 'score' => 3],
                                ['name' => 'Solusi yang Ditawarkan', 'indicator' => 'Solusi konkret, realistis, dan menjawab akar masalah', 'score' => 4],
                                ['name' => 'Rencana Implementasi', 'indicator' => 'Timeline jelas, tahapan logis, melibatkan stakeholder', 'score' => 4],
                                ['name' => 'Target Dampak & KPI', 'indicator' => 'Indikator keberhasilan terukur, baseline-target jelas', 'score' => 5],
                                ['name' => 'Risiko & Mitigasi', 'indicator' => 'Mengenali risiko dan menyusun strategi antisipasi', 'score' => 4],
                                ['name' => 'Gaya Presentasi & Penguasaan Materi', 'indicator' => 'Komunikatif, percaya diri, menjawab pertanyaan', 'score' => 3],
                                ['name' => 'Refleksi Peran sebagai Posisi yang Dituju', 'indicator' => 'Menunjukkan kesiapan mindset kepemimpinan, Strategic Thingking dan Conceptual thinking.', 'score' => 4],
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
                @if($search)
                    Tidak ada hasil untuk "<strong>{{ $search }}</strong>"
                @else
                    Belum ada permintaan penilaian.
                @endif
            </div>
        </div>
    @endforelse

    {{-- ── Pagination ── --}}
    @if($projects->hasPages())
        <div class="flex justify-center mt-6">
            {{ $projects->links('livewire.pagination-simple') }}
        </div>
    @endif
</div>
