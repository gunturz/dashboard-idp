<x-talent.layout title="Detail Riwayat Program – Individual Development Plan" :user="$user" :notifications="$notifications" :mobileCollapsible="true">
    <x-slot name="styles">
        <style>
            /* ── Donut Chart ── */
            .donut-ring {
                transform: rotate(-90deg);
                transform-origin: 50% 50%;
            }

            /* ── Competency bar ── */
            @keyframes barReveal {
                from { clip-path: inset(0 100% 0 0); }
                to { clip-path: inset(0 0% 0 0); }
            }

            .bar-fill {
                animation: barReveal 0.9s cubic-bezier(0.4, 0, 0.2, 1) both;
                animation-delay: 0.35s;
            }

            /* ── Common Premium Styles ── */
            .btn-back-prem {
                background: white;
                border: 1px solid #e2e8f0;
                color: #475569;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                transition: all 0.2s;
            }

            .btn-back-prem:hover {
                background: #f8fafc;
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }
        </style>
    </x-slot>

    <div class="w-full px-4 lg:px-6 pt-5 pb-6 space-y-8 flex-grow">

        {{-- ══════════════════════════════ KOMPETENSI ══════════════════════════════ --}}
        <div class="space-y-4" id="Kompetensi">
            <div class="page-header animate-title mb-2 mt-2">
                <div class="page-header-icon" style="background: linear-gradient(135deg, #2e3746 0%, #38475a 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="page-header-title">Kompetensi</div>
                    <div class="page-header-sub">Hasil penilaian kompetensi pada sesi ini (GAP Score)</div>
                </div>
            </div>

            <div class="prem-card p-6 md:p-8 fade-up fade-up-2">
                @php $maxScore = 5; @endphp
                <div class="space-y-5">
                    <div class="flex justify-end hidden md:flex" style="margin-bottom: -15px;">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mr-[8px]">GAP</span>
                    </div>
                    @foreach ($kompetensiData as $label => $data)
                        @php
                            $scoreVal = is_array($data) ? $data['score'] : $data;
                            $gapVal = is_array($data) ? $data['gap'] : 0;
                            $targetScore = $scoreVal - $gapVal;
                            $pct = ($scoreVal / $maxScore) * 100;
                            $targetPct = ($targetScore / $maxScore) * 100;

                            $textColor = '#64748b';
                            if ($gapVal < -1.5) { $textColor = '#ef4444'; }
                            elseif ($gapVal < 0) { $textColor = '#f97316'; }
                        @endphp
                        <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-3 mb-2 md:mb-0">
                            <span class="text-sm text-gray-700 md:w-56 flex-shrink-0 whitespace-nowrap overflow-hidden truncate" title="{{ $label }}">{{ $label }}</span>
                            <div class="flex items-center gap-3 flex-1 w-full">
                                <div class="flex-1 bg-gray-100 rounded-full h-5 relative overflow-hidden">
                                    <div class="absolute top-0 left-0 h-full rounded-full bg-gray-300" style="width:{{ $targetPct }}%; z-index: 0;"></div>
                                    <div class="absolute top-0 left-0 bar-fill h-full rounded-full" style="width:{{ $pct }}%; background:#0d9488; z-index: 10;"></div>
                                </div>
                                <span class="text-sm font-black w-10 text-right flex-shrink-0" style="color:{{ $textColor }};">
                                    {{ number_format($gapVal, 1) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                    <div class="items-center gap-3 pt-1 hidden md:flex">
                        <span class="w-56 flex-shrink-0"></span>
                        <div class="flex-1 flex justify-between text-xs text-gray-400">
                            <span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                        </div>
                        <span class="w-10 flex-shrink-0"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════ IDP MONITORING ══════════════════════════════ --}}
        <div class="space-y-4" id="IDP Monitoring">
            <div class="page-header animate-title mb-2 mt-6">
                <div class="page-header-icon" style="background: linear-gradient(135deg, #2e3746 0%, #38475a 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                </div>
                <div>
                    <div class="page-header-title">IDP Monitoring</div>
                    <div class="page-header-sub">Ringkasan perkembangan program IDP pada sesi ini</div>
                </div>
            </div>

            <div class="prem-card p-6 md:p-8 fade-up fade-up-4">
                @php
                    $idpChartData = [
                        'Exposure' => [
                            'done' => min($exposureCount ?? 0, 6), 'total' => 6, 'from' => '#334155', 'to' => '#334155', 'id' => 'grad-exposure',
                            'btn_color' => 'bg-slate-700 shadow-[0_4px_12px_-2px_rgba(51,65,85,0.4)]'
                        ],
                        'Mentoring' => [
                            'done' => min($mentoringCount ?? 0, 6), 'total' => 6, 'from' => '#f59e0b', 'to' => '#f59e0b', 'id' => 'grad-mentoring',
                            'btn_color' => 'bg-amber-500 shadow-[0_4px_12px_-2px_rgba(245,158,11,0.4)]'
                        ],
                        'Learning' => [
                            'done' => min($learningCount ?? 0, 6), 'total' => 6, 'from' => '#0d9488', 'to' => '#0d9488', 'id' => 'grad-learning',
                            'btn_color' => 'bg-teal-600 shadow-[0_4px_12px_-2px_rgba(13,148,136,0.4)]'
                        ],
                    ];
                    $r = 38; $circ = 2 * M_PI * $r;
                @endphp
                <div class="flex justify-evenly gap-6 flex-wrap">
                    @foreach ($idpChartData as $label => $d)
                        @php
                            $pct = $d['done'] / $d['total'];
                            $filled = $pct * $circ;
                            $empty = $circ - $filled;
                        @endphp
                        <div class="flex flex-col items-center gap-3">
                            <div class="relative w-48 h-48 drop-shadow-sm">
                                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                    <defs>
                                        <linearGradient id="{{ $d['id'] }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="{{ $d['from'] }}" />
                                            <stop offset="100%" stop-color="{{ $d['to'] }}" />
                                        </linearGradient>
                                    </defs>
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="10" />
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="url(#{{ $d['id'] }})" stroke-width="10" stroke-linecap="round"
                                        stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                        style="transition: stroke-dasharray 0.8s ease;" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-4xl font-bold" style="color:{{ $d['from'] }};">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <div class="{{ $d['btn_color'] }} text-white px-8 py-2 rounded-[10px] text-sm font-bold tracking-wide">
                                {{ $label }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════ PROJECT IMPROVEMENT ══════════════════════════════ --}}
        <div class="space-y-4" id="Project Improvement">
            <div class="page-header animate-title mb-2 mt-6">
                <div class="page-header-icon" style="background: linear-gradient(135deg, #2e3746 0%, #38475a 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                    </svg>
                </div>
                <div>
                    <div class="page-header-title">Project Improvement</div>
                    <div class="page-header-sub">Daftar project improvement pada sesi ini</div>
                </div>
            </div>

            <div class="prem-card p-6 md:p-8 fade-up fade-up-4">
                <div class="overflow-x-auto rounded-[10px] border border-gray-200">
                    <table class="w-full text-sm bg-white min-w-[600px]">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-center px-4 py-3 font-semibold text-gray-700 border-b border-r border-gray-200">Judul Project Improvement</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700 border-b border-gray-200 w-44">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr class="bg-white border-b border-gray-100">
                                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200 font-medium">
                                        {{ $project->judul_project }}
                                        <div class="text-xs text-gray-400 font-normal mt-0.5">{{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        @php
                                            $statusThemes = [
                                                'Pending' => ['text' => 'text-orange-500', 'dot' => 'bg-orange-400'],
                                                'Verified' => ['text' => 'text-green-600', 'dot' => 'bg-green-500'],
                                                'On Progress' => ['text' => 'text-blue-500', 'dot' => 'bg-blue-400'],
                                                'Rejected' => ['text' => 'text-red-500', 'dot' => 'bg-red-400'],
                                            ];
                                            $theme = $statusThemes[$project->status] ?? ['text' => 'text-gray-500', 'dot' => 'bg-gray-400'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 {{ $theme['text'] }} text-xs font-semibold">
                                            <span class="w-2 h-2 rounded-full {{ $theme['dot'] }} inline-block"></span>
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white">
                                    <td class="px-4 py-5 text-gray-400 border-r border-gray-200 text-center text-xs" colspan="2">Belum ada project yang disubmit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════ ACTIONS ══════════════════════════════ --}}
        <div class="flex justify-end pt-4">
            <a href="{{ route('talent.riwayat') }}" class="btn-back-prem flex items-center gap-2 px-8 py-2.5 rounded-[12px] font-bold text-sm tracking-wide active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                Kembali
            </a>
        </div>

    </div>
</x-talent.layout>
