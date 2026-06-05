<x-finance.layout title="Dashboard Finance" :user="$user">
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

            .section-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 1.2rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 24px;
                margin-top: 40px;
                text-align: left;
            }

            .section-title::before {
                content: '';
                display: inline-block;
                width: 4px;
                height: 18px;
                background: linear-gradient(180deg, #14b8a6, #0d9488);
                border-radius: 99px;
            }

            .section-subtitle {
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-top: 32px;
                margin-bottom: 24px;
            }

            .section-subtitle svg {
                width: 28px;
                height: 28px;
                color: #0f172a;
            }
        </style>
    </x-slot>

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
                <div class="dash-header-title">Dashboard</div>
                <div class="dash-header-sub">
                    {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $user->company->nama_company ?? 'Finance Validation & Review Module') }}
                </div>
            </div>
            <div class="dash-header-date hidden md:block">
                Hari ini
                <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
            </div>
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
            <div class="prem-stat-label">Total Permintaan Validasi</div>
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
            <div class="prem-stat-label">Menunggu Validasi</div>
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
            <div class="prem-stat-label">Telah Disetujui</div>
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
            <div class="prem-stat-label">Ditolak</div>
        </div>
    </div>

    {{-- Notification Alert --}}
    @if ($pending > 0)
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
                    Ada <span class="font-bold text-amber-600">{{ $pending }} Permintaan</span> yang menunggu
                    validasi
                    Anda
                </p>
            </div>
            <a href="{{ route('finance.permintaan_validasi') }}" class="btn-prem btn-teal px-8 py-2.5">
                Review Sekarang
            </a>
        </div>
    @endif

    <div class="section-subtitle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd"
                d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                clip-rule="evenodd" />
            <path fill-rule="evenodd"
                d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                clip-rule="evenodd" />
        </svg>
        Daftar Permintaan Validasi
    </div>

    {{-- Menunggu Validasi Tables Grouped by Position --}}
    @forelse($groupedPendingProjects as $groupTitle => $projectsGroup)
        <div class="section-title">
            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $groupTitle) }}
        </div>

        <div
            class="bg-white border border-slate-200 rounded-[20px] shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse font-sans">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-[25%]">Talent</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-[25%]">Project / Dept
                            </th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-[20%]">Catatan Admin
                            </th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-[20%]">Feedback Finance
                            </th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center w-[10%]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($projectsGroup as $idx => $project)
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                    <div style="text-align: center; display: inline-block; width: 100%;">
                                        <div class="font-bold text-sm text-slate-800 leading-tight">
                                            {{ $project->talent->nama ?? '-' }}</div>
                                        <div class="text-xs text-gray-500 font-medium mt-1">
                                            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->position->position_name ?? '-') }}
                                            &rarr;
                                            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->promotion_plan->targetPosition->position_name ?? '?') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                    <div style="text-align: center; display: inline-block; width: 100%;">
                                        <div class="font-bold text-sm text-slate-800 leading-tight">
                                            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->title) }}</div>
                                        <div class="text-xs text-gray-500 font-medium mt-1">
                                            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->department->nama_department ?? '-') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                    <span class="text-sm text-slate-700">{{ $project->feedback ?? '-' }}</span>
                                </td>
                                <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                    <span
                                        class="text-sm text-slate-700">{{ $project->finance_feedback ?? '-' }}</span>
                                </td>
                                <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                    <span
                                        class="inline-flex items-center justify-center bg-amber-50 border border-amber-200 text-amber-600 font-bold text-xs px-2.5 py-0.5 rounded-full whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                            viewBox="0 0 20 20" fill="currentColor">
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
        <div class="flex flex-col items-center justify-center py-10 text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto"
                style="background: linear-gradient(135deg, #ccfbf1, #99f6e4);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-base font-bold text-gray-700">Tidak ada permintaan validasi</p>
            <p class="text-sm text-gray-500 mt-1 max-w-sm leading-relaxed mx-auto">Semua permintaan telah diproses
                atau belum ada yang baru.</p>
        </div>
    @endforelse

    </div>
</x-finance.layout>
