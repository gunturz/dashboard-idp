<x-atasan.layout title="LogBook Talent – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .custom-scrollbar::-webkit-scrollbar { height: 8px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #0d9488; border-radius: 10px; border: 2px solid #f8fafc; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #0f766e; }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .pdc-log-table {
                width: 100%;
                border-collapse: collapse;
            }
            .pdc-log-table th {
                padding: 24px 32px;
                background: #f8fafc;
                font-weight: 800;
                color: #475569;
                font-size: 0.95rem;
                text-align: center;
                white-space: nowrap;
            }
            .pdc-log-table td {
                padding: 32px;
                color: #64748b;
                font-size: 0.9rem;
                border-top: 1px solid #f1f5f9;
            }
            .pdc-log-table tr:hover {
                background: #fafafa;
            }

            /* Tabs styling */
            .tab-btn {
                padding: 10px 24px;
                font-size: 0.875rem;
                font-weight: 700;
                border-radius: 99px;
                transition: all 0.2s;
                cursor: pointer;
                white-space: nowrap;
            }
            .tab-btn.active {
                background: #2e3746;
                color: white;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
            .tab-btn:not(.active) {
                color: #64748b;
            }
            .tab-btn:not(.active):hover {
                color: #1e293b;
            }
        </style>
    </x-slot>

    <div class="px-3 md:px-0">
        {{-- Kembali Button --}}
        <div class="mb-6">
            <a href="{{ route('atasan.monitoring.detail', $talent->id) }}" class="btn-prem btn-ghost w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- ── Page Header ── --}}
        <div class="page-header animate-title">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h1 class="page-header-title">LogBook Talent : {{ $talent->nama }}</h1>
                <p class="page-header-sub">Rekap detail seluruh aktivitas pengembangan yang telah dilaksanakan oleh talent</p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex items-center gap-2 mb-8 overflow-x-auto pb-2 custom-scrollbar">
            <button id="tab-exposure" onclick="switchTab('exposure')" class="btn-prem btn-dark tab-btn active">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')" class="btn-prem btn-ghost tab-btn">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')" class="btn-prem btn-ghost tab-btn">Learning</button>
        </div>

        {{-- Exposure Panel --}}
        <div id="panel-exposure" class="tab-panel">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tanggal Pengiriman/Update</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureData as $item)
                        <tr>
                            <td class="text-center font-medium">{{ $item['mentor'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($item['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->format('d F Y') : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}</td>
                            <td class="text-center whitespace-nowrap w-32">
                                @php
                                    $isApprove = in_array($item['status'], ['Approve', 'Approved', 'Verified']);
                                @endphp
                                @if($isApprove)
                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $item['status'] ?: 'Pending' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('atasan.logbook.detail', $item['id']) }}" class="flex items-center justify-center font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100 mx-auto w-fit" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Exposure yang dicatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mentoring Panel --}}
        <div id="panel-mentoring" class="tab-panel hidden">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tanggal Pengiriman/Update</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringData as $item)
                        <tr>
                            <td class="text-center font-medium">{{ $item['mentor'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($item['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->format('d F Y') : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}</td>
                            <td class="text-center whitespace-nowrap w-32">
                                @php
                                    $isApprove = in_array($item['status'], ['Approve', 'Approved', 'Verified']);
                                @endphp
                                @if($isApprove)
                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $item['status'] ?: 'Pending' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('atasan.logbook.detail', $item['id']) }}" class="flex items-center justify-center font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100 mx-auto w-fit" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Mentoring yang dicatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Learning Panel --}}
        <div id="panel-learning" class="tab-panel hidden">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
                    <thead>
                        <tr>
                            <th>Sumber</th>
                            <th>Tema</th>
                            <th>Tanggal Pengiriman/Update</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningData as $item)
                        <tr>
                            <td class="text-center font-medium">{{ $item['sumber'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($item['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->format('d F Y') : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d F Y') }}</td>
                            <td class="text-center whitespace-nowrap w-32">
                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('atasan.logbook.detail', $item['id']) }}" class="flex items-center justify-center font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100 mx-auto w-fit" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Learning yang dicatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function switchTab(tab) {
                // Hide all panels
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
                // Reset all buttons to ghost
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('btn-dark', 'active');
                    b.classList.add('btn-ghost');
                });
                
                // Show selected panel
                const panel = document.getElementById('panel-' + tab);
                if (panel) panel.classList.remove('hidden');
                
                // Activate selected button
                const activeBtn = document.getElementById('tab-' + tab);
                if (activeBtn) {
                    activeBtn.classList.add('btn-dark', 'active');
                    activeBtn.classList.remove('btn-ghost');
                }

                // Update URL hash without jumping
                if (history.pushState) {
                    history.pushState(null, null, '#' + tab);
                } else {
                    window.location.hash = '#' + tab;
                }
            }

            // Handle initial hash
            document.addEventListener('DOMContentLoaded', () => {
                const hash = window.location.hash.replace('#', '');
                if (hash && ['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });
        </script>
    </x-slot>
</x-atasan.layout>
