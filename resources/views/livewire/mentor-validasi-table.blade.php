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
            font-size: 0.875rem;
            text-align: center;
            white-space: nowrap;
            border-bottom: 1px solid #e2e8f0;
        }

        .pdc-log-table td {
            padding: 16px 24px;
            color: #64748b;
            font-size: 0.875rem;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            vertical-align: middle;
        }

        .pdc-log-table tr:hover td {
            background: #fafafa;
        }
    </style>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3.5 rounded-xl shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Header & Talent Selector Row --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between mb-8" style="position: relative; z-index: 40;">
        <div class="flex-1">
            @if(!$showAllTalents && $selectedTalent)
                <div class="flex items-center gap-4">
                    <img src="{{ $selectedTalent->foto ? asset('storage/' . $selectedTalent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedTalent->nama) . '&background=random' }}"
                        class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm">
                    <div>
                        <h3 class="font-bold text-[20px] text-slate-800 leading-tight">{{ $selectedTalent->nama }}</h3>
                        <p class="text-[13px] text-gray-500 font-medium">
                            {{ optional($selectedTalent->position)->position_name ?? '-' }}
                            <span class="text-gray-400 mx-1">|</span>
                            <span class="italic">{{ optional($selectedTalent->department)->nama_department ?? '-' }}</span>
                        </p>
                    </div>
                </div>
            @else
                <div>
                    <h3 class="font-bold text-[20px] text-slate-800 leading-tight">Semua Talent</h3>
                    <p class="text-[13px] text-gray-500 font-medium mt-1">Menampilkan seluruh logbook talent, Talent yang baru divalidasi akan berada di urutan atas.</p>
                </div>
            @endif
        </div>
        
        <div class="relative w-full sm:w-72 flex-shrink-0">
            <select wire:model.live="selectedTalentId" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] font-medium outline-none focus:border-[#2dd4bf] focus:ring-1 focus:ring-[#2dd4bf] bg-white appearance-none cursor-pointer">
                <option value="0">Tampilkan Semua Talent</option>
                @foreach($mentees as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
            <svg class="w-4 h-4 text-[#94a3b8] absolute right-3.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    @if($showAllTalents || $selectedTalent)

    @if($showAllTalents)
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
                ->sortByDesc(function ($talentId) use ($groupedExposure, $groupedMentoring, $groupedLearning, $focusedTalentId) {
                    if ((int) $talentId === (int) $focusedTalentId) {
                        return 2;
                    }

                    return collect([
                        $groupedExposure->get($talentId, collect())->contains(fn($row) => ($row['status'] ?? null) === 'Pending' || ($row['status'] ?? null) === null || ($row['status'] ?? null) === ''),
                        $groupedMentoring->get($talentId, collect())->contains(fn($row) => ($row['status'] ?? null) === 'Pending' || ($row['status'] ?? null) === null || ($row['status'] ?? null) === ''),
                        $groupedLearning->get($talentId, collect())->contains(fn($row) => ($row['status'] ?? null) === 'Pending' || ($row['status'] ?? null) === null || ($row['status'] ?? null) === ''),
                    ])->contains(true) ? 1 : 0;
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
                
                $dataList = match($currentTab) {
                    'exposure' => $exposureRows,
                    'mentoring' => $mentoringRows,
                    'learning' => $learningRows,
                    default => collect()
                };
            @endphp
            <div class="prem-card">
                <div class="prem-card-header" style="border-bottom:none; padding-bottom: 6px;">
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $talentProfile && $talentProfile->foto ? asset('storage/' . $talentProfile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talentName) . '&background=random' }}"
                            class="w-14 h-14 rounded-full object-cover border-2 border-slate-100 shadow-sm flex-shrink-0">
                        <div>
                            <h3 class="font-bold text-[20px] text-slate-800 leading-tight">{{ $talentName }}</h3>
                            <p class="text-[13px] text-gray-500 font-medium">
                                {{ optional($talentProfile?->position)->position_name ?? '-' }}
                                <span class="text-gray-400 mx-1">|</span>
                                <span class="italic">{{ optional($talentProfile?->department)->nama_department ?? '-' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-5 pt-1 pb-5">
                    <div class="flex gap-1.5 overflow-x-auto rounded-full border border-[#e2e8f0] bg-[#f9fafb] p-1.5 shadow-inner w-fit">
                        <button type="button" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'exposure' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}" wire:click="switchTab('exposure', {{ $talentId }})">Exposure</button>
                        <button type="button" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'mentoring' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}" wire:click="switchTab('mentoring', {{ $talentId }})">Mentoring</button>
                        <button type="button" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'learning' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}" wire:click="switchTab('learning', {{ $talentId }})">Learning</button>
                    </div>
                </div>

                <div class="px-5 pb-5">
                    <div class="log-table-container custom-scrollbar overflow-x-auto">
                        <table class="pdc-log-table w-full">
                            <thead>
                                <tr>
                                    @if($currentTab == 'learning')
                                        <th>Sumber</th>
                                    @else
                                        <th>Mentor</th>
                                    @endif
                                    <th>Tema</th>
                                    <th>Tanggal Pengiriman/Update</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataList as $data)
                                <tr>
                                    @if($currentTab == 'learning')
                                        <td class="text-center font-medium">{{ $data['sumber'] ?: '-' }}</td>
                                    @else
                                        <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                                    @endif
                                    <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 35) ?: '-' }}</td>
                                    <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                    <td class="text-center whitespace-nowrap">{{ $data['tanggal'] ? date('d F Y', strtotime($data['tanggal'])) : '-' }}</td>
                                    <td class="text-center whitespace-nowrap w-32">
                                        @if($data['status'] === 'Pending' || $data['status'] === null || $data['status'] === '')
                                            <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                            </span>
                                        @elseif(in_array($data['status'], ['Approve','Approved']))
                                            <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                            class="inline-flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas {{ ucfirst($currentTab) }}.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="prem-card">
                <div class="py-8 text-center text-gray-400 text-sm italic">Belum ada aktivitas.</div>
            </div>
        @endforelse
    @else
        @php
            $currentTab = $talentActiveTabs[$selectedTalent->id] ?? 'exposure';
            
            $dataList = match($currentTab) {
                'exposure' => $exposureData,
                'mentoring' => $mentoringData,
                'learning' => $learningData,
                default => collect()
            };
        @endphp
        <div class="mb-6">
            <div class="flex gap-1.5 overflow-x-auto rounded-full border border-[#e2e8f0] bg-[#f9fafb] p-1.5 shadow-inner w-fit">
                <button type="button" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'exposure' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}" wire:click="switchTab('exposure', {{ $selectedTalent->id }})">Exposure</button>
                <button type="button" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'mentoring' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}" wire:click="switchTab('mentoring', {{ $selectedTalent->id }})">Mentoring</button>
                <button type="button" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $currentTab == 'learning' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}" wire:click="switchTab('learning', {{ $selectedTalent->id }})">Learning</button>
            </div>
        </div>

        <div class="log-table-container custom-scrollbar overflow-x-auto">
            <table class="pdc-log-table w-full">
                <thead>
                    <tr>
                        @if($currentTab == 'learning')
                            <th>Sumber</th>
                        @else
                            <th>Mentor</th>
                        @endif
                        <th>Tema</th>
                        <th>Tanggal Pengiriman/Update</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataList as $data)
                    <tr>
                        @if($currentTab == 'learning')
                            <td class="text-center font-medium">{{ $data['sumber'] ?: '-' }}</td>
                        @else
                            <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                        @endif
                        <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 35) ?: '-' }}</td>
                        <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                        <td class="text-center whitespace-nowrap">{{ $data['tanggal'] ? date('d F Y', strtotime($data['tanggal'])) : '-' }}</td>
                        <td class="text-center whitespace-nowrap w-32">
                            @if($data['status'] === 'Pending' || $data['status'] === null || $data['status'] === '')
                                <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                </span>
                            @elseif(in_array($data['status'], ['Approve','Approved']))
                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('mentor.riwayat.detail', $data['id']) }}"
                                class="inline-flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas {{ ucfirst($currentTab) }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @else
    <div class="text-center py-20">
        <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Logbook</h3>
        <p class="text-gray-500 text-sm">Belum ada logbook talent yang bisa ditampilkan.</p>
    </div>
    @endif
</div>
