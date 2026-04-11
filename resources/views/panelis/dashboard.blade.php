<x-panelis.layout title="Dashboard Panelis – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ── Page Title ── */
            .page-title {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 32px;
            }
            .page-title h2 {
                font-size: 1.4rem;
                font-weight: 800;
                color: #2e3746;
            }

            /* ── Company Section ── */
            .company-section {
                margin-bottom: 36px;
            }
            .company-section-title {
                display: flex;
                align-items: center;
                gap: 16px;
                font-size: 1rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 16px;
            }
            .company-section-title::before,
            .company-section-title::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e2e8f0;
            }

            /* ── Cards Grid ── */
            .cards-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            @media (max-width: 768px) {
                .cards-grid { grid-template-columns: 1fr; }
            }

            /* ── Talent Item Wrapper ── */
            .talent-item-wrapper {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            /* ── Talent Card ── */
            .talent-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                transition: box-shadow 0.2s;
                cursor: pointer;
            }
            .talent-card:hover {
                box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            }

            /* ── Card Header ── */
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
            .talent-avatar-ph {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 800;
                font-size: 1.1rem;
                color: #0284c7;
                flex-shrink: 0;
                border: 2px solid #e2e8f0;
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
                display: block;
                margin-top: 1px;
            }

            /* ── Lihat Detail Button ── */
            .btn-lihat-detail {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 7px 18px;
                background: #0d9488;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 0.78rem;
                font-weight: 700;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
                white-space: nowrap;
                flex-shrink: 0;
            }
            .btn-lihat-detail:hover {
                background: #0f766e;
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(13, 148, 136, 0.3);
                color: white;
            }
            .btn-lihat-detail:active {
                transform: translateY(0) scale(0.95);
                box-shadow: none;
            }

            /* ── Beri Penilaian Button (separated) ── */
            .btn-penilaian-separated {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 12px 18px;
                background: #2e3746;
                color: white;
                border: none;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
                border-radius: 12px;
            }
            .btn-penilaian-separated:hover {
                background: #1e293b;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(46, 55, 70, 0.3);
                color: white;
            }
            .btn-penilaian-separated:active {
                transform: translateY(0) scale(0.98);
                box-shadow: none;
            }

            /* ── Card Info Body ── */
            .card-info {
                padding: 14px 20px;
            }
            .info-grid {
                display: grid;
                grid-template-columns: auto 1fr;
                gap: 6px 16px;
                align-items: baseline;
            }
            .info-label {
                font-size: 0.78rem;
                color: #64748b;
                font-weight: 500;
                white-space: nowrap;
            }
            .info-value {
                font-size: 0.78rem;
                color: #1e293b;
                font-weight: 600;
            }

            /* ── Empty state ── */
            .empty-state {
                text-align: center;
                color: #94a3b8;
                padding: 48px 16px;
                font-size: 0.9rem;
            }
        </style>
    </x-slot>

    {{-- Page Title --}}
    <div class="page-title">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
        </svg>
        <h2>Dashboard</h2>
    </div>

    {{-- Companies & Cards --}}
    @forelse($groupedData as $companyId => $companyData)
        <div class="company-section">
            <div class="company-section-title">
                {{ $companyData['company']->nama_company ?? 'Unassigned' }}
            </div>
            <div class="cards-grid">
                @foreach($companyData['positions'] as $positionId => $posData)
                    @foreach($posData['talents'] as $talent)
                        @php
                            $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                            if (!empty($mentorIds)) {
                                $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->toArray();
                                $mentorDisplay = implode(', ', $mentorNames) ?: '-';
                            } else {
                                $mentorDisplay = optional($talent->mentor)->nama ?? '-';
                            }
                            $targetPos     = optional($posData['targetPosition'])->position_name ?? '-';
                            $companyName   = optional($companyData['company'])->nama_company ?? '-';
                            $atasanName    = optional($talent->atasan)->nama ?? '-';
                            $currentPos    = optional($talent->position)->position_name ?? 'Officer';
                            $deptName      = optional($talent->department)->nama_department ?? '-';
                            $avatarUrl     = $talent->foto
                                             ? asset('storage/' . $talent->foto)
                                             : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=e0f2fe&color=0284c7&bold=true';
                        @endphp

                        <div class="talent-item-wrapper">
                            {{-- Card — whole card clicks → detail --}}
                            <div class="talent-card" onclick="window.location='{{ route('panelis.detail_talent', $talent->id) }}'">
                                {{-- Header --}}
                                <div class="card-header">
                                    <div class="card-header-left">
                                        <img src="{{ $avatarUrl }}" alt="{{ $talent->nama }}" class="talent-avatar">
                                        <div class="talent-name-block">
                                            <span class="name">{{ $talent->nama }}</span>
                                            <span class="role">
                                                 {{ $talent->position->position_name ?? '-' }}
                                                &rarr;
                                                {{ $talent->promotion_plan->targetPosition->position_name ?? '?' }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('panelis.detail_talent', $talent->id) }}"
                                       class="btn-lihat-detail"
                                       onclick="event.stopPropagation()">
                                        Lihat Detail
                                    </a>
                                </div>

                                {{-- Info Body --}}
                                <div class="card-info">
                                    <div class="info-grid">
                                        <span class="info-label">Department</span>
                                        <span class="info-value">{{ $deptName }}</span>

                                        <span class="info-label">Perusahaan</span>
                                        <span class="info-value">{{ $companyName }}</span>

                                        <span class="info-label">Mentor</span>
                                        <span class="info-value">{{ $mentorDisplay }}</span>

                                        <span class="info-label">Atasan</span>
                                        <span class="info-value">{{ $atasanName }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Beri Penilaian Button (Separated) --}}
                            <a href="{{ route('panelis.penilaian', $talent->id) }}"
                               class="btn-penilaian-separated">
                                Beri Penilaian
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        <div class="empty-state">
            Belum ada data progress talent yang menunggu penilaian Panelis.
        </div>
    @endforelse

</x-panelis.layout>
