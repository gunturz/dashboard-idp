<x-atasan.layout title="Dashboard Atasan – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .summary-card {
                background: white;
                border-radius: 12px;
                padding: 24px;
                text-align: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: 140px;
                border: 2px solid transparent; /* default */
                transition: all 0.2s;
            }

            .summary-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            }

            .summary-value {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 8px;
            }

            .summary-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
            }

            /* Specific Card Colors */
            .card-teal { border-color: #0d9488; }
            .card-teal .summary-value { color: #0d9488; }
            
            .card-green { border-color: #22c55e; }
            .card-green .summary-value { color: #22c55e; }
            
            .card-amber { border-color: #f59e0b; }
            .card-amber .summary-value { color: #f59e0b; }

            .talent-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                transition: box-shadow 0.2s;
                display: flex;
                flex-direction: column;
            }
            .talent-card:hover {
                box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            }

            .card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                border-bottom: 1px solid #f1f5f9;
            }

            .card-header-left {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .talent-avatar {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }

            .talent-name-block .name {
                font-size: 0.95rem;
                font-weight: 800;
                color: #1e293b;
                display: block;
            }
            .talent-name-block .role {
                font-size: 0.75rem;
                color: #64748b;
                display: flex;
                align-items: center;
                gap: 4px;
                margin-top: 1px;
                flex-wrap: wrap;
            }

            .card-info {
                padding: 14px 20px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .competency-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 16px;
            }

            .competency-table th {
                background: #f8fafc;
                padding: 10px 16px;
                font-size: 0.78rem;
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
                font-size: 0.8rem;
                color: #475569;
                border: 1px solid #e2e8f0;
                text-align: center;
            }

            .competency-table td:first-child {
                text-align: left;
                font-weight: 500;
            }

            .btn-assessment {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 12px;
                border-radius: 12px;
                font-size: 0.85rem;
                font-weight: 700;
                text-align: center;
                transition: all 0.2s;
                cursor: pointer;
                border: none;
                margin-top: auto;
            }

            .btn-assessment-active {
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
                color: white;
                text-decoration: none;
            }

            .btn-assessment-active:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
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
                    min-height: 120px;
                }
                .summary-value {
                    font-size: 2rem;
                }
                .summary-label {
                    font-size: 0.85rem;
                }
                .talent-card {
                    border-radius: 12px;
                }
                .card-header {
                    padding: 14px 16px;
                }
                .card-header-left {
                    gap: 12px;
                }
                .talent-avatar {
                    width: 44px;
                    height: 44px;
                }
                .talent-name-block .name {
                    font-size: 0.9rem;
                }
                .talent-name-block .role {
                    font-size: 0.7rem;
                }
                .card-info {
                    padding: 12px 16px;
                }
                .competency-table th {
                    padding: 8px 10px;
                    font-size: 0.7rem;
                }
                .competency-table td {
                    padding: 8px 10px;
                    font-size: 0.75rem;
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
        <div class="summary-card card-teal">
            <div class="summary-value">{{ $totalTalents }}</div>
            <div class="summary-label">Talent</div>
        </div>
        <div class="summary-card card-amber">
            <div class="summary-value">{{ $assessmentPending }}</div>
            <div class="summary-label">Assessment Pending</div>
        </div>
        <div class="summary-card card-green">
            <div class="summary-value">{{ $onTrack }}</div>
            <div class="summary-label">On track</div>
        </div>
    </div>

    {{-- Talent Cards Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        @forelse ($talents as $talent)
            @php
                $session = $talent->assessmentSession;
                $details = $session ? $session->details : collect();
                $hasAtasanScored = $details->sum('score_atasan') > 0;
                $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
                $standards = $allStandards[$positionId] ?? collect();
            @endphp
            <div class="talent-card">
                <div class="card-header">
                    <div class="card-header-left">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                             class="talent-avatar" alt="{{ $talent->nama }}">
                        <div class="talent-name-block">
                            <span class="name">{{ $talent->nama }}</span>
                            <span class="role">
                                {{ optional($talent->position)->position_name ?? '-' }}
                                @if(optional($talent->promotion_plan)->targetPosition)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    <span class="text-[#0d9488] font-semibold">{{ $talent->promotion_plan->targetPosition->position_name }}</span>
                                @endif
                                <span class="ml-2 font-medium not-italic text-xs bg-gray-100 px-2 py-0.5 rounded-full">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-info">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Anda sudah mengisi Assessment ini
                            </div>
                        @else
                            <a href="{{ route('atasan.competency_atasan.page', $talent->id) }}" class="btn-assessment btn-assessment-active">
                                Isi Assessment
                            </a>
                        @endif
                    @else
                        <div class="btn-assessment btn-assessment-done">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Talent belum melakukan assessment
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-1 lg:col-span-2 text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200 shadow-sm flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Anda sudah mengisi assessment talent</h3>
                <p class="text-gray-500 text-sm">Anda dapat memeriksa hasilnya di halaman <a href="{{ route('atasan.riwayat') }}" class="text-[#005ba1] font-semibold hover:underline">Riwayat</a>.</p>
            </div>
        @endforelse
    </div>



</x-atasan.layout>
