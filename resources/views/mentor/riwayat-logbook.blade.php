<x-mentor.layout title="Riwayat Logbook – Individual Development Plan" :user="$user" :notifications="$notifications">
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

            @media (max-width: 767px) {
                .custom-scrollbar {
                    max-width: calc(100vw - 1.5rem);
                }
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                position: relative;
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
        </style>
    </x-slot>

    <div class="w-full px-3 md:px-6 pt-4 pb-6 fade-up">
        {{-- ── Page Header ── --}}
        <div class="page-header animate-title flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="page-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <div class="page-header-title">Riwayat Logbook</div>
                    <div class="page-header-sub">Rekam jejak aktivitas pengembangan talent {{ $talent->nama }}</div>
                </div>
            </div>

            <a href="{{ route('mentor.riwayat') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-slate-800 bg-white hover:bg-gray-50 border border-gray-200 px-5 py-3 rounded-full transition-colors text-sm font-bold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Talent Profile --}}
        <div class="flex items-center gap-4 mb-8 mt-6">
            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                 class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm">
            <div>
                <h3 class="font-bold text-[18px] text-slate-800 leading-tight">{{ $talent->nama }}</h3>
                <p class="text-[13px] text-gray-500 font-medium">
                    {{ optional($talent->position)->position_name ?? '-' }}
                    <span class="text-gray-400 mx-1">|</span>
                    <span class="italic">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="mb-8 flex gap-1.5 overflow-x-auto rounded-full border border-[#e2e8f0] bg-[#f9fafb] p-1.5 shadow-inner w-fit">
            <button id="tab-exposure" onclick="switchTab('exposure')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 bg-[#0f172a] text-white shadow-sm whitespace-nowrap">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a] whitespace-nowrap">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a] whitespace-nowrap">Learning</button>
        </div>

        {{-- ═══ EXPOSURE ═══ --}}
        <div id="panel-exposure" class="mb-12">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
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
                        @forelse($exposureData as $data)
                            <tr>
                                <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                                <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ date('d F Y', strtotime($data['tanggal'])) }}</td>
                                <td class="text-center whitespace-nowrap w-32">
                                    @if(in_array($data['status'], ['Approve','Approved']))
                                        <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($data['status'] === 'Rejected')
                                        <span class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                        class="inline-flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Exposure yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ═══ MENTORING ═══ --}}
        <div id="panel-mentoring" class="mb-12 hidden">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
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
                        @forelse($mentoringData as $data)
                            <tr>
                                <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                                <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ date('d F Y', strtotime($data['tanggal'])) }}</td>
                                <td class="text-center whitespace-nowrap w-32">
                                    @if(in_array($data['status'], ['Approve','Approved']))
                                        <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($data['status'] === 'Rejected')
                                        <span class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                        class="inline-flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Mentoring yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ═══ LEARNING ═══ --}}
        <div id="panel-learning" class="mb-12 hidden">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
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
                        @forelse($learningData as $data)
                            <tr>
                                <td class="text-center font-medium">{{ $data['sumber'] ?: '-' }}</td>
                                <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 35) ?: '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $data['tanggal'] ? date('d F Y', strtotime($data['tanggal'])) : '-' }}</td>
                                <td class="text-center whitespace-nowrap w-32">
                                    @if(in_array($data['status'], ['Approve','Approved','Verified']))
                                        <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            {{ in_array($data['status'], ['Approve','Approved']) ? 'Approved' : 'Verified' }}
                                        </span>
                                    @elseif($data['status'] === 'Rejected')
                                        <span class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                        class="inline-flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Learning yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <x-slot name="scripts">
        <script>
            function switchTab(tab) {
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    document.getElementById('panel-' + t).classList.add('hidden');
                    const btn = document.getElementById('tab-' + t);
                    btn.classList.remove('bg-[#0f172a]', 'text-white', 'shadow-sm');
                    btn.classList.add('text-[#64748b]', 'hover:bg-[#cbd5e1]', 'hover:text-[#0f172a]');
                });

                document.getElementById('panel-' + tab).classList.remove('hidden');
                const activeBtn = document.getElementById('tab-' + tab);
                activeBtn.classList.remove('text-[#64748b]', 'hover:bg-[#cbd5e1]', 'hover:text-[#0f172a]');
                activeBtn.classList.add('bg-[#0f172a]', 'text-white', 'shadow-sm');
                history.replaceState(null, null, '#' + tab);
            }

            document.addEventListener('DOMContentLoaded', function () {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });
        </script>
    </x-slot>
</x-mentor.layout>
