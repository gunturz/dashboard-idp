<x-atasan.layout title="Dashboard Atasan – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ══ Talent Card Refinement ══ */
            .talent-card {
                background: #f9fafb;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 24px;
                border-bottom: 1px solid #f1f5f9;
            }

            .card-header-left {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .talent-avatar {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #f1f5f9;
                flex-shrink: 0;
            }

            .talent-name-block .name {
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                display: block;
                line-height: 1.2;
            }

            .talent-name-block .role {
                font-size: 0.85rem;
                color: #64748b;
                display: flex;
                align-items: center;
                gap: 4px;
                margin-top: 3px;
            }

            .card-info {
                padding: 20px 24px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .competency-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                margin-bottom: 20px;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e2e8f0;
            }

            .competency-table th {
                background: #f1f5f9;
                padding: 12px 14px;
                font-size: 0.8rem;
                font-weight: 800;
                color: #334155;
                text-transform: uppercase;
                letter-spacing: 0.025em;
                border-bottom: 1px solid #e2e8f0;
            }

            .competency-table td {
                padding: 12px 14px;
                font-size: 0.9rem;
                color: #1e293b;
                border-bottom: 1px solid #e2e8f0;
                text-align: center;
                background: #ffffff;
                transition: background-color 0.2s ease;
            }

            .competency-table tr:hover td {
                background: #f8fafc;
            }

            .competency-table tr:last-child td {
                border-bottom: none;
            }

            .competency-table td:first-child {
                text-align: left;
                font-weight: 600;
                color: #0f172a;
            }

            .btn-assessment {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 12px;
                border-radius: 12px;
                font-size: 0.95rem;
                font-weight: 700;
                transition: all 0.2s;
                border: none;
                margin-top: auto;
                text-decoration: none;
            }

            .btn-assessment-active {
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
                color: white;
                box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
            }

            .btn-assessment-active:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(20, 184, 166, 0.3);
            }

            .btn-assessment-done {
                background: #f8fafc;
                color: #94a3b8;
                border: 1.5px solid #e2e8f0;
                cursor: default;
            }

            @media (max-width: 767px) {
                .card-header {
                    padding: 16px;
                }

                .card-info {
                    padding: 16px;
                }

                .talent-avatar {
                    width: 48px;
                    height: 48px;
                }

                .prem-stat-grid {
                    grid-template-columns: 1fr !important;
                }
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="dash-header animate-title">
        <div class="dash-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                <path
                    d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z" />
            </svg>
        </div>
        <div>
            <div class="dash-header-title">Dashboard Atasan</div>
            <div class="dash-header-sub">Pantau perkembangan kompetensi dan progress talent Anda</div>
        </div>
        <div class="dash-header-date hidden md:block">
            Hari ini
            <span>{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="prem-stat-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path
                        d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $totalTalents }}">0</div>
            <div class="prem-stat-label">Total Talent</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $assessmentPending }}">0</div>
            <div class="prem-stat-label">Assessment Pending</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $onTrack }}">0</div>
            <div class="prem-stat-label">On Track</div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8 mt-10">
        <div>
            <h3 class="text-xl font-bold text-[#1e293b]">Daftar Talent</h3>
            <p class="text-sm text-gray-500 mt-0.5 font-medium">Kelola dan lihat perkembangan kompetensi setiap talent
            </p>
        </div>
    </div>

    {{-- ── Talent Cards Grid ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8" id="talent-grid">
        @forelse ($talents as $talent)
            @php
                $session = $talent->assessmentSession;
                $details = $session ? $session->details : collect();
                $hasAtasanScored = $details->sum('score_atasan') > 0;
                $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
                $standards = $allStandards[$positionId] ?? collect();
            @endphp
            <div class="talent-card talent-card-item" data-name="{{ strtolower($talent->nama) }}">
                <div class="card-header">
                    <div class="card-header-left">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=e0f2fe&color=0369a1&bold=true' }}"
                            class="talent-avatar" alt="{{ $talent->nama }}">
                        <div class="talent-name-block">
                            <span class="name">{{ $talent->nama }}</span>
                            <span class="role">
                                <span
                                    class="text-gray-500">{{ optional($talent->position)->position_name ?? '-' }}</span>
                                @if (optional($talent->promotion_plan)->targetPosition)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-300 mx-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    <span
                                        class="text-gray-500">{{ $talent->promotion_plan->targetPosition->position_name }}</span>
                                @endif
                            </span>
                            <div class="mt-1.5">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-wider">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        @if ($hasAtasanScored)
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">Done</span>
                        @endif
                    </div>
                </div>

                <div class="card-info">
                    {{-- Competency Table --}}
                    <table class="competency-table">
                        <thead>
                            <tr>
                                <th>Item Kompetensi</th>
                                <th style="width: 80px;">Target</th>
                                <th style="width: 100px;">Skor Talent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competencies as $comp)
                                @php
                                    $detail = $details->firstWhere('competence_id', $comp->id);
                                    $standard = $standards[$comp->id] ?? 0;
                                    $scoreTalent = $detail->score_talent ?? 0;
                                @endphp
                                <tr>
                                    <td>{{ $comp->name }}</td>
                                    <td class="font-bold text-gray-800">{{ $standard }}</td>
                                    <td>
                                        @if ($scoreTalent)
                                            <span class="font-bold text-[#0d9488]">{{ $scoreTalent }}</span>
                                        @else
                                            <span class="text-slate-400 font-medium">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Assessment Button --}}
                    @if ($details->isNotEmpty())
                        @if ($hasAtasanScored)
                            <div class="btn-assessment btn-assessment-done gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="truncate">Assessment Selesai</span>
                            </div>
                        @else
                            <a href="{{ route('atasan.competency_atasan.page', $talent->id) }}"
                                class="btn-assessment btn-assessment-active">
                                Mulai Isi Assessment
                            </a>
                        @endif
                    @else
                        <div class="btn-assessment btn-assessment-done gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="truncate">Talent belum submit assessment</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div
                class="col-span-1 lg:col-span-2 text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
                <div
                    class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center mb-5 ring-8 ring-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2">Semua Assessment Selesai!</h3>
                <p class="text-slate-500 text-base max-w-sm">Anda telah menyelesaikan tugas assessment untuk seluruh
                    talent di tim Anda</p>
                <a href="{{ route('atasan.riwayat') }}"
                    class="mt-6 px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-base rounded-xl hover:bg-slate-50 transition-all shadow-sm">Buka
                    Halaman Riwayat</a>
            </div>
        @endforelse
    </div>

    <x-slot name="scripts">
        <script>
            // ── Statistical Counter Animation ──
            document.querySelectorAll('.animate-counter').forEach(el => {
                const target = parseInt(el.dataset.target);
                if (target === 0) {
                    el.textContent = '0';
                    return;
                }
                let current = 0;
                const duration = 1000;
                const step = target / (duration / 16);
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        el.textContent = target;
                        clearInterval(timer);
                    } else {
                        el.textContent = Math.floor(current);
                    }
                }, 16);
            });
        </script>
    </x-slot>
</x-atasan.layout>
