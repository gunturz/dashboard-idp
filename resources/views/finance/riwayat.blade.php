<x-finance.layout title="Riwayat Validasi" :user="$user">
    <div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <circle cx="10.5" cy="13.5" r="2.5"></circle>
                    <line x1="12.5" y1="15.5" x2="15" y2="18"></line>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Validasi</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <input type="text" id="searchInput" onkeyup="filterHistory()" placeholder="Cari Nama Talent" class="border-[1.5px] border-[#38b2ac] rounded-lg px-4 py-2 w-72 text-sm focus:outline-none focus:ring-1 focus:ring-[#38b2ac] placeholder:text-[#38b2ac] placeholder:text-sm">
            </div>
        </div>

        {{-- History Cards --}}
        <div class="space-y-6">
            @forelse($projects as $index => $project)
            <div class="bg-white rounded-xl shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-200 overflow-hidden transition-all duration-300 filter-card">
                {{-- Card Header --}}
                <div class="p-4 md:p-6 cursor-pointer flex flex-col md:flex-row md:items-center justify-between gap-4 select-none hover:bg-gray-50 transition-colors" onclick="toggleAccordion('riwayat-content-{{ $project->id }}', 'riwayat-icon-{{ $project->id }}')">
                    
                    {{-- Profile Info --}}
                    <div class="flex items-center gap-4 w-full md:w-[40%]">
                        <div class="w-14 h-14 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center overflow-hidden border border-gray-200">
                            <div class="text-indigo-400 w-full h-full flex items-center justify-center font-bold text-xl bg-orange-100 text-orange-800">
                                {{ collect(explode(' ', $project->talent->nama ?? 'A'))->map(fn($n)=>substr($n,0,1))->take(2)->join('') }}
                            </div>
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="font-bold text-gray-800 text-sm talent-name">{{ $project->talent->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->position->position_name ?? '-' }} &rarr; {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->department->nama_department ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-1">Dikirim: {{ $project->updated_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Project Title --}}
                    <div class="w-full md:w-[35%] py-2 md:py-0 md:px-6 md:border-l border-gray-200 flex items-center">
                        <p class="font-bold text-gray-700 text-sm xl:text-base">{{ $project->title }}</p>
                    </div>

                    {{-- Badge & Toggle --}}
                    <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-[25%] mt-2 md:mt-0">
                        @php
                            $finBadgeDecision = null;
                            if (str_starts_with($project->finance_feedback ?? '', '[Approved]')) $finBadgeDecision = 'Approved';
                            elseif (str_starts_with($project->finance_feedback ?? '', '[Rejected]')) $finBadgeDecision = 'Rejected';
                            // Feedback teks tanpa prefix
                            $cleanFeedback = $project->finance_feedback
                                ? preg_replace('/^\[(Approved|Rejected)\]\s*/', '', $project->finance_feedback)
                                : null;
                        @endphp
                        @if($finBadgeDecision === 'Approved')
                        <span class="px-5 py-1.5 rounded-full border-2 border-green-500 text-green-600 text-[13px] font-bold shadow-sm whitespace-nowrap">
                            ✓ Approved
                        </span>
                        @elseif($finBadgeDecision === 'Rejected')
                        <span class="px-5 py-1.5 rounded-full border-2 border-red-500 text-red-600 text-[13px] font-bold shadow-sm whitespace-nowrap">
                            ✕ Rejected
                        </span>
                        @else
                        <span class="px-5 py-1.5 rounded-full border-2 border-gray-400 text-gray-600 text-[13px] font-bold shadow-sm whitespace-nowrap">
                            Menunggu
                        </span>
                        @endif
                        <svg id="riwayat-icon-{{ $project->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600 transition-transform duration-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Card Content (Expandable) --}}
                <div id="riwayat-content-{{ $project->id }}" class="px-4 md:px-6 border-t border-gray-100 bg-white transition-all overflow-hidden pb-0 pt-0 max-h-0 opacity-0">
                    <div class="flex flex-col lg:flex-row gap-5 lg:gap-8 items-start pb-6 pt-5">
                        <div class="w-full flex flex-col lg:flex-row gap-5 lg:gap-8 items-start">
                            <div class="w-full lg:w-auto flex-grow flex flex-col gap-4">
                                {{-- Catatan dari Admin --}}
                                @if($project->feedback)
                                <div>
                                    <div class="font-bold text-gray-700 text-[13px] mb-1">Catatan dari Admin PDC</div>
                                    <div class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-[13px] text-gray-700 min-h-[50px]">
                                        {{ $project->feedback }}
                                    </div>
                                </div>
                                @endif
                                {{-- Feedback Finance (tanpa prefix) --}}
                                <div>
                                    <div class="font-bold text-gray-700 text-[13px] mb-1">Feedback Finance</div>
                                    <div class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-[13px] text-gray-700 min-h-[50px]">
                                        {{ $cleanFeedback ?: '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 min-w-[220px] w-full lg:w-auto xl:w-[25%] flex-shrink-0 mt-2 lg:mt-0">
                                @if($project->document_path)
                                <a href="{{ asset('storage/' . $project->document_path) }}" target="_blank" class="w-full py-2.5 px-4 rounded-lg border border-gray-300 text-gray-800 text-[13px] font-bold flex items-center justify-center gap-2 hover:bg-gray-50 transition-colors shadow-sm bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    Preview File
                                </a>
                                @else
                                <button disabled type="button" class="w-full py-2.5 px-4 rounded-lg border border-gray-300 text-gray-400 text-[13px] font-bold flex items-center justify-center gap-2 bg-gray-100">
                                    Tidak Ada File
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500 bg-white rounded-xl shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-200">
                Belum ada riwayat validasi.
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
            
            document.querySelectorAll('.filter-card').forEach(card => {
                let talentName = card.querySelector('.talent-name')?.innerText.toLowerCase() || "";
                
                if (talentName.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</x-finance.layout>
