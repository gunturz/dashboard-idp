<div>
    {{-- ══════════════════════════════ CHART ROW ══════════════════════════════ --}}
    <div class="space-y-4" id="Kompetensi">
        <div class="page-header animate-title mb-2 mt-2">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">Kompetensi</div>
                <div class="page-header-sub">Hasil penilaian kompetensi (GAP Score)</div>
            </div>
        </div>

        {{-- ── Kompetensi Bar Chart (full width) ── --}}
        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 fade-up fade-up-2">
            @if(!$hasDevPlan)
                {{-- Belum ada development plan dari PDC Admin --}}
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background:linear-gradient(135deg,#fef3c7,#fde68a)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-base font-bold text-gray-700">Menunggu Development Plan</p>
                    <p class="text-sm text-gray-500 mt-1 max-w-[700px] leading-relaxed">
                        PDC Admin belum menetapkan posisi yang dituju, mentor, dan atasan untuk Anda.<br>
                        Data kompetensi akan tampil setelah development plan dibuat.
                    </p>
                </div>
            @elseif(!$latestAssessment)
                <div class="flex flex-col items-center justify-center py-6">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-base font-bold text-gray-700">Belum Ada Data Assessment</p>
                    <p class="text-sm text-gray-500 mt-1 mb-2 text-center max-w-sm">Anda belum mengisi assessment kompetensi. Silakan isi terlebih dahulu untuk melihat data kompetensi Anda.</p>
                    <a href="{{ route('talent.competency') }}"
                        class="mt-5 inline-flex items-center gap-2 px-8 py-3 rounded-xl font-bold text-white shadow-[0_6px_15px_-3px_rgba(13,148,136,0.4)] transition transform hover:-translate-y-0.5" 
                        style="background: linear-gradient(135deg, #0d9488, #10b981);">
                        Isi Kompetensi
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            @elseif(!$atasanHasScored)
                <div class="flex flex-col items-center justify-center py-6">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background:linear-gradient(135deg,#ffedd5,#fed7aa)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <p class="text-base font-bold text-gray-700">Atasan Belum Memberikan Nilai</p>
                    <p class="text-sm text-gray-500 mt-1 text-center max-w-sm">Grafik kompetensi akan muncul setelah
                        atasan Anda memberikan penilaian dan approval.</p>
                </div>
            @else
                @php $maxScore = 5; @endphp
                <div class="space-y-5">
                    <div class="flex justify-end hidden md:flex" style="margin-bottom: -15px;">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-[10px]">GAP</span>
                    </div>
                    @foreach ($kompetensiData as $label => $data)
                        @php
                            $scoreVal = is_array($data) ? $data['score'] : $data;
                            $gapVal = is_array($data) ? $data['gap'] : 0;
                            $targetScore = $scoreVal - $gapVal;
                            $pct = ($scoreVal / $maxScore) * 100;
                            $targetPct = ($targetScore / $maxScore) * 100;

                            $textColor = '#64748b'; 
                            if ($gapVal < -1.5) {
                                $textColor = '#ef4444';
                            } elseif ($gapVal < 0) {
                                $textColor = '#f97316';
                            }
                        @endphp
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 group">
                            <span class="text-base text-gray-700 md:w-56 flex-shrink-0 whitespace-nowrap overflow-hidden truncate"
                                title="{{ $label }}">{{ $label }}</span>
                            <div class="flex items-center gap-3 flex-1 w-full">
                                <div class="flex-1 bg-gray-100 rounded-full h-5 relative overflow-hidden">
                                    <div class="absolute top-0 left-0 h-full rounded-full bg-gray-300"
                                        style="width:{{ $targetPct }}%; z-index: 0;"></div>
                                    <div class="absolute top-0 left-0 bar-fill h-full rounded-full"
                                        style="width:{{ $pct }}%; background:#0d9488; z-index: 10;"></div>
                                </div>
                                <span class="text-base font-black w-12 text-right flex-shrink-0"
                                    style="color:{{ $textColor }};">
                                    {{ number_format($gapVal, 1) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                    <div class="items-center gap-3 pt-1 hidden md:flex">
                        <span class="w-56 flex-shrink-0"></span>
                        <div class="flex-1 flex justify-between text-sm text-gray-400">
                            <span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                        </div>
                        <span class="w-12 flex-shrink-0"></span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════ IDP MONITORING CARDS ══════════════════════════════ --}}
    <div class="space-y-4 pt-4" id="IDP Monitoring">
        <div class="page-header animate-title mb-2 mt-6">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                    <path
                        d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">IDP Monitoring</div>
                <div class="page-header-sub">Perkembangan program Individual Development Plan (IDP)</div>
            </div>
        </div>

        <div class="prem-card p-6 md:p-8 fade-up fade-up-4">

            {{-- Smooth Progress Circle Charts --}}
            @php
                $idpChartData = [
                    'Exposure' => [
                        'done' => min($exposureCount ?? 0, 6),
                        'total' => 6,
                        'from' => '#334155',
                        'to' => '#334155',
                        'id' => 'grad-exposure',
                        'btn_color' =>
                            'bg-slate-700 hover:bg-slate-800 shadow-[0_4px_12px_-2px_rgba(51,65,85,0.4)] hover:shadow-[0_6px_16px_-2px_rgba(51,65,85,0.5)]',
                    ],
                    'Mentoring' => [
                        'done' => min($mentoringCount ?? 0, 6),
                        'total' => 6,
                        'from' => '#f59e0b',
                        'to' => '#f59e0b',
                        'id' => 'grad-mentoring',
                        'btn_color' =>
                            'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_12px_-2px_rgba(245,158,11,0.4)] hover:shadow-[0_6px_16px_-2px_rgba(245,158,11,0.5)]',
                    ],
                    'Learning' => [
                        'done' => min($learningCount ?? 0, 6),
                        'total' => 6,
                        'from' => '#0d9488',
                        'to' => '#0d9488',
                        'id' => 'grad-learning',
                        'btn_color' =>
                            'bg-teal-600 hover:bg-teal-700 shadow-[0_4px_12px_-2px_rgba(13,148,136,0.4)] hover:shadow-[0_6px_16px_-2px_rgba(13,148,136,0.5)]',
                    ],
                ];
                $r = 38;
                $circ = 2 * M_PI * $r; // ≈ 238.76
            @endphp
            <div class="flex justify-evenly gap-6 flex-wrap mb-8 pb-6 border-b border-gray-200">
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
                                    <linearGradient id="{{ $d['id'] }}" x1="0%" y1="0%"
                                        x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="{{ $d['from'] }}" />
                                        <stop offset="100%" stop-color="{{ $d['to'] }}" />
                                    </linearGradient>
                                </defs>
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                    stroke="#f1f5f9" stroke-width="10" />
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                    stroke="url(#{{ $d['id'] }})" stroke-width="10" stroke-linecap="round"
                                    stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                    style="transition: stroke-dasharray 0.8s ease;" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-4xl font-bold"
                                    style="color:{{ $d['from'] }};">{{ round($pct * 100) }}%</span>
                            </div>
                        </div>
                        <a href="{{ route('talent.logbook') }}#{{ strtolower($label) }}"
                            class="{{ $d['btn_color'] }} text-white px-8 py-2 rounded-[10px] transition-all flex items-center justify-center gap-2 group active:scale-95 hover:-translate-y-0.5">
                            <span class="text-sm font-bold tracking-wide">{{ $label }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 relative transition-transform group-hover:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Exposure --}}
                <div
                    class="bg-gray-50 border border-gray-200 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="text-base font-bold text-gray-800">Exposure</h3>
                        </div>
                        <p class="text-sm text-teal-600 font-semibold mb-1">Exposure / Assignment</p>
                        <p class="text-sm text-gray-600 mb-1 font-medium">Contoh kegiatan:</p>
                        <ul class="text-sm text-gray-600 space-y-0.5 list-disc list-inside mb-3">
                            <li>Meeting</li>
                            <li>Shadowing</li>
                            <li>Acting</li>
                            <li>Project</li>
                        </ul>
                        <p class="text-sm text-teal-600 font-bold text-right mt-auto">Bobot : 70%</p>
                    </div>
                    <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring', 'exposure') }}"
                        class="mt-4 w-full block text-center bg-amber-400 text-white text-sm font-semibold py-2 rounded-[10px] {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-amber-500 transition active:scale-95' }}"
                        {{ optional($user->promotion_plan)->is_locked ? 'title="Progress telah dikunci"' : '' }}>
                        Upload
                    </a>
                </div>

                {{-- Mentoring --}}
                <div
                    class="bg-gray-50 border border-gray-200 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="text-base font-bold text-gray-800">Mentoring</h3>
                        </div>
                        <p class="text-sm text-teal-600 font-semibold mb-1">Mentoring / Coaching</p>
                        <p class="text-sm text-gray-600 mb-1 font-medium">Contoh kegiatan:</p>
                        <ul class="text-sm text-gray-600 space-y-0.5 list-disc list-inside mb-3">
                            <li>Penjadwalan</li>
                            <li>Catatan singkat</li>
                            <li>Action plan</li>
                        </ul>
                        <p class="text-sm text-teal-600 font-bold text-right mt-auto">Bobot : 20%</p>
                    </div>
                    <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring', 'mentoring') }}"
                        class="mt-4 w-full block text-center bg-amber-400 text-white text-sm font-semibold py-2 rounded-[10px] {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-amber-500 transition active:scale-95' }}"
                        {{ optional($user->promotion_plan)->is_locked ? 'title="Progress telah dikunci"' : '' }}>
                        Upload
                    </a>
                </div>

                {{-- Learning --}}
                <div
                    class="bg-gray-50 border border-gray-200 rounded-2xl p-5 flex flex-col justify-between">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="text-base font-bold text-gray-800">Learning</h3>
                        </div>
                        <p class="text-sm text-teal-600 font-semibold mb-1">Learning</p>
                        <p class="text-sm text-gray-600 mb-1 font-medium">Contoh kegiatan:</p>
                        <ul class="text-sm text-gray-600 space-y-0.5 list-disc list-inside mb-3">
                            <li>LMS Internal</li>
                            <li>Youtube edukatif</li>
                            <li>Artikel</li>
                            <li>Online course</li>
                        </ul>
                        <p class="text-sm text-teal-600 font-bold text-right mt-auto">Bobot : 10%</p>
                    </div>
                    <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring', 'learning') }}"
                        class="mt-4 w-full block text-center bg-amber-400 text-white text-sm font-semibold py-2 rounded-[10px] {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-amber-500 transition active:scale-95' }}"
                        {{ optional($user->promotion_plan)->is_locked ? 'title="Progress telah dikunci"' : '' }}>
                        Upload
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════ PROJECT IMPROVEMENT ══════════════════════════════ --}}
    <div class="space-y-4 pt-4" id="Project Improvement">
        <div class="page-header animate-title mb-2 mt-6">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">Project Improvement</div>
                <div class="page-header-sub">Daftar & submission project improvement Anda</div>
            </div>
        </div>

        <div class="prem-card p-6 md:p-8 fade-up fade-up-4">

            @if (session('success_project'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] relative text-sm"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success_project') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-[10px] relative text-sm"
                    role="alert">
                    <strong class="font-bold">Oops! Terjadi kesalahan:</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="submitProject" enctype="multipart/form-data">
                {{-- Judul Project Input --}}
                <div class="mb-4">
                    <input type="text" wire:model="judul_project"
                        class="w-full text-sm border border-gray-300 rounded-[8px] px-4 py-2 focus:outline-none focus:border-green-500 focus:ring-[3px] focus:ring-green-500/20 bg-white transition-all"
                        placeholder="Judul Project..." required>
                    @error('judul_project') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Download Template --}}
                <div class="flex justify-start mb-5">
                    <a href="#"
                        class="flex items-center gap-2 text-sm font-semibold text-gray-600 border border-gray-300 bg-white hover:bg-gray-100 px-4 py-2 rounded-[10px] transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Template
                    </a>
                </div>

                <p class="text-xs text-gray-500 mb-2">Unggah projek anda disini</p>

                {{-- Upload Area --}}
                <div class="relative upload-wrapper mb-5" x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    
                    <label for="file-upload-livewire"
                        class="upload-area rounded-2xl cursor-pointer flex flex-col items-center justify-center py-10 bg-gray-50 border-2 border-dashed border-gray-200 hover:border-teal-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-gray-400 mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span class="text-sm text-gray-500" id="file-name-display-livewire">
                            @if($project_file)
                                {{ $project_file->getClientOriginalName() }}
                            @else
                                Klik untuk mengunggah
                            @endif
                        </span>
                        <input id="file-upload-livewire" wire:model="project_file" type="file" class="sr-only" required>
                    </label>

                    <div x-show="uploading" class="absolute bottom-0 left-0 w-full rounded-b-2xl overflow-hidden bg-gray-200 h-2">
                        <div class="h-full bg-teal-500 transition-all duration-200" x-bind:style="'width: ' + progress + '%'"></div>
                    </div>
                </div>
                @error('project_file') <div class="text-red-500 text-xs mb-4">{{ $message }}</div> @enderror

                {{-- Submit Project --}}
                <div class="flex justify-end mb-6">
                    <button type="submit"
                        class="btn-action-teal px-8"
                        {{ optional($user->promotion_plan)->is_locked ? 'disabled title="Progress telah dikunci"' : '' }}>
                        Submit
                        <div wire:loading wire:target="submitProject" class="ml-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                </div>

                {{-- Project Table --}}
                <div class="overflow-x-auto rounded-2xl border border-gray-200">
                    <table class="w-full text-sm bg-gray-50 min-w-[600px]">
                        <thead>
                            <tr class="bg-gray-100">
                                <th
                                    class="text-center px-4 py-3 font-semibold text-gray-700 border-b border-r border-gray-200">
                                    Judul Project Improvement</th>
                                <th
                                    class="text-center px-4 py-3 font-semibold text-gray-700 border-b border-r border-gray-200 w-32">
                                    File</th>
                                <th
                                    class="text-center px-4 py-3 font-semibold text-gray-700 border-b border-gray-200 w-44">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr class="bg-white border-b border-gray-100">
                                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200 font-medium">
                                        {{ $project->title }}
                                        <div class="text-xs text-gray-400 font-normal mt-0.5">
                                            {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-center px-4 py-3 border-r border-gray-200">
                                        @if($project->document_path)
                                            <a href="{{ route('files.preview', ['path' => $project->document_path]) }}" target="_blank"
                                                class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 border border-blue-200 rounded-lg transition text-xs font-semibold" title="Lihat/Download File Project">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                Lampiran
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        @if($project->status === 'Approved')
                                            <span class="inline-flex items-center gap-1.5 text-green-600 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                                Approved
                                            </span>
                                        @elseif($project->status === 'Rejected')
                                            <span class="inline-flex items-center gap-1.5 text-red-500 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>
                                                Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-orange-500 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white">
                                    <td class="px-4 py-5 text-gray-400 border-r border-gray-200 text-center text-xs"
                                        colspan="3">
                                        Belum ada project yang disubmit.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
