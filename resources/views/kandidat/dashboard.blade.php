<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kandidat – Individual Development Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        /* ── Donut Chart ── */
        .donut-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        /* ── Smooth entrance ── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeSlideUp 0.5s ease both;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.12s;
        }

        .fade-up-3 {
            animation-delay: 0.20s;
        }

        .fade-up-4 {
            animation-delay: 0.28s;
        }

        /* ── Competency bar ── */
        @keyframes barReveal {
            from {
                clip-path: inset(0 100% 0 0);
            }

            to {
                clip-path: inset(0 0% 0 0);
            }
        }

        .bar-fill {
            animation: barReveal 0.9s cubic-bezier(0.4, 0, 0.2, 1) both;
            animation-delay: 0.35s;
        }

        /* ── Dropdown custom ── */
        .score-select {
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%234a5a6a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 14px;
            padding: 0.4rem 2rem 0.4rem 0.75rem;
            min-width: 64px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #3d4f62;
            background-color: #f8fafc;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .score-select:focus {
            outline: none;
            border-color: #3d4f62;
            box-shadow: 0 0 0 3px rgba(61, 79, 98, 0.12);
        }

        .score-select:hover {
            border-color: #94a3b8;
            background-color: #fff;
        }

        /* ── Upload area ── */
        .upload-area {
            border: 2px dashed #cbd5e1;
            transition: border-color 0.2s, background 0.2s;
        }

        .upload-area:hover,
        .upload-area.drag-over {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        /* ── Navbar outer wrapper ── */
        .navbar-outer {
            position: relative;
            z-index: 50;
            width: 100%;
            display: flex;
            align-items: center;
            background: transparent;
            /* memberi ruang kanan agar ikon kelihatan */
            padding-right: 1.25rem;
        }

        /* ── Dark part (brand + nav links) ── */
        .navbar-dark {
            flex: 1;
            background: #3d4f62;
            border-radius: 0 0 2rem 0;
            /* hanya kanan-bawah melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            gap: 2rem;
        }

        /* ── Navbar notification badge ── */
        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 9px;
            height: 9px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid white;
        }

        /* ── Icon buttons (bell & user) ── */
        .nav-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
            color: #3d4f62;
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.15s;
            position: relative;
        }

        .nav-icon-btn:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
            transform: translateY(-1px);
        }

        /* ── Page Background ── */
        .page-bg {
            background-image:
                linear-gradient(135deg, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 0.6) 100%),
                url('{{ asset('storage/images/Gambar TS.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="page-bg min-h-screen flex flex-col">

    {{-- ══════════════════════════════ NAVBAR ══════════════════════════════ --}}
    <div class="navbar-outer">

        {{-- Area gelap: brand + nav links --}}
        <div class="navbar-dark">
            {{-- Brand --}}
            <h1 class="text-white text-xl font-bold tracking-wide whitespace-nowrap flex-shrink-0">
                Individual Development Plan
            </h1>

            {{-- Nav links --}}
            <div class="flex items-center space-x-14 text-white text-sm font-medium ml-auto pr-6">
                <a href="#Kompetensi" class="hover:text-blue-200 transition-colors duration-150">Kompetensi</a>
                <a href="#IDP Monitoring" class="hover:text-blue-200 transition-colors duration-150">IDP</a>
                <a href="#Project Improvement" class="hover:text-blue-200 transition-colors duration-150">Project
                    Improvement</a>
                <a href="#LogBook" class="hover:text-blue-200 transition-colors duration-150">LogBook</a>
            </div>
        </div>

        {{-- Ikon di LUAR area gelap --}}
        <div class="flex items-center space-x-3 pl-4">
            {{-- Bell --}}
            <button class="nav-icon-btn" aria-label="Notifikasi">
                <span class="notif-badge"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                </svg>
            </button>
            {{-- Profile --}}
            <button class="nav-icon-btn" aria-label="Profil">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

    </div>

    {{-- ══════════════════════════════ PROFILE CARD ══════════════════════════════ --}}
    <div class="bg-[#3d4f62] shadow-md pl-6 pr-0 py-5 ml-6 mt-6 rounded-l-2xl fade-up fade-up-1">
        <div class="flex items-center gap-6 pl-10">
            {{-- Avatar --}}
            <div class="flex-shrink-0">
                @if ($user->foto ?? false)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                        class="w-28 h-28 rounded-xl object-cover border-2 border-white/30">
                @else
                    <div
                        class="w-28 h-28 rounded-xl bg-white/20 flex items-center justify-center border-2 border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-white/70" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info Grid --}}
            <div class="flex-grow grid grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-2 text-sm pl-10">
                {{-- Kiri --}}
                <div class="space-y-1.5">
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Nama</span>
                        <span class="text-white/80">{{ $user->nama ?? $user->name }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Perusahaan</span>
                        <span class="text-white/80">{{ $user->perusahaan ?? '-' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Departemen</span>
                        <span class="text-white/80">{{ $user->departemen ?? '-' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Role</span>
                        <span class="text-white/80">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
                {{-- Kanan --}}
                <div class="space-y-1.5 pl-16">
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Role Target</span>
                        <span class="text-white/80">{{ $user->jabatan_target ?? '-' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Mentor</span>
                        <span class="text-white/80">{{ $user->mentor->nama ?? '-' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-semibold text-white w-24 flex-shrink-0">Atasan</span>
                        <span class="text-white/80">{{ $user->atasan->nama ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-6 pt-5 pb-6 space-y-6 flex-grow">

        {{-- ══════════════════════════════ CHART ROW ══════════════════════════════ --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

            {{-- ── Kompetensi Bar Chart ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 fade-up fade-up-2 md:col-span-3">
                <h2 class="text-base font-bold text-gray-800 mb-4">Kompetensi</h2>
                @php
                    $kompetensiBars = [
                        'Integrity' => $kompetensi->integrity ?? 3,
                        'Communication' => $kompetensi->communication ?? 4,
                        'Innovation & Creativity' => $kompetensi->innovation_creativity ?? 3,
                        'Customer Orientation' => $kompetensi->customer_orientation ?? 2,
                        'Teamwork' => $kompetensi->teamwork ?? 4,
                        'Leadership' => $kompetensi->leadership ?? 3,
                        'Business Acumen' => $kompetensi->business_acumen ?? 3,
                        'Problem Solving & Decision Making' => $kompetensi->problem_solving ?? 2,
                        'Achievement Orientation' => $kompetensi->achievement_orientation ?? 3,
                        'Strategic Thinking' => $kompetensi->strategic_thinking ?? 2,
                    ];
                    $maxScore = 5;
                @endphp
                <div class="space-y-3">
                    @foreach ($kompetensiBars as $label => $score)
                        @php
                            // Skala 1-5: nilai 1 = 0%, nilai 5 = 100%
                            $pct = (($score - 1) / ($maxScore - 1)) * 100;
                        @endphp
                        <div class="flex items-center gap-3">
                            <span
                                class="text-sm text-gray-700 w-52 flex-shrink-0 whitespace-nowrap overflow-hidden truncate"
                                title="{{ $label }}">{{ $label }}</span>
                            <div class="flex-1 bg-gray-100 rounded-full h-5 overflow-hidden">
                                <div class="bar-fill h-full rounded-full"
                                    style="width:{{ $pct }}%; background:#0d9488;"></div>
                            </div>
                            <span class="text-sm font-bold w-6 text-right flex-shrink-0"
                                style="color:#0d9488;">{{ $score }}</span>
                        </div>
                    @endforeach
                    {{-- Skala keterangan -- sejajar dengan bar --}}
                    <div class="flex items-center gap-3 pt-1">
                        <span class="w-52 flex-shrink-0"></span>
                        <div class="flex-1 flex justify-between text-xs text-gray-400">
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                        </div>
                        <span class="w-6 flex-shrink-0"></span>
                    </div>
                </div>
            </div>

            {{-- ── IDP Monitoring Donut Charts ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 fade-up fade-up-2 md:col-span-2">
                <h2 class="text-base font-bold text-gray-800 mb-6">IDP Monitoring</h2>
                @php
                    $idpData = [
                        'Exposure' => ['done' => 4, 'total' => 6, 'color' => '#3d4f62'],
                        'Mentoring' => ['done' => 6, 'total' => 6, 'color' => '#f59e0b'],
                        'Learning' => ['done' => 5, 'total' => 6, 'color' => '#f97316'],
                    ];
                @endphp
                <div class="flex flex-wrap justify-around gap-4">
                    @foreach ($idpData as $label => $d)
                        @php
                            $r = 40;
                            $circ = 2 * M_PI * $r;
                            $filledDash = ($d['done'] / $d['total']) * $circ;
                            $emptyDash = $circ - $filledDash;
                        @endphp
                        <div class="flex flex-col items-center gap-2">
                            <div class="relative w-28 h-28">
                                <svg viewBox="0 0 100 100" class="w-full h-full">
                                    {{-- Track --}}
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="#e2e8f0" stroke-width="12" />
                                    {{-- Fill --}}
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                                        stroke="{{ $d['color'] }}" stroke-width="12"
                                        stroke-dasharray="{{ $filledDash }} {{ $emptyDash }}"
                                        stroke-linecap="round" class="donut-ring" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span
                                        class="text-lg font-bold text-gray-700">{{ $d['done'] }}/{{ $d['total'] }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════ KOMPETENSI FORM ══════════════════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 fade-up fade-up-3">
            {{-- Section header --}}
            <div class="flex items-center gap-2 mb-5">
                <span class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-gray-800">Kompetensi</h2>
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Core Competencies --}}
                    <div>
                        <h3 class="text-sm font-bold text-gray-700 mb-3">Core Competencies</h3>
                        <div class="space-y-2">
                            @php
                                $coreItems = [
                                    'Integrity' => $kompetensi->integrity ?? 1,
                                    'Communication' => $kompetensi->communication ?? 1,
                                    'Innovation & Creativity' => $kompetensi->innovation_creativity ?? 1,
                                    'Customer Orientation' => $kompetensi->customer_orientation ?? 1,
                                    'Teamwork' => $kompetensi->teamwork ?? 1,
                                ];
                            @endphp
                            @foreach ($coreItems as $itemLabel => $itemVal)
                                <div
                                    class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-2.5 border border-gray-100">
                                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                        <span class="text-gray-400">◦</span>
                                        {{ $itemLabel }}
                                    </div>
                                    <select name="core_{{ \Illuminate\Support\Str::slug($itemLabel, '_') }}"
                                        class="score-select">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" @selected($itemVal == $i)>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Managerial Competencies --}}
                    <div>
                        <h3 class="text-sm font-bold text-gray-700 mb-3">Managerial Competencies</h3>
                        <div class="space-y-2">
                            @php
                                $mngItems = [
                                    'Leadership' => $kompetensi->leadership ?? 1,
                                    'Business Acumen' => $kompetensi->business_acumen ?? 1,
                                    'Problem Solving & Decision Making' => $kompetensi->problem_solving ?? 1,
                                    'Achievement Orientation' => $kompetensi->achievement_orientation ?? 1,
                                    'Strategic Thinking' => $kompetensi->strategic_thinking ?? 1,
                                ];
                            @endphp
                            @foreach ($mngItems as $itemLabel => $itemVal)
                                <div
                                    class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-2.5 border border-gray-100">
                                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                        <span class="text-gray-400">◦</span>
                                        {{ $itemLabel }}
                                    </div>
                                    <select name="mng_{{ \Illuminate\Support\Str::slug($itemLabel, '_') }}"
                                        class="score-select">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" @selected($itemVal == $i)>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Submit Kompetensi --}}
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-2.5 rounded-xl shadow transition-all hover:shadow-md active:scale-95">
                        Submit
                    </button>
                </div>
            </form>
        </div>

        {{-- ══════════════════════════════ IDP MONITORING CARDS ══════════════════════════════ --}}
        <div class="bg-[#3d4f62] rounded-2xl shadow-md p-6 fade-up fade-up-4">
            {{-- Header --}}
            <div class="flex items-center gap-2 mb-5">
                <span class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-white">IDP Monitoring</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Exposure --}}
                <div class="bg-white rounded-xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold text-gray-800">Exposure</h3>
                        </div>
                        <p class="text-xs text-teal-600 font-semibold mb-1">Exposure / Assignment</p>
                        <p class="text-xs text-gray-600 mb-1 font-medium">Contoh kegiatan:</p>
                        <ul class="text-xs text-gray-600 space-y-0.5 list-disc list-inside mb-3">
                            <li>Meeting</li>
                            <li>Shadowing</li>
                            <li>Acting</li>
                            <li>Project</li>
                        </ul>
                        <p class="text-xs text-teal-600 font-semibold">Bobot : 70%</p>
                    </div>
                    <button
                        class="mt-4 w-full bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold py-2 rounded-lg transition active:scale-95">
                        Next
                    </button>
                </div>

                {{-- Mentoring --}}
                <div class="bg-white rounded-xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold text-gray-800">Mentoring</h3>
                        </div>
                        <p class="text-xs text-teal-600 font-semibold mb-1">Mentoring / Coaching</p>
                        <p class="text-xs text-gray-600 mb-1 font-medium">Contoh kegiatan:</p>
                        <ul class="text-xs text-gray-600 space-y-0.5 list-disc list-inside mb-3">
                            <li>Penjadwalan</li>
                            <li>Catatan singkat</li>
                            <li>Action plan</li>
                        </ul>
                        <p class="text-xs text-teal-600 font-semibold">Bobot : 20%</p>
                    </div>
                    <button
                        class="mt-4 w-full bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold py-2 rounded-lg transition active:scale-95">
                        Next
                    </button>
                </div>

                {{-- Learning --}}
                <div class="bg-white rounded-xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold text-gray-800">Learning</h3>
                        </div>
                        <p class="text-xs text-teal-600 font-semibold mb-1">Learning</p>
                        <p class="text-xs text-gray-600 mb-1 font-medium">Contoh kegiatan:</p>
                        <ul class="text-xs text-gray-600 space-y-0.5 list-disc list-inside mb-3">
                            <li>LMS Internal</li>
                            <li>Youtube edukatif</li>
                            <li>Artikel</li>
                            <li>Online course</li>
                        </ul>
                        <p class="text-xs text-teal-600 font-semibold">Bobot : 10%</p>
                    </div>
                    <button
                        class="mt-4 w-full bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold py-2 rounded-lg transition active:scale-95">
                        Next
                    </button>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════ PROJECT IMPROVEMENT ══════════════════════════════ --}}
        <div id="logbook" class="bg-gray-50 rounded-2xl shadow-sm p-6 border border-gray-200 fade-up fade-up-4">

            {{-- Download Template --}}
            <div class="flex justify-center mb-5">
                <a href="#"
                    class="flex items-center gap-2 text-sm font-semibold text-gray-600 border border-gray-300 bg-white hover:bg-gray-100 px-4 py-2 rounded-lg transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Template
                </a>
            </div>

            <p class="text-xs text-gray-500 mb-2">Unggah projek anda disini</p>

            {{-- Upload Area --}}
            <form action="#" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <label for="file-upload"
                    class="upload-area rounded-xl cursor-pointer flex flex-col items-center justify-center py-10 mb-4"
                    id="drop-zone">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-gray-400 mb-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    <span class="text-sm text-gray-500">Klik untuk mengunggah</span>
                    <input id="file-upload" name="project_file" type="file" class="sr-only">
                </label>

                {{-- Project Table --}}
                <div class="overflow-hidden rounded-xl border border-gray-200 mb-5">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left px-4 py-3 font-semibold text-gray-700 border-b border-gray-200">
                                    Judul Project Improvement</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-700 border-b border-gray-200">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b border-gray-100">
                                <td class="px-4 py-3 text-gray-700" id="uploaded-file-name">–</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center gap-1.5 text-orange-500 text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
                                        Pending
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg-white border-b border-gray-100">
                                <td class="px-4 py-3 text-gray-300">–</td>
                                <td class="px-4 py-3"></td>
                            </tr>
                            <tr class="bg-white">
                                <td class="px-4 py-3 text-gray-300">–</td>
                                <td class="px-4 py-3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Submit Project --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-2.5 rounded-xl shadow transition-all hover:shadow-md active:scale-95">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div> <!-- Tutup w-full px-6 flex-grow wrapper -->

    {{-- ══════════════════════════════ FOOTER ══════════════════════════════ --}}
    <footer class="mt-auto bg-[#3d4f62]/90 backdrop-blur-sm shadow-md py-4 text-center w-full">
        <span class="text-white/80 text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>

</body>

</html>
