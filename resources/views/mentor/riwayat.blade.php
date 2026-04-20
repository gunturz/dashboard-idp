<x-mentor.layout title="Riwayat – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .section-pill {
                display: inline-flex;
                align-items: center;
                background: #2e3746;
                color: #fff;
                font-size: 0.85rem;
                font-weight: 700;
                padding: 0.45rem 1.25rem;
                border-radius: 999px;
                margin-bottom: 1rem;
                letter-spacing: 0.01em;
            }

            .val-table-wrap {
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 2rem;
            }

            .val-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.875rem;
            }

            .val-table th {
                background: #f8fafc;
                color: #475569;
                font-weight: 700;
                font-size: 0.78rem;
                text-align: center;
                padding: 14px 16px;
                border-bottom: 1px solid #e2e8f0;
                white-space: nowrap;
            }

            .val-table th:first-child,
            .val-table td:first-child {
                text-align: left;
                padding-left: 20px;
            }

            .val-table td {
                padding: 14px 16px;
                color: #475569;
                border-top: 1px solid #f1f5f9;
                text-align: center;
                vertical-align: middle;
            }

            .val-table tr:hover td {
                background: #fafbfc;
            }

            .status-dot {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.82rem;
                font-weight: 600;
            }

            .status-dot::before {
                content: '';
                display: inline-block;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .status-pending::before  { background: #f59e0b; }
            .status-approved::before { background: #22c55e; }
            .status-rejected::before { background: #ef4444; }
            .status-pending  { color: #92400e; }
            .status-approved { color: #15803d; }
            .status-rejected { color: #b91c1c; }

            .btn-detail {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 0.78rem;
                font-weight: 600;
                color: #475569;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                text-decoration: none;
            }
            .btn-detail:hover { color: #2e3746; }

            @media (max-width: 767px) {
                main { padding: 16px !important; }
                .val-table th, .val-table td { padding: 10px 10px; font-size: 0.78rem; }
                .talent-selector-row { flex-direction: column !important; gap: 10px !important; }
            }
        </style>
    </x-slot>

    <div class="w-full">
        {{-- Talent Selector --}}
        <div class="mb-6 flex items-center gap-6 talent-selector-row" style="position: relative; z-index: 50;">
            <label class="text-[15px] font-bold text-gray-700 whitespace-nowrap">Talent</label>
            
            <div class="relative w-full max-w-lg" id="custom-select-container">
                <!-- Dropdown Button -->
                <button type="button" onclick="toggleTalentDropdown()" id="dropdown-btn" class="w-full bg-white border border-gray-300 rounded-lg flex items-center justify-between py-3 px-4 hover:border-gray-400 focus:outline-none transition-colors">
                    <span class="text-slate-700 font-medium text-[15px]" id="dropdown-text">
                        {{ $selectedTalent ? $selectedTalent->nama : 'Pilih Talent...' }}
                    </span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" id="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Options List (Open State) -->
                <div id="dropdown-menu" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-xl z-[60] overflow-hidden">
                    <div class="flex flex-col w-full max-h-72 overflow-y-auto">
                        @forelse($mentees as $m)
                            <a href="?talent_id={{ $m->id }}" class="block w-full text-left border-b border-gray-200 py-3.5 px-4 text-slate-700 font-medium hover:bg-slate-50 transition-colors focus:bg-slate-50 focus:outline-none last:border-b-0">
                                {{ $m->nama }}
                            </a>
                        @empty
                            <div class="block py-3.5 px-4 text-gray-400 italic">Belum ada mentee</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @if($selectedTalent)

        {{-- Talent Profile --}}
        <div class="flex items-center gap-4 mb-8">
            <img src="{{ $selectedTalent->foto ? asset('storage/' . $selectedTalent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedTalent->nama) . '&background=random' }}"
                 class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm">
            <div>
                <h3 class="font-bold text-[20px] text-slate-800 leading-tight">{{ $selectedTalent->nama }}</h3>
                <p class="text-[13px] text-gray-500 font-medium">
                    {{ optional($selectedTalent->position)->position_name ?? '-' }}
                    <span class="text-gray-400 mx-1">|</span>
                    <span class="italic">{{ optional($selectedTalent->department)->nama_department ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 p-1.5 bg-gray-100 rounded-full w-fit mb-8 shadow-inner overflow-x-auto">
            <button id="tab-exposure" onclick="switchTab('exposure')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 bg-[#2e3746] text-white shadow-sm whitespace-nowrap">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Learning</button>
        </div>

        {{-- ═══ EXPOSURE ═══ --}}
        <div id="panel-exposure">
            <div class="val-table-wrap">
            <table class="val-table">
                <thead>
                    <tr>
                        <th>Mentor</th>
                        <th>Tema</th>
                        <th>Tanggal Pengiriman /<br>Update</th>
                        <th>Tanggal<br>Pelaksanaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exposureData as $data)
                    <tr>
                        <td class="font-medium text-left">{{ $data['mentor'] }}</td>
                        <td class="font-semibold text-[#1e293b]">{{ \Illuminate\Support\Str::limit($data['tema'], 40) }}</td>
                        <td>{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                        <td>{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                        <td>
                            <span class="status-dot status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="flex items-center justify-center">
                                <a href="{{ route('mentor.logbook.detail', $data['id']) }}" class="btn-detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-sm italic">Belum ada aktivitas Exposure.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>

        {{-- ═══ MENTORING ═══ --}}
        <div id="panel-mentoring" class="hidden">
        <div class="val-table-wrap">
            <table class="val-table">
                <thead>
                    <tr>
                        <th>Mentor</th>
                        <th>Tema</th>
                        <th>Tanggal Pengiriman /<br>Update</th>
                        <th>Tanggal<br>Pelaksanaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mentoringData as $data)
                    <tr>
                        <td class="font-medium text-left">{{ $data['mentor'] }}</td>
                        <td class="font-semibold text-[#1e293b]">{{ \Illuminate\Support\Str::limit($data['tema'], 40) }}</td>
                        <td>{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                        <td>{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                        <td>
                            <span class="status-dot status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="flex items-center justify-center">
                                <a href="{{ route('mentor.logbook.detail', $data['id']) }}" class="btn-detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-sm italic">Belum ada aktivitas Mentoring.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>

        {{-- ═══ LEARNING ═══ --}}
        <div id="panel-learning" class="hidden">
        <div class="val-table-wrap">
            <table class="val-table">
                <thead>
                    <tr>
                        <th>Sumber</th>
                        <th>Tema</th>
                        <th>Tanggal Pengiriman /<br>Update</th>
                        <th>Tanggal<br>Pelaksanaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($learningData as $data)
                    <tr>
                        <td class="font-medium text-left">{{ $data['sumber'] ?: '-' }}</td>
                        <td class="font-semibold text-[#1e293b]">{{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 40) ?: '-' }}</td>
                        <td>{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                        <td>{{ $data['tanggal'] ? date('d M Y', strtotime($data['tanggal'])) : '-' }}</td>
                        <td>
                            <span class="status-dot status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="flex items-center justify-center">
                                <a href="{{ route('mentor.logbook.detail', $data['id']) }}" class="btn-detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 text-sm italic">Belum ada aktivitas Learning.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>

        @endif
    </div>

    <x-slot name="scripts">
        <script>
            // Custom Dropdown Talent Logic
            function toggleTalentDropdown() {
                const menu = document.getElementById('dropdown-menu');
                const btn = document.getElementById('dropdown-btn');
                const text = document.getElementById('dropdown-text');
                const icon = document.getElementById('dropdown-icon');
                
                menu.classList.toggle('hidden');

                if (!menu.classList.contains('hidden')) {
                    // Open state
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-[#14b8a6]', 'ring-1', 'ring-[#14b8a6]');
                    text.classList.remove('text-slate-700');
                    text.classList.add('text-[#14b8a6]');
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('text-[#14b8a6]', 'rotate-180');
                } else {
                    // Closed state
                    btn.classList.remove('border-[#14b8a6]', 'ring-1', 'ring-[#14b8a6]');
                    btn.classList.add('border-gray-300');
                    text.classList.remove('text-[#14b8a6]');
                    text.classList.add('text-slate-700');
                    icon.classList.remove('text-[#14b8a6]', 'rotate-180');
                    icon.classList.add('text-gray-400');
                }
            }

            document.addEventListener('click', function(event) {
                const container = document.getElementById('custom-select-container');
                const menu = document.getElementById('dropdown-menu');
                const btn = document.getElementById('dropdown-btn');
                const text = document.getElementById('dropdown-text');
                const icon = document.getElementById('dropdown-icon');

                if (container && !container.contains(event.target)) {
                    if(!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        btn.classList.remove('border-[#14b8a6]', 'ring-1', 'ring-[#14b8a6]');
                        btn.classList.add('border-gray-300');
                        text.classList.remove('text-[#14b8a6]');
                        text.classList.add('text-slate-700');
                        icon.classList.remove('text-[#14b8a6]', 'rotate-180');
                        icon.classList.add('text-gray-400');
                    }
                }
            });

            function switchTab(tab) {
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    const panel = document.getElementById('panel-' + t);
                    const btn = document.getElementById('tab-' + t);
                    if (panel) panel.classList.add('hidden');
                    if (btn) {
                        btn.classList.remove('bg-[#2e3746]', 'text-white', 'shadow-sm');
                        btn.classList.add('text-gray-500', 'hover:text-gray-900');
                    }
                });
                const activePanel = document.getElementById('panel-' + tab);
                const activeBtn = document.getElementById('tab-' + tab);
                if (activePanel) activePanel.classList.remove('hidden');
                if (activeBtn) {
                    activeBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
                    activeBtn.classList.add('bg-[#2e3746]', 'text-white', 'shadow-sm');
                }
                // Save state in hash
                history.replaceState(null, null, '#' + tab);
            }

            // Restore tab from hash on load
            document.addEventListener('DOMContentLoaded', function() {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });
        </script>

    </x-slot>
</x-mentor.layout>
