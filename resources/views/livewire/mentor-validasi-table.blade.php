<div>
    <style>
        .pdc-log-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pdc-log-table th {
            padding: 16px 24px;
            background: #f8fafc;
            font-weight: 800;
            color: #475569;
            font-size: 0.925rem;
            text-align: center;
            white-space: nowrap;
            border-bottom: 1px solid #e2e8f0;
        }

        .pdc-log-table td {
            padding: 16px 24px;
            color: #64748b;
            font-size: 0.925rem;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            vertical-align: middle;
        }

        .pdc-log-table tr:hover td {
            background: #fafafa;
        }

        .pdc-log-table .col-person {
            width: 14%;
        }

        .pdc-log-table .col-theme {
            width: 28%;
        }

        .pdc-log-table .col-date {
            width: 17%;
        }

        .pdc-log-table .col-status {
            width: 10%;
        }

        .pdc-log-table .col-action {
            width: 14%;
        }

        .pdc-log-table .person-cell {
            min-width: 170px;
        }

        .pdc-log-table .theme-cell {
            min-width: 260px;
            white-space: normal;
            line-height: 1.45;
        }

        .pdc-log-table .date-cell {
            min-width: 170px;
            font-size: 0.86rem;
        }
    </style>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 3000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-[-10px]"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-[-10px]"
            class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3.5 rounded-xl shadow-sm w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header & Talent Selector Row --}}
    <div class="flex flex-col {{ $showAllTalents ? 'gap-3 mb-5' : 'gap-6 mb-8' }}">
        {{-- Dropdown (Now Above) --}}
        <div class="flex items-center gap-3 w-full">
            <span class="text-sm font-bold text-[#475569] whitespace-nowrap">Pilih Talent:</span>
            <div class="relative flex-1">
                <select wire:model.live="selectedTalentId"
                    class="w-full border border-[#d1d5db] rounded-lg p-2.5 pr-10 text-sm text-[#475569] font-medium outline-none focus:border-[#2dd4bf] focus:ring-1 focus:ring-[#2dd4bf] bg-white appearance-none cursor-pointer"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                    <option value="0">Tampilkan Semua Talent</option>
                    @foreach ($mentees as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Talent Profile/Title (Now Below) --}}
        <div class="flex-1">
            @if (!$showAllTalents && $selectedTalent)
                <div class="flex items-center gap-4">
                    <img src="{{ $selectedTalent->foto ? asset('storage/' . $selectedTalent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedTalent->nama) . '&background=random' }}"
                        class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm">
                    <div>
                        <h3 class="font-bold text-[20px] text-slate-800 leading-tight">{{ $selectedTalent->nama }}</h3>
                        <p class="text-[13px] text-gray-500 font-medium">
                            {{ optional($selectedTalent->position)->position_name ?? '-' }}
                            <span class="text-gray-400 mx-1">|</span>
                            <span
                                class="italic">{{ optional($selectedTalent->department)->nama_department ?? '-' }}</span>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($showAllTalents || $selectedTalent)

        @if ($showAllTalents)
            @php
                $menteeMap = collect($mentees)->keyBy('id');
                $groupedExposure = collect($exposureData)->groupBy('talent_id');
                $groupedMentoring = collect($mentoringData)->groupBy('talent_id');
                $groupedLearning = collect($learningData)->groupBy('talent_id');

                // Get all unique talent IDs from all three data types
                $allTalentIds = collect()
                    ->merge($groupedExposure->keys())
                    ->merge($groupedMentoring->keys())
                    ->merge($groupedLearning->keys())
                    ->unique()
                    ->sortByDesc(function ($talentId) use (
                        $groupedExposure,
                        $groupedMentoring,
                        $groupedLearning,
                        $focusedTalentId,
                    ) {
                        if ((int) $talentId === (int) $focusedTalentId) {
                            return 2;
                        }

                        return collect([
                            $groupedExposure
                                ->get($talentId, collect())
                                ->contains(
                                    fn($row) => ($row['status'] ?? null) === 'Pending' ||
                                        ($row['status'] ?? null) === null ||
                                        ($row['status'] ?? null) === '',
                                ),
                            $groupedMentoring
                                ->get($talentId, collect())
                                ->contains(
                                    fn($row) => ($row['status'] ?? null) === 'Pending' ||
                                        ($row['status'] ?? null) === null ||
                                        ($row['status'] ?? null) === '',
                                ),
                            $groupedLearning
                                ->get($talentId, collect())
                                ->contains(
                                    fn($row) => ($row['status'] ?? null) === 'Pending' ||
                                        ($row['status'] ?? null) === null ||
                                        ($row['status'] ?? null) === '',
                                ),
                        ])->contains(true)
                            ? 1
                            : 0;
                    })
                    ->values();
            @endphp

            @forelse($allTalentIds as $talentId)
                @php
                    $talentProfile = $menteeMap->get((int) $talentId);
                    $talentName = $talentProfile?->nama ?? '-';
                    $exposureRows = $groupedExposure->get($talentId, collect());
                    $mentoringRows = $groupedMentoring->get($talentId, collect());
                    $learningRows = $groupedLearning->get($talentId, collect());

                    $currentTab = $talentActiveTabs[$talentId] ?? 'exposure';

                    $dataList = match ($currentTab) {
                        'exposure' => $exposureRows,
                        'mentoring' => $mentoringRows,
                        'learning' => $learningRows,
                        default => collect(),
                    };
                @endphp
                <div class="prem-card">
                    <div class="prem-card-header" style="border-bottom:none; padding-bottom: 6px;">
                        <div class="flex items-center gap-4">
                            <img src="{{ $talentProfile && $talentProfile->foto ? asset('storage/' . $talentProfile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talentName) . '&background=random' }}"
                                class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm flex-shrink-0">
                            <div>
                                <h3 class="font-bold text-[20px] text-slate-800 leading-tight">{{ $talentName }}</h3>
                                <p class="text-[13px] text-gray-500 font-medium">
                                    {{ optional($talentProfile?->position)->position_name ?? '-' }}
                                    <span class="text-gray-400 mx-1">|</span>
                                    <span
                                        class="italic">{{ optional($talentProfile?->department)->nama_department ?? '-' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 pt-1 pb-5">
                        <div
                            class="flex gap-1.5 overflow-x-auto no-scrollbar rounded-full border border-[#e2e8f0] bg-[#f9fafb] p-1.5 shadow-inner w-fit max-w-full">
                            <button type="button"
                                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'exposure' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}"
                                wire:click="switchTab('exposure', {{ $talentId }})">Exposure</button>
                            <button type="button"
                                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'mentoring' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}"
                                wire:click="switchTab('mentoring', {{ $talentId }})">Mentoring</button>
                            <button type="button"
                                class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'learning' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}"
                                wire:click="switchTab('learning', {{ $talentId }})">Learning</button>
                        </div>
                    </div>

                    <div class="px-5 pb-5">
                        <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto">
                            <table class="w-full min-w-[800px] md:min-w-full table-auto text-left bg-white">
                                <thead class="bg-slate-50 border-b border-gray-200">
                                    <tr>
                                        @if ($currentTab == 'learning')
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Sumber</th>
                                        @else
                                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                                        @endif
                                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal Pengiriman/Update</th>
                                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal Pelaksanaan</th>
                                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dataList as $data)
                                        <tr
                                            class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                            @if ($currentTab == 'learning')
                                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                                    {{ $data['sumber'] ?: '-' }}</td>
                                            @else
                                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                                    {{ $data['mentor'] }}</td>
                                            @endif
                                            <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                                {{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 35) ?: '-' }}
                                            </td>
                                            <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                {{ $data['tanggal_update'] ? \Carbon\Carbon::parse($data['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                                {{ $data['tanggal'] ? \Carbon\Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="py-4 px-6 text-center w-32">
                                                @if ($data['status'] === 'Pending' || $data['status'] === null || $data['status'] === '')
                                                    <span
                                                        class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                                        Pending
                                                    </span>
                                                @elseif(in_array($data['status'], ['Approve', 'Approved']))
                                                    <span
                                                        class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                        Approved
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                                    class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                                    title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-12 px-6 text-center text-gray-400 text-sm bg-white">
                                                Belum ada aktivitas {{ strtolower($currentTab) }} yang perlu divalidasi untuk talent ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 px-6 text-center text-gray-400 text-sm">
                    Belum ada talent yang tersedia untuk divalidasi saat ini.
                </div>
            @endforelse
        @else
            @php
                $currentTab = $talentActiveTabs[$selectedTalent->id] ?? 'exposure';

                $dataList = match ($currentTab) {
                    'exposure' => $exposureData,
                    'mentoring' => $mentoringData,
                    'learning' => $learningData,
                    default => collect(),
                };
            @endphp
            <div class="mb-6">
                <div
                    class="flex gap-1.5 overflow-x-auto no-scrollbar rounded-full border border-[#e2e8f0] bg-[#f9fafb] p-1.5 shadow-inner w-fit max-w-full">
                    <button type="button"
                        class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'exposure' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}"
                        wire:click="switchTab('exposure', {{ $selectedTalent->id }})">Exposure</button>
                    <button type="button"
                        class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'mentoring' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}"
                        wire:click="switchTab('mentoring', {{ $selectedTalent->id }})">Mentoring</button>
                    <button type="button"
                        class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'learning' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}"
                        wire:click="switchTab('learning', {{ $selectedTalent->id }})">Learning</button>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto">
                <table class="w-full min-w-[800px] md:min-w-full table-auto text-left bg-white">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            @if ($currentTab == 'learning')
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Sumber</th>
                            @else
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                            @endif
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal Pengiriman/Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataList as $data)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                @if ($currentTab == 'learning')
                                    <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                        {{ $data['sumber'] ?: '-' }}</td>
                                @else
                                    <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                        {{ $data['mentor'] }}</td>
                                @endif
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 35) ?: '-' }}</td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $data['tanggal_update'] ? \Carbon\Carbon::parse($data['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $data['tanggal'] ? \Carbon\Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center w-32">

                                    @if ($data['status'] === 'Pending' || $data['status'] === null || $data['status'] === '')
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @elseif(in_array($data['status'], ['Approve', 'Approved']))
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                        class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400 text-sm bg-white">
                                    Belum ada aktivitas {{ strtolower($currentTab) }} yang perlu divalidasi untuk talent ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
