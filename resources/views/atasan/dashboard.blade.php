<x-atasan.layout title="Dashboard Atasan – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .summary-card {
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 16px;
                padding: 28px 32px;
                text-align: center;
                transition: all 0.2s;
            }

            .summary-card:hover {
                border-color: #cbd5e1;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            }

            .summary-number {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 8px;
            }

            .summary-label {
                font-size: 0.95rem;
                font-weight: 600;
                color: #64748b;
            }

            .talent-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 28px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.06);
            }

            .talent-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 20px;
            }

            .talent-photo {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #f1f5f9;
            }

            .talent-name {
                font-size: 1.125rem;
                font-weight: 700;
                color: #1e293b;
            }

            .talent-position {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
            }

            .competency-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 16px;
            }

            .competency-table th {
                background: #f8fafc;
                padding: 10px 16px;
                font-size: 0.8rem;
                font-weight: 800;
                color: #1e293b;
                text-align: center;
                border: 1px solid #e2e8f0;
            }

            .competency-table th:first-child {
                text-align: left;
            }

            .competency-table td {
                padding: 10px 16px;
                font-size: 0.85rem;
                color: #475569;
                border: 1px solid #e2e8f0;
                text-align: center;
            }

            .competency-table td:first-child {
                text-align: left;
                font-weight: 500;
            }

            .btn-assessment {
                width: 100%;
                padding: 12px;
                border-radius: 12px;
                font-size: 0.875rem;
                font-weight: 700;
                text-align: center;
                transition: all 0.2s;
                cursor: pointer;
                border: none;
            }

            .btn-assessment-active {
                background: linear-gradient(135deg, #f59e0b, #eab308);
                color: white;
            }

            .btn-assessment-active:hover {
                background: linear-gradient(135deg, #d97706, #ca8a04);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            }

            .btn-assessment-done {
                background: #f8fafc;
                color: #94a3b8;
                border: 1.5px solid #e2e8f0;
                cursor: default;
            }

            /* ══ MOBILE ONLY — does NOT affect desktop ══ */
            @media (max-width: 767px) {
                .summary-card {
                    padding: 20px 16px;
                    border-radius: 12px;
                }
                .summary-number {
                    font-size: 2rem;
                }
                .summary-label {
                    font-size: 0.85rem;
                }
                .talent-card {
                    padding: 20px 16px;
                    border-radius: 12px;
                }
                .talent-header {
                    gap: 12px;
                    margin-bottom: 16px;
                }
                .talent-photo {
                    width: 44px;
                    height: 44px;
                }
                .talent-name {
                    font-size: 1rem;
                }
                .talent-position {
                    font-size: 0.7rem;
                }
                .competency-table th {
                    padding: 8px 10px;
                    font-size: 0.7rem;
                }
                .competency-table td {
                    padding: 8px 10px;
                    font-size: 0.78rem;
                }
                .btn-assessment {
                    padding: 10px;
                    font-size: 0.8rem;
                    border-radius: 10px;
                }
            }

            /* Modal */
            .modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(4px);
                z-index: 100;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s;
            }

            .modal-overlay.active {
                opacity: 1;
                pointer-events: auto;
            }

            .modal-box {
                background: white;
                width: 100%;
                max-width: 550px;
                max-height: 90vh;
                border-radius: 20px;
                padding: 32px;
                overflow-y: auto;
                transform: translateY(20px);
                transition: transform 0.3s;
            }

            .modal-overlay.active .modal-box {
                transform: translateY(0);
            }

            .score-input {
                width: 64px;
                text-align: center;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 8px;
                font-size: 0.875rem;
                font-weight: 700;
                color: #1e293b;
                outline: none;
                transition: border-color 0.2s;
            }

            .score-input:focus {
                border-color: #f59e0b;
            }
        </style>
    </x-slot>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="summary-card">
            <div class="summary-number text-[#2e3746]">{{ $totalTalents }}</div>
            <div class="summary-label">Talent</div>
        </div>
        <div class="summary-card">
            <div class="summary-number text-[#2e3746]">{{ $assessmentPending }}</div>
            <div class="summary-label">Assessment Pending</div>
        </div>
        <div class="summary-card">
            <div class="summary-number text-[#f59e0b]">{{ $onTrack }}</div>
            <div class="summary-label">On track</div>
        </div>
    </div>

    {{-- Talent Cards Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach ($talents as $talent)
            @php
                $session = $talent->assessmentSession;
                $details = $session ? $session->details : collect();
                $hasAtasanScored = $details->sum('score_atasan') > 0;
                $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
                $standards = $allStandards[$positionId] ?? collect();
            @endphp
            <div class="talent-card">
                <div class="talent-header">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                         class="talent-photo" alt="{{ $talent->nama }}">
                    <div>
                        <div class="talent-name">{{ $talent->nama }}</div>
                        <div class="talent-position flex items-center gap-1 flex-wrap">
                            {{ optional($talent->position)->position_name ?? '-' }}
                            @if(optional($talent->promotion_plan)->targetPosition)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-500 font-bold mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                                <span class="text-[#0d9488]">{{ $talent->promotion_plan->targetPosition->position_name }}</span>
                            @endif
                            <span class="ml-3 font-semibold not-italic">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Competency Table --}}
                <table class="competency-table">
                    <thead>
                        <tr>
                            <th>Kompetensi</th>
                            <th>Standar</th>
                            <th>Skor Talent</th>
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
                                <td>{{ $standard }}</td>
                                <td>{{ $scoreTalent ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Assessment Button --}}
                @if ($details->isNotEmpty())
                    @if ($hasAtasanScored)
                        <div class="btn-assessment btn-assessment-done">
                            Anda sudah mengisi Assessment ini
                        </div>
                    @else
                        <a href="{{ route('atasan.competency_atasan.page', $talent->id) }}" class="btn-assessment btn-assessment-active" style="display: block;">
                            Isi Assessment
                        </a>
                    @endif
                @else
                    <div class="btn-assessment btn-assessment-done">
                        Talent belum melakukan self-assessment
                    </div>
                @endif
            </div>
        @endforeach
    </div>



</x-atasan.layout>
