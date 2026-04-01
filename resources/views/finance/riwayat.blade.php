<x-finance.layout title="Riwayat Validasi" :user="$user">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <circle cx="10.5" cy="13.5" r="2.5"></circle>
                    <line x1="12.5" y1="15.5" x2="15" y2="18"></line>
                </svg>
                <h2 class="text-[28px] font-extrabold text-[#2e3746]">Riwayat Validasi</h2>
            </div>
            
            <form action="{{ route('finance.riwayat') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Talent" class="border-[1.5px] border-[#38b2ac] rounded-lg px-4 py-2 w-72 text-sm focus:outline-none focus:ring-1 focus:ring-[#38b2ac] placeholder:text-[#38b2ac] placeholder:text-sm">
                <button type="submit" class="border-[1.5px] border-[#38b2ac] text-[#38b2ac] bg-white hover:bg-[#38b2ac] hover:text-white transition-colors rounded-lg px-6 py-2 text-sm font-medium">
                    Search
                </button>
            </form>
        </div>

        {{-- Validation History Section Grouped by Position --}}
        @forelse($groupedHistoryProjects as $groupTitle => $projectsGroup)
        <div class="mb-8 overflow-hidden bg-white border border-gray-300 rounded-xl shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center w-1/5 break-words">Talent</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center border-l w-1/5 break-words border-gray-300">Project</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center border-l w-1/5 break-words border-gray-300">Catatan dari Admin</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center border-l w-1/5 break-words border-gray-300">Feedback Finance</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center border-l w-1/5 break-words border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($projectsGroup as $project)
                        <tr class="border-b border-gray-300 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 border-r border-gray-300 text-center">
                                <p class="font-bold text-gray-800 text-sm">{{ $project->talent->nama ?? '-' }}</p>
                                <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->position->position_name ?? '-' }} &rarr; {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}</p>
                                <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->department->nama_department ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800 text-center border-r border-gray-300">
                                {{ $project->title }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 text-center border-r border-gray-300">
                                {{ $project->feedback ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 text-center border-r border-gray-300">
                                {{ $project->finance_feedback ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($project->status == 'Verified')
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <span class="font-bold text-green-600">Approved</span>
                                </div>
                                @elseif($project->status == 'Rejected')
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    <span class="font-bold text-red-600">Rejected</span>
                                </div>
                                @else
                                <span class="text-gray-500">{{ $project->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="mb-8 overflow-hidden bg-white border border-gray-300 rounded-xl shadow-sm">
            <div class="bg-gray-50 border-b border-gray-300 px-6 py-4 text-center">
                <h3 class="text-gray-800 font-bold text-lg">Riwayat Validasi</h3>
            </div>
            <div class="p-6 text-center text-gray-500">
                Belum ada riwayat validasi
            </div>
        </div>
        @endforelse
    </div>
</x-finance.layout>
