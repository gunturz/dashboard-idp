<x-pdc_admin.layout title="Lihat Penilaian Panelis – Individual Development Plan" :user="$user" :hideSidebar="true">
    <x-slot name="styles">
        <style>
            /* ── Section Title ── */
            .section-title {
                font-size: 1.2rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 16px;
                padding-left: 4px;
            }

            /* ── Penilaian Table ── */
            .penilaian-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
                border: 1px solid #e2e8f0;
            }

            .penilaian-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                white-space: nowrap;
            }

            .penilaian-table td {
                text-align: center;
                padding: 18px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
                min-height: 60px;
            }

            .penilaian-table td.text-left-cell {
                text-align: left;
            }

            .status-text {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.85rem;
                display: block;
            }

            .status-sub {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 2px;
            }

            /* ── Bottom Buttons ── */
            .btn-batal {
                padding: 10px 28px;
                border-radius: 10px;
                border: 1.5px solid #e2e8f0;
                background: white;
                color: #475569;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }

            .btn-batal:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            .btn-selesai {
                padding: 10px 28px;
                border-radius: 10px;
                border: none;
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: white;
                font-size: 0.875rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 8px rgba(245, 158, 11, 0.35);
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .btn-selesai:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 14px rgba(245, 158, 11, 0.45);
            }

            /* ── Decision Modal ── */
            #decisionModal,
            #confirmModal {
                display: none;
            }

            .decision-card {
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                padding: 18px 14px;
                text-align: center;
                cursor: pointer;
                transition: all 0.22s;
                background: white;
            }

            .decision-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            }

            .decision-card.ready-now:hover     { border-color: #22c55e; }
            .decision-card.ready-1-2:hover     { border-color: #3b82f6; }
            .decision-card.ready-over-2:hover  { border-color: #f59e0b; }
            .decision-card.not-ready:hover     { border-color: #ef4444; }

            .decision-card .card-icon {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 10px;
                font-size: 1.4rem;
            }

            .decision-card.ready-now    .card-icon { background: rgba(34, 197, 94, 0.12); }
            .decision-card.ready-1-2    .card-icon { background: rgba(59, 130, 246, 0.12); }
            .decision-card.ready-over-2 .card-icon { background: rgba(245, 158, 11, 0.12); }
            .decision-card.not-ready    .card-icon { background: rgba(239, 68, 68, 0.10); }

            .decision-card h4 {
                font-size: 0.875rem;
                font-weight: 800;
                margin-bottom: 4px;
            }

            .decision-card.ready-now    h4 { color: #16a34a; }
            .decision-card.ready-1-2    h4 { color: #2563eb; }
            .decision-card.ready-over-2 h4 { color: #d97706; }
            .decision-card.not-ready    h4 { color: #dc2626; }

            .decision-card p {
                font-size: 0.72rem;
                color: #64748b;
                line-height: 1.4;
            }

            .decision-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
        </style>
    </x-slot>

    {{-- ── Talent Profile Header ── --}}
    @php
        $namaTalent = $talent->nama ?? '-';
        $parts = explode(' ', trim($namaTalent));
        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

        $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
        if (!empty($mentorIds)) {
            $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->implode(', ');
        } else {
            $mentorNames = optional($talent->mentor)->nama ?? '-';
        }

        $startDate = optional($talent->promotion_plan)->start_date;
        $targetDate = optional($talent->promotion_plan)->target_date;
        $periodeStr = ($startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '-')
            . ' – '
            . ($targetDate ? \Carbon\Carbon::parse($targetDate)->format('d/m/Y') : '-');
    @endphp

    {{-- CSS identik dengan Talent profile-card --}}
    <style>
        .talent-prof-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #2a4060 100%);
            padding: 28px 32px;
            display: flex;
            align-items: stretch;
            gap: 0;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            margin-bottom: 28px;
        }

        .talent-prof-hero::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(20, 184, 166, 0.08);
            pointer-events: none;
        }

        .talent-prof-hero::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 30%;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            pointer-events: none;
        }

        .talent-hero-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .talent-hero-avatar-img {
            width: 96px;
            height: 96px;
            border-radius: 20px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        .talent-hero-avatar-placeholder {
            width: 96px;
            height: 96px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            font-weight: 800;
            color: white;
            border: 3px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            letter-spacing: -1px;
        }

        .talent-hero-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
            padding: 0 28px;
            position: relative;
            z-index: 1;
        }

        .talent-hero-section-1 {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 0 28px 0 0;
            position: relative;
            z-index: 1;
        }

        .talent-hero-divider {
            width: 1px;
            align-self: stretch;
            background: rgba(255, 255, 255, 0.15);
            flex-shrink: 0;
            margin: 4px 0;
        }

        .talent-hero-info {
            min-width: 0;
        }

        .talent-hero-name {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .talent-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(20, 184, 166, 0.18);
            border: 1px solid rgba(20, 184, 166, 0.3);
            color: #5eead4;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 99px;
            margin-top: 10px;
            letter-spacing: .04em;
        }

        .talent-hero-badge::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #14b8a6;
            animation: pulse-dot-hero 2s ease infinite;
        }

        @keyframes pulse-dot-hero {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .4
            }
        }

        .talent-hero-meta-label {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
            line-height: 1.2;
        }

        .talent-hero-meta-value {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.92);
            font-weight: 700;
            margin-top: 1px;
            line-height: 1.3;
        }

        .talent-hero-meta-row {
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 1024px) {
            .talent-hero-section {
                padding: 0 16px;
            }

            .talent-hero-section-1 {
                padding: 0 16px 0 0;
            }
        }

        @media (max-width: 768px) {
            .talent-prof-hero {
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                padding: 20px 20px;
            }

            .talent-hero-section,
            .talent-hero-section-1 {
                flex: none;
            }

            .talent-hero-section-1 {
                padding: 0;
                flex-direction: row;
                align-items: center;
            }

            .talent-hero-divider {
                width: auto;
                height: 1px;
                align-self: auto;
                margin: 16px 0;
            }

            .talent-hero-section {
                padding: 0;
            }
        }
    </style>

    <div class="talent-prof-hero" style="box-shadow:0 8px 32px rgba(15,23,42,0.35);">

        {{-- Section 1: Avatar + Identity --}}
        <div class="talent-hero-section-1">
            <div class="talent-hero-avatar-wrap">
                @if ($talent->foto ?? false)
                    <img src="{{ asset('storage/' . $talent->foto) }}" alt="Foto Profil" class="talent-hero-avatar-img">
                @else
                    <div class="talent-hero-avatar-placeholder">{{ $initials }}</div>
                @endif
            </div>
            <div class="talent-hero-info">
                <div class="talent-hero-name">{{ $namaTalent }}</div>
                <div class="talent-hero-badge">Talent</div>
            </div>
        </div>

        <div class="talent-hero-divider"></div>

        {{-- Section 2: Perusahaan, Departemen, Posisi --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Perusahaan</span>
                <span class="talent-hero-meta-value">{{ optional($talent->company)->nama_company ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Departemen</span>
                <span class="talent-hero-meta-value">{{ optional($talent->department)->nama_department ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Posisi yang Dituju</span>
                <span
                    class="talent-hero-meta-value">{{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
            </div>
        </div>

        <div class="talent-hero-divider"></div>

        {{-- Section 3: Mentor, Atasan, Periode --}}
        <div class="talent-hero-section flex-1">
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Mentor</span>
                <span class="talent-hero-meta-value">{{ $mentorNames }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Atasan</span>
                <span class="talent-hero-meta-value">{{ optional($talent->atasan)->nama ?? '-' }}</span>
            </div>
            <div class="talent-hero-meta-row">
                <span class="talent-hero-meta-label">Periode</span>
                <span class="talent-hero-meta-value">{{ $periodeStr }}</span>
            </div>
        </div>

    </div>


    {{-- ── Success Message ── --}}
    @if (session('success'))
        <div
            class="flex items-center gap-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Section Title ── --}}
    @php
        $projectTitle =
            optional($latestProject)->title ??
            'Penilaian Panelis – ' . (optional($talent->company)->nama_company ?? '-');
    @endphp
    <h3 class="section-title">{{ $projectTitle }}</h3>

    {{-- ── Penilaian Table ── --}}
    <div class="overflow-x-auto rounded-xl shadow-sm mb-8">
        <table class="penilaian-table">
            <thead>
                <tr>
                    <th class="w-[20%]">Penilai Panelis</th>
                    <th class="w-[20%]">Perusahaan</th>
                    <th class="w-[7%]">Skor</th>
                    <th class="w-[33%]">Feedback</th>
                    <th class="w-[20%]">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($panelisUsers as $i => $panelis)
                    @php
                        $assessment = \App\Models\PanelisAssessment::where('user_id_talent', $talent->id)
                            ->where('panelis_id', $panelis->id)
                            ->first();
                        $isAssessor = $assessment !== null;
                    @endphp
                    <tr>
                        {{-- Penilai Panelis --}}
                        <td class="text-left-cell">
                            <span class="font-semibold text-[#1e293b]">{{ $panelis->nama }}</span>
                            @if ($panelis->position)
                                <span class="block text-xs text-[#64748b] italic">{{ $panelis->position->position_name }}</span>
                            @endif
                        </td>

                        {{-- Perusahaan --}}
                        <td>
                            @if (optional($panelis->company)->nama_company)
                                {{ $panelis->company->nama_company }}
                            @endif
                        </td>

                        {{-- Skor --}}
                        <td>
                            @if ($isAssessor && $assessment->panelis_score)
                                <span class="font-bold text-[#1e293b]">{{ $assessment->panelis_score }} /
                                    50</span>
                            @endif
                        </td>

                        {{-- Feedback --}}
                        <td>
                            @if ($isAssessor)
                                {{ $assessment->panelis_komentar }}
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="text-left-cell">
                            @if ($isAssessor && $assessment->panelis_rekomendasi)
                                @php
                                    $rekomen = $assessment->panelis_rekomendasi;
                                    $desc = '';
                                    if (str_contains($rekomen, 'Ready Now')) {
                                        $desc = 'Siap dipromosikan dalam < 6 bulan';
                                    } elseif (str_contains($rekomen, '1 – 2')) {
                                        $desc = 'Siap dengan pengembangan terarah';
                                    } elseif (str_contains($rekomen, '> 2')) {
                                        $desc = 'Masih membutuhkan pengembangan signifikan';
                                    } elseif (str_contains($rekomen, 'Not Ready')) {
                                        $desc = 'Belum direkomendasikan untuk jalur suksesi';
                                    }
                                @endphp
                                <span class="status-text">{{ $rekomen }}</span>
                                @if ($desc)
                                    <span class="status-sub">({{ $desc }})</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-gray-400 py-8">Belum ada panelis yang ditugaskan untuk talent ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Bottom Actions ── --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('pdc_admin.panelis_review') }}" class="btn-batal" id="batal-panelis-detail">Kembali</a>

        @php
            $statusPromo = optional($talent->promotion_plan)->status_promotion;
            $isComplete = in_array($statusPromo, ['Promoted', 'Not Promoted', 'Approved Panelis', 'Rejected Panelis']);
        @endphp

        @if ($isComplete)
            @if ($statusPromo === 'Promoted')
                <button class="btn-selesai"
                    style="background: #22c55e; box-shadow: 0 2px 8px rgba(34,197,94,0.3); cursor: default;" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Ready Now — Diangkat ✓
                </button>
            @elseif ($statusPromo === 'Not Promoted')
                <button class="btn-selesai"
                    style="background: #64748b; box-shadow: 0 2px 8px rgba(100,116,139,0.3); cursor: default;" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Keputusan Telah Ditetapkan ✓
                </button>
            @else
                <button class="btn-selesai" style="background: #e2e8f0; color: #64748b; box-shadow: none; cursor: default;"
                    disabled>
                    Sudah Selesai
                </button>
            @endif
        @else
            <button type="button" class="btn-selesai" id="selesai-panelis-detail" onclick="openDecisionModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                Selesai
            </button>
        @endif
    </div>

    {{-- ── Hidden Form untuk submit keputusan ── --}}
    <form method="POST" action="{{ route('pdc_admin.panelis_review.complete', $talent->id) }}" id="form-decision">
        @csrf
        <input type="hidden" name="decision" id="decisionValue" value="">
    </form>

    {{-- ── MODAL STEP 1: Pilih Keputusan ── --}}
    <div id="decisionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(15,23,42,0.55); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden animate-in">
            {{-- Header --}}
            <div class="px-6 pt-6 pb-4">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="text-xl font-bold text-[#1e293b]">Decision</h3>
                    <button type="button" onclick="closeDecisionModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-[#64748b]">Tentukan hasil promosi untuk <span
                        class="font-semibold text-[#1e293b]">{{ $talent->nama }}</span></p>
            </div>
            {{-- Decision Cards 2x2 Grid --}}
            <div class="px-6 pb-2 decision-grid">

                {{-- Ready Now --}}
                <div class="decision-card ready-now" onclick="selectDecision('ready_now')">
                    <div class="card-icon">🏆</div>
                    <h4>Ready Now</h4>
                    <p>Talent siap & resmi diangkat ke posisi target sekarang</p>
                </div>

                {{-- Ready in 1-2 Years --}}
                <div class="decision-card ready-1-2" onclick="selectDecision('ready_1_2_years')">
                    <div class="card-icon">📈</div>
                    <h4>Ready in 1–2 Years</h4>
                    <p>Diproyeksikan siap promosi dalam 1–2 tahun dengan pengembangan terarah</p>
                </div>

                {{-- Ready in > 2 Years --}}
                <div class="decision-card ready-over-2" onclick="selectDecision('ready_over_2_years')">
                    <div class="card-icon">🕐</div>
                    <h4>Ready in &gt; 2 Years</h4>
                    <p>Masih membutuhkan pengembangan signifikan sebelum siap promosi</p>
                </div>

                {{-- Not Ready --}}
                <div class="decision-card not-ready" onclick="selectDecision('not_ready')">
                    <div class="card-icon">❌</div>
                    <h4>Not Ready</h4>
                    <p>Belum direkomendasikan untuk jalur suksesi pada periode ini</p>
                </div>

            </div>
            {{-- Footer --}}
            <div class="px-6 py-4 flex justify-end">
                <button type="button" onclick="closeDecisionModal()"
                    class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
            </div>
        </div>
    </div>

    {{-- ── MODAL STEP 2: Konfirmasi ── --}}
    <div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(15,23,42,0.55); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
            {{-- Icon + Header --}}
            <div class="px-6 pt-7 pb-4 text-center">
                <div id="confirmIcon"
                    class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl"></div>
                <h3 class="text-lg font-bold text-[#1e293b] mb-2" id="confirmTitle"></h3>
                <p class="text-sm text-[#475569]" id="confirmDesc"></p>
            </div>
            {{-- Warning note --}}
            <div class="mx-6 mb-4 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                <p class="text-xs text-amber-700 font-medium">⚠️ Tindakan ini tidak dapat dibatalkan setelah
                    dikonfirmasi.</p>
            </div>
            {{-- Footer --}}
            <div class="px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
                <button type="button" onclick="backToDecision()"
                    class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Kembali</button>
                <button type="button" onclick="submitDecision()" id="confirmBtn"
                    class="px-6 py-2 text-sm font-bold text-white rounded-xl transition-colors">Ya, Konfirmasi</button>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            let pendingDecision = null;

            function openDecisionModal() {
                document.getElementById('decisionModal').style.display = 'flex';
            }

            function closeDecisionModal() {
                document.getElementById('decisionModal').style.display = 'none';
                pendingDecision = null;
            }

            function selectDecision(decision) {
                pendingDecision = decision;
                document.getElementById('decisionModal').style.display = 'none';

                const confirmIcon  = document.getElementById('confirmIcon');
                const confirmTitle = document.getElementById('confirmTitle');
                const confirmDesc  = document.getElementById('confirmDesc');
                const confirmBtn   = document.getElementById('confirmBtn');

                const decisionMap = {
                    ready_now: {
                        icon: '🏆', bg: 'rgba(34,197,94,0.12)',
                        title: 'Konfirmasi: Ready Now',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> sebagai <strong class="text-green-600">DIANGKAT</strong> ke posisi target sekarang. Posisi talent akan diperbarui otomatis.',
                        btnColor: '#22c55e'
                    },
                    ready_1_2_years: {
                        icon: '📈', bg: 'rgba(59,130,246,0.12)',
                        title: 'Konfirmasi: Ready in 1–2 Years',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> dengan keputusan <strong class="text-blue-600">READY IN 1–2 YEARS</strong>. Talent belum diangkat pada periode ini.',
                        btnColor: '#3b82f6'
                    },
                    ready_over_2_years: {
                        icon: '🕐', bg: 'rgba(245,158,11,0.12)',
                        title: 'Konfirmasi: Ready in > 2 Years',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> dengan keputusan <strong class="text-amber-600">READY IN &gt; 2 YEARS</strong>. Talent belum diangkat pada periode ini.',
                        btnColor: '#f59e0b'
                    },
                    not_ready: {
                        icon: '❌', bg: 'rgba(239,68,68,0.1)',
                        title: 'Konfirmasi: Not Ready',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> sebagai <strong class="text-red-600">NOT READY</strong>. Talent belum diangkat pada periode ini.',
                        btnColor: '#ef4444'
                    },
                };

                const cfg = decisionMap[decision];
                if (!cfg) return;

                confirmIcon.innerHTML = cfg.icon;
                confirmIcon.style.background = cfg.bg;
                confirmTitle.textContent = cfg.title;
                confirmDesc.innerHTML = cfg.desc;
                confirmBtn.style.background = cfg.btnColor;

                document.getElementById('confirmModal').style.display = 'flex';
            }

            function backToDecision() {
                document.getElementById('confirmModal').style.display = 'none';
                document.getElementById('decisionModal').style.display = 'flex';
            }

            function submitDecision() {
                if (!pendingDecision) return;
                document.getElementById('decisionValue').value = pendingDecision;
                document.getElementById('form-decision').submit();
            }

            // Tutup modal jika klik overlay
            ['decisionModal', 'confirmModal'].forEach(id => {
                document.getElementById(id).addEventListener('click', function (e) {
                    if (e.target === this) {
                        if (id === 'decisionModal') closeDecisionModal();
                        else backToDecision();
                    }
                });
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>