<x-panelis.layout title="Dashboard Panelis – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ══ Premium Stats Cards ══ */
            .prem-stat-grid {
                display: grid;
                gap: 20px;
                margin-bottom: 28px;
            }

            .prem-stat {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 20px 20px 18px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0;
                position: relative;
                overflow: hidden;
            }

            .prem-stat::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 3.5px;
                border-radius: 16px 16px 0 0;
            }

            .prem-stat-teal::before {
                background: linear-gradient(90deg, #14b8a6, #2dd4bf);
            }

            .prem-stat-blue::before {
                background: linear-gradient(90deg, #3b82f6, #60a5fa);
            }

            .prem-stat-green::before {
                background: linear-gradient(90deg, #10b981, #34d399);
            }

            .prem-stat-icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                margin-bottom: 10px;
            }

            .prem-stat-icon svg {
                width: 18px;
                height: 18px;
            }

            .si-teal {
                background: rgba(20, 184, 166, 0.12);
                color: #14b8a6;
            }

            .si-blue {
                background: rgba(59, 130, 246, 0.12);
                color: #3b82f6;
            }

            .si-green {
                background: rgba(16, 185, 129, 0.12);
                color: #10b981;
            }

            .prem-stat-value {
                font-size: 2.2rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1;
                margin-bottom: 2px;
            }

            .prem-stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 600;
            }

            /* ══ Page Header ══ */
            .dash-header {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 28px;
            }

            .dash-header-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                background: #0f172a;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
                flex-shrink: 0;
            }

            .dash-header-icon svg {
                color: white;
                width: 24px;
                height: 24px;
            }

            .dash-header-title {
                font-size: 1.6rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1.1;
            }

            .dash-header-sub {
                font-size: 0.8rem;
                color: #64748b;
                margin-top: 2px;
                font-weight: 400;
            }

            .animate-title {
                animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
            }

            @keyframes titleReveal {
                from {
                    opacity: 0;
                    transform: translateX(-20px)
                }

                to {
                    opacity: 1;
                    transform: translateX(0)
                }
            }

            /* ── Company Section ── */
            .company-section {
                margin-bottom: 36px;
            }

            .company-section-title {
                display: flex;
                align-items: center;
                gap: 16px;
                font-size: 1.15rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 16px;
            }

            .company-section-title::before,
            .company-section-title::after {
                content: '';
                flex: 1;
                height: 1.5px;
                background: #e2e8f0;
            }

            /* ── Cards Grid ── */
            .cards-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            @media (max-width: 768px) {
                .cards-grid {
                    grid-template-columns: 1fr;
                }
            }

            /* ── Talent Item Wrapper ── */
            .talent-item-wrapper {
                display: flex;
                flex-direction: column;
            }

            /* ── Talent Card ── */
            .talent-card {
                background: #f9fafb;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
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
                width: 56px;
                height: 56px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            }

            .talent-avatar-ph {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 800;
                font-size: 1.3rem;
                color: #0284c7;
                flex-shrink: 0;
                border: 2px solid #e2e8f0;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            }

            .talent-name-block .name {
                font-size: 1rem;
                font-weight: 800;
                color: #1e293b;
                display: block;
            }

            .talent-name-block .role {
                font-size: 0.82rem;
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
                font-size: 0.84rem;
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

            /* ── Card Footer ── */
            .card-footer {
                padding: 12px 16px;
                border-top: 1px solid #f1f5f9;
            }

            /* ── Beri Penilaian Button ── */
            .btn-penilaian {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                width: 100%;
                padding: 11px 18px;
                background: #0f172a;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 0.88rem;
                font-weight: 700;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .btn-penilaian:hover {
                background: #1e293b;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
                color: white;
            }

            .btn-penilaian:active {
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
                font-size: 0.85rem;
                color: #64748b;
                font-weight: 500;
                white-space: nowrap;
            }

            .info-value {
                font-size: 0.85rem;
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

            /* ── Section Title Override (match detail page) ── */
            .section-title::before {
                display: none;
            }
            .section-title {
                gap: 14px;
                font-size: 1.25rem;
                margin-top: 0;
                margin-bottom: 20px;
                padding: 0;
            }
            .section-title svg {
                width: 28px;
                height: 28px;
                color: #0f172a;
                flex-shrink: 0;
            }
        </style>
    </x-slot>

    {{-- Page Title --}}
    <div class="mb-8">
        <div class="dash-header animate-title !mb-0">
            <div class="dash-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </div>
            <div>
                <div class="dash-header-title">Dashboard</div>
                <div class="dash-header-sub">Individual Development Plan – Panelis</div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    @php
        $totalTalent = 0;
        foreach ($groupedData as $companyId => $companyData) {
            foreach ($companyData['positions'] as $posId => $posData) {
                $totalTalent += $posData['talents']->count();
            }
        }
        $totalCompany = count($groupedData);
        $totalReviewed = \App\Models\PanelisAssessment::where('panelis_id', auth()->id())->whereNotNull('panelis_score')->count();
    @endphp

    <div class="prem-stat-grid grid-cols-1 md:grid-cols-3">
        {{-- Stat 1: Talent Menunggu Review --}}
        <div class="prem-stat prem-stat-blue">
            <div class="prem-stat-icon si-blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalTalent }}</div>
            <div class="prem-stat-label">Menunggu Penilaian</div>
        </div>

        {{-- Stat 2: Total Perusahaan --}}
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalCompany }}</div>
            <div class="prem-stat-label">Total Perusahaan</div>
        </div>

        {{-- Stat 3: Penilaian Selesai --}}
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalReviewed }}</div>
            <div class="prem-stat-label">Penilaian Selesai</div>
        </div>
    </div>

    {{-- Section Title & Controls --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 mt-4">
        <div class="section-title !mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
            </svg>
            Daftar Penilaian Talent
        </div>
        {{-- Live Search --}}
        <div class="relative w-full sm:w-80">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent…"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                oninput="filterTalents()">
        </div>
    </div>

    {{-- Companies & Cards --}}
    @forelse($groupedData as $companyId => $companyData)
        <div class="company-section" data-company-id="{{ $companyId }}">
            <div class="company-section-title">
                {{ $companyData['company']->nama_company ?? 'Unassigned' }}
            </div>
            <div class="cards-grid">
                @foreach ($companyData['positions'] as $positionId => $posData)
                    @foreach ($posData['talents'] as $talent)
                        @php
                            $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                            if (!empty($mentorIds)) {
                                $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->toArray();
                                $mentorDisplay = implode(', ', $mentorNames) ?: '-';
                            } else {
                                $mentorDisplay = optional($talent->mentor)->nama ?? '-';
                            }
                            $targetPos = optional($posData['targetPosition'])->position_name ?? '-';
                            $companyName = optional($companyData['company'])->nama_company ?? '-';
                            $atasanName = optional($talent->atasan)->nama ?? '-';
                            $currentPos = optional($talent->position)->position_name ?? 'Officer';
                            $deptName = optional($talent->department)->nama_department ?? '-';
                            $avatarUrl = $talent->foto
                                ? asset('storage/' . $talent->foto)
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode($talent->nama) .
                                    '&background=e0f2fe&color=0284c7&bold=true';
                        @endphp

                        <div class="talent-item-wrapper talent-card-item" data-name="{{ strtolower($talent->nama) }}">
                            {{-- Card --}}
                            <div class="talent-card">
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
                                        class="btn-lihat-detail" onclick="event.stopPropagation()">
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

                                {{-- Card Footer: Beri Penilaian --}}
                                <div class="card-footer">
                                    <a href="{{ route('panelis.penilaian', $talent->id) }}" class="btn-penilaian">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd"
                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Beri Penilaian
                                    </a>
                                </div>
                            </div>
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

    <x-slot name="scripts">
        <script>
            function filterTalents() {
                const searchTxt = document.getElementById('live-search-input').value.toLowerCase().trim();
                const items = document.querySelectorAll('.talent-card-item');

                items.forEach(item => {
                    const name = item.getAttribute('data-name') || '';
                    item.style.display = name.includes(searchTxt) ? '' : 'none';
                });

                // Hide company sections that have no visible talents
                document.querySelectorAll('.company-section').forEach(section => {
                    const visibleItems = section.querySelectorAll('.talent-card-item[style="display: "]');
                    // Note: if style.display is empty string, it's visible. But we need to check if it's NOT none.
                    const anyVisible = Array.from(section.querySelectorAll('.talent-card-item')).some(i => i.style
                        .display !== 'none');
                    section.style.display = anyVisible ? '' : 'none';
                });
            }
        </script>
    </x-slot>

</x-panelis.layout>
