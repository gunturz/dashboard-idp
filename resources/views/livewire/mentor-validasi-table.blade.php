<div>
    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3.5 rounded-xl shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Talent Selector --}}
    <div class="mb-6 flex items-center gap-6 talent-selector-row" style="position: relative; z-index: 40;">
        <label class="text-[15px] font-bold text-gray-700 whitespace-nowrap">Talent</label>
        
        <div class="relative w-full max-w-lg">
            <select wire:model.live="selectedTalentId" class="w-full bg-white border border-gray-300 rounded-lg flex items-center justify-between py-3 px-4 hover:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 text-slate-700 font-medium text-[15px] transition-colors appearance-none">
                <option value="0">Semua Talent</option>
                @foreach($mentees as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
            <svg class="w-5 h-5 text-gray-400 absolute right-4 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    @if($showAllTalents || $selectedTalent)
    @if(!$showAllTalents)
        <div class="flex items-center gap-4 mb-8">
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
        <div class="mb-8">
            <h3 class="font-bold text-[20px] text-slate-800 leading-tight">Semua Talent</h3>
            <p class="text-[13px] text-gray-500 font-medium mt-1">Menampilkan seluruh logbook talent. Talent yang baru divalidasi akan berada di urutan atas dropdown.</p>
        </div>
    @endif

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
                    <div class="inline-flex items-center gap-1.5 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/60 overflow-x-auto custom-scrollbar w-fit">
                        <button type="button" class="btn-prem {{ $currentTab == 'exposure' ? 'btn-dark active px-6 rounded-full' : 'btn-ghost px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80' }}" wire:click="switchTab('exposure', {{ $talentId }})">Exposure</button>
                        <button type="button" class="btn-prem {{ $currentTab == 'mentoring' ? 'btn-dark active px-6 rounded-full' : 'btn-ghost px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80' }}" wire:click="switchTab('mentoring', {{ $talentId }})">Mentoring</button>
                        <button type="button" class="btn-prem {{ $currentTab == 'learning' ? 'btn-dark active px-6 rounded-full' : 'btn-ghost px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80' }}" wire:click="switchTab('learning', {{ $talentId }})">Learning</button>
                    </div>
                </div>

                <div class="p-0 overflow-x-auto custom-scrollbar">
                    <table class="highlight-table mb-0">
                        <thead>
                            <tr>
                                @if($currentTab == 'learning')
                                    <th>Sumber</th>
                                @else
                                    <th>Mentor</th>
                                @endif
                                <th>Tema</th>
                                <th>Tanggal Pengiriman /<br>Update</th>
                                <th>Tanggal<br>Pelaksanaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataList as $data)
                            <tr>
                                @if($currentTab == 'learning')
                                    <td class="font-medium text-left">{{ $data['sumber'] ?: '-' }}</td>
                                @else
                                    <td class="font-medium text-left">{{ $data['mentor'] }}</td>
                                @endif
                                <td class="font-semibold text-[#1e293b]">{{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 40) ?: '-' }}</td>
                                <td>{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td>{{ $data['tanggal'] ? date('d M Y', strtotime($data['tanggal'])) : '-' }}</td>
                                <td>
                                    @if($data['status'] === 'Pending')
                                        <span class="status-dot status-pending">Pending</span>
                                    @elseif(in_array($data['status'], ['Approve','Approved']))
                                        <span class="status-dot status-approved">Approved</span>
                                    @else
                                        <span class="status-dot status-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('mentor.riwayat.detail', $data['id']) }}" class="btn-detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 text-sm italic">Belum ada aktivitas {{ ucfirst($currentTab) }}.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
            <div class="inline-flex items-center gap-1.5 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/60 overflow-x-auto custom-scrollbar w-fit">
                <button type="button" class="btn-prem {{ $currentTab == 'exposure' ? 'btn-dark active px-6 rounded-full' : 'btn-ghost px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80' }}" wire:click="switchTab('exposure', {{ $selectedTalent->id }})">Exposure</button>
                <button type="button" class="btn-prem {{ $currentTab == 'mentoring' ? 'btn-dark active px-6 rounded-full' : 'btn-ghost px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80' }}" wire:click="switchTab('mentoring', {{ $selectedTalent->id }})">Mentoring</button>
                <button type="button" class="btn-prem {{ $currentTab == 'learning' ? 'btn-dark active px-6 rounded-full' : 'btn-ghost px-6 rounded-full border-transparent bg-transparent hover:bg-slate-200/80' }}" wire:click="switchTab('learning', {{ $selectedTalent->id }})">Learning</button>
            </div>
        </div>
        <div class="prem-card">
            <div class="p-0 overflow-x-auto custom-scrollbar">
                <table class="highlight-table mb-0">
                    <thead>
                        <tr>
                            @if($currentTab == 'learning')
                                <th>Sumber</th>
                            @else
                                <th>Mentor</th>
                            @endif
                            <th>Tema</th>
                            <th>Tanggal Pengiriman /<br>Update</th>
                            <th>Tanggal<br>Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataList as $data)
                        <tr>
                            @if($currentTab == 'learning')
                                <td class="font-medium text-left">{{ $data['sumber'] ?: '-' }}</td>
                            @else
                                <td class="font-medium text-left">{{ $data['mentor'] }}</td>
                            @endif
                            <td class="font-semibold text-[#1e293b]">{{ \Illuminate\Support\Str::limit($data['tema'] ?? '', 40) ?: '-' }}</td>
                            <td>{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td>{{ $data['tanggal'] ? date('d M Y', strtotime($data['tanggal'])) : '-' }}</td>
                            <td>
                                @if($data['status'] === 'Pending')
                                    <span class="status-dot status-pending">Pending</span>
                                @elseif(in_array($data['status'], ['Approve','Approved']))
                                    <span class="status-dot status-approved">Approved</span>
                                @else
                                    <span class="status-dot status-rejected">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('mentor.riwayat.detail', $data['id']) }}" class="btn-detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 text-sm italic">Belum ada aktivitas {{ ucfirst($currentTab) }}.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @else
    <div class="text-center py-20">
        <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Logbook</h3>
        <p class="text-gray-500 text-sm">Belum ada logbook talent yang bisa ditampilkan.</p>
    </div>
    @endif
</div>
