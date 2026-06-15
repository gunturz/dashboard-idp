<x-pdc_admin.layout title="{{ $pageTitle ?? 'LogBook - Individual Development Plan' }}" :user="$user">
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
                background: #14b8a6;
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #0d9488;
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
                padding: 12px 16px;
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
                font-size: 0.8rem;
                text-align: center;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }

            .pdc-log-table th:last-child {
                border-right: none;
            }

            .pdc-log-table td {
                padding: 12px 16px;
                color: #334155;
                font-size: 0.88rem;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
            }

            .pdc-log-table td:last-child {
                border-right: none;
            }

            .pdc-log-table tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .pdc-log-table tr:hover td {
                background: #f8fafc;
            }
        </style>
    </x-slot>

    <div class="w-full pb-6 fade-up">
        <div class="page-header animate-title">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">{{ $pageTitle ?? 'LogBook' }}</div>
                <div class="page-header-sub">
                    {{ $pageSubtitle ?? 'Rekam jejak aktivitas pengembangan talent ' . $talent->nama }}</div>
            </div>
        </div>

        <div
            class="mb-8 flex gap-1.5 overflow-x-auto rounded-full border border-[#e2e8f0] bg-[#f9fafb] p-1.5 shadow-inner w-fit">
            <button id="tab-exposure" onclick="switchTab('exposure')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 bg-[#0f172a] text-white shadow-sm whitespace-nowrap">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a] whitespace-nowrap">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a] whitespace-nowrap">Learning</button>
        </div>

        <div id="panel-exposure" class="mb-12">
            <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto">
                <table class="w-full min-w-[900px] table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">Tanggal
                                Pengiriman/<br>Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">
                                Tanggal<br>Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureData as $data)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">{{ $data['mentor'] }}
                                </td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $data['tanggal_update'] ? \Carbon\Carbon::parse($data['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center w-32">
                                    @if (in_array($data['status'], ['Approve', 'Approved']))
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif (in_array($data['status'], ['Reject', 'Rejected']))
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pdc_admin.logbook.detail', $data['id']) }}"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-[12px] font-semibold text-white hover:bg-[#0d9488] hover:border-[#0d9488] shadow-sm transition-all"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas
                                    Exposure yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="panel-mentoring" class="mb-12 hidden">
            <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto">
                <table class="w-full min-w-[900px] table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">Tanggal
                                Pengiriman/<br>Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">
                                Tanggal<br>Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringData as $data)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">{{ $data['mentor'] }}
                                </td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $data['tanggal_update'] ? \Carbon\Carbon::parse($data['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center w-32">
                                    @if (in_array($data['status'], ['Approve', 'Approved']))
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif (in_array($data['status'], ['Reject', 'Rejected']))
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pdc_admin.logbook.detail', $data['id']) }}"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-[12px] font-semibold text-white hover:bg-[#0d9488] hover:border-[#0d9488] shadow-sm transition-all"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas
                                    Mentoring yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="panel-learning" class="mb-12 hidden">
            <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto">
                <table class="w-full min-w-[900px] table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Sumber</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">Tanggal
                                Pengiriman/<br>Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">
                                Tanggal<br>Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningData as $data)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                    {{ $data['sumber'] }}</td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $data['tanggal_update'] ? \Carbon\Carbon::parse($data['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center w-32">
                                    @if (in_array($data['status'], ['Approve', 'Approved', 'Verified']))
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Verified' }}
                                        </span>
                                    @elseif (in_array($data['status'], ['Reject', 'Rejected']))
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pdc_admin.logbook.detail', $data['id']) }}"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-[12px] font-semibold text-white hover:bg-[#0d9488] hover:border-[#0d9488] shadow-sm transition-all"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas
                                    Learning yang dicatat.</td>
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

            document.addEventListener('DOMContentLoaded', function() {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });
        </script>
    </x-slot>
</x-pdc_admin.layout>
