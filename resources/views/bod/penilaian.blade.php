<x-bod.layout title="Penilaian BOD – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ── Back button ── */
            .btn-back {
                display: inline-flex; align-items: center; gap: 7px;
                padding: 7px 14px; border: 1px solid #cbd5e1; border-radius: 8px;
                background: white; color: #475569; font-weight: 600; font-size: 0.8rem;
                text-decoration: none; transition: all 0.2s; margin-bottom: 20px;
            }
            .btn-back:hover { background: #f8fafc; border-color: #94a3b8; color: #1e293b; }

            /* ── Page Title ── */
            .penilaian-title {
                font-size: 1.35rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 20px;
            }

            /* ── Info Card (dark) ── */
            .info-card {
                background: #2e3746;
                border-radius: 14px;
                padding: 20px 28px;
                margin-bottom: 32px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px 40px;
            }
            @media (max-width: 640px) { .info-card { grid-template-columns: 1fr; } }

            .info-row {
                display: flex;
                align-items: baseline;
                gap: 10px;
            }
            .info-row label {
                font-size: 0.75rem;
                font-weight: 700;
                color: #94a3b8;
                white-space: nowrap;
                min-width: 120px;
            }
            .info-row span {
                font-size: 0.85rem;
                font-weight: 600;
                color: #f1f5f9;
            }
            .info-row input[type="date"] {
                background: transparent;
                border: 1px solid #475569;
                border-radius: 6px;
                color: #f1f5f9;
                font-size: 0.82rem;
                padding: 4px 10px;
                font-family: 'Poppins', sans-serif;
                outline: none;
                color-scheme: dark;
            }
            .info-row input[type="date"]:focus {
                border-color: #14b8a6;
            }

            /* ── Section heading ── */
            .section-heading {
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 14px;
            }

            /* ── Aspek Table ── */
            .aspek-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 28px;
            }
            .aspek-table th {
                background: #f8fafc;
                font-size: 0.8rem;
                font-weight: 700;
                color: #1e293b;
                padding: 12px 16px;
                text-align: center;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .aspek-table th:first-child { text-align: left; }
            .aspek-table th:last-child  { border-right: none; }

            .aspek-table td {
                padding: 12px 16px;
                font-size: 0.82rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }
            .aspek-table td:last-child { border-right: none; }
            .aspek-table tbody tr:last-child td { border-bottom: none; }
            .aspek-table .col-aspek     { text-align: left; width: 22%; font-weight: 600; }
            .aspek-table .col-indikator { width: 42%; }
            .aspek-table .col-status    { width: 36%; text-align: center; }

            /* ── Score Buttons ── */
            .score-btns {
                display: flex;
                justify-content: center;
                gap: 6px;
            }
            .score-btn {
                width: 32px;
                height: 32px;
                border-radius: 6px;
                border: 1.5px solid #cbd5e1;
                background: white;
                color: #64748b;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.15s;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .score-btn:hover {
                border-color: #14b8a6;
                color: #0d9488;
                background: #f0fdfa;
            }
            .score-btn.selected {
                background: #14b8a6;
                border-color: #14b8a6;
                color: white;
                box-shadow: 0 2px 8px rgba(20,184,166,0.28);
            }

            /* ── Comment ── */
            .comment-box {
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 28px;
            }
            .comment-box-label {
                background: #f8fafc;
                font-size: 0.82rem;
                font-weight: 700;
                color: #1e293b;
                padding: 10px 16px;
                border-bottom: 1px solid #e2e8f0;
            }
            .comment-textarea {
                width: 100%;
                min-height: 100px;
                border: none;
                padding: 14px 16px;
                font-size: 0.82rem;
                color: #334155;
                resize: vertical;
                font-family: 'Poppins', sans-serif;
                outline: none;
            }
            .comment-textarea::placeholder { color: #94a3b8; }

            /* ── Rekomendasi ── */
            .rekomen-box {
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                padding: 16px 20px;
                margin-bottom: 28px;
            }
            .rekomen-box .rekomen-title {
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 14px;
            }
            .rekomen-option {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 10px;
                cursor: pointer;
            }
            .rekomen-option:last-child { margin-bottom: 0; }

            .rekomen-checkbox {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                border: 2px solid #cbd5e1;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.15s;
                background: white;
            }
            .rekomen-checkbox.checked {
                background: #14b8a6;
                border-color: #14b8a6;
            }
            .rekomen-checkbox.checked::after {
                content: '';
                display: block;
                width: 5px;
                height: 9px;
                border: 2px solid white;
                border-top: none;
                border-left: none;
                transform: rotate(45deg) translateY(-1px);
            }

            .rekomen-label {
                font-size: 0.82rem;
                color: #334155;
            }
            .rekomen-label strong { font-weight: 700; color: #1e293b; }
            .rekomen-label span   { color: #64748b; }

            /* ── Skor & Footer ── */
            .skor-footer {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 14px;
                padding-top: 12px;
                flex-wrap: wrap;
                margin-bottom: 28px;
            }
            .skor-display {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
            }
            .skor-count {
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 6px 16px;
                font-size: 0.9rem;
                font-weight: 800;
                color: #1e293b;
                min-width: 80px;
                text-align: center;
            }
            .btn-reset {
                padding: 9px 22px;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                font-family: 'Poppins', sans-serif;
            }
            .btn-reset:hover { border-color: #94a3b8; color: #1e293b; }

            .btn-simpan {
                padding: 9px 26px;
                border: none;
                border-radius: 8px;
                background: #14b8a6;
                color: white;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
                font-family: 'Poppins', sans-serif;
            }
            .btn-simpan:hover { background: #0d9488; }

            /* ── Rubrik Table ── */
            .rubrik-section {
                margin-top: 8px;
            }
            .rubrik-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                font-size: 0.82rem;
            }
            .rubrik-table th {
                background: #f8fafc;
                font-size: 0.82rem;
                font-weight: 700;
                color: #1e293b;
                padding: 12px 16px;
                text-align: left;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .rubrik-table th:last-child { border-right: none; }
            .rubrik-table td {
                padding: 12px 16px;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }
            .rubrik-table td:last-child  { border-right: none; }
            .rubrik-table tbody tr:last-child td { border-bottom: none; }
            .rubrik-table .skor-cell {
                text-align: center;
                font-weight: 800;
                font-size: 0.95rem;
                color: #1e293b;
                width: 60px;
            }
            .rubrik-table .kategori-cell {
                width: 130px;
                font-weight: 700;
                color: #1e293b;
            }
        </style>
    </x-slot>

    {{-- Back --}}
    <a href="{{ route('bod.dashboard') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
        </svg>
        Kembali
    </a>

    {{-- Title --}}
    <p class="penilaian-title">Penilaian BOD</p>

    {{-- Info Card (dark) --}}
    <div class="info-card">
        <div>
            <div class="info-row">
                <label>Nama Talent</label>
                <span>{{ $talent->nama }}</span>
            </div>
            <div class="info-row mt-2">
                <label>Posisi saat ini</label>
                <span>{{ optional($talent->position)->position_name ?? '-' }}</span>
            </div>
            <div class="info-row mt-2">
                <label>Departemen</label>
                <span>{{ optional($talent->department)->nama_department ?? '-' }}</span>
            </div>
            <div class="info-row mt-2">
                <label>Judul Presentasi</label>
                <span>{{ $project->title ?? 'Pengembangan bla bla bla' }}</span>
            </div>
        </div>
        <div>
            <div class="info-row">
                <label>Nama Penilai</label>
                <span>{{ $user->nama ?? $user->name ?? '-' }}</span>
            </div>
            <div class="info-row mt-2">
                <label>Tanggal Penilaian</label>
                <input type="date" id="tanggal-penilaian" value="{{ now()->format('Y-m-d') }}">
            </div>
        </div>
    </div>

    {{-- Aspek Penilaian --}}
    <p class="section-heading">Aspek Penilaian</p>
    <div class="overflow-x-auto">
        <table class="aspek-table" id="aspek-table">
            <thead>
                <tr>
                    <th class="col-aspek">Aspek yang Dinilai</th>
                    <th class="col-indikator">Indikator Penilaian</th>
                    <th class="col-status">Status Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $aspects = [
                        ['name' => 'Pemahaman Bisnis & Strategi',         'indicator' => 'Memahami konteks industri, Business proses dan arah perusahaan'],
                        ['name' => 'Identifikasi Masalah',                'indicator' => 'Masalah yang diangkat relevan, kritis, dan berbasis data'],
                        ['name' => 'Analisis Akar Masalah',               'indicator' => "Penggunaan tools (Fishbone, 5 Why's atau yang lain), logis dan mendalam"],
                        ['name' => 'Solusi yang Ditawarkan',              'indicator' => 'Solusi konkret, realistis, dan menjawab akar masalah'],
                        ['name' => 'Rencana Implementasi',                'indicator' => 'Timeline jelas, tahapan logis, melibatkan stakeholder'],
                        ['name' => 'Target Dampak & KPI',                 'indicator' => 'Indikator keberhasilan terukur, baseline–target jelas'],
                        ['name' => 'Risiko & Mitigasi',                   'indicator' => 'Mengenali risiko dan menyusun strategi antisipasi'],
                        ['name' => 'Gaya Presentasi & Penguasaan Materi', 'indicator' => 'Komunikatif, percaya diri, menjawab pertanyaan'],
                        ['name' => 'Refleksi Peran sebagai GM',           'indicator' => 'Menunjukkan kesiapan mindset kepemimpinan, Strategic Thingking dan Conceptual thinking.'],
                        ['name' => 'Nilai Tambah',                        'indicator' => 'Inisiatif ekstra, kolaborasi, atau insight mendalam'],
                    ];
                @endphp
                @foreach($aspects as $i => $aspect)
                    <tr>
                        <td class="col-aspek">{{ $aspect['name'] }}</td>
                        <td class="col-indikator">{{ $aspect['indicator'] }}</td>
                        <td class="col-status">
                            <div class="score-btns" data-row="{{ $i }}">
                                @for($s = 1; $s <= 5; $s++)
                                    <button type="button"
                                            class="score-btn"
                                            data-row="{{ $i }}"
                                            data-score="{{ $s }}"
                                            onclick="selectScore({{ $i }}, {{ $s }})">{{ $s }}</button>
                                @endfor
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Komentar --}}
    <div class="comment-box">
        <div class="comment-box-label">Komentar / Catatan Penilai:</div>
        <textarea class="comment-textarea" id="komentar" placeholder="Tambahkan komentar ke talent.."></textarea>
    </div>

    {{-- Rekomendasi Panelis --}}
    <div class="rekomen-box">
        <div class="rekomen-title">Rekomendasi Panelis:</div>

        @php
            $rekomenOptions = [
                ['id' => 'r0', 'label' => 'Ready Now',          'desc' => 'Siap dipromosikan dalam < 6 bulan'],
                ['id' => 'r1', 'label' => 'Ready in 1 – 2 Years','desc' => 'Siap dengan pengembangan terarah'],
                ['id' => 'r2', 'label' => 'Ready in > 2 Years',  'desc' => 'Masih membutuhkan pengembangan signifikan'],
                ['id' => 'r3', 'label' => 'Not Ready',           'desc' => 'Belum direkomendasikan untuk jalur suksesi saat ini'],
            ];
        @endphp

        @foreach($rekomenOptions as $opt)
            <div class="rekomen-option" onclick="selectRekomen('{{ $opt['id'] }}')">
                <div class="rekomen-checkbox" id="{{ $opt['id'] }}"></div>
                <div class="rekomen-label">
                    <strong>{{ $opt['label'] }}</strong>
                    <span> ({{ $opt['desc'] }})</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Skor + Buttons --}}
    <div class="skor-footer">
        <div class="skor-display">
            <span>Skor</span>
            <div class="skor-count" id="skor-display">0 / 50</div>
        </div>
        <button class="btn-reset" onclick="resetAll()">Reset</button>
        <button class="btn-simpan" onclick="simpanPenilaian()">Simpan</button>
    </div>

    {{-- Rubrik Skor ── --}}
    <div class="rubrik-section">
        <p class="section-heading">Rubrik Skor Penilaian</p>
        <table class="rubrik-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:60px;">Skor</th>
                    <th style="width:130px;">Kategori</th>
                    <th>Deskripsi Singkat Penilaian</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="skor-cell">5</td>
                    <td class="kategori-cell">Sangat Baik</td>
                    <td>Menunjukkan keunggulan luar biasa, melampaui ekspektasi, analisis & solusi sangat kuat</td>
                </tr>
                <tr>
                    <td class="skor-cell">4</td>
                    <td class="kategori-cell">Baik</td>
                    <td>Memenuhi ekspektasi dengan baik, logis dan tepat, ada insight yang relevan</td>
                </tr>
                <tr>
                    <td class="skor-cell">3</td>
                    <td class="kategori-cell">Cukup</td>
                    <td>Cukup baik tapi masih bisa dikembangkan, kurang dalam eksplorasi/solusi kurang tajam</td>
                </tr>
                <tr>
                    <td class="skor-cell">2</td>
                    <td class="kategori-cell">Kurang</td>
                    <td>Analisis atau solusi belum tepat atau dangkal, banyak asumsi, kurang relevan</td>
                </tr>
                <tr>
                    <td class="skor-cell">1</td>
                    <td class="kategori-cell">Sangat Kurang</td>
                    <td>Gagal menangkap inti masalah, solusi tidak relevan, pemahaman rendah</td>
                </tr>
            </tbody>
        </table>
    </div>

    <x-slot name="scripts">
        <script>
            // scores[rowIndex] = selected score (1-5) or 0
            const scores = new Array(10).fill(0);
            const MAX_SCORE = 50; // 10 aspects × 5

            function selectScore(row, score) {
                scores[row] = score;
                // Update button states for that row
                document.querySelectorAll(`.score-btn[data-row="${row}"]`).forEach(btn => {
                    const s = parseInt(btn.getAttribute('data-score'));
                    btn.classList.toggle('selected', s === score);
                });
                updateTotal();
            }

            function updateTotal() {
                const total = scores.reduce((a, b) => a + b, 0);
                document.getElementById('skor-display').textContent = total + ' / ' + MAX_SCORE;
            }

            // Single-select rekomendasi
            let selectedRekomen = null;
            function selectRekomen(id) {
                if (selectedRekomen) {
                    document.getElementById(selectedRekomen).classList.remove('checked');
                }
                if (selectedRekomen === id) {
                    selectedRekomen = null;
                    return;
                }
                selectedRekomen = id;
                document.getElementById(id).classList.add('checked');
            }

            function resetAll() {
                scores.fill(0);
                document.querySelectorAll('.score-btn').forEach(b => b.classList.remove('selected'));
                updateTotal();
                if (selectedRekomen) {
                    document.getElementById(selectedRekomen).classList.remove('checked');
                    selectedRekomen = null;
                }
                document.getElementById('komentar').value = '';
            }

            function simpanPenilaian() {
                const total = scores.reduce((a, b) => a + b, 0);
                if (total === 0) {
                    alert('Harap isi minimal satu skor penilaian terlebih dahulu.');
                    return;
                }
                alert('Penilaian berhasil disimpan! Total skor: ' + total + ' / ' + MAX_SCORE);
                window.location = '{{ route("bod.dashboard") }}';
            }
        </script>
    </x-slot>

</x-bod.layout>
