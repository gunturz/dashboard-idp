<x-finance.layout title="Dashboard Finance" :user="$user">
    <div class="mb-8">
        {{-- ── Page Header ── --}}
        <div class="dash-header animate-title">
            <div class="dash-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <div class="dash-header-title">Dashboard Finance</div>
                <div class="dash-header-sub">{{ $user->company->nama_company ?? 'Individual Development Plan' }}</div>
            </div>
            <div class="dash-header-date hidden md:block">
                Hari ini
                <span>{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
        <div>
            <div class="dash-header-title">Dashboard Finance</div>
            <div class="dash-header-sub">{{ $user->company->nama_company ?? 'Individual Development Plan' }}</div>
        </div>
        <div class="dash-header-date hidden md:block">
            Hari ini
            <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

        {{-- 4 Summary Cards --}}
        <div class="prem-stat-grid mb-8" style="grid-template-columns: repeat(4, 1fr);">
            <div class="prem-stat prem-stat-teal">
                <div class="prem-stat-icon si-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $total }}</div>
                <div class="prem-stat-label">Total Request</div>
            </div>
            <div class="prem-stat prem-stat-amber">
                <div class="prem-stat-icon si-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $pending }}</div>
                <div class="prem-stat-label">Pending Review</div>
            </div>
            <div class="prem-stat prem-stat-green">
                <div class="prem-stat-icon si-green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $approved }}</div>
                <div class="prem-stat-label">Approved</div>
            </div>
            <div class="prem-stat prem-stat-red">
                <div class="prem-stat-icon si-red">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $rejected }}</div>
                <div class="prem-stat-label">Rejected</div>
            </div>
        </div>

        {{-- Notification Alert --}}
        <div
            class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between shadow-sm mb-8">
            <div class="flex items-center gap-4 mb-3 sm:mb-0">
                <div
                    class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="text-amber-900 font-medium text-sm">
                    Ada <span class="font-bold text-amber-600">{{ $pending }} Permintaan</span> yang menunggu validasi
                    anda
                </p>
            </div>
            <a href="{{ route('finance.permintaan_validasi') }}" class="btn-prem btn-teal px-8 py-2.5">
                Review Sekarang
            </a>
        </div>

        {{-- Menunggu Validasi Tables Grouped by Position --}}
        @forelse($groupedPendingProjects as $groupTitle => $projectsGroup)
            <div class="prem-card">
                <div class="prem-card-header">
                    <div class="prem-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Daftar Permintaan - {{ $groupTitle }}</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="prem-table">
                        <thead>
                            <tr>
                                <th class="w-[25%]">Talent</th>
                                <th class="w-[20%]">Project</th>
                                <th class="w-[20%]">Catatan Admin</th>
                                <th class="w-[20%]">Feedback Finance</th>
                                <th class="w-[15%] text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projectsGroup as $project)
                                <tr>
                                    <td class="text-left px-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800">{{ $project->talent->nama ?? '-' }}</span>
                                            <span
                                                class="text-[11px] text-gray-500 italic leading-tight mt-1">{{ $project->talent->position->position_name ?? '-' }}
                                                &rarr;
                                                {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}</span>
                                            <span
                                                class="text-[11px] text-gray-500 italic">{{ $project->talent->department->nama_department ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="font-bold text-gray-700">
                                        {{ $project->title }}
                                    </td>
                                    <td class="text-gray-500 text-xs">
                                        {{ $project->feedback ?? '-' }}
                                    </td>
                                    <td class="text-gray-500 text-xs">
                                        {{ $project->finance_feedback ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-amber">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Review
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="prem-card">
                <div class="empty-prem">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3>Tidak ada permintaan validasi</h3>
                    <p>Semua permintaan telah diproses atau belum ada yang baru.</p>
                </div>
            </div>
        @endforelse

    </div>
</x-finance.layout>