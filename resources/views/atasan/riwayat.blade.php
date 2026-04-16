<x-atasan.layout title="Riwayat Penilaian – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .riwayat-container {
                max-width: 1200px;
                margin: 0 auto;
            }

            .page-title {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 24px;
            }

            .page-title h1 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #1e293b;
            }

            .search-container {
                margin-bottom: 24px;
                display: flex;
                justify-content: flex-end;
            }

            .search-box {
                position: relative;
                width: 100%;
                max-width: 400px;
            }

            .search-input {
                width: 100%;
                padding: 12px 16px;
                padding-right: 48px;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                font-size: 0.875rem;
                font-weight: 500;
                color: #475569;
                outline: none;
                transition: all 0.2s;
            }

            .search-input:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
            }

            .search-icon {
                position: absolute;
                right: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                background: none;
                border: none;
                cursor: pointer;
            }

            .history-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                margin-bottom: 16px;
                overflow: hidden;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .history-card:hover {
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            .card-trigger {
                width: 100%;
                display: flex;
                align-items: center;
                padding: 24px;
                cursor: pointer;
                text-align: left;
                background: white;
                border: none;
                outline: none;
                transition: background 0.2s;
            }

            .card-trigger:hover {
                background: #f8fafc;
            }

            .card-profile {
                display: flex;
                align-items: center;
                gap: 16px;
                flex: 2;
                border-right: 1.5px solid #f1f5f9;
                padding-right: 24px;
            }

            .profile-img {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
            }

            .profile-info .name {
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                display: block;
            }

            .profile-info .role {
                font-size: 0.75rem;
                color: #64748b;
                font-weight: 500;
                margin-top: 2px;
            }

            .profile-info .date {
                font-size: 0.75rem;
                color: #94a3b8;
                margin-top: 2px;
            }

            .card-project {
                flex: 2;
                padding: 0 24px;
            }

            .card-project .label {
                font-size: 0.75rem;
                font-weight: 700;
                color: #1e293b;
            }

            .card-status {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                gap: 12px;
            }

            .status-badge {
                padding: 8px 16px;
                border-radius: 99px;
                font-size: 0.75rem;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .badge-done {
                background: rgba(34, 197, 94, 0.1);
                color: #16a34a;
                border: 1px solid rgba(34, 197, 94, 0.2);
            }

            .badge-pending {
                background: rgba(245, 158, 11, 0.1);
                color: #d97706;
                border: 1px solid rgba(245, 158, 11, 0.2);
            }

            .collapse-icon {
                transition: transform 0.3s;
                color: #14b8a6;
            }

            .history-card.active .collapse-icon {
                transform: rotate(180deg);
            }

            .card-content {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                background: white;
            }

            .history-card.active .card-content {
                max-height: 2000px;
            }

            .content-inner {
                padding: 24px;
                border-top: 1.5px solid #f1f5f9;
            }

            .assessment-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 16px;
                overflow: hidden;
                border: 1.5px solid #e2e8f0;
                margin-bottom: 24px;
            }

            .assessment-table th {
                background: #f8fafc;
                padding: 16px;
                font-size: 0.875rem;
                font-weight: 800;
                color: #1e293b;
                text-align: center;
                border-bottom: 1.5px solid #e2e8f0;
                border-right: 1.5px solid #e2e8f0;
            }

            .assessment-table th:last-child {
                border-right: none;
            }

            .assessment-table td {
                padding: 16px;
                font-size: 0.875rem;
                color: #475569;
                text-align: center;
                border-bottom: 1.5px solid #f1f5f9;
                border-right: 1.5px solid #f1f5f9;
            }

            .assessment-table td:last-child {
                border-right: none;
            }

            .assessment-table tr:last-child td {
                border-bottom: none;
            }

            .assessment-table td:first-child {
                text-align: left;
                font-weight: 600;
                color: #1e293b;
            }

            .gap-cell {
                font-weight: 800;
                color: white;
            }

            .gap-red { background: #ef4444; color: white !important; }
            .gap-orange { background: #f97316; color: white !important; }
            .gap-yellow { background: #eab308; color: white !important; }
            .gap-white { background: #ffffff; color: #475569 !important; }

            .footer-row td {
                background: #f8fafc;
                font-weight: 800;
                color: #1e293b;
            }

            .detail-btn {
                display: inline-block;
                width: 180px;
                text-align: center;
                padding: 10px;
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                font-size: 0.813rem;
                font-weight: 700;
                color: #64748b;
                text-decoration: none;
                transition: all 0.2s;
            }

            .detail-btn:hover {
                background: #f8fafc;
                border-color: #14b8a6;
                color: #0d9488;
            }

            /* Responsive Adjustment */
            @media (max-width: 1024px) {
                .card-profile { border-right: none; padding-right: 0; }
                .card-project { display: none; }
                .card-trigger { padding: 16px; }
            }

            @media (max-width: 640px) {
                .profile-img { width: 44px; height: 44px; }
                .profile-info .name { font-size: 0.875rem; }
                .assessment-table th, .assessment-table td { padding: 8px; font-size: 0.7rem; }
            }
        </style>
    </x-slot>

    <div class="riwayat-container">
        <div class="page-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
            </svg>
            <h1>Riwayat Penilaian</h1>
        </div>

        <div class="search-container">
            <form action="{{ route('atasan.riwayat') }}" method="GET" class="search-box">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Talent" class="search-input">
                <button type="submit" class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($talents as $talent)
                @php
                    $session = $talent->assessmentSession;
                    $details = $session ? $session->details->sortBy('competence_id') : collect();
                    $hasAtasanScored = $details->isNotEmpty() && $details->sum('score_atasan') > 0;
                    
                    // Standards
                    $positionId = optional($talent->promotion_plan)->target_position_id ?? $talent->position_id;
                    $standards = \App\Models\PositionTargetCompetence::where('position_id', $positionId)
                        ->pluck('target_level', 'competence_id');
                @endphp
                <div class="history-card" id="card-{{ $talent->id }}">
                    <button class="card-trigger" onclick="toggleCard('{{ $talent->id }}')">
                        <div class="card-profile">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" 
                                 class="profile-img" alt="{{ $talent->nama }}">
                            <div class="profile-info">
                                <span class="name">{{ $talent->nama }}</span>
                                <span class="role">{{ $talent->position->position_name ?? '-' }}
                                &rarr;
                                {{ $talent->promotion_plan->targetPosition
                                    ->position_name ?? '?' }}
                                </span>
                                <br>
                                <span class="role">{{ optional($talent->department)->nama_department ?? '-' }}    
                                </span>
                                @if($session)
                                    <br>
                                    <span class="date">Dikirim: {{ $session->created_at->translatedFormat('d F Y') }}</span>
                                @else
                                    <span class="date text-amber-500 font-medium italic">Belum Assessment</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-project">
                            <span class="label">Judul Project</span>
                            <p class="text-[0.875rem] text-[#475569] mt-1 truncate max-w-[300px]">
                                {{ $talent->improvementProjects->first()->title ?? '-' }}
                            </p>
                        </div>

                        <div class="card-status">
                            @if($hasAtasanScored)
                                <span class="status-badge badge-done">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Done Review
                                </span>
                            @else
                                <span class="status-badge badge-pending">
                                    Pending Review
                                </span>
                            @endif
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 collapse-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <div class="card-content">
                        <div class="content-inner">
                            @if($session && $details->isNotEmpty())
                                <div class="overflow-x-auto">
                                    <table class="assessment-table">
                                        <thead>
                                            <tr>
                                                <th class="w-[30%]">Kompetensi</th>
                                                <th>Standar</th>
                                                <th>Skor Talent</th>
                                                <th>Skor Atasan</th>
                                                <th>Final Score</th>
                                                <th>GAP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($competencies as $comp)
                                                @php
                                                    $detail = $details->firstWhere('competence_id', $comp->id);
                                                    $standard = (float)($standards[$comp->id] ?? 0);
                                                    $scoreTalent = (float)($detail->score_talent ?? 0);
                                                    $scoreAtasan = (float)($detail->score_atasan ?? 0);
                                                    $finalScore = ($scoreTalent + $scoreAtasan) / 2;
                                                    $gap = $finalScore - $standard;
                                                    
                                                    $gapClass = 'gap-white';
                                                    if ($gap <= -2) $gapClass = 'gap-red';
                                                    elseif ($gap < 0) $gapClass = 'gap-orange';
                                                    elseif ($gap >= 0) $gapClass = 'gap-white';
                                                @endphp
                                                <tr>
                                                    <td>{{ $comp->name }}</td>
                                                    <td>{{ $standard % 1 == 0 ? (int)$standard : number_format($standard, 1) }}</td>
                                                    <td>{{ $scoreTalent % 1 == 0 ? (int)$scoreTalent : number_format($scoreTalent, 1) }}</td>
                                                    <td>{{ $scoreAtasan ?: '0' }}</td>
                                                    <td>{{ $finalScore % 1 == 0 ? (int)$finalScore : number_format($finalScore, 1) }}</td>
                                                    <td class="gap-cell {{ $gapClass }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @php
                                            $avgStandard = $standards->avg() ?: 0;
                                            $avgTalent = $details->avg('score_talent') ?: 0;
                                            $avgAtasan = $details->avg('score_atasan') ?: 0;
                                            $avgFinal = ($avgTalent + $avgAtasan) / 2;
                                            $avgGap = $avgFinal - $avgStandard;
                                            
                                            $avgGapClass = 'gap-white';
                                            if ($avgGap <= -2) $avgGapClass = 'gap-red';
                                            elseif ($avgGap < 0) $avgGapClass = 'gap-orange';
                                        @endphp
                                        <tfoot>
                                            <tr class="footer-row">
                                                <td>Nilai Rata-Rata</td>
                                                <td>{{ number_format($avgStandard, 1) }}</td>
                                                <td>{{ number_format($avgTalent, 1) }}</td>
                                                <td>{{ number_format($avgAtasan, 1) }}</td>
                                                <td>{{ number_format($avgFinal, 1) }}</td>
                                                <td class="gap-cell {{ $avgGapClass }}">{{ number_format($avgGap, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('atasan.monitoring.detail', $talent->id) }}" class="detail-btn">
                                        Lihat Detail
                                    </a>
                                </div>
                            @else
                                <div class="py-10 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Talent belum menyelesaikan self-assessment.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-400 font-medium">Tidak ada data talent yang ditemukan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function toggleCard(id) {
            const card = document.getElementById('card-' + id);
            card.classList.toggle('active');
            
            // Close other cards
            document.querySelectorAll('.history-card').forEach(c => {
                if (c.id !== 'card-' + id) {
                    c.classList.remove('active');
                }
            });
        }

        // Auto-buka lonceng notifikasi setelah beri nilai
        @if(session('open_bell_notif'))
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const bellBtn = document.getElementById('bell-btn');
                    if (bellBtn && typeof toggleDropdown === 'function') {
                        toggleDropdown('bell-dropdown', 'bell-btn');
                    }
                }, 100);
            });
        @endif
    </script>
</x-atasan.layout>
