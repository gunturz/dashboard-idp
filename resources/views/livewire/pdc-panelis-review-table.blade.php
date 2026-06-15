{{-- Livewire: pdc-panelis-review-table --}}
<div>
    {{-- ── Summary Cards ── --}}
    <div class="prem-stat-grid overflow-x-auto pb-2" style="grid-template-columns:repeat(4, minmax(150px, 1fr))">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.36-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm3 0v.25c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75v-.25a1.5 1.5 0 0 0-1.5-1.5h-1.5a1.5 1.5 0 0 0-1.5 1.5Z"
                        clip-rule="evenodd" />
                    <path
                        d="M3 16.02v2.73a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2.73a26.12 26.12 0 0 1-9 1.73 26.12 26.12 0 0 1-9-1.73Z" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $stats['totalProjectImprovement'] }}</div>
            <div class="prem-stat-label">Project Improvement</div>
        </div>
        <div class="prem-stat prem-stat-blue">
            <div class="prem-stat-icon si-blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $stats['totalTargetPenilaian'] }}</div>
            <div class="prem-stat-label">Total Target Penilaian</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $stats['penilaianSelesai'] }}</div>
            <div class="prem-stat-label">Penilaian Selesai</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $stats['menungguPenilaian'] }}</div>
            <div class="prem-stat-label">Menunggu Penilaian</div>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="flex flex-col sm:flex-row items-center gap-4 mb-8 mt-8" id="panelis-filter-bar">
        {{-- Live Search --}}
        <div class="relative w-full sm:flex-[1.5]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Talent…"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                id="live-search-input">
        </div>

        {{-- Perusahaan --}}
        <div class="relative w-full sm:w-[240px]">
            <select id="live-company-filter" wire:model.live="companyFilter"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                @endforeach
            </select>
        </div>

        {{-- Jabatan --}}
        <div class="relative w-full sm:w-[240px]">
            <select id="live-position-filter" wire:model.live="positionFilter"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-13 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua posisi yang dituju</option>
                @foreach ($positions as $pos)
                    <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Departemen (tampil jika perusahaan terpilih) --}}
        @if ($companyFilter && $departmentsForFilter->isNotEmpty())
            <div class="relative w-full sm:w-[240px]">
                <select id="live-department-filter" wire:model.live="departmentFilter"
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                    <option value="">Semua Departemen</option>
                    @foreach ($departmentsForFilter as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    {{-- ── Data Table grouped by Company ── --}}
    <div class="panelis-review-wrapper">
        @forelse ($groupedData as $companyId => $companyData)
            <div class="mb-8 company-section" data-company-id="{{ $companyId }}">
                <h3 class="company-section-title">
                    {{ $companyData['company']->nama_company ?? 'Unassigned' }}
                </h3>
                <div class="prem-card">
                    <div class="overflow-x-auto w-full border border-gray-200 rounded-2xl shadow-sm bg-white">
                        <table class="w-full table-auto text-left">
                            <thead class="bg-slate-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Posisi Yang Dituju</th>
                                    <th
                                        class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Talent</th>
                                    <th
                                        class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Departemen</th>
                                    <th
                                        class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Validasi Finance</th>
                                    <th
                                        class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Lock Progress</th>
                                    <th
                                        class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($companyData['positions'] as $positionId => $posData)
                                    @php
                                        $firstTalent = $posData['talents']->first();
                                        $plan = optional($firstTalent)->promotion_plan;
                                        $allLocked = $posData['talents']->every(
                                            fn($progressTalent) => optional($progressTalent->promotion_plan)->is_locked,
                                        );
                                        $anySentOrReviewed = $posData['talents']->contains(function ($progressTalent) {
                                            $progressPlan = optional($progressTalent)->promotion_plan;
                                            $sessionId = optional($progressPlan)->development_session_id;
                                            $alreadySent = in_array(optional($progressPlan)->status_promotion, [
                                                'Pending Panelis',
                                                'Approved Panelis',
                                                'Rejected Panelis',
                                            ]);
                                            $isReviewedByPanelis = \App\Models\PanelisAssessment::where(
                                                'user_id_talent',
                                                $progressTalent->id,
                                            )
                                                ->when(
                                                    $sessionId,
                                                    fn($q) => $q->where('development_session_id', $sessionId),
                                                )
                                                ->whereNotNull('panelis_score')
                                                ->exists();

                                            return $alreadySent || $isReviewedByPanelis;
                                        });
                                        $periodLabel = '-';
                                        if (!empty($plan->start_date) && !empty($plan->target_date)) {
                                            $periodLabel =
                                                \Carbon\Carbon::parse($plan->start_date)->locale('id')->translatedFormat('d F Y') .
                                                ' - ' .
                                                \Carbon\Carbon::parse($plan->target_date)->locale('id')->translatedFormat('d F Y');
                                        }
                                    @endphp
                                    @foreach ($posData['talents'] as $index => $talent)
                                        <tr class="talent-row hover:bg-teal-50/50 transition duration-150"
                                            data-name="{{ strtolower($talent->nama) }}"
                                            data-company="{{ $talent->company_id }}"
                                            data-position="{{ $positionId }}"
                                            data-dept="{{ $talent->department_id }}"
                                            data-pos-group="{{ $companyId }}-{{ $positionId }}">
                                            {{-- Posisi (rowspan) --}}
                                            @if ($index === 0)
                                                <td rowspan="{{ count($posData['talents']) }}"
                                                    class="px-6 py-5 text-center align-middle bg-slate-50/30">
                                                    <div class="flex flex-col items-center justify-center gap-2">
                                                        <div
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-teal-200/60 bg-white shadow-sm">
                                                            <span
                                                                class="font-bold text-teal-900 text-sm leading-tight text-center">{{ optional($posData['targetPosition'])->position_name ?? '-' }}</span>
                                                        </div>
                                                        <span
                                                            class="text-[11px] text-slate-500 font-medium">{{ $periodLabel }}</span>
                                                    </div>
                                                </td>
                                            @endif

                                            {{-- Talent --}}
                                            <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                                <div style="display: inline-block; text-align: center; width: 100%;">
                                                    <span
                                                        class="font-bold text-slate-800 block text-sm leading-tight">{{ $talent->nama }}</span>
                                                    <span
                                                        class="text-[11px] text-gray-500 italic block mt-1 leading-tight">{{ optional($talent->position)->position_name ?? 'Officer' }}</span>
                                                </div>
                                            </td>

                                            {{-- Departemen --}}
                                            <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                                <span
                                                    class="text-sm text-slate-700 font-medium">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                                            </td>

                                            {{-- Validasi Finance --}}
                                            <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                                @php
                                                    $latestProject = $talent->improvementProjects
                                                        ->sortByDesc('created_at')
                                                        ->first();
                                                    $financeStatus = $latestProject
                                                        ? $latestProject->status
                                                        : 'Belum Ada';
                                                @endphp
                                                @if ($financeStatus === 'Verified')
                                                    <span class="badge badge-green">Approved</span>
                                                @elseif($financeStatus === 'Rejected')
                                                    <span class="badge badge-red">Rejected</span>
                                                @else
                                                    <span class="badge badge-amber">Pending</span>
                                                @endif
                                            </td>

                                            {{-- Lock Progress --}}
                                            @if ($index === 0)
                                                <td rowspan="{{ count($posData['talents']) }}" class="px-6 py-5"
                                                    style="text-align:center; vertical-align:middle;">
                                                    <form method="POST" class="flex justify-center"
                                                        action="{{ route('pdc_admin.panelis_review.toggle_lock', $firstTalent->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn-prem {{ $allLocked ? 'btn-red' : 'btn-dark' }} text-[10px] px-3 py-1 font-bold">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="2.5">
                                                                @if ($allLocked)
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                                @else
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                                @endif
                                                            </svg>
                                                            {{ $allLocked ? 'Locked' : 'Unlocked' }}
                                                        </button>
                                                    </form>
                                                    <span class="block mt-2 text-[10px] font-semibold text-slate-500">
                                                        {{ count($posData['talents']) }} Talent
                                                    </span>
                                                </td>
                                            @endif

                                            {{-- Aksi --}}
                                            @if ($index === 0)
                                                <td rowspan="{{ count($posData['talents']) }}" class="px-6 py-5"
                                                    style="text-align:center; vertical-align:middle;">
                                                    @if ($anySentOrReviewed)
                                                        <div class="flex items-center justify-center gap-2">
                                                            <a href="{{ route('pdc_admin.panelis_review.detail', $firstTalent->id) }}"
                                                                class="inline-flex items-center gap-1.5 bg-[#0f172a] hover:bg-[#1e242e] text-white text-[11px] font-bold px-4 py-2 rounded-xl transition-all shadow-sm whitespace-nowrap">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                                Lihat Penilaian
                                                            </a>
                                                            @php
                                                                $firstTalentPlan = optional($firstTalent)->promotion_plan;
                                                                $firstTalentSessionId = optional($firstTalentPlan)->development_session_id;
                                                                $assignedPanelisIds = \App\Models\PanelisAssessment::where('user_id_talent', $firstTalent->id)
                                                                    ->when($firstTalentSessionId, fn($q) => $q->where('development_session_id', $firstTalentSessionId))
                                                                    ->where('is_active', true)
                                                                    ->pluck('panelis_id')
                                                                    ->toArray();
                                                            @endphp
                                                            <button type="button"
                                                                onclick="openPanelisModal({{ $firstTalent->id }}, '{{ addslashes($firstTalent->nama) }}', {{ json_encode($assignedPanelisIds) }})"
                                                                class="inline-flex items-center gap-1.5 px-4 py-2 text-[11px] font-bold text-white bg-blue-500 hover:bg-blue-600 rounded-xl transition-all shadow-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                Edit
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="flex justify-center">
                                                            <button type="button"
                                                                onclick="openPanelisModal({{ $firstTalent->id }}, '{{ addslashes($firstTalent->nama) }}')"
                                                                class="inline-flex items-center gap-1.5 px-4 py-2 text-[11px] font-bold text-white bg-teal-500 hover:bg-teal-600 rounded-xl transition-all shadow-sm {{ !$allLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                                {{ !$allLocked ? 'disabled title="Progress harus dikunci terlebih dahulu"' : '' }}>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                                </svg>
                                                                Kirim Panelis
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>{{-- /overflow-x-auto --}}
                </div>{{-- /prem-card --}}
            </div>
        @empty
            <div class="empty-prem" style="margin-top: 40px">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3>Belum Ada Project Improvement Talent</h3>
                <p>{{ $search || $companyFilter || $positionFilter || $departmentFilter ? 'Tidak ada data review panelis yang cocok dengan pencarian atau filter yang dipilih.' : 'Data akan muncul setelah talent meng-upload project improvement.' }}</p>
            </div>
        @endforelse
    </div>{{-- /panelis-review-wrapper --}}

    {{-- ── Kirim Panelis Wizard Modal (tetap di sini agar JS modal tetap bekerja) ── --}}
    <div id="panelisWizardModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"
                style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);" onclick="closePanelisModal()">
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            {{-- Modal panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle w-full"
                style="max-width: 460px;">
                <form id="wizardForm" method="POST" action="">
                    @csrf
                    {{-- HEADER --}}
                    <div class="bg-white px-6 pt-6 pb-4 flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Kirim Panelis</h3>
                            <p class="text-sm text-gray-600 mt-0.5" id="wizardSubtitle">Pilih Perusahaan</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors mt-1"
                            onclick="closePanelisModal()">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    {{-- BODY --}}
                    <div class="px-6 pb-2 relative" style="min-height: 280px;">
                        {{-- STEP 1: Pilih Perusahaan --}}
                        <div id="step-1" class="modal-step active">
                            <div class="flex justify-end mb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="selectAllCompanies"
                                        onchange="toggleAllCompanies(this)"
                                        class="w-4 h-4 rounded border-gray-400 text-teal-600 focus:ring-teal-500">
                                    <span class="text-sm text-gray-600">Pilih semua</span>
                                </label>
                            </div>
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @forelse($companies as $comp)
                                    <label
                                        class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors [&:has(:checked)]:border-teal-500 [&:has(:checked)]:bg-teal-50">
                                        <input type="checkbox" name="selected_companies[]"
                                            value="{{ $comp->id }}"
                                            class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 company-checkbox"
                                            onchange="updateCompanySelectAll()">
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $comp->nama_company }}</span>
                                    </label>
                                @empty
                                    <div class="text-sm text-gray-500 italic">Belum ada data perusahaan.</div>
                                @endforelse
                            </div>
                            <div id="step-1-error" class="hidden text-red-500 text-xs mt-2">* Pilih minimal satu
                                perusahaan.</div>
                        </div>
                        {{-- STEP 2: Pilih Panelis per Perusahaan (Generated by JS) --}}
                        <div id="step-2-container"></div>
                        {{-- STEP 3: Confirmation --}}
                        <div id="step-final" class="modal-step">
                            <div id="final-panelis-list" class="space-y-3 max-h-72 overflow-y-auto pr-1">
                                {{-- JS populated --}}
                            </div>
                        </div>
                    </div>
                    {{-- FOOTER --}}
                    <div class="px-6 py-4 flex justify-end gap-3">
                        <button type="button" id="btn-cancel"
                            class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-colors"
                            onclick="closePanelisModal()">Batal</button>
                        <button type="button" id="btn-prev"
                            class="hidden px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-colors"
                            onclick="prevStep()">Sebelumnya</button>
                        <button type="button" id="btn-next"
                            class="px-6 py-2 text-sm font-bold text-white bg-teal-500 rounded-xl hover:bg-teal-600 focus:outline-none transition-colors"
                            onclick="nextStep()">Next</button>
                        <button type="submit" id="btn-submit"
                            class="hidden px-6 py-2 text-sm font-bold text-white bg-teal-500 rounded-xl hover:bg-teal-600 focus:outline-none transition-colors">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        const panelisUsers = @json($panelisUsers);
        const panelisCompanies = @json($companies);

        let currentStep = 0;
        let selectedCompanyIds = [];
        let preSelectedPanelisIds = [];

        const modal = document.getElementById('panelisWizardModal');
        const step1 = document.getElementById('step-1');
        const step2Container = document.getElementById('step-2-container');
        const stepFinal = document.getElementById('step-final');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const btnSubmit = document.getElementById('btn-submit');
        const btnCancel = document.getElementById('btn-cancel');
        const wizardForm = document.getElementById('wizardForm');

        function openPanelisModal(talentId, talentName, assignedPanelisIds = []) {
            wizardForm.action = `/pdc-admin/panelis-review/send/${talentId}`;
            wizardForm.reset();
            
            preSelectedPanelisIds = assignedPanelisIds.map(id => id.toString());
            
            document.querySelectorAll('.company-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAllCompanies').checked = false;
            step2Container.innerHTML = '';
            document.getElementById('final-panelis-list').innerHTML = '';
            document.getElementById('step-1-error').classList.add('hidden');

            if (preSelectedPanelisIds.length > 0) {
                let companiesToCheck = new Set();
                preSelectedPanelisIds.forEach(pId => {
                    let user = panelisUsers.find(u => u.id == pId);
                    if (user && user.company_id) {
                        companiesToCheck.add(user.company_id.toString());
                    }
                });

                document.querySelectorAll('.company-checkbox').forEach(cb => {
                    if (companiesToCheck.has(cb.value.toString())) {
                        cb.checked = true;
                    }
                });
                updateCompanySelectAll();
                
                selectedCompanyIds = Array.from(companiesToCheck);
                generateCompanySteps();
                preSelectedPanelisIds = []; // Clear it after initial step generation
            } else {
                selectedCompanyIds = [];
            }
            
            currentStep = 0;
            updateView();
            modal.style.display = 'block';
        }

        function closePanelisModal() {
            modal.style.display = 'none';
        }

        function updateView() {
            step1.classList.remove('active');
            stepFinal.classList.remove('active');
            document.querySelectorAll('.company-step').forEach(el => el.classList.remove('active'));
            const subtitle = document.getElementById('wizardSubtitle');

            if (currentStep === 0) {
                subtitle.innerText = 'Pilih Perusahaan';
                step1.classList.add('active');
                btnPrev.classList.add('hidden');
                btnNext.classList.remove('hidden');
                btnSubmit.classList.add('hidden');
                btnCancel.classList.remove('hidden');
            } else if (currentStep > 0 && currentStep <= selectedCompanyIds.length) {
                subtitle.innerText = 'Pilih Panelis';
                document.getElementById(`step-comp-${selectedCompanyIds[currentStep - 1]}`).classList.add('active');
                btnPrev.classList.remove('hidden');
                btnNext.classList.remove('hidden');
                btnSubmit.classList.add('hidden');
                btnCancel.classList.add('hidden');
            } else if (currentStep === selectedCompanyIds.length + 1) {
                subtitle.innerText = 'Konfirmasi Panelis';
                populateFinalSummary();
                stepFinal.classList.add('active');
                btnPrev.classList.remove('hidden');
                btnNext.classList.add('hidden');
                btnSubmit.classList.remove('hidden');
                btnCancel.classList.add('hidden');
            }
        }

        function nextStep() {
            if (currentStep === 0) {
                const checkedComps = document.querySelectorAll('.company-checkbox:checked');
                if (checkedComps.length === 0) {
                    document.getElementById('step-1-error').classList.remove('hidden');
                    return;
                }
                document.getElementById('step-1-error').classList.add('hidden');
                selectedCompanyIds = Array.from(checkedComps).map(cb => cb.value);
                generateCompanySteps();
            }
            currentStep++;
            updateView();
        }

        function prevStep() {
            currentStep--;
            updateView();
        }

        function toggleAllCompanies(selectAllCb) {
            document.querySelectorAll('.company-checkbox').forEach(cb => cb.checked = selectAllCb.checked);
        }

        function updateCompanySelectAll() {
            const all = document.querySelectorAll('.company-checkbox');
            const checked = document.querySelectorAll('.company-checkbox:checked');
            document.getElementById('selectAllCompanies').checked = (all.length > 0 && all.length === checked.length);
        }

        function generateCompanySteps() {
            const currentSelections = getSelectedPanelisIds();
            step2Container.innerHTML = '';

            selectedCompanyIds.forEach((compId) => {
                const companyName = panelisCompanies.find(c => c.id == compId)?.nama_company || 'Unknown Company';
                const compPanelis = panelisUsers.filter(u => u.company_id == compId);

                let htmlList = '';
                let selectAllHtml = '';
                if (compPanelis.length === 0) {
                    htmlList =
                        `<div class="text-sm text-gray-500 italic px-2">Tidak ada panelis di perusahaan ini.</div>`;
                } else {
                    selectAllHtml =
                        `<label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="selectAllPanelis_${compId}" onchange="toggleAllPanelis(this, ${compId})" class="w-4 h-4 rounded border-gray-400 text-teal-600 focus:ring-teal-500"><span class="text-sm text-gray-600">Pilih semua</span></label>`;
                    compPanelis.forEach(panelis => {
                        const isChecked = (currentSelections.includes(panelis.id.toString()) || preSelectedPanelisIds.includes(panelis.id.toString())) ? 'checked' :
                            '';
                        const roleName = panelis.position?.position_name || 'Panelis';
                        htmlList +=
                            `<label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors [&:has(:checked)]:border-teal-500 [&:has(:checked)]:bg-teal-50"><input type="checkbox" name="panelis_ids[]" value="${panelis.id}" class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 panelis-checkbox-${compId} panelis-checkbox-global" ${isChecked} onchange="updatePanelisSelectAll(${compId})"><span class="text-sm font-medium text-gray-800">${panelis.nama} - ${roleName}</span></label>`;
                    });
                }

                const stepHtml =
                    `<div id="step-comp-${compId}" class="modal-step company-step"><div class="flex items-center justify-between mb-3"><h4 class="text-base font-bold text-gray-900">${companyName}</h4><div>${selectAllHtml}</div></div><div class="space-y-2 max-h-72 overflow-y-auto">${htmlList}</div></div>`;
                step2Container.insertAdjacentHTML('beforeend', stepHtml);
                updatePanelisSelectAll(compId);
            });
        }

        function toggleAllPanelis(selectAllCb, compId) {
            document.querySelectorAll(`.panelis-checkbox-${compId}`).forEach(cb => cb.checked = selectAllCb.checked);
        }

        function updatePanelisSelectAll(compId) {
            const all = document.querySelectorAll(`.panelis-checkbox-${compId}`);
            const checked = document.querySelectorAll(`.panelis-checkbox-${compId}:checked`);
            const sa = document.getElementById(`selectAllPanelis_${compId}`);
            if (sa) sa.checked = (all.length > 0 && all.length === checked.length);
        }

        function getSelectedPanelisIds() {
            return Array.from(document.querySelectorAll('.panelis-checkbox-global:checked')).map(cb => cb.value);
        }

        function populateFinalSummary() {
            const container = document.getElementById('final-panelis-list');
            container.innerHTML = '';
            const selectedIds = getSelectedPanelisIds();
            if (selectedIds.length === 0) {
                container.innerHTML =
                    '<div class="text-gray-500 italic">Tidak ada panelis yang dipilih. Data tidak dapat dikirim.</div>';
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                selectedCompanyIds.forEach(compId => {
                    const compPanelis = panelisUsers.filter(u => u.company_id == compId && selectedIds.includes(u.id
                        .toString()));
                    if (compPanelis.length > 0) {
                        const companyName = panelisCompanies.find(c => c.id == compId)?.nama_company || 'Unknown';
                        let listHtml = compPanelis.map(p =>
                            `<div class="px-4 py-2.5 border-b border-gray-100 last:border-0"><span class="text-sm font-medium text-gray-800">${p.nama} - ${p.position?.position_name || 'Panelis'}</span></div>`
                        ).join('');
                        container.innerHTML +=
                            `<div class="border border-gray-200 rounded-xl overflow-hidden"><div class="bg-gray-50 border-b border-gray-200 px-4 py-3"><h5 class="text-sm font-bold text-gray-900">${companyName}</h5></div><div class="bg-white">${listHtml}</div></div>`;
                    }
                });
            }
        }

        // Re-init hover setelah Livewire update DOM
        document.addEventListener('livewire:navigated', initGroupHover);
        document.addEventListener('livewire:updated', initGroupHover);

        function initGroupHover() {
            document.querySelectorAll('.talent-row').forEach(row => {
                row.addEventListener('mouseenter', () => {
                    const group = row.dataset.posGroup;
                    if (!group) return;
                    document.querySelectorAll(`.talent-row[data-pos-group="${group}"]`).forEach(r => r
                        .classList.add('group-hovered'));
                });
                row.addEventListener('mouseleave', () => {
                    const group = row.dataset.posGroup;
                    if (!group) return;
                    document.querySelectorAll(`.talent-row[data-pos-group="${group}"]`).forEach(r => r
                        .classList.remove('group-hovered'));
                });
            });
        }

        document.addEventListener('DOMContentLoaded', initGroupHover);
    </script>
    <style>
        .modal-step {
            display: none;
        }

        .modal-step.active {
            display: block;
        }

        @keyframes lvwire-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
