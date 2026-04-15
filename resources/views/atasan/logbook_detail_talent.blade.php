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

    <div class="w-full px-3 md:px-6 pt-4 pb-6 fade-up">
        {{-- Kembali Button --}}
        <div class="mb-5">
            <a href="{{ route('atasan.monitoring.detail', $talent->id) }}"
                class="px-4 py-2 border border-[#e2e8f0] rounded-lg bg-white text-[#475569] font-medium text-[0.875rem] flex items-center gap-2 transition-all duration-200 hover:bg-[#f8fafc] hover:border-[#cbd5e1] w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span class="text-[#2e3746]">Kembali</span>
            </a>
        </div>

        <div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            <h1 class="text-2xl font-bold text-[#2e3746]">LogBook : {{ $talent->nama }}</h1>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 p-1.5 bg-gray-100 rounded-full w-fit mb-8 shadow-inner overflow-x-auto">
            <button id="tab-exposure" onclick="switchTab('exposure')" class="tab-btn active">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')" class="tab-btn">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')" class="tab-btn">Learning</button>
        </div>

        {{-- Exposure Panel --}}
        <div id="panel-exposure" class="tab-panel">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table">
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
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table">
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
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table">
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
                // Deactivate all buttons
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                
                // Show selected panel
                document.getElementById('panel-' + tab).classList.remove('hidden');
                // Activate selected button
                document.getElementById('tab-' + tab).classList.add('active');
            }
        </script>
    </x-slot>
</x-atasan.layout>
