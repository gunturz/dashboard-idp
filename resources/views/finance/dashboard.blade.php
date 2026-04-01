<x-finance.layout title="Dashboard Finance" :user="$user">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Finance</h2>
        </div>

        {{-- 4 Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl border-2 border-teal-500 p-6 flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                <span class="text-4xl font-extrabold text-teal-500 mb-2">{{ $total }}</span>
                <span class="text-xs text-gray-500 font-medium">Total Request</span>
            </div>
            <div class="bg-white rounded-xl border-2 border-yellow-400 p-6 flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                <span class="text-4xl font-extrabold text-yellow-400 mb-2">{{ $pending }}</span>
                <span class="text-xs text-gray-500 font-medium">Pending Review</span>
            </div>
            <div class="bg-white rounded-xl border-2 border-green-500 p-6 flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                <span class="text-4xl font-extrabold text-green-500 mb-2">{{ $approved }}</span>
                <span class="text-xs text-gray-500 font-medium">Approved</span>
            </div>
            <div class="bg-white rounded-xl border-2 border-red-500 p-6 flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                <span class="text-4xl font-extrabold text-red-500 mb-2">{{ $rejected }}</span>
                <span class="text-xs text-gray-500 font-medium">Rejected</span>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <input type="text" placeholder="Cari Nama Talent" class="w-full px-4 py-2.5 rounded-lg border border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 text-sm text-teal-600 placeholder-teal-400">
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/4">
                <div class="relative">
                    <select class="w-full px-4 py-2.5 rounded-lg border border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 text-sm text-gray-600 appearance-none bg-white">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $company)
                            <option value="{{ $company }}">{{ $company }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-teal-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notification Alert --}}
        <div class="bg-white border text-sm border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row items-center justify-between shadow-sm mb-8">
            <p class="text-gray-700 font-medium mb-3 sm:mb-0">
                Ada <span class="font-bold">{{ $pending }} Permintaan</span> yang menunggu validasi anda
            </p>
            <a href="{{ route('finance.permintaan_validasi') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 text-xs font-bold py-2 px-6 rounded-md transition-colors whitespace-nowrap">
                Review Sekarang
            </a>
        </div>

        {{-- Menunggu Validasi Tables Grouped by Position --}}
        @forelse($groupedPendingProjects as $groupTitle => $projectsGroup)
        <div class="mb-8 overflow-hidden bg-white border border-gray-300 rounded-xl shadow-sm">
            <div class="bg-gray-50 border-b border-gray-300 px-6 py-4 text-center">
                <h3 class="text-gray-800 font-bold text-lg">{{ $groupTitle }}</h3>
            </div>
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
        <div class="mb-8 overflow-hidden bg-white border border-gray-300 rounded-xl shadow-sm">
            <div class="bg-gray-50 border-b border-gray-300 px-6 py-4 text-center">
                <h3 class="text-gray-800 font-bold text-lg">Daftar Permintaan by Perusahaan</h3>
            </div>
            <div class="p-6 text-center text-gray-500">
                Tidak ada permintaan validasi
            </div>
        </div>
        @endforelse

        {{-- Divider --}}
        <hr class="border-gray-200 my-8">

        {{-- Riwayat Validasi Header --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Validasi</h2>

        {{-- Validation History Section Grouped by Position --}}
        @forelse($groupedHistoryProjects as $groupTitle => $projectsGroup)
        <div class="mb-8 overflow-hidden bg-white border border-gray-300 rounded-xl shadow-sm">
            <div class="bg-gray-50 border-b border-gray-300 px-6 py-4 text-center">
                <h3 class="text-gray-800 font-bold text-lg">{{ $groupTitle }}</h3>
            </div>
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
                                    <span class="font-bold text-gray-700">Approved</span>
                                </div>
                                @elseif($project->status == 'Rejected')
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    <span class="font-bold text-gray-700">Rejected</span>
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
