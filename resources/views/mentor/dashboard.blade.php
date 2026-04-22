<x-mentor.layout title="Dashboard Mentor" :user="$user">
    <x-slot name="styles">
        <style>
            .summary-card {
                background: #f9fafb;
                border-radius: 12px;
                padding: 24px;
                text-align: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: 130px;
                border: 2px solid transparent;
            }
            .summary-value { font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 6px; }
            .summary-label { font-size: 0.8rem; color: #64748b; font-weight: 500; }
            .card-teal { border-color: #0d9488; }
            .card-teal .summary-value { color: #0d9488; }
            .card-yellow { border-color: #facc15; }
            .card-yellow .summary-value { color: #facc15; }
            .card-green { border-color: #22c55e; }
            .card-green .summary-value { color: #22c55e; }
            .card-red { border-color: #ef4444; }
            .card-red .summary-value { color: #ef4444; }

            /* ══ MOBILE ONLY — does NOT affect desktop ══ */
            @media (max-width: 767px) {
                main { padding: 16px !important; }
                .accordion-header { padding: 16px !important; gap: 12px !important; }
                .accordion-header img { width: 44px !important; height: 44px !important; }
                .accordion-header h3 { font-size: 15px !important; }
                .accordion-header p { font-size: 11px !important; }
                .accordion-content { padding: 16px !important; }
                .donut-container { justify-content: center !important; gap: 20px !important; }
                .donut-wrapper { width: 90px !important; height: 90px !important; }
                .donut-wrapper span:first-child { font-size: 14px !important; }
                .gap-title { font-size: 13px !important; margin-bottom: 12px !important; }
                .gap-item { padding: 8px 12px !important; }
                .gap-item span { font-size: 12px !important; }
                .summary-card { min-height: 100px; padding: 16px; }
                .summary-value { font-size: 1.875rem !important; }
            }
        </style>
    </x-slot>
    @php
        $totalMentee  = count($menteesList);
        $totalPending  = collect($menteesList)->sum(fn($m) => $m['status']['pending']);
        $totalApproved = collect($menteesList)->sum(fn($m) => $m['status']['approved']);
        $totalRejected = collect($menteesList)->sum(fn($m) => $m['status']['rejected']);
    @endphp

    {{-- Summary Stats Bar --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="summary-card card-teal">
            <div class="summary-value">{{ $totalMentee }}</div>
            <div class="summary-label">Total Talent</div>
        </div>
        <div class="summary-card card-yellow">
            <div class="summary-value">{{ $totalPending }}</div>
            <div class="summary-label">Pending Review</div>
        </div>
        <div class="summary-card card-green">
            <div class="summary-value">{{ $totalApproved }}</div>
            <div class="summary-label">Approved</div>
        </div>
        <div class="summary-card card-red">
            <div class="summary-value">{{ $totalRejected }}</div>
            <div class="summary-label">Rejected</div>
        </div>
    </div>

    {{-- Daftar Talent Table --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div class="flex items-center gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                <h2 class="text-xl font-bold text-[#2e3746]">Daftar Talent</h2>
            </div>

            {{-- Live Search --}}
            <div class="relative w-full sm:w-80">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="live-search-input" placeholder="Cari Nama Talent…" 
                    class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                    oninput="filterMentees()">
            </div>
        </div>

        @if($totalPending > 0)
        <!-- Banner Approval Validation - Image 1 View -->
        <div class="mb-4 bg-gray-50 border border-gray-300 rounded-lg shadow-sm py-3 px-5 flex items-center justify-between">
            <div class="text-[#475569] font-medium text-[14px]">
                Ada <span class="font-bold text-[#2e3746]">{{ $totalPending }} Permintaan</span> yang menunggu validasi anda
            </div>
            <a href="{{ route('mentor.validasi') }}" class="bg-[#facc15] hover:bg-[#eab308] text-[#1e293b] font-bold text-[13px] px-5 py-2.5 rounded-lg transition-colors inline-block shadow-sm">
                Review Sekarang
            </a>
        </div>
        @endif

        <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            @if($totalMentee > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-[#f8fafc] border-b border-gray-200">
                            <th class="px-5 py-4 text-left text-xs font-bold text-[#475569] uppercase tracking-wider">Talent</th>
                            <th class="px-5 py-4 text-center text-xs font-bold text-[#475569] uppercase tracking-wider">Pending</th>
                            <th class="px-5 py-4 text-center text-xs font-bold text-[#475569] uppercase tracking-wider">Approved</th>
                            <th class="px-5 py-4 text-center text-xs font-bold text-[#475569] uppercase tracking-wider">Rejected</th>
                            <th class="px-5 py-4 text-center text-xs font-bold text-[#475569] uppercase tracking-wider">Progress Logbook</th>
                            <th class="px-5 py-4 text-center text-xs font-bold text-[#475569] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="mentee-tbody">
                        @foreach($menteesList as $mentee)
                        <tr class="mentee-row-item hover:bg-gray-50/60 transition-colors" data-name="{{ strtolower($mentee['name']) }}">
                            {{-- Foto + Nama + Jabatan --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $mentee['foto'] ? asset('storage/' . $mentee['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($mentee['name']) . '&background=random' }}"
                                        class="w-10 h-10 rounded-full object-cover flex-shrink-0 border border-gray-100 shadow-sm">
                                    <div>
                                        <p class="font-bold text-[14px] text-slate-800 leading-tight">{{ $mentee['name'] }}</p>
                                        <p class="text-[11px] text-gray-500 font-medium mt-0.5">
                                            {{ $mentee['position'] }} <span class="text-gray-400">·</span> <span class="italic">{{ $mentee['department'] }}</span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            {{-- Pending --}}
                            <td class="px-5 py-4 text-center">
                                @if($mentee['status']['pending'] > 0)
                                    <span class="inline-flex items-center justify-center bg-yellow-50 border border-yellow-300 text-yellow-600 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                        {{ $mentee['status']['pending'] }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            {{-- Approved --}}
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center bg-green-50 border border-green-200 text-green-600 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                    {{ $mentee['status']['approved'] }}
                                </span>
                            </td>
                            {{-- Rejected --}}
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center bg-red-50 border border-red-200 text-red-500 font-bold text-sm px-3 py-1 rounded-full min-w-[36px]">
                                    {{ $mentee['status']['rejected'] }}
                                </span>
                            </td>
                            {{-- Progress Donuts --}}
                            <td class="px-5 py-4">
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
                                            <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                                <span class="text-[13px] tracking-tight">{{ $cnt }}/{{ $tgt }}</span>
                                                <span class="text-[10px] text-[#475569] italic">{{ $pct }}%</span>
                                            </div>
                                        </div>
                                        <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[11px] font-medium px-3 py-1 rounded-full shadow-sm">{{ $prog['label'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            {{-- Aksi --}}
                            <td class="px-5 py-4 text-center">
                                @if($mentee['status']['pending'] > 0)
                                    <a href="{{ route('mentor.validasi', ['talent_id' => $mentee['id']]) }}"
                                        class="inline-flex items-center gap-1.5 bg-[#2e3746] hover:bg-[#38475a] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Validasi
                                    </a>
                                @else
                                    <a href="{{ route('mentor.validasi', ['talent_id' => $mentee['id']]) }}"
                                        class="inline-flex items-center gap-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
