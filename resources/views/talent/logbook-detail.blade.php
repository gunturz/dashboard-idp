<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogBook Detail – Individual Development Plan</title>
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

        /* ── Title Animation ── */
        @keyframes titleReveal {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-title {
            animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
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

        /* ── Navbar outer wrapper ── */
        .navbar-outer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            width: 100%;
            display: flex;
            align-items: center;
            background: #2e3746;
            padding: 1rem 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-outer.nav-hidden {
            transform: translateY(-110%);
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
            color: #2e3746;
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.15s;
            position: relative;
        }

        .nav-icon-btn:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
            transform: translateY(-1px);
        }

        /* ── Dropdown panel ── */
        .dropdown-panel {
            transform-origin: top right;
            animation: dropIn 0.18s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-6px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Custom Scrollbar Styles for LogBook Tables */
        .custom-scrollbar::-webkit-scrollbar {
            height: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2E3746;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #1e2530;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex flex-col pt-[80px]">

    {{-- ══════════════════════════════ NAVBAR ══════════════════════════════ --}}
    <div class="navbar-outer">
        {{-- Brand --}}
        <a href="{{ route('talent.dashboard') }}" class="flex items-center gap-4 flex-shrink-0 hover:opacity-90 transition-opacity">
            <div class="bg-white p-2 rounded-[10px] shadow-sm flex items-center justify-center w-14 h-14">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white text-xl font-bold tracking-wide whitespace-nowrap">
                Individual Development Plan
            </h1>
        </a>

        {{-- Nav links --}}
        <div class="flex items-center space-x-14 text-white text-sm font-medium ml-auto pr-6">
            <a href="{{ route('talent.dashboard') }}#Kompetensi" class="hover:text-blue-200 transition-colors duration-150">Kompetensi</a>
            <a href="{{ route('talent.dashboard') }}#IDP Monitoring" class="hover:text-blue-200 transition-colors duration-150">IDP</a>
            <a href="{{ route('talent.dashboard') }}#Project Improvement" class="hover:text-blue-200 transition-colors duration-150">Project Improvement</a>
            <a href="{{ route('talent.dashboard') }}#LogBook" class="hover:text-blue-200 transition-colors duration-150">LogBook</a>
        </div>

        {{-- Ikon (Kanan) --}}
        <div class="flex items-center space-x-3 pl-4 border-l border-white/20">
            {{-- Bell Dropdown --}}
            <div class="relative" id="bell-wrapper">
                <button class="nav-icon-btn" aria-label="Notifikasi" id="bell-btn"
                    onclick="toggleDropdown('bell-dropdown', 'bell-btn')">
                    @if ($notifications->where('is_read', false)->count() > 0)
                        <span class="notif-badge"></span>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                </button>
                <div id="bell-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-700">Notifikasi</span>
                        <form action="{{ route('talent.notifikasi.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-teal-500 font-semibold cursor-pointer hover:underline">Tandai semua</button>
                        </form>
                    </div>
                    <ul class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                        @foreach ($notifications as $notif)
                            <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer">
                                @if (!$notif['is_read'])
                                    <span class="w-2 h-2 mt-1.5 rounded-full bg-teal-500 flex-shrink-0"></span>
                                @else
                                    <span class="w-2 h-2 mt-1.5 rounded-full bg-gray-300 flex-shrink-0"></span>
                                @endif
                                <div>
                                    <p class="text-sm {{ !$notif['is_read'] ? 'text-gray-700 font-medium' : 'text-gray-500' }}">
                                        {!! $notif['title'] !!}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $notif['time'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                        <a href="{{ route('talent.notifikasi') }}"
                            class="text-xs text-gray-400 font-medium hover:text-teal-600 transition-colors">Lihat semua notifikasi</a>
                    </div>
                </div>
            </div>

            {{-- Profile Dropdown --}}
            <div class="relative" id="profile-wrapper">
                <button class="nav-icon-btn" aria-label="Profil" id="profile-btn"
                    onclick="toggleDropdown('profile-dropdown', 'profile-btn')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="profile-dropdown"
                    class="dropdown-panel hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ $user->nama ?? $user->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $user->email }}</p>
                    </div>
                    <ul class="py-1">
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Lihat Profil
                            </a>
                        </li>
                        <li class="border-t border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════ PROFILE CARD ══════════════════════════════ --}}
    <div class="bg-[#2e3746] shadow-md py-6 fade-up fade-up-1">
        <div class="flex items-stretch divide-x divide-white/20">

            {{-- Bagian 1: Avatar + Nama + Role --}}
            <div class="flex items-center gap-5 px-10 flex-shrink-0 w-1/3 justify-center py-2">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    @if ($user->foto ?? false)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                            class="w-24 h-24 rounded-[10px] object-cover border-2 border-white/30">
                    @else
                        <div
                            class="w-24 h-24 rounded-[10px] bg-white/20 flex items-center justify-center border-2 border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/70"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-white font-bold text-base leading-tight">{{ $user->nama ?? $user->name }}</p>
                    <p class="text-white/60 text-xs mt-1">
                        {{ ucfirst($user->role->role_name ?? 'Talent') }}</p>
                </div>
            </div>

            {{-- Bagian 2: Perusahaan, Departemen, Jabatan yang Dituju --}}
            <div class="px-10 w-1/3 flex flex-col pt-3 space-y-3 text-sm border-l border-white/20">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Perusahaan</span>
                    <span class="text-white">{{ optional($user->company)->nama_company ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Departemen</span>
                    <span class="text-white">{{ optional($user->department)->nama_department ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Jabatan yang dituju</span>
                    <span
                        class="text-white">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
                </div>
            </div>

            {{-- Bagian 3: Mentor, Atasan --}}
            <div class="px-10 w-1/3 flex flex-col pt-3 space-y-3 text-sm border-l border-white/20">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-24 flex-shrink-0">Mentor</span>
                    <span class="text-white">{{ optional($user->mentor)->nama ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-24 flex-shrink-0">Atasan</span>
                    <span class="text-white">{{ optional($user->atasan)->nama ?? '-' }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════ MAIN CONTENT ══════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-6 pt-4 pb-6 fade-up">
        {{-- Back Link --}}
        <div class="mb-2">
            <a href="{{ route('talent.dashboard') }}"
                class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#0d9488] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="flex items-center gap-3 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            <h1 class="text-2xl font-bold text-[#2e3746]">LogBook</h1>
        </div>

        {{-- Exposure Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-[#3d4f62] mb-4">Exposure</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Lokasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Aktivitas</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Deskripsi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Dokumentasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">FeedBack</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($exposureData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['mentor'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ $data['tema'] }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['lokasi'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['aktivitas'] }}</td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    {{ $data['deskripsi'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-emerald-600 font-medium border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-colors max-w-[160px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 18) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 text-gray-400 max-w-[160px]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Tidak ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    -
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @if($data['status'] === 'Approve')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data logbook ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Exposure yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Mentoring Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-[#3d4f62] mb-4">Mentoring</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Lokasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Deskripsi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Action Plan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Dokumentasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">FeedBack</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mentoringData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['mentor'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ $data['tema'] }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['lokasi'] }}</td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    {{ $data['deskripsi'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium border-r border-gray-100">
                                    {{ $data['action_plan'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-emerald-600 font-medium border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-colors max-w-[160px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 18) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 text-gray-400 max-w-[160px]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Tidak ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    -
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @if($data['status'] === 'Approve')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data logbook ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Mentoring yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Learning Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-[#3d4f62] mb-4">Learning</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Sumber</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Platform</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Dokumentasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">FeedBack</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($learningData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['sumber'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ $data['tema'] }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['platform'] }}</td>
                                <td class="px-6 py-4 text-emerald-600 font-medium border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-colors max-w-[160px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 18) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 text-gray-400 max-w-[160px]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Tidak ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    -
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @if($data['status'] === 'Approve')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data logbook ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Learning yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto bg-[#2e3746] py-5 text-center w-full">
        <span class="text-white text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>




    
    <script>
        // Hide navbar on scroll down, show on scroll up
        (function() {
            const navbar = document.querySelector('.navbar-outer');
            let lastScrollY = window.scrollY;
            let ticking = false;

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        const currentScrollY = window.scrollY;
                        if (currentScrollY > lastScrollY && currentScrollY > 80) {
                            navbar.classList.add('nav-hidden');
                        } else {
                            navbar.classList.remove('nav-hidden');
                        }
                        lastScrollY = currentScrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        })();

        // ── Dropdown toggle (bell & profile) ──
        function toggleDropdown(dropdownId, btnId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
            if (isHidden) {
                dropdown.classList.remove('hidden');
            }
        }

        // Klik di luar → tutup semua dropdown
        document.addEventListener('click', function(e) {
            const wrappers = ['bell-wrapper', 'profile-wrapper'];
            const clickedInside = wrappers.some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!clickedInside) {
                document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
            }
        });
    </script>
</body>

</html>
