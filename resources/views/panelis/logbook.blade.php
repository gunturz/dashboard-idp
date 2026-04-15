<x-panelis.layout title="LogBook Panelis – Individual Development Plan" :user="$user">
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
        </style>
    </x-slot>


    <div class="w-full px-3 md:px-6 pt-4 pb-6 fade-up">
        {{-- Back Link --}}
        <div class="mb-5">
            <a href="{{ route('panelis.detail_talent', $talent->id) }}#logbook-section"
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
            <button id="tab-exposure" onclick="switchTab('exposure')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 bg-[#2e3746] text-white shadow-sm whitespace-nowrap">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Learning</button>
        </div>


        {{-- Exposure Section --}}
        <div id="panel-exposure" class="mb-12">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left table-fixed">

                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tgl. Pengiriman/Update</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tgl. Pelaksanaan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($exposureActivities as $act)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ optional($act->verifier)->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 border-r border-gray-100" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-left border-r border-gray-100">
                                    @php
                                        $st = $act->status ?? 'Pending';
                                        $isApprove = in_array($st, ['Approve', 'Approved', 'Verified']);
                                    @endphp
                                    @if($isApprove)
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-[11px] bg-orange-50"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $st }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('panelis.logbook.detail', $act->id) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada aktivitas Exposure yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Mentoring Section --}}
        <div id="panel-mentoring" class="mb-12 hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tgl. Pengiriman/Update</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tgl. Pelaksanaan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mentoringActivities as $act)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ optional($act->verifier)->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 border-r border-gray-100" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-left border-r border-gray-100">
                                    @php
                                        $st = $act->status ?? 'Pending';
                                        $isApprove = in_array($st, ['Approve', 'Approved', 'Verified']);
                                    @endphp
                                    @if($isApprove)
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-[11px] bg-orange-50"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $st }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('panelis.logbook.detail', $act->id) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada aktivitas Mentoring yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Learning Section --}}
        <div id="panel-learning" class="mb-12 hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Sumber</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tgl. Pengiriman/Update</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tgl. Pelaksanaan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($learningActivities as $act)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $act->activity ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 border-r border-gray-100" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($act->theme, 35) ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-left border-r border-gray-100">
                                    <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified</span>
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('panelis.logbook.detail', $act->id) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada aktivitas Learning yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Generic Logbook Detail Modal -->
    <div id="logbookDetailModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-[500px] p-7 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="logbookDetailModalContent">
            <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-[#1e293b]">Detail Logbook</h3>
                <button onclick="closeLogbookDetailModal()" class="text-gray-400 hover:text-gray-600 bg-gray-50 rounded-full p-2 hover:bg-gray-200 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="text-sm" id="detailModalBody"></div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <button onclick="closeLogbookDetailModal()" class="w-full bg-[#f1f5f9] text-[#64748b] font-bold py-2.5 rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function switchTab(tab) {
                // Hide all panels
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    document.getElementById('panel-' + t).classList.add('hidden');
                    let btn = document.getElementById('tab-' + t);
                    btn.classList.remove('bg-[#2e3746]', 'text-white', 'shadow-sm');
                    btn.classList.add('text-gray-500', 'hover:text-gray-900');
                });
                
                // Show selected panel
                document.getElementById('panel-' + tab).classList.remove('hidden');
                
                // Highlight selected tab
                let activeBtn = document.getElementById('tab-' + tab);
                activeBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
                activeBtn.classList.add('bg-[#2e3746]', 'text-white', 'shadow-sm');

                // Update URL hash without causing scroll
                history.replaceState(null, null, '#' + tab);
            }

            // Check URL hash for initial tab
            document.addEventListener('DOMContentLoaded', function () {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });

            function openLogbookDetail(btn) {
                const htmlContent = btn.nextElementSibling.innerHTML;
                document.getElementById('detailModalBody').innerHTML = htmlContent;
                const modal = document.getElementById('logbookDetailModal');
                const content = document.getElementById('logbookDetailModalContent');
                modal.classList.remove('hidden');
                setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
            }

            function closeLogbookDetailModal() {
                const modal = document.getElementById('logbookDetailModal');
                const content = document.getElementById('logbookDetailModalContent');
                modal.classList.add('opacity-0'); content.classList.add('scale-95');
                setTimeout(() => { modal.classList.add('hidden'); }, 300);
            }
        </script>
    </x-slot>
</x-panelis.layout>
