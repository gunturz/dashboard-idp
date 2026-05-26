<x-pdc_admin.layout title="Lihat Penilaian Panelis – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Section Title ── */
            .section-title {
                font-family: 'Poppins', sans-serif;
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
                padding: 45px 14px 20px 14px;
                text-align: center;
                cursor: pointer;
                transition: all 0.22s;
                background: white;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                min-height: 145px;
            }

            .decision-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            }

            .decision-card.ready-now:hover {
                border-color: #22c55e;
            }

            .decision-card.ready-1-2:hover {
                border-color: #3b82f6;
            }

            .decision-card.ready-over-2:hover {
                border-color: #f59e0b;
            }

            .decision-card.not-ready:hover {
                border-color: #ef4444;
            }

            .decision-card h4 {
                font-size: 0.875rem;
                font-weight: 800;
                margin-bottom: 4px;
            }

            .decision-card.ready-now h4 {
                color: #16a34a;
            }

            .decision-card.ready-1-2 h4 {
                color: #2563eb;
            }

            .decision-card.ready-over-2 h4 {
                color: #d97706;
            }

            .decision-card.not-ready h4 {
                color: #dc2626;
            }

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
        $backUrl = request()->get('back_url')
            ? (filter_var(urldecode(request()->get('back_url')), FILTER_VALIDATE_URL) ?:
            route('pdc_admin.panelis_review'))
            : route('pdc_admin.panelis_review');
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
        $periodeStr =
            ($startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '-') .
            ' – ' .
            ($targetDate ? \Carbon\Carbon::parse($targetDate)->format('d/m/Y') : '-');
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
            font-family: 'Poppins', sans-serif;
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

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title mb-6">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path fill-rule="evenodd"
                    d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Panelis Review</div>
            <div class="page-header-sub">Detail hasil penilaian panelis untuk talent {{ $namaTalent }}</div>
        </div>
    </div>

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
        <div id="success-alert"
            class="flex items-center gap-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                fill="currentColor">
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
    <div class="overflow-x-auto border border-gray-200 rounded-xl overflow-hidden w-full mb-8">
        <table class="w-full table-auto text-left bg-white min-w-[700px]">
            <thead class="bg-slate-50 border-b border-gray-200">
                <tr>
                    <th class="w-[20%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Penilai
                        Panelis</th>
                    <th class="w-[20%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                        Perusahaan</th>
                    <th class="w-[8%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Skor
                    </th>
                    <th class="w-[32%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                        Feedback</th>
                    <th class="w-[20%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($panelisUsers as $i => $panelis)
                    @php
                        $assessment = $panelisAssessmentsByPanelis[$panelis->id] ?? null;
                        $isAssessor = $assessment !== null;
                    @endphp
                    <tr
                        class="hover:bg-teal-50/50 transition duration-150 {{ $loop->last ? '' : 'border-b border-gray-200' }}">
                        {{-- Penilai Panelis --}}
                        <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                            <div class="font-bold text-sm text-slate-800 leading-tight">{{ $panelis->nama }}</div>
                            @if ($panelis->position)
                                <div class="text-xs text-slate-500 italic mt-0.5">
                                    {{ $panelis->position->position_name }}</div>
                            @endif
                        </td>

                        {{-- Perusahaan --}}
                        <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                            <div class="text-sm text-slate-700">
                                {{ optional($panelis->company)->nama_company ?? '-' }}
                            </div>
                        </td>

                        {{-- Skor --}}
                        <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                            <div class="font-bold text-sm text-slate-800">
                                @if ($isAssessor && $assessment->panelis_score)
                                    {{ $assessment->panelis_score }} / 50
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </div>
                        </td>

                        {{-- Feedback --}}
                        <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                            <div class="text-sm text-slate-700">
                                @if ($isAssessor && $assessment->panelis_komentar)
                                    {{ $assessment->panelis_komentar }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
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
                                <div class="font-bold text-sm text-slate-800">{{ $rekomen }}</div>
                                @if ($desc)
                                    <div class="text-[0.7rem] text-slate-500 mt-0.5">{{ $desc }}</div>
                                @endif
                            @else
                                <span class="text-slate-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-slate-400 text-sm py-6">Belum ada panelis yang
                            ditugaskan untuk talent ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Bottom Actions ── --}}
    <div class="flex justify-end gap-3">
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
                <button class="btn-selesai"
                    style="background: #e2e8f0; color: #64748b; box-shadow: none; cursor: default;" disabled>
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
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
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
                    <h4>Ready Now</h4>
                    <p>Talent siap & resmi diangkat ke posisi target sekarang</p>
                </div>

                {{-- Ready in 1-2 Years --}}
                <div class="decision-card ready-1-2" onclick="selectDecision('ready_1_2_years')">
                    <h4>Ready in 1–2 Years</h4>
                    <p>Diproyeksikan siap promosi dalam 1–2 tahun dengan pengembangan terarah</p>
                </div>

                {{-- Ready in > 2 Years --}}
                <div class="decision-card ready-over-2" onclick="selectDecision('ready_over_2_years')">
                    <h4>Ready in &gt; 2 Years</h4>
                    <p>Masih membutuhkan pengembangan signifikan sebelum siap promosi</p>
                </div>

                {{-- Not Ready --}}
                <div class="decision-card not-ready" onclick="selectDecision('not_ready')">
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
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-6 pt-12 pb-4 text-center">
                <h3 class="text-lg font-bold text-[#1e293b] mb-3" id="confirmTitle"></h3>
                <div class="min-h-[70px] flex items-center justify-center">
                    <p class="text-sm text-[#475569]" id="confirmDesc"></p>
                </div>
            </div>
            {{-- Warning note --}}
            <div class="mx-6 mb-4 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                <p class="text-xs text-amber-700 font-medium">⚠️ Tindakan ini tidak dapat dibatalkan setelah
                    dikonfirmasi.</p>
            </div>
            {{-- Footer --}}
            <div class="px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
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

                const confirmTitle = document.getElementById('confirmTitle');
                const confirmDesc = document.getElementById('confirmDesc');
                const confirmBtn = document.getElementById('confirmBtn');

                const decisionMap = {
                    ready_now: {
                        title: 'Konfirmasi: Ready Now',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> sebagai <strong class="text-green-600">DIANGKAT</strong> ke posisi target sekarang. Posisi talent akan diperbarui otomatis.',
                        btnColor: '#22c55e'
                    },
                    ready_1_2_years: {
                        title: 'Konfirmasi: Ready in 1–2 Years',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> dengan keputusan <strong class="text-blue-600">READY IN 1–2 YEARS</strong>. Talent belum diangkat pada periode ini.',
                        btnColor: '#3b82f6'
                    },
                    ready_over_2_years: {
                        title: 'Konfirmasi: Ready in > 2 Years',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> dengan keputusan <strong class="text-amber-600">READY IN &gt; 2 YEARS</strong>. Talent belum diangkat pada periode ini.',
                        btnColor: '#f59e0b'
                    },
                    not_ready: {
                        title: 'Konfirmasi: Not Ready',
                        desc: 'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> sebagai <strong class="text-red-600">NOT READY</strong>. Talent belum diangkat pada periode ini.',
                        btnColor: '#ef4444'
                    },
                };

                const cfg = decisionMap[decision];
                if (!cfg) return;

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
                document.getElementById(id).addEventListener('click', function(e) {
                    if (e.target === this) {
                        if (id === 'decisionModal') closeDecisionModal();
                        else backToDecision();
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    setTimeout(function() {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 5000);
                }
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>
