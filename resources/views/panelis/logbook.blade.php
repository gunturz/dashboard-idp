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


    <div class="px-3 md:px-0">
        {{-- Kembali Button --}}
        <div class="mb-6">
            <a href="{{ route('panelis.detail_talent', $talent->id) }}#logbook-section" class="btn-prem btn-ghost w-fit">
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


        {{-- Exposure Section --}}
        <div id="panel-exposure" class="tab-panel mb-12">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">

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
        <div id="panel-mentoring" class="tab-panel mb-12 hidden">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
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
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Learning Section --}}
        <div id="panel-learning" class="tab-panel mb-12 hidden">
            <div class="prem-card">
                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
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
                    const p = document.getElementById('panel-' + t);
                    if (p) p.classList.add('hidden');
                    
                    let btn = document.getElementById('tab-' + t);
                    if (btn) {
                        btn.classList.remove('btn-dark', 'active');
                        btn.classList.add('btn-ghost');
                    }
                });
                
                // Show selected panel
                const activePanel = document.getElementById('panel-' + tab);
                if (activePanel) activePanel.classList.remove('hidden');
                
                // Highlight selected tab
                let activeBtn = document.getElementById('tab-' + tab);
                if (activeBtn) {
                    activeBtn.classList.remove('btn-ghost');
                    activeBtn.classList.add('btn-dark', 'active');
                }

                // Update URL hash without causing scroll
                if (history.pushState) {
                    history.pushState(null, null, '#' + tab);
                } else {
                    window.location.hash = '#' + tab;
                }
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
