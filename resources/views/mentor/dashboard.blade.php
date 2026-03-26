<x-mentor.layout title="Dashboard Mentor" :user="$user">
    <div class="space-y-6">
        @foreach($menteesList as $mentee)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden accordion-card">
                <!-- Header -->
                <div class="flex items-center justify-between p-5 cursor-pointer hover:bg-gray-50 transition-colors accordion-header" onclick="toggleAccordion(this)">
                    <div class="flex items-center gap-4">
                        <img src="{{ $mentee['foto'] ? asset('storage/' . $mentee['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($mentee['name']) . '&background=random' }}" class="w-14 h-14 rounded-full object-cover">
                        <div>
                            <h3 class="font-bold text-[17px] text-slate-800">{{ $mentee['name'] }}</h3>
                            <p class="text-[13px] text-gray-500 font-medium">
                                {{ $mentee['position'] }} - <span class="italic">{{ $mentee['department'] }}</span>
                            </p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-teal-600 transform transition-transform duration-300 accordion-icon shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Expanded Content -->
                <div class="accordion-content hidden border-t border-gray-100 p-6 bg-white pb-8">
                    
                    <!-- Stats Section 3 state cards-->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <div class="border-[1.5px] border-yellow-400 rounded-xl py-6 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(250,204,21,0.1)] transition-shadow hover:shadow-md">
                            <span class="text-yellow-400 font-bold text-4xl mb-1">{{ $mentee['status']['pending'] }}</span>
                            <span class="text-gray-400 text-[13px] font-medium">Feedback Pending</span>
                        </div>
                        <div class="border-[1.5px] border-green-500 rounded-xl py-6 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(34,197,94,0.1)] transition-shadow hover:shadow-md">
                            <span class="text-green-500 font-bold text-4xl mb-1">{{ $mentee['status']['approved'] }}</span>
                            <span class="text-gray-400 text-[13px] font-medium">Approved</span>
                        </div>
                        <div class="border-[1.5px] border-red-500 rounded-xl py-6 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(239,68,68,0.1)] transition-shadow hover:shadow-md">
                            <span class="text-red-500 font-bold text-4xl mb-1">{{ $mentee['status']['rejected'] }}</span>
                            <span class="text-gray-400 text-[13px] font-medium">Rejected</span>
                        </div>
                    </div>

                    <!-- Lower Section Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14">
                        <!-- Left: Circular Progress (Donuts) -->
                        <div class="flex flex-wrap sm:flex-nowrap items-center justify-around gap-6 lg:gap-2">
                            <!-- Exposure -->
                            <div class="flex flex-col items-center gap-3">
                                <div class="relative w-[110px] h-[110px] md:w-32 md:h-32 flex items-center justify-center">
                                    <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                      <path class="text-slate-400/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"/>
                                      <path class="text-slate-600" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="{{ $mentee['progress']['exposure']['pct'] }}, 100" />
                                    </svg>
                                    <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                        <span class="text-xl tracking-tight">{{ $mentee['progress']['exposure']['count'] }}/{{ $mentee['progress']['exposure']['target'] }}</span>
                                        <span class="text-[11px] text-[#475569] italic">{{ $mentee['progress']['exposure']['pct'] }}%</span>
                                    </div>
                                </div>
                                <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[12px] font-medium px-4 py-1.5 rounded-full shadow-sm w-[110px] text-center">Exposure</span>
                            </div>

                            <!-- Mentoring -->
                            <div class="flex flex-col items-center gap-3">
                                <div class="relative w-[110px] h-[110px] md:w-32 md:h-32 flex items-center justify-center">
                                    <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                      <path class="text-yellow-400/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"/>
                                      <path class="text-[#eab308]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="{{ $mentee['progress']['mentoring']['pct'] }}, 100" />
                                    </svg>
                                    <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                        <span class="text-xl tracking-tight">{{ $mentee['progress']['mentoring']['count'] }}/{{ $mentee['progress']['mentoring']['target'] }}</span>
                                        <span class="text-[11px] text-[#475569] italic">{{ $mentee['progress']['mentoring']['pct'] }}%</span>
                                    </div>
                                </div>
                                <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[12px] font-medium px-4 py-1.5 rounded-full shadow-sm w-[110px] text-center">Mentoring</span>
                            </div>

                            <!-- Learning -->
                            <div class="flex flex-col items-center gap-3">
                                <div class="relative w-[110px] h-[110px] md:w-32 md:h-32 flex items-center justify-center">
                                    <svg viewBox="0 0 36 36" class="absolute w-full h-full -rotate-90">
                                      <path class="text-teal-400/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"/>
                                      <path class="text-[#0d9488]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="{{ $mentee['progress']['learning']['pct'] }}, 100" />
                                    </svg>
                                    <div class="flex flex-col items-center font-bold text-[#2e3746] leading-tight">
                                        <span class="text-xl tracking-tight">{{ $mentee['progress']['learning']['count'] }}/{{ $mentee['progress']['learning']['target'] }}</span>
                                        <span class="text-[11px] text-[#475569] italic">{{ $mentee['progress']['learning']['pct'] }}%</span>
                                    </div>
                                </div>
                                <span class="border border-[#cbd5e1] text-[#475569] bg-white text-[12px] font-medium px-4 py-1.5 rounded-full shadow-sm w-[110px] text-center">Learning</span>
                            </div>
                        </div>

                        <!-- Right: Top 3 Gap -->
                        <div class="flex flex-col justify-between h-full pt-2">
                            <div>
                                <h4 class="font-extrabold text-[15px] text-slate-800 mb-4 tracking-wide">TOP 3 GAP</h4>
                                <div class="space-y-3">
                                    @forelse($mentee['gaps'] as $index => $gap)
                                        @php
                                            // Colors mapping 0=Red, 1=Orange, 2=Blue
                                            $colors = [
                                                ['border' => 'border-red-400', 'bg' => 'bg-red-500', 'text' => 'text-white'],
                                                ['border' => 'border-orange-400', 'bg' => 'bg-orange-400', 'text' => 'text-white'],
                                                ['border' => 'border-blue-400', 'bg' => 'bg-blue-400', 'text' => 'text-white']
                                            ];
                                            $c = $colors[$index] ?? $colors[2];
                                            $compName = optional($gap->competence)->name ?? '-';
                                            $val = is_numeric($gap->gap_score) ? ($gap->gap_score == intval($gap->gap_score) ? intval($gap->gap_score) : number_format($gap->gap_score, 1)) : $gap->gap_score;
                                        @endphp
                                        <div class="flex items-center justify-between border-[1.5px] {{ $c['border'] }} rounded-xl px-4 py-2.5">
                                            <div class="flex items-center gap-4">
                                                <span class="{{ $c['bg'] }} {{ $c['text'] }} w-[26px] h-[26px] rounded-full flex items-center justify-center font-bold text-[13px] shadow-sm">{{ $index + 1 }}</span>
                                                <span class="font-bold text-[#2e3746] text-[13px]">{{ $compName }}</span>
                                            </div>
                                            <span class="font-semibold text-slate-700">{{ $val }}</span>
                                        </div>
                                    @empty
                                        <div class="text-sm text-gray-400 py-4 italic">Belum ada data GAP</div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Action Link -->
                            <div class="flex justify-end mt-6">
                                <a href="{{ route('mentor.logbook', ['talent_id' => $mentee['id']]) }}" class="text-[14px] font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                    Lihat Logbook
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if(count($menteesList) === 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum ada Mentee</h3>
                <p class="text-gray-500 text-sm">Anda belum memiliki talent yang dibimbing.</p>
            </div>
        @endif
    </div>

    <x-slot name="scripts">
        <script>
            function toggleAccordion(element) {
                const parent = element.closest('.accordion-card');
                const content = parent.querySelector('.accordion-content');
                const icon = parent.querySelector('.accordion-icon');
                
                if (content.classList.contains('hidden')) {
                    // Open
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    // Close
                    content.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            }
        </script>
    </x-slot>
</x-mentor.layout>
