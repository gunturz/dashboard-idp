<x-finance.layout title="Permintaan Validasi" :user="$user">
    <div class="mb-8">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 transform rotate-45 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800">Permintaan Validasi</h2>
        </div>

        {{-- Validation List --}}
        <div class="space-y-6">

            @forelse($projects as $index => $project)
            <div class="bg-white rounded-xl shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-200 overflow-hidden transition-all duration-300">
                {{-- Card Header --}}
                <div class="p-4 md:p-6 cursor-pointer flex flex-col md:flex-row md:items-center justify-between gap-4 select-none hover:bg-gray-50 transition-colors" onclick="toggleAccordion('content-{{ $project->id }}', 'icon-{{ $project->id }}')">
                    
                    {{-- Profile Info --}}
                    <div class="flex items-center gap-4 w-full md:w-[40%]">
                        <div class="w-14 h-14 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center overflow-hidden border border-gray-200">
                            {{-- Placeholder Image --}}
                            <div class="text-indigo-400 w-full h-full flex items-center justify-center font-bold text-xl bg-orange-100 text-orange-800">
                                {{ collect(explode(' ', $project->talent->nama ?? 'A'))->map(fn($n)=>substr($n,0,1))->take(2)->join('') }}
                            </div>
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="font-bold text-gray-800 text-sm">{{ $project->talent->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->position->position_name ?? '-' }} &rarr; {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->department->nama_department ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-1">Dikirim (Admin): {{ $project->updated_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Project Title --}}
                    <div class="w-full md:w-[35%] py-2 md:py-0 md:px-6 md:border-l border-gray-200 flex items-center">
                        <p class="font-bold text-gray-700 text-sm xl:text-base">{{ $project->title }}</p>
                    </div>

                    {{-- Badge & Toggle --}}
                    <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-[25%] mt-2 md:mt-0">
                        <span class="px-5 py-1.5 rounded-full border-2 border-yellow-400 text-[#2a303b] text-[13px] font-bold shadow-sm whitespace-nowrap">
                            {{ $project->status == 'Pending' ? 'Pending Review' : $project->status }}
                        </span>
                        <svg id="icon-{{ $project->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600 transition-transform duration-300 {{ $index === 0 ? 'transform rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Card Content (Expanded or Collapsed dynamically) --}}
                <div id="content-{{ $project->id }}" class="px-4 md:px-6 border-t border-gray-100 bg-white transition-all overflow-hidden {{ $index === 0 ? 'pb-6 pt-5 max-h-[1000px] opacity-100' : 'pb-0 pt-0 max-h-0 opacity-0' }}">
                    <div class="flex flex-col lg:flex-row gap-5 lg:gap-8 items-start {{ $index === 0 ? '' : 'pb-6 pt-5' }}">
                        <form action="{{ route('finance.permintaan_validasi.update', $project->id) }}" method="POST" class="w-full flex flex-col lg:flex-row gap-5 lg:gap-8 items-start">
                            @csrf
                            @method('PATCH')
                            <div class="w-full lg:w-auto flex-grow flex flex-col gap-4">
                                {{-- Catatan dari Admin PDC (read-only) --}}
                                @if($project->feedback)
                                <div>
                                    <div class="font-bold text-gray-700 text-[13px] mb-1">Catatan dari Admin PDC:</div>
                                    <div class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-[13px] text-gray-700 min-h-[70px]">
                                        {{ $project->feedback }}
                                    </div>
                                </div>
                                @endif
                                {{-- Feedback Finance --}}
                                <div>
                                    <div class="font-bold text-gray-700 text-[13px] mb-1">Feedback Finance:</div>
                                    <textarea name="finance_feedback" class="w-full rounded-lg border-2 border-teal-400 px-4 py-3 text-[13px] xl:text-[14px] text-gray-700 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-teal-500 min-h-[100px] resize-y" placeholder="Ketikkan feedback atau catatan persetujuan / penolakan di sini...">{{ $project->finance_feedback }}</textarea>
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
                                <div class="flex gap-3">
                                    <button type="submit" name="status" value="Verified" class="w-1/2 bg-[#34a853] hover:bg-green-600 text-white font-bold text-[13px] py-1.5 rounded-lg transition-colors shadow-sm h-full flex items-center justify-center">
                                        Approved
                                    </button>
                                    <button type="submit" name="status" value="Rejected" class="w-1/2 bg-[#ea4335] hover:bg-red-600 text-white font-bold text-[13px] py-1.5 rounded-lg transition-colors shadow-sm h-full flex items-center justify-center">
                                        Rejected
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500 bg-white rounded-xl shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-200">
                Tidak ada permintaan validasi baru.
            </div>
            @endforelse

        </div>
    </div>

    {{-- Script for Accordion Behavior --}}
    <script>
        function toggleAccordion(contentId, iconId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            if (content.classList.contains('max-h-0')) {
                // Expanding
                content.classList.remove('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.add('max-h-[1000px]', 'opacity-100', 'pb-6');
                icon.classList.add('rotate-180');
            } else {
                // Collapsing
                content.classList.add('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.remove('max-h-[1000px]', 'opacity-100', 'pb-6');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</x-finance.layout>
