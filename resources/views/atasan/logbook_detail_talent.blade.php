<x-atasan.layout title="LogBook Talent – Individual Development Plan" :user="$user">
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

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow-x: auto;
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
                text-transform: capitalize;
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
                background: #0f172a;
                color: white;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .tab-btn:not(.active) {
                color: #64748b;
            }

            .tab-btn:not(.active):hover {
                color: #1e293b;
            }

            @media (max-width: 768px) {
                .tab-panel table {
                    min-width: 800px;
                }
            }
        </style>
    </x-slot>

    <div class="px-3 md:px-0">


        {{-- ── Page Header ── --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                    <path
                        d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c1.68 0 3.282.466 4.75 1.286a.75.75 0 001-.707V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#1f2937]">LogBook</h1>
                <p class="text-[13px] font-medium text-gray-500 mt-1">Rekam jejak aktivitas pengembangan talent
                    {{ strtolower($talent->nama) }}</p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div
            class="flex overflow-x-auto no-scrollbar bg-white border border-gray-100 rounded-full w-fit max-w-full p-1 mb-10 shadow-sm ring-1 ring-inset ring-gray-100/50">
            <button id="tab-exposure" onclick="switchTab('exposure')"
                class="tab-btn px-6 py-2.5 font-bold text-sm rounded-full transition-all tracking-wide {{ ($activeTab ?? 'exposure') === 'exposure' ? 'bg-slate-900 text-white shadow-md active' : 'text-slate-500 hover:text-slate-800' }}">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')"
                class="tab-btn px-6 py-2.5 font-bold text-sm rounded-full transition-all tracking-wide {{ ($activeTab ?? 'exposure') === 'mentoring' ? 'bg-slate-900 text-white shadow-md active' : 'text-slate-500 hover:text-slate-800' }}">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')"
                class="tab-btn px-6 py-2.5 font-bold text-sm rounded-full transition-all tracking-wide {{ ($activeTab ?? 'exposure') === 'learning' ? 'bg-slate-900 text-white shadow-md active' : 'text-slate-500 hover:text-slate-800' }}">Learning</button>
        </div>

        {{-- Exposure Panel --}}
        <div id="panel-exposure" class="tab-panel {{ ($activeTab ?? 'exposure') === 'exposure' ? '' : 'hidden' }}">
            <div class="rounded-xl overflow-x-auto custom-scrollbar border border-gray-200">
                <table class="w-full table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal
                                Pengiriman/Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal
                                Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureData as $item)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">{{ $item['mentor'] }}
                                </td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($item['tema'], 35) }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $statusTxt = strtolower(trim($item['status'] ?? 'pending'));
                                        $statusLabel = in_array($statusTxt, ['approve', 'approved'])
                                            ? 'Approved'
                                            : ($statusTxt === 'rejected'
                                                ? 'Rejected'
                                                : 'Pending');
                                    @endphp
                                    @if ($statusLabel === 'Approved')
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($statusLabel === 'Rejected')
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('atasan.logbook.detail', $item['id']) }}"
                                        class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
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

        {{-- Mentoring Panel --}}
        <div id="panel-mentoring" class="tab-panel {{ ($activeTab ?? 'exposure') === 'mentoring' ? '' : 'hidden' }}">
            <div class="rounded-xl overflow-x-auto custom-scrollbar border border-gray-200">
                <table class="w-full table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal
                                Pengiriman/Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal
                                Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringData as $item)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                    {{ $item['mentor'] }}</td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($item['tema'], 35) }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $statusTxt = strtolower(trim($item['status'] ?? 'pending'));
                                        $statusLabel = in_array($statusTxt, ['approve', 'approved'])
                                            ? 'Approved'
                                            : ($statusTxt === 'rejected'
                                                ? 'Rejected'
                                                : 'Pending');
                                    @endphp
                                    @if ($statusLabel === 'Approved')
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($statusLabel === 'Rejected')
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('atasan.logbook.detail', $item['id']) }}"
                                        class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
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

        {{-- Learning Panel --}}
        <div id="panel-learning" class="tab-panel {{ ($activeTab ?? 'exposure') === 'learning' ? '' : 'hidden' }}">
            <div class="rounded-xl overflow-x-auto custom-scrollbar border border-gray-200">
                <table class="w-full table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Sumber</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                Tanggal Pengiriman/Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                Tanggal Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningData as $item)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                    {{ $item['sumber'] }}</td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($item['tema'], 35) }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $statusTxt = strtolower(trim($item['status'] ?? 'pending'));
                                        $statusLabel = in_array($statusTxt, ['approve', 'approved'])
                                            ? 'Approved'
                                            : ($statusTxt === 'rejected'
                                                ? 'Rejected'
                                                : 'Pending');
                                    @endphp
                                    @if ($statusLabel === 'Approved')
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif($statusLabel === 'Rejected')
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('atasan.logbook.detail', $item['id']) }}"
                                        class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
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
                // Hide all panels
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));

                // Reset all buttons 
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'bg-slate-900', 'text-white', 'shadow-md');
                    b.classList.add('text-slate-500', 'hover:text-slate-800');
                });

                // Show selected panel
                const panel = document.getElementById('panel-' + tab);
                if (panel) panel.classList.remove('hidden');

                // Activate selected button
                const activeBtn = document.getElementById('tab-' + tab);
                if (activeBtn) {
                    activeBtn.classList.remove('text-slate-500', 'hover:text-slate-800');
                    activeBtn.classList.add('active', 'bg-slate-900', 'text-white', 'shadow-md');
                }

                // Update URL query without reloading
                const url = new URL(window.location.href);
                url.searchParams.set('tab', tab);
                url.hash = tab;
                window.history.replaceState({}, '', url.toString());
            }

            // Handle initial tab from query/hash
            document.addEventListener('DOMContentLoaded', () => {
                const params = new URLSearchParams(window.location.search);
                const queryTab = params.get('tab');
                const hash = window.location.hash.replace('#', '');
                const initialTab = ['exposure', 'mentoring', 'learning'].includes(queryTab) ?
                    queryTab :
                    (['exposure', 'mentoring', 'learning'].includes(hash) ? hash : @json($activeTab ?? 'exposure'));

                switchTab(initialTab);
            });
        </script>
    </x-slot>
</x-atasan.layout>
