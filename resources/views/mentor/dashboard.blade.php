<x-mentor.layout title="Dashboard Mentor" :user="$user">
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
                min-height: 130px;
                border: 2px solid transparent;
            .summary-value { font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 6px; }
            .summary-label { font-size: 0.8rem; color: #64748b; font-weight: 500; }
            .card-teal { border-color: #0d9488; }
            .card-teal .summary-value { color: #0d9488; }
            .card-yellow { border-color: #eab308; }
            .card-yellow .summary-value { color: #eab308; }
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
            <div class="summary-label">Total Mentee</div>
        </div>
        <div class="summary-card card-yellow">
            <div class="summary-value">{{ $totalPending }}</div>
            <div class="summary-label">Feedback Pending</div>
        </div>
        <div class="summary-card card-green">
            <div class="summary-value">{{ $totalApproved }}</div>
            <div class="summary-label">Total Approved</div>
        </div>
        <div class="summary-card card-red">
            <div class="summary-value">{{ $totalRejected }}</div>
            <div class="summary-label">Total Rejected</div>
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
        <div class="mb-4 bg-white border border-gray-300 rounded-lg shadow-sm py-3 px-5 flex items-center justify-between">
            <div class="text-[#475569] font-medium text-[14px]">
                Ada <span class="font-bold text-[#2e3746]">{{ $totalPending }} Permintaan</span> yang menunggu validasi anda
            </div>
            <a href="{{ route('mentor.logbook') }}" class="bg-[#facc15] hover:bg-[#eab308] text-[#1e293b] font-bold text-[13px] px-5 py-2.5 rounded-lg transition-colors inline-block shadow-sm">
                Review Sekarang
            </a>
        </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
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
                                <a href="{{ route('mentor.logbook', ['talent_id' => $mentee['id']]) }}"
                                    class="inline-flex items-center gap-1.5 bg-[#2e3746] hover:bg-[#38475a] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Validasi
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-10 text-center text-gray-400 text-sm font-medium">Belum ada mentee yang terdaftar.</div>
            @endif
        </div>
    </div>


    <div class="space-y-6" id="mentee-accordion">
        @foreach($menteesList as $mentee)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden accordion-card mentee-card-item" data-name="{{ strtolower($mentee['name']) }}">
                <!-- Header -->
                <div class="flex items-center justify-between p-5 cursor-pointer hover:bg-gray-50 transition-colors accordion-header" onclick="toggleAccordion(this)">
                    <div class="flex items-center gap-4">
                        <img src="{{ $mentee['foto'] ? asset('storage/' . $mentee['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($mentee['name']) . '&background=random' }}" class="w-14 h-14 rounded-full object-cover">
                        <div>
                            <h3 class="font-bold text-[17px] text-slate-800">{{ $mentee['name'] }}</h3>
                            <p class="text-[13px] text-gray-500 font-medium">
                                {{ $mentee['position'] }} - <span class="italic">{{ $mentee['department'] }}</span>
                            </p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-teal-600 transform transition-transform duration-300 accordion-icon shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Expanded Content -->
                <div class="accordion-content hidden border-t border-gray-100 p-6 bg-white pb-8">
                    
                    <!-- Stats Section 3 state cards-->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 stats-grid">
                        <div class="border-[1.5px] border-yellow-400 rounded-xl py-6 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(250,204,21,0.1)] stats-card">
                            <span class="text-yellow-400 font-bold text-4xl mb-1">{{ $mentee['status']['pending'] }}</span>
                            <span class="text-gray-400 text-[13px] font-medium">Feedback Pending</span>
                        </div>
                        <div class="border-[1.5px] border-green-500 rounded-xl py-6 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(34,197,94,0.1)] stats-card">
                            <span class="text-green-500 font-bold text-4xl mb-1">{{ $mentee['status']['approved'] }}</span>
                            <span class="text-gray-400 text-[13px] font-medium">Approved</span>
                        </div>
                        <div class="border-[1.5px] border-red-500 rounded-xl py-6 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(239,68,68,0.1)] stats-card">
                            <span class="text-red-500 font-bold text-4xl mb-1">{{ $mentee['status']['rejected'] }}</span>
                            <span class="text-gray-400 text-[13px] font-medium">Rejected</span>
                        </div>
                    </div>

                    <!-- Lower Section Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14">
                        <!-- Left: Circular Progress (Donuts) -->
                        <div class="flex flex-wrap sm:flex-nowrap items-center justify-around gap-6 lg:gap-2 donut-container">
                            <!-- Exposure -->
                            <div class="flex flex-col items-center gap-3">
                                <div class="relative w-[110px] h-[110px] md:w-32 md:h-32 flex items-center justify-center donut-wrapper">
                                    <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                      <path class="text-slate-400/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"/>
                                      <path class="text-slate-600" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="{{ $mentee['progress']['exposure']['pct'] }}, 100" />
                                    </svg>
                                    <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                        <span class="text-xl tracking-tight">{{ $mentee['progress']['exposure']['count'] }}/{{ $mentee['progress']['exposure']['target'] }}</span>
                                        <span class="text-[11px] text-[#475569] italic">{{ $mentee['progress']['exposure']['pct'] }}%</span>
                                    </div>
                                </div>
                                <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[12px] font-medium px-4 py-1.5 rounded-full shadow-sm w-[110px] text-center">Exposure</span>
                            </div>

                            <!-- Mentoring -->
                            <div class="flex flex-col items-center gap-3">
                                <div class="relative w-[110px] h-[110px] md:w-32 md:h-32 flex items-center justify-center donut-wrapper">
                                    <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                      <path class="text-yellow-400/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"/>
                                      <path class="text-[#eab308]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="{{ $mentee['progress']['mentoring']['pct'] }}, 100" />
                                    </svg>
                                    <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                        <span class="text-xl tracking-tight">{{ $mentee['progress']['mentoring']['count'] }}/{{ $mentee['progress']['mentoring']['target'] }}</span>
                                        <span class="text-[11px] text-[#475569] italic">{{ $mentee['progress']['mentoring']['pct'] }}%</span>
                                    </div>
                                </div>
                                <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[12px] font-medium px-4 py-1.5 rounded-full shadow-sm w-[110px] text-center">Mentoring</span>
                            </div>

                            <!-- Learning -->
                            <div class="flex flex-col items-center gap-3">
                                <div class="relative w-[110px] h-[110px] md:w-32 md:h-32 flex items-center justify-center">
                                    <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                      <path class="text-green-400/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"/>
                                      <path class="text-[#22c55e]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="{{ $mentee['progress']['learning']['pct'] }}, 100" />
                                    </svg>
                                    <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                        <span class="text-xl tracking-tight">{{ $mentee['progress']['learning']['count'] }}/{{ $mentee['progress']['learning']['target'] }}</span>
                                        <span class="text-[11px] text-[#475569] italic">{{ $mentee['progress']['learning']['pct'] }}%</span>
                                    </div>
                                </div>
                                <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[12px] font-medium px-4 py-1.5 rounded-full shadow-sm w-[110px] text-center">Learning</span>
                            </div>

                        </div>

                        <!-- Right: Top 3 Gap -->
                        <div class="flex flex-col justify-between h-full pt-2">
                            <div>
                                <h4 class="font-extrabold text-[15px] text-slate-800 mb-4 tracking-wide gap-title">TOP 3 GAP</h4>
                                <div class="space-y-3">
                                    @forelse($mentee['gaps'] as $index => $gap)
                                        @php
                                            // Colors mapping 0=Red, 1=Orange, 2=Blue
                                            $colors = [
                                                ['border' => 'border-red-400', 'bg' => 'bg-red-500', 'text' => 'text-white'],
                                                ['border' => 'border-orange-400', 'bg' => 'bg-orange-400', 'text' => 'text-white'],
                                                ['border' => 'border-blue-400', 'bg' => 'bg-blue-400', 'text' => 'text-white']
                                            ];
                                            $c = $colors[$index] ?? $colors[2];
                                            $compName = optional($gap->competence)->name ?? '-';
                                            $val = is_numeric($gap->gap_score) ? ($gap->gap_score == intval($gap->gap_score) ? intval($gap->gap_score) : number_format($gap->gap_score, 1)) : $gap->gap_score;
                                        @endphp
                                        <div class="flex items-center justify-between border-[1.5px] {{ $c['border'] }} rounded-xl px-4 py-2.5 gap-item">
                                            <div class="flex items-center gap-4">
                                                <span class="{{ $c['bg'] }} {{ $c['text'] }} w-[26px] h-[26px] rounded-full flex items-center justify-center font-bold text-[13px] shadow-sm">{{ $index + 1 }}</span>
                                                <span class="font-bold text-[#2e3746] text-[13px]">{{ $compName }}</span>
                                            </div>
                                            <span class="font-semibold text-slate-700">{{ $val }}</span>
                                        </div>
                                    @empty
                                        <div class="text-sm text-gray-400 py-4 italic">Belum ada data GAP</div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Action Link -->
                            <div class="flex justify-end mt-6">
                                <a href="{{ route('mentor.logbook', ['talent_id' => $mentee['id']]) }}" class="text-[14px] font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                    Lihat Logbook
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if(count($menteesList) === 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum ada Mentee</h3>
                <p class="text-gray-500 text-sm">Anda belum memiliki talent yang dibimbing.</p>
            </div>
        @endif
    </div>

    <x-slot name="scripts">
        <script>
            function toggleAccordion(element) {
                const parent = element.closest('.accordion-card');
                const content = parent.querySelector('.accordion-content');
                const icon = parent.querySelector('.accordion-icon');
                
                if (content.classList.contains('hidden')) {
                    // Open
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    // Close
                    content.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            }

            function filterMentees() {
                const searchTxt = document.getElementById('live-search-input').value.toLowerCase().trim();
                
                // Filter Table Rows
                const tableRows = document.querySelectorAll('.mentee-row-item');
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    row.style.display = name.includes(searchTxt) ? '' : 'none';
                });

                // Filter Accordion Cards
                const cards = document.querySelectorAll('.mentee-card-item');
                cards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    card.style.display = name.includes(searchTxt) ? '' : 'none';
                });
            }
        </script>
    </x-slot>
</x-mentor.layout>
