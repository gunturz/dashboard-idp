<x-panelis.layout title="LogBook Panelis – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Page Header ── */
            .page-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 28px;
            }
            .page-header-icon {
                width: 52px;
                height: 52px;
                border-radius: 18px;
                background: #0f172a;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 8px 16px -4px rgba(30, 41, 59, 0.3);
                flex-shrink: 0;
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .page-header-icon svg { width: 26px; height: 26px; }
            .page-header-title {
                font-size: 1.75rem;
                font-weight: 800;
                color: #0f172a;
                line-height: 1.15;
                letter-spacing: -0.025em;
            }
            .page-header-sub {
                font-size: 0.8rem;
                color: #64748b;
                margin-top: 3px;
                font-weight: 400;
            }
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
                padding: 24px 32px;
                color: #64748b;
                font-size: 0.9rem;
                border-top: 1px solid #f1f5f9;
            }

            .pdc-log-table tr:hover td {
                background: #fafafa;
            }
        </style>
    </x-slot>


    <div class="px-3 md:px-0">


        {{-- ── Page Header ── --}}
        <div class="page-header animate-title">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                    <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.707V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">LogBook Talent : {{ $talent->nama }}</div>
                <div class="page-header-sub">Rekap detail seluruh aktivitas pengembangan yang telah dilaksanakan oleh talent</div>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 p-1.5 bg-gray-100 rounded-full w-fit mb-8 shadow-inner overflow-x-auto">
            <button id="tab-exposure" onclick="switchTab('exposure')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 bg-[#0f172a] text-white shadow-sm whitespace-nowrap">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')"
                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Learning</button>
        </div>


        {{-- Exposure Section --}}
        <div id="panel-exposure" class="mb-12">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tgl. Pengiriman/Update</th>
                            <th>Tgl. Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureActivities as $act)
                            <tr>
                                <td class="text-center font-medium">{{ optional($act->verifier)->nama ?? '-' }}</td>
                                <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($act->theme, 35) ?? '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d M Y') : '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d M Y') : '-' }}</td>
                                <td class="text-center whitespace-nowrap w-32">
                                    @php
                                        $st = $act->status ?? 'Pending';
                                        $isApprove = in_array($st, ['Approve', 'Approved', 'Verified']);
                                    @endphp
                                    @if($isApprove)
                                        <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $st }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('panelis.logbook.detail', $act->id) }}"
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


        {{-- Mentoring Section --}}
        <div id="panel-mentoring" class="mb-12 hidden">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tgl. Pengiriman/Update</th>
                            <th>Tgl. Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringActivities as $act)
                            <tr>
                                <td class="text-center font-medium">{{ optional($act->verifier)->nama ?? '-' }}</td>
                                <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($act->theme, 35) ?? '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d M Y') : '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d M Y') : '-' }}</td>
                                <td class="text-center whitespace-nowrap w-32">
                                    @php
                                        $st = $act->status ?? 'Pending';
                                        $isApprove = in_array($st, ['Approve', 'Approved', 'Verified']);
                                    @endphp
                                    @if($isApprove)
                                        <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $st }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('panelis.logbook.detail', $act->id) }}"
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


        {{-- Learning Section --}}
        <div id="panel-learning" class="mb-12 hidden">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
                    <thead>
                        <tr>
                            <th>Sumber</th>
                            <th>Tema</th>
                            <th>Tgl. Pengiriman/Update</th>
                            <th>Tgl. Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningActivities as $act)
                            <tr>
                                <td class="text-center font-medium">{{ $act->activity ?? '-' }}</td>
                                <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($act->theme, 35) ?? '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d M Y') : '-' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d M Y') : '-' }}</td>
                                <td class="text-center whitespace-nowrap w-32">
                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('panelis.logbook.detail', $act->id) }}"
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
                    btn.classList.add('text-gray-500', 'hover:text-gray-900');
                });
                document.getElementById('panel-' + tab).classList.remove('hidden');
                const activeBtn = document.getElementById('tab-' + tab);
                activeBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
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
</x-panelis.layout>
