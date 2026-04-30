<x-mentor.layout title="Dashboard Mentor" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ══ Page Header (Admin Style) ══ */
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

            .dash-header-date {
                margin-left: auto;
                font-size: 0.78rem;
                color: #94a3b8;
                font-weight: 500;
                text-align: right;
            }

            .dash-header-date span {
                display: block;
                font-size: 1rem;
                font-weight: 700;
                color: #475569;
            }

            .animate-title {
                animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
            }

            @keyframes titleReveal {
                from { opacity: 0; transform: translateX(-20px) }
                to { opacity: 1; transform: translateX(0) }
            }

            /* ══ Glass Card (Admin style) ══ */
            .glass-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .03);
                overflow: hidden;
            }

            .card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 18px 24px;
                border-bottom: 1px solid #e2e8f0;
                gap: 12px;
            }

            .card-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: .95rem;
                font-weight: 700;
                color: #1e293b;
            }

            .card-title svg {
                width: 20px;
                height: 20px;
                color: #0f172a;
                flex-shrink: 0;
            }

            /* ══ Table Card (Admin Style) ══ */
            .highlight-table {
                width: 100%;
                border-collapse: collapse;
                font-size: .9rem;
            }

            .highlight-table th {
                background: #f8fafc;
                color: #475569;
                font-weight: 700;
                padding: 12px 16px;
                border-bottom: 1px solid #e2e8f0;
                white-space: nowrap;
                font-size: .8rem;
                text-transform: uppercase;
                letter-spacing: .05em;
            }

            .highlight-table td {
                padding: 12px 16px;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
                color: #334155;
            }

            .table-row {
                transition: background .15s;
            }

            .table-row:hover td {
                background: #f0fdfa !important;
            }

            .row-even td {
                background: #fafbfc;
            }

            /* ══ MOBILE ONLY — does NOT affect desktop ══ */
            @media (max-width: 767px) {
                main {
                    padding: 16px !important;
                }
                .summary-card {
                    min-height: 100px;
                    padding: 16px;
                }
                .summary-value {
                    font-size: 1.875rem !important;
                }
            }
        </style>
    </x-slot>
    @php
        $totalMentee = count($menteesList);
        $totalPending = collect($menteesList)->sum(fn($m) => $m['status']['pending']);
        $totalApproved = collect($menteesList)->sum(fn($m) => $m['status']['approved']);
        $totalRejected = collect($menteesList)->sum(fn($m) => $m['status']['rejected']);
        $firstPendingMentee = collect($menteesList)->firstWhere('has_pending', true);
    @endphp

    {{-- ── Page Header (Admin Style) ── --}}
    <div class="dash-header animate-title">
        <div class="dash-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z" />
            </svg>
        </div>
        <div>
            <div class="dash-header-title">Dashboard</div>
            <div class="dash-header-sub">Individual Development Plan – Monitoring Talent</div>
        </div>
        <div class="dash-header-date hidden md:block">
            Hari ini
            <span>{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- Summary Stats Bar --}}
    <div class="prem-stat-grid grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $totalMentee }}">{{ $totalMentee }}</div>
            <div class="prem-stat-label">Total Talent</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $totalPending }}">{{ $totalPending }}</div>
            <div class="prem-stat-label">Pending Review</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $totalApproved }}">{{ $totalApproved }}</div>
            <div class="prem-stat-label">Approved</div>
        </div>
        <div class="prem-stat prem-stat-red">
            <div class="prem-stat-icon si-red">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value animate-counter" data-target="{{ $totalRejected }}">{{ $totalRejected }}</div>
            <div class="prem-stat-label">Rejected</div>
        </div>
    </div>

    {{-- Daftar Talent: Header di luar card (sesuai pola Atasan) --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 mt-2">
        <div>
            <h3 class="text-xl font-bold text-[#1e293b]">Daftar Talent Anda</h3>
            <p class="text-sm text-gray-500 mt-0.5 font-medium">Pantau progress logbook dan validasi setiap talent</p>
        </div>

        {{-- Live Search --}}
        <div class="relative w-full sm:w-72">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent…"
                class="w-full border border-gray-200 rounded-xl py-2 pl-9 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                oninput="filterMentees()">
        </div>
    </div>

    {{-- Daftar Talent Card --}}
    <div class="glass-card mb-10">
        @if ($totalPending > 0)
            {{-- Banner Approval Validation (Finance style) --}}
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between shadow-sm m-6">
                <div class="flex items-center gap-4 mb-3 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <p class="text-amber-900 font-medium text-sm">
                        Ada <span class="font-bold text-amber-600">{{ $totalPending }} Permintaan</span> yang menunggu validasi anda
                    </p>
                </div>
                <a href="{{ $firstPendingMentee
                    ? route('mentor.validasi', ['focus_talent_id' => $firstPendingMentee['id'], 'tab' => ltrim($firstPendingMentee['pending_tab'] ?: '#exposure', '#')])
                    : route('mentor.validasi') }}"
                    class="inline-flex items-center gap-2 bg-[#14b8a6] hover:bg-[#0d9488] text-white text-sm font-bold px-8 py-2.5 rounded-[10px] transition-all shadow-sm hover:-translate-y-0.5 whitespace-nowrap">
                    Review Sekarang
                </a>
            </div>
        @endif

        @if($totalMentee > 0)
            <div class="overflow-x-auto">
                <table class="highlight-table">
                    <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 10%;">
                        <col style="width: 10%;">
                        <col style="width: 10%;">
                        <col style="width: 30%;">
                        <col style="width: 20%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="px-5 py-4 font-bold text-[#475569] uppercase tracking-wider" style="text-align:center;">Talent</th>
                            <th class="px-5 py-4 font-bold text-[#475569] uppercase tracking-wider" style="text-align:center;">Pending</th>
                            <th class="px-5 py-4 font-bold text-[#475569] uppercase tracking-wider" style="text-align:center;">Approved</th>
                            <th class="px-5 py-4 font-bold text-[#475569] uppercase tracking-wider" style="text-align:center;">Rejected</th>
                            <th class="px-5 py-4 font-bold text-[#475569] uppercase tracking-wider" style="text-align:center;">Progress Logbook</th>
                            <th class="px-5 py-4 font-bold text-[#475569] uppercase tracking-wider" style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="mentee-tbody">
                        @foreach($menteesList as $mentee)
                        <tr class="mentee-row-item hover:bg-gray-50/60 transition-colors" data-name="{{ strtolower($mentee['name']) }}">
                            {{-- Foto + Nama + Jabatan --}}
                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                <div class="flex items-center justify-center gap-3">
                                    <img src="{{ $mentee['foto'] ? asset('storage/' . $mentee['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($mentee['name']) . '&background=random' }}"
                                        class="w-10 h-10 rounded-full object-cover flex-shrink-0 border border-gray-100 shadow-sm">
                                    <div style="text-align: left;">
                                        <p class="font-bold text-base text-slate-800 leading-tight">{{ $mentee['name'] }}</p>
                                        <p class="text-sm text-gray-500 font-medium mt-1">
                                            {{ $mentee['position'] }} <span class="text-gray-400">·</span> <span class="italic">{{ $mentee['department'] }}</span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            {{-- Pending --}}
                            <td class="px-5 py-4" style="text-align:center;vertical-align:middle;">
                                @if($mentee['status']['pending'] > 0)
                                    <span class="inline-flex items-center justify-center bg-yellow-50 border border-yellow-300 text-yellow-600 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                        {{ $mentee['status']['pending'] }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center bg-gray-50 border border-yellow-500 text-yellow-500 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                        0
                                    </span>
                                @endif
                            </td>
                            {{-- Approved --}}
                            <td class="px-5 py-4" style="text-align:center;vertical-align:middle;">
                                <span class="inline-flex items-center justify-center bg-green-50 border border-green-200 text-green-600 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                    {{ $mentee['status']['approved'] }}
                                </span>
                            </td>
                            {{-- Rejected --}}
                            <td class="px-5 py-4" style="text-align:center;vertical-align:middle;">
                                <span class="inline-flex items-center justify-center bg-red-50 border border-red-200 text-red-500 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                    {{ $mentee['status']['rejected'] }}
                                </span>
                            </td>
                            {{-- Progress Donuts --}}
                            <td class="px-5 py-4" style="text-align:center;vertical-align:middle;">
                                <div class="flex items-end justify-center gap-5">
                                    @foreach([
                                        ['key' => 'exposure',  'stroke' => '#64748b', 'track' => 'rgba(100,116,139,0.15)', 'label' => 'Exposure'],
                                        ['key' => 'mentoring', 'stroke' => '#eab308', 'track' => 'rgba(234,179,8,0.15)',   'label' => 'Mentoring'],
                                        ['key' => 'learning',  'stroke' => '#22c55e', 'track' => 'rgba(34,197,94,0.15)',   'label' => 'Learning'],
                                    ] as $prog)
                                    @php
                                        $pct = $mentee['progress'][$prog['key']]['pct'] ?? 0;
                                        $cnt = $mentee['progress'][$prog['key']]['count'] ?? 0;
                                        $tgt = $mentee['progress'][$prog['key']]['target'] ?? 0;
                                    @endphp
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="relative w-[80px] h-[80px] flex items-center justify-center">
                                            <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                    fill="none" stroke="{{ $prog['track'] }}" stroke-width="4"/>
                                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                    fill="none" stroke="{{ $prog['stroke'] }}" stroke-width="4"
                                                    stroke-dasharray="{{ $pct }}, 100"/>
                                            </svg>
                                            <div class="flex flex-col items-center font-bold text-[#0f172a] leading-tight">
                                                <span class="text-[15px] tracking-tight">{{ $cnt }}/{{ $tgt }}</span>
                                                <span class="text-xs text-[#475569] italic">{{ $pct }}%</span>
                                            </div>
                                        </div>
                                        <span class="border border-[#cbd5e1] text-[#475569] bg-white text-xs font-medium px-3 py-1 rounded-full shadow-sm">{{ $prog['label'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            {{-- Aksi --}}
                            <td class="px-5 py-4 align-middle" style="text-align:center;">
                                @if($mentee['status']['pending'] > 0)
                                    <a href="{{ route('mentor.validasi', ['talent_id' => $mentee['id'], 'tab' => ltrim($mentee['pending_tab'] ?: '#exposure', '#')]) }}"
                                        class="inline-flex items-center gap-1.5 bg-[#0f172a] hover:bg-[#38475a] text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Validasi
                                    </a>
                                @else
                                    <a href="{{ route('mentor.validasi', ['talent_id' => $mentee['id']]) }}"
                                        class="inline-flex items-center gap-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-bold px-3 py-2.5 rounded-lg transition-colors shadow-sm whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Validasi
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="py-10 text-center text-gray-400 text-sm font-medium">Belum ada talent yang terdaftar.</div>
            @endif
        </div>
    </div>


    <x-slot name="scripts">
        <script>
            function filterMentees() {
                const searchTxt = document.getElementById('live-search-input').value.toLowerCase().trim();

                // Filter Table Rows
                const tableRows = document.querySelectorAll('.mentee-row-item');
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    row.style.display = name.includes(searchTxt) ? '' : 'none';
                });
            }
        </script>
    </x-slot>
</x-mentor.layout>
