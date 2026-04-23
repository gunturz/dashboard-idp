<x-finance.layout title="Dashboard Finance" :user="$user">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <h2 class="text-2xl font-bold text-[#2e3746]">Dashboard Finance</h2>
        </div>
        
        <div class="text-center mb-8 mt-4">
            <h3 class="text-[22px] font-bold text-[#475569]">{{ $user->company->nama_company ?? '-' }}</h3>
        </div>

        {{-- 4 Summary Cards --}}
        <div class="prem-stat-grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="prem-stat prem-stat-teal">
                <div class="prem-stat-icon si-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $total }}</div>
                <div class="prem-stat-label">Total Request</div>
            </div>
            <div class="prem-stat prem-stat-amber">
                <div class="prem-stat-icon si-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $pending }}</div>
                <div class="prem-stat-label">Pending Review</div>
            </div>
            <div class="prem-stat prem-stat-green">
                <div class="prem-stat-icon si-green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $approved }}</div>
                <div class="prem-stat-label">Approved</div>
            </div>
            <div class="prem-stat prem-stat-red">
                <div class="prem-stat-icon si-red">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $rejected }}</div>
                <div class="prem-stat-label">Rejected</div>
            </div>
        </div>



        {{-- Notification Alert --}}
        <div class="bg-gray-50 border text-sm border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row items-center justify-between shadow-sm mb-8">
            <p class="text-gray-700 font-medium mb-3 sm:mb-0">
                Ada <span class="font-bold">{{ $pending }} Permintaan</span> yang menunggu validasi anda
            </p>
            <a href="{{ route('finance.permintaan_validasi') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 text-xs font-bold py-2 px-6 rounded-md transition-colors whitespace-nowrap">
                Review Sekarang
            </a>
        </div>

        {{-- Menunggu Validasi Tables Grouped by Position --}}
        @forelse($groupedPendingProjects as $groupTitle => $projectsGroup)
        <div class="mb-8 overflow-hidden bg-gray-50 border border-gray-300 rounded-xl shadow-sm">
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
                            <td class="px-6 py-4 text-gray-500 text-center border-r border-gray-300">
                                {{ $project->feedback ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-center border-r border-gray-300">
                                {{ $project->finance_feedback ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-gray-500">Menunggu Validasi</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="mb-8 overflow-hidden bg-gray-50 border border-gray-300 rounded-xl shadow-sm">
            <div class="bg-gray-50 border-b border-gray-300 px-6 py-4 text-center">
                <h3 class="text-gray-800 font-bold text-lg">Daftar Permintaan </h3>
            </div>
            <div class="p-6 text-center text-gray-500">
                Tidak ada permintaan validasi
            </div>
        </div>
        @endforelse

    </div>
</x-finance.layout>
