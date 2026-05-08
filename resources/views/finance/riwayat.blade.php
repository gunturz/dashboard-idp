<x-finance.layout title="Riwayat Validasi" :user="$user">
    <div class="mb-8">
    {{-- ── Page Header ── --}}
    <div class="dash-header animate-title">
        <div class="dash-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <div class="dash-header-title">Riwayat Validasi</div>
            <div class="dash-header-sub">Daftar semua project yang telah divalidasi</div>
        </div>
    </div>

        {{-- Filter Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" oninput="filterHistory()" placeholder="Cari Talent / Project" 
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-11 pr-4 text-sm outline-none focus:ring-2 focus:ring-teal-500 transition-all">
            </div>
            <div class="flex-shrink-0 w-full sm:w-60">
                <select id="statusFilter" onchange="filterHistory()" 
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                    <option value="">Semua Status</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
        </div>

        {{-- History List --}}
        <div class="space-y-6">
            @forelse($projects as $index => $project)
            @php
                $finBadgeDecision = null;
                if (str_starts_with($project->finance_feedback ?? '', '[Approved]')) $finBadgeDecision = 'Approved';
                elseif (str_starts_with($project->finance_feedback ?? '', '[Rejected]')) $finBadgeDecision = 'Rejected';
                
                $cleanFeedback = $project->finance_feedback
                    ? preg_replace('/^\[(Approved|Rejected)\]\s*/', '', $project->finance_feedback)
                    : null;
            @endphp
            <div class="prem-card filter-card" data-status="{{ $finBadgeDecision }}">
                {{-- Card Header --}}
                <div class="prem-card-header !py-6 md:!py-8 cursor-pointer select-none hover:bg-gray-50 transition-colors" onclick="toggleAccordion('riwayat-content-{{ $project->id }}', 'riwayat-icon-{{ $project->id }}')">
                    
                    {{-- Profile Info --}}
                    <div class="flex items-center gap-4 w-full md:w-[40%]">
                        <div class="flex-shrink-0">
                            @if($project->talent->foto)
                                <img src="{{ asset('storage/' . $project->talent->foto) }}" alt="{{ $project->talent->nama }}" class="w-16 h-16 rounded-xl object-cover border-2 border-gray-100 shadow-sm">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-2xl border-2 border-slate-50">
                                    {{ collect(explode(' ', $project->talent->nama ?? 'A'))->map(fn($n)=>substr($n,0,1))->take(2)->join('') }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="text-gray-800 talent-name" style="font-size: 0.9rem; font-weight: 600; line-height: 1.2;">{{ $project->talent->nama ?? '-' }}</p>
                            <p class="text-gray-500 italic leading-tight mt-0.5" style="font-size: 0.9rem;">
                                {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->position->position_name ?? '-') }} &rarr; 
                                {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->promotion_plan->targetPosition->position_name ?? '?') }}
                            </p>
                            <p class="text-gray-500 italic" style="font-size: 0.9rem;">
                                {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->department->nama_department ?? '-') }}
                            </p>
                        </div>
                    </div>

                    {{-- Project Title --}}
                    <div class="w-full md:w-[35%] py-2 md:py-0 md:px-6 flex items-center">
                        <p class="text-gray-700" style="font-size: 0.9rem; font-weight: 700; line-height: 1.3;">
                            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->title) }}
                        </p>
                    </div>

                    {{-- Badge & Toggle --}}
                    <div class="flex items-center justify-between md:justify-end gap-6 ml-auto mt-2 md:mt-0">


                        @if($finBadgeDecision === 'Approved')
                            <span class="badge badge-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Approved
                            </span>
                        @elseif($finBadgeDecision === 'Rejected')
                            <span class="badge badge-red">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Rejected
                            </span>
                        @else
                            <span class="badge badge-gray">Menunggu</span>
                        @endif

                        <svg id="riwayat-icon-{{ $project->id }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Card Content (Expandable) --}}
                <div id="riwayat-content-{{ $project->id }}" class="px-6 border-t border-gray-100 bg-white transition-all overflow-hidden pb-0 pt-0 max-h-0 opacity-0">
                    <div class="flex flex-col lg:flex-row gap-6 items-start pb-6 pt-5">
                        <div class="w-full flex flex-col lg:flex-row gap-6 items-start">
                            <div class="w-full lg:w-auto flex-grow flex flex-col gap-4">
                                {{-- Catatan dari Admin --}}
                                @if($project->feedback)
                                <div>
                                    <div class="font-bold text-gray-700 mb-1.5 flex items-center gap-2" style="font-size: 0.9rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        Catatan Admin PDC:
                                    </div>
                                    <div class="w-full rounded-xl border border-gray-100 bg-gray-50/50 px-4 py-3 text-gray-600 leading-relaxed min-h-[50px]" style="font-size: 0.9rem;">
                                        {{ $project->feedback }}
                                    </div>
                                </div>
                                @endif
                                {{-- Feedback Finance (tanpa prefix) --}}
                                <div>
                                    <div class="font-bold text-gray-700 mb-1.5 flex items-center gap-2" style="font-size: 0.9rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Feedback Finance:
                                    </div>
                                    <div class="w-full rounded-xl border border-gray-100 bg-gray-50/50 px-4 py-3 text-gray-600 leading-relaxed min-h-[50px]" style="font-size: 0.9rem;">
                                        {{ $cleanFeedback ?: '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 min-w-[240px] w-full lg:w-auto xl:w-[25%] flex-shrink-0 mt-2 lg:mt-5">
                                @if($project->document_path)
                                <a href="{{ route('files.preview', ['path' => $project->document_path]) }}" target="_blank" class="btn-prem btn-ghost w-full py-3 shadow-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview Dokumen
                                </a>
                                @else
                                <button disabled type="button" class="btn-prem btn-ghost w-full py-3 opacity-50 cursor-not-allowed">
                                    Tidak Ada File
                                </button>
                                @endif
                                <p class="text-gray-800 text-center italic leading-tight" style="font-size: 0.8rem;">Project divalidasi pada {{ $project->updated_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="prem-card">
                <div class="empty-prem">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3>Belum ada riwayat</h3>
                    <p>Belum ada riwayat validasi atau hasil pencarian tidak ditemukan.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        function toggleAccordion(contentId, iconId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            if (content.classList.contains('max-h-0')) {
                // Expanding
                content.classList.remove('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.add('max-h-[1000px]', 'opacity-100', 'pb-6', 'pt-5');
                icon.classList.add('rotate-180');
            } else {
                // Collapsing
                content.classList.add('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.remove('max-h-[1000px]', 'opacity-100', 'pb-6', 'pt-5');
                icon.classList.remove('rotate-180');
            }
        }

        function filterHistory() {
            let searchValue = document.getElementById('searchInput').value.toLowerCase();
            let statusValue = document.getElementById('statusFilter').value;
            
            document.querySelectorAll('.filter-card').forEach(card => {
                let talentName = card.querySelector('.talent-name')?.innerText.toLowerCase() || "";
                let cardStatus = card.getAttribute('data-status') || "";
                
                let matchesSearch = talentName.includes(searchValue);
                let matchesStatus = statusValue === "" || cardStatus === statusValue;
                
                if (matchesSearch && matchesStatus) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</x-finance.layout>
