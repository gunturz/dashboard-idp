<x-talent.layout title="Dashboard Talent – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ── Donut Chart ── */
            .donut-ring { transform: rotate(-90deg); transform-origin: 50% 50%; }
            /* ── Competency bar ── */
            @keyframes barReveal { from { clip-path: inset(0 100% 0 0); } to { clip-path: inset(0 0% 0 0); } }
            .bar-fill { animation: barReveal 0.9s cubic-bezier(0.4, 0, 0.2, 1) both; animation-delay: 0.35s; }
            /* ── Dropdown custom ── */
            .score-select { -webkit-appearance: none; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%234a5a6a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; background-size: 14px; padding: 0.4rem 2rem 0.4rem 0.75rem; min-width: 64px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.875rem; font-weight: 600; color: #2e3746; background-color: #f8fafc; cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s; }
            .score-select:focus { outline: none; border-color: #2e3746; box-shadow: 0 0 0 3px rgba(46, 55, 70, 0.12); }
            .score-select:hover { border-color: #94a3b8; background-color: #fff; }
            /* ── Upload area ── */
            .upload-area { border: 2px dashed #cbd5e1; transition: border-color 0.2s, background 0.2s; }
            .upload-area:hover, .upload-area.drag-over { border-color: #22c55e; background: #f0fdf4; }
        </style>
    </x-slot>

    <div class="w-full px-6 pt-5 pb-6 space-y-6 flex-grow">


        {{-- ══════════════════════════════ CHART ROW ══════════════════════════════ --}}
        <div class="space-y-1" id="Kompetensi">
            <div class="flex items-center gap-2.5 px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <h2 class="text-xl font-bold text-[#2e3746] animate-title">Kompetensi</h2>
            </div>

            {{-- ── Kompetensi Bar Chart (full width) ── --}}
            <div class="bg-gray-50 border border-gray-100 rounded-[10px] shadow-sm p-6 fade-up fade-up-2">
                @if(!$latestAssessment)
                    <div class="flex flex-col items-center justify-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-semibold text-gray-500">Anda belum mengisi assessment kompetensi.</p>
                        <a href="{{ route('talent.competency') }}" class="mt-3 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Isi Sekarang</a>
                    </div>
                @elseif(!$atasanHasScored)
                    <div class="flex flex-col items-center justify-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-orange-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-base font-bold text-gray-700">Atasan Belum Memberikan Nilai</p>
                        <p class="text-sm text-gray-500 mt-1 text-center max-w-sm">Grafik kompetensi akan muncul setelah atasan Anda memberikan penilaian dan approval.</p>
                    </div>
                @else
                    @php $maxScore = 5; @endphp
                    <div class="space-y-5">
                        @foreach ($kompetensiData as $label => $score)
                            @php
                                $pct = ($score / $maxScore) * 100;
                            @endphp
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-700 w-56 flex-shrink-0 whitespace-nowrap overflow-hidden truncate" title="{{ $label }}">{{ $label }}</span>
                                <div class="flex-1 bg-gray-100 rounded-full h-5 overflow-hidden">
                                    <div class="bar-fill h-full rounded-full" style="width:{{ $pct }}%; background:#0d9488;"></div>
                                </div>
                                <span class="text-sm font-bold w-10 text-right flex-shrink-0" style="color:#0d9488;">{{ number_format($score, 1) }}</span>
                            </div>
                        @endforeach
                        {{-- Skala keterangan -- sejajar dengan bar --}}
                        <div class="flex items-center gap-3 pt-1">
                            <span class="w-56 flex-shrink-0"></span>
                            <div class="flex-1 flex justify-between text-xs text-gray-400">
                                <span>0</span>
                                <span>1</span>
                                <span>2</span>
                                <span>3</span>
                                <span>4</span>
                                <span>5</span>
                            </div>
                            <span class="w-10 flex-shrink-0"></span>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- ══════════════════════════════ IDP MONITORING CARDS ══════════════════════════════ --}}
        <div class="space-y-1" id="IDP Monitoring">
            <div class="flex items-center gap-2.5 px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                    <path
                        d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
                <h2 class="text-xl font-bold text-[#2e3746] animate-title">IDP Monitoring</h2>
            </div>

            <div class="bg-gray-50 rounded-[10px] shadow-sm p-6 border border-gray-200 fade-up fade-up-4">

                {{-- Smooth Progress Circle Charts --}}
                @php
                    $idpChartData = [
                        'Exposure' => [
                            'done' => min($exposureCount ?? 0, 6),
                            'total' => 6,
                            'from' => '#334155',
                            'to' => '#334155',
                            'id' => 'grad-exposure',
                        ],
                        'Mentoring' => [
                            'done' => min($mentoringCount ?? 0, 6),
                            'total' => 6,
                            'from' => '#f59e0b',
                            'to' => '#f59e0b',
                            'id' => 'grad-mentoring',
                        ],
                        'Learning' => [
                            'done' => min($learningCount ?? 0, 6),
                            'total' => 6,
                            'from' => '#0d9488',
                            'to' => '#0d9488',
                            'id' => 'grad-learning',
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
                                    {{-- Gradient definition --}}
                                    <defs>
                                        <linearGradient id="{{ $d['id'] }}" x1="0%" y1="0%"
                                            x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="{{ $d['from'] }}" />
                                            <stop offset="100%" stop-color="{{ $d['to'] }}" />
                                        </linearGradient>
                                    </defs>
                                    {{-- Track (background ring) --}}
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="#f1f5f9" stroke-width="10" />
                                    {{-- Progress arc --}}
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="url(#{{ $d['id'] }})" stroke-width="10" stroke-linecap="round"
                                        stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                        style="transition: stroke-dasharray 0.8s ease;" />
                                </svg>
                                {{-- Center text --}}
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-4xl font-bold"
                                        style="color:{{ $d['from'] }};">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 px-5 py-1.5 rounded-[10px] shadow-sm">
                                <span class="text-sm font-bold text-gray-800">{{ $label }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Exposure --}}
                    <div
                        class="bg-white shadow-sm border border-gray-100 rounded-[10px] p-5 flex flex-col justify-between">
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
                        <a href="{{ route('talent.idp_monitoring', 'exposure') }}"
                            class="mt-4 w-full block text-center bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold py-2 rounded-[10px] transition active:scale-95">
                            Next
                        </a>
                    </div>

                    {{-- Mentoring --}}
                    <div
                        class="bg-white shadow-sm border border-gray-100 rounded-[10px] p-5 flex flex-col justify-between">
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
                        <a href="{{ route('talent.idp_monitoring', 'mentoring') }}"
                            class="mt-4 w-full block text-center bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold py-2 rounded-[10px] transition active:scale-95">
                            Next
                        </a>
                    </div>

                    {{-- Learning --}}
                    <div
                        class="bg-white shadow-sm border border-gray-100 rounded-[10px] p-5 flex flex-col justify-between">
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
                        <a href="{{ route('talent.idp_monitoring', 'learning') }}"
                            class="mt-4 w-full block text-center bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold py-2 rounded-[10px] transition active:scale-95">
                            Next
                        </a>
                    </div>

                </div>
            </div>
        </div> {{-- /wrapper IDP Monitoring cards --}}

        {{-- ══════════════════════════════ PROJECT IMPROVEMENT ══════════════════════════════ --}}
        <div class="space-y-1">
            <div class="flex items-center gap-2.5 px-2" id="Project Improvement">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                </svg>
                <h2 class="text-xl font-bold text-[#2e3746] animate-title">Project Improvement</h2>
            </div>

            <div class="bg-gray-50 rounded-[10px] shadow-sm p-6 border border-gray-200 fade-up fade-up-4">

                @if(session('success_project'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] relative text-sm" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success_project') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-[10px] relative text-sm" role="alert">
                        <strong class="font-bold">Oops! Terjadi kesalahan:</strong>
                        <ul class="list-disc list-inside mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('talent.project.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                    @csrf

                    {{-- Judul Project Input --}}
                    <div class="mb-4">
                        <input type="text" name="judul_project"
                            class="w-full text-sm border border-gray-300 rounded-[8px] px-4 py-2 focus:outline-none focus:border-green-500 focus:ring-[3px] focus:ring-green-500/20 bg-white transition-all"
                            placeholder="Judul Project..." required>
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
                    <label for="file-upload"
                        class="upload-area rounded-[10px] cursor-pointer flex flex-col items-center justify-center py-10 mb-5 bg-white border-2 border-dashed border-gray-300 hover:border-teal-500 transition-colors"
                        id="drop-zone">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-gray-400 mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span class="text-sm text-gray-500" id="file-name-display">Klik untuk mengunggah</span>
                        <input id="file-upload" name="project_file" type="file" class="sr-only" required>
                    </label>

                    {{-- Submit Project --}}
                    <div class="flex justify-end mb-6">
                        <button type="submit"
                            class="bg-gradient-to-br from-[#10b981] to-[#059669] hover:from-[#16a34a] hover:to-[#15803d] text-white font-semibold px-8 py-2.5 rounded-[10px] transition-all active:scale-95 shadow-[0_10px_15px_-3px_rgba(16,185,129,0.3)] hover:shadow-[0_6px_20px_rgba(34,197,94,0.5)] active:shadow-[0_3px_10px_rgba(34,197,94,0.3)]">
                            Submit
                        </button>
                    </div>

                    {{-- Project Table --}}
                    <div class="overflow-hidden rounded-[10px] border border-gray-200">
                        <table class="w-full text-sm bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="text-center px-4 py-3 font-semibold text-gray-700 border-b border-r border-gray-200">
                                        Judul Project Improvement</th>
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
                                        <div class="text-xs text-gray-400 font-normal mt-0.5">{{ $project->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        @if($project->status === 'Pending')
                                            <span class="inline-flex items-center gap-1.5 text-orange-500 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span> Pending
                                            </span>
                                        @elseif($project->status === 'Verified')
                                            <span class="inline-flex items-center gap-1.5 text-green-600 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Verified
                                            </span>
                                        @elseif($project->status === 'On Progress')
                                            <span class="inline-flex items-center gap-1.5 text-blue-500 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span> On Progress
                                            </span>
                                        @elseif($project->status === 'Rejected')
                                            <span class="inline-flex items-center gap-1.5 text-red-500 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span> Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-gray-500 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full bg-gray-400 inline-block"></span> {{ $project->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white">
                                    <td class="px-4 py-5 text-gray-400 border-r border-gray-200 text-center text-xs" colspan="2">
                                        Belum ada project yang disubmit.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div> {{-- /wrapper Project Improvement --}}

        {{-- ══════════════════════════════ LOGBOOK ══════════════════════════════ --}}
        <div class="space-y-1">
            <div class="flex items-center gap-2.5 px-2" id="LogBook">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                <h2 class="text-xl font-bold text-[#2e3746] animate-title">LogBook</h2>
            </div>

            <div
                class="bg-gray-50 rounded-[10px] shadow-sm p-6 border border-gray-200 fade-up flex items-center justify-between">
                <div class="pr-6">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2e3746]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <h3 class="text-base font-bold text-[#2e3746] animate-title">Lihat rekap aktivitas LogBook kamu
                        </h3>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Pantau progress Exposure, Mentoring, dan Learning
                        secara lengkap klik tombol untuk melihat detail seluruh sesi.</p>
                </div>
                <a href="{{ route('talent.logbook.detail') }}"
                    class="bg-gradient-to-br from-[#10b981] to-[#059669] hover:from-[#16a34a] hover:to-[#15803d] text-white font-semibold flex-shrink-0 px-6 py-2.5 rounded-[10px] text-sm transition-all active:scale-95 shadow-[0_10px_15px_-3px_rgba(16,185,129,0.3)] hover:shadow-[0_6px_20px_rgba(34,197,94,0.5)] active:shadow-[0_3px_10px_rgba(34,197,94,0.3)]">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div> {{-- /wrapper LogBook --}}
    
    </div> <!-- Tutup w-full px-6 flex-grow wrapper -->

    <x-slot name="scripts">
        <script>
            // File name update for Project Improvement upload
            document.getElementById('file-upload').addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Klik untuk mengunggah';
                document.getElementById('file-name-display').textContent = fileName;
            });
        </script>
    </x-slot>
</x-talent.layout>
