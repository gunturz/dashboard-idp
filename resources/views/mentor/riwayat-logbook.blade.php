<x-mentor.layout title="Riwayat Logbook – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .custom-scrollbar::-webkit-scrollbar { 
                height: 8px; 
            }
            .custom-scrollbar::-webkit-scrollbar-track { 
                background: #f8fafc; 
                border-radius: 10px; 
            }
            .custom-scrollbar::-webkit-scrollbar-thumb { 
                background: #0d9488; 
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
                background: #0f766e; 
            }

            .prem-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
                overflow: hidden;
                margin-bottom: 24px;
            }

            .btn-prem {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                font-size: 0.8rem;
                font-weight: 700;
                padding: 8px 16px;
                border-radius: 10px;
                border: none;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
                white-space: nowrap;
            }

            .btn-prem:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            }

            .btn-dark {
                background: #475569;
                color: #fff;
            }

            .btn-dark:hover {
                background: #334155;
                color: #fff;
            }

            .btn-ghost {
                background: #f1f5f9;
                color: #334155;
                border: 1px solid #e2e8f0;
            }

            .btn-ghost:hover {
                background: #e2e8f0;
                color: #1e293b;
            }

            .highlight-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.85rem;
            }

            .highlight-table th {
                background: #f8fafc;
                color: #475569;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                white-space: nowrap;
                font-size: 0.78rem;
            }

            .highlight-table td {
                padding: 14px 16px;
                color: #475569;
                border-top: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                text-align: center;
                vertical-align: middle;
            }

            .highlight-table th:last-child,
            .highlight-table td:last-child {
                border-right: none;
            }

            .highlight-table tbody tr:hover td {
                background: #f0fdfa;
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

            .btn-pending {
                display: inline-flex;
                align-items: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: #92400e;
                background: #fef3c7;
                border: 1px solid #fde68a;
                padding: 4px 12px;
                border-radius: 6px;
            }

            .btn-approved {
                display: inline-flex;
                align-items: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: #15803d;
                background: #dcfce7;
                border: 1px solid #bbf7d0;
                padding: 4px 12px;
                border-radius: 6px;
            }

            .btn-rejected {
                display: inline-flex;
                align-items: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: #b91c1c;
                background: #fee2e2;
                border: 1px solid #fecaca;
                padding: 4px 12px;
                border-radius: 6px;
            }

            @media (max-width: 767px) {
                main { padding: 16px !important; }
                .val-table th, .val-table td { padding: 10px 10px; font-size: 0.78rem; }
            }
        </style>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        {{-- Back & Title --}}
        <div class="flex items-center gap-4 mb-8 border-b border-gray-100 pb-6">
            <a href="{{ route('mentor.riwayat') }}" class="text-gray-400 hover:text-gray-700 bg-gray-50 hover:bg-gray-200 p-2.5 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-[#1e293b]">Riwayat Logbook - {{ $talent->nama }}</h2>
                <p class="text-gray-500 text-sm mt-1">Daftar semua aktivitas logbook dari talent yang telah dinilai.</p>
            </div>
        </div>

        {{-- Talent Profile --}}
        <div class="flex items-center gap-4 mb-8">
            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                 class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm">
            <div>
                <h3 class="font-bold text-[20px] text-slate-800 leading-tight">{{ $talent->nama }}</h3>
                <p class="text-[13px] text-gray-500 font-medium">
                    {{ optional($talent->position)->position_name ?? '-' }}
                    <span class="text-gray-400 mx-1">|</span>
                    <span class="italic">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="inline-flex items-center gap-1.5 mb-8 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/60 overflow-x-auto custom-scrollbar w-fit">
            <button id="tab-exposure" onclick="switchTab('exposure')" class="btn-prem btn-dark tab-btn active px-6 rounded-full">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')" class="btn-prem btn-ghost tab-btn px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')" class="btn-prem btn-ghost tab-btn px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80">Learning</button>
        </div>

        {{-- ═══ EXPOSURE ═══ --}}
        <div id="panel-exposure">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
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
                                    @if($data['status'] === 'Pending')
                                        <span class="status-dot status-pending">Pending</span>
                                    @elseif(in_array($data['status'], ['Approve','Approved']))
                                        <span class="status-dot status-approved">Approved</span>
                                    @else
                                        <span class="status-dot status-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>
                            <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('mentor.riwayat.detail', $data['id']) }}" class="btn-detail">
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
        </div>

        {{-- ═══ MENTORING ═══ --}}
        <div id="panel-mentoring" class="hidden">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
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
                                    @if($data['status'] === 'Pending')
                                        <span class="status-dot status-pending">Pending</span>
                                    @elseif(in_array($data['status'], ['Approve','Approved']))
                                        <span class="status-dot status-approved">Approved</span>
                                    @else
                                        <span class="status-dot status-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>
                            <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('mentor.riwayat.detail', $data['id']) }}" class="btn-detail">
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
        </div>

        {{-- ═══ LEARNING ═══ --}}
        <div id="panel-learning" class="hidden">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
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
                                    @if($data['status'] === 'Pending')
                                        <span class="status-dot status-pending">Pending</span>
                                    @elseif(in_array($data['status'], ['Approve','Approved']))
                                        <span class="status-dot status-approved">Approved</span>
                                    @else
                                        <span class="status-dot status-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>
                            <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('mentor.riwayat.detail', $data['id']) }}" class="btn-detail">
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
        </div>

    </div>

    <x-slot name="scripts">
        <script>
            function switchTab(tab) {
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    const panel = document.getElementById('panel-' + t);
                    const btn = document.getElementById('tab-' + t);
                    if (panel) panel.classList.add('hidden');
                    if (btn) {
                        btn.classList.remove('btn-dark', 'active');
                        btn.classList.add('btn-ghost', 'border-transparent', 'bg-transparent', 'hover:bg-slate-200/80');
                    }
                });
                const activePanel = document.getElementById('panel-' + tab);
                const activeBtn = document.getElementById('tab-' + tab);
                if (activePanel) activePanel.classList.remove('hidden');
                if (activeBtn) {
                    activeBtn.classList.remove('btn-ghost', 'border-transparent', 'bg-transparent', 'hover:bg-slate-200/80');
                    activeBtn.classList.add('btn-dark', 'active');
                }
                
                if (history.pushState) {
                    history.pushState(null, null, '#' + tab);
                } else {
                    window.location.hash = '#' + tab;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });
        </script>
    </x-slot>
</x-mentor.layout>
