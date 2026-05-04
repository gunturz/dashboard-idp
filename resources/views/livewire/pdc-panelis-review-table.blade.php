{{-- Livewire: pdc-panelis-review-table --}}
<div>
    {{-- ── Summary Cards ── --}}
    <div class="prem-stat-grid overflow-x-auto pb-2" style="grid-template-columns:repeat(3, minmax(150px, 1fr))">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.36-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm3 0v.25c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75v-.25a1.5 1.5 0 0 0-1.5-1.5h-1.5a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" /><path d="M3 16.02v2.73a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2.73a26.12 26.12 0 0 1-9 1.73 26.12 26.12 0 0 1-9-1.73Z" /></svg>
            </div>
            <div class="prem-stat-value">{{ $stats['totalProjectImprovement'] }}</div>
            <div class="prem-stat-label">Project Improvement</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" /></svg>
            </div>
            <div class="prem-stat-value">{{ $stats['belumDinilai'] }}</div>
            <div class="prem-stat-label">Belum Dinilai Panelis</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" /></svg>
            </div>
            <div class="prem-stat-value">{{ $stats['sudahDinilai'] }}</div>
            <div class="prem-stat-label">Sudah Dinilai Panelis</div>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6 mt-8" id="panelis-filter-bar">
        {{-- Live Search --}}
        <div class="relative w-full sm:w-[25%]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari Nama Talent…"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                id="live-search-input">
        </div>

        {{-- Perusahaan --}}
        <div class="relative w-full sm:w-[20%]">
            <select id="live-company-filter"
                wire:model.live="companyFilter"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                @endforeach
            </select>
        </div>

        {{-- Jabatan --}}
        <div class="relative w-full sm:w-[20%]">
            <select id="live-position-filter"
                wire:model.live="positionFilter"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua posisi yang dituju</option>
                @foreach ($positions as $pos)
                    <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Departemen (tampil jika perusahaan terpilih) --}}
        @if ($companyFilter && $departmentsForFilter->isNotEmpty())
            <div class="relative w-full sm:w-[20%]">
                <select id="live-department-filter"
                    wire:model.live="departmentFilter"
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
                <div class="overflow-x-auto">
                    <table class="prem-table">
                        <thead>
                            <tr>
                                <th class="w-[20%] text-left pl-6">Posisi Yang Dituju</th>
                                <th class="w-[18%]">Talent</th>
                                <th class="w-[16%]">Departemen</th>
                                <th class="w-[15%]">Validasi PDC</th>
                                <th class="w-[13%]">Lock Progress</th>
                                <th class="w-[18%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companyData['positions'] as $positionId => $posData)
                                @php
                                    $firstTalent = $posData['talents']->first();
                                    $plan = optional($firstTalent)->promotion_plan;
                                    $periodLabel = '-';
                                    if (!empty($plan->start_date) && !empty($plan->target_date)) {
                                        $periodLabel = \Carbon\Carbon::parse($plan->start_date)->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($plan->target_date)->translatedFormat('d M Y');
                                    }
                                @endphp
                                @foreach ($posData['talents'] as $index => $talent)
                                    <tr class="talent-row"
                                        data-name="{{ strtolower($talent->nama) }}"
                                        data-company="{{ $talent->company_id }}"
                                        data-position="{{ $positionId }}"
                                        data-dept="{{ $talent->department_id }}"
                                        data-pos-group="{{ $companyId }}-{{ $positionId }}">
                                        {{-- Posisi (rowspan) --}}
                                        @if ($index === 0)
                                            <td rowspan="{{ count($posData['talents']) }}" class="border-r border-[#f1f5f9] text-center align-middle">
                                                <div class="flex flex-col items-center justify-center gap-2 px-4 py-2">
                                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-teal-200/60 bg-teal-50/50">
                                                        <span class="font-bold text-teal-900 text-sm leading-none">{{ optional($posData['targetPosition'])->position_name ?? '-' }}</span>
                                                    </div>
                                                    <span class="text-[11px] text-slate-500 font-medium">{{ $periodLabel }}</span>
                                                </div>
                                            </td>
                                        @endif

                                        {{-- Talent --}}
                                        <td>
                                            <span class="font-bold text-[#1e293b] block text-sm">{{ $talent->nama }}</span>
                                            <span class="text-xs text-[#64748b] italic block mt-0.5">{{ optional($talent->position)->position_name ?? 'Officer' }}</span>
                                        </td>

                                        {{-- Departemen --}}
                                        <td>
                                            <span class="text-sm text-[#475569]">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                                        </td>

                                        {{-- Validasi Finance --}}
                                        <td>
                                            @php
                                                $latestProject = $talent->improvementProjects->sortByDesc('created_at')->first();
                                                $financeStatus = $latestProject ? $latestProject->status : 'Belum Ada';
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
                                        <td>
                                            @php
                                                $isLocked = optional($talent->promotion_plan)->is_locked ?? false;
                                            @endphp
                                            <form method="POST" action="{{ route('pdc_admin.panelis_review.toggle_lock', $talent->id) }}">
                                                @csrf
                                                <button type="submit" class="btn-prem {{ $isLocked ? 'btn-red' : 'btn-dark' }} text-[11px] px-2.5 py-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        @if($isLocked)
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                        @endif
                                                    </svg>
                                                    {{ $isLocked ? 'Locked' : 'Unlocked' }}
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Aksi --}}
                                        <td>
                                            @php
                                                $alreadySent = in_array(
                                                    optional($talent->promotion_plan)->status_promotion,
                                                    ['Pending Panelis', 'Approved Panelis', 'Rejected Panelis']
                                                );
                                                $isReviewedByPanelis = \App\Models\PanelisAssessment::where('user_id_talent', $talent->id)->whereNotNull('panelis_score')->exists();
                                            @endphp
                                            @if ($isReviewedByPanelis)
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('pdc_admin.panelis_review.detail', $talent->id) }}" class="btn-prem btn-ghost text-xs px-3 py-1.5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        Lihat Penilaian
                                                    </a>
                                                </div>
                                            @elseif ($alreadySent && !$isReviewedByPanelis)
                                                <button type="button" class="btn-prem btn-ghost text-xs px-3 py-1.5 opacity-60 cursor-not-allowed mx-auto" disabled title="Menunggu penilaian dari Panelis">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Menunggu
                                                </button>
                                            @else
                                                <button type="button"
                                                    onclick="openPanelisModal({{ $talent->id }}, '{{ addslashes($talent->nama) }}')"
                                                    class="btn-prem btn-teal text-xs px-3 py-1.5 mx-auto {{ !optional($talent->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ !optional($talent->promotion_plan)->is_locked ? 'disabled title="Progress harus dikunci terlebih dahulu"' : '' }}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    Kirim Panelis
                                                </button>
                                            @endif
                                        </td>
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3>Belum Ada Data Talent</h3>
            <p>{{ $search || $companyFilter || $positionFilter || $departmentFilter ? 'Tidak ada data yang cocok dengan filter yang dipilih.' : 'Data akan muncul setelah talent memiliki development plan aktif.' }}</p>
        </div>
    @endforelse
    </div>{{-- /panelis-review-wrapper --}}

    {{-- ── Kirim Panelis Wizard Modal (tetap di sini agar JS modal tetap bekerja) ── --}}
    <div id="panelisWizardModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closePanelisModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            {{-- Modal panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle w-full" style="max-width: 460px;">
                <form id="wizardForm" method="POST" action="">
                    @csrf
                    {{-- HEADER --}}
                    <div class="bg-white px-6 pt-6 pb-4 flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Kirim Panelis</h3>
                            <p class="text-sm text-gray-600 mt-0.5" id="wizardSubtitle">Pilih Perusahaan</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors mt-1" onclick="closePanelisModal()">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    {{-- BODY --}}
                    <div class="px-6 pb-2" style="min-height: 280px;">
                        {{-- STEP 1: Pilih Perusahaan --}}
                        <div id="step-1" class="modal-step active">
                            <div class="flex justify-end mb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="selectAllCompanies" onchange="toggleAllCompanies(this)" class="w-4 h-4 rounded border-gray-400 text-teal-600 focus:ring-teal-500">
                                    <span class="text-sm text-gray-600">Pilih semua</span>
                                </label>
                            </div>
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @forelse($companies as $comp)
                                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors [&:has(:checked)]:border-teal-500 [&:has(:checked)]:bg-teal-50">
                                        <input type="checkbox" name="selected_companies[]" value="{{ $comp->id }}" class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 company-checkbox" onchange="updateCompanySelectAll()">
                                        <span class="text-sm font-medium text-gray-800">{{ $comp->nama_company }}</span>
                                    </label>
                                @empty
                                    <div class="text-sm text-gray-500 italic">Belum ada data perusahaan.</div>
                                @endforelse
                            </div>
                            <div id="step-1-error" class="hidden text-red-500 text-xs mt-2">* Pilih minimal satu perusahaan.</div>
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
                        <button type="button" id="btn-cancel" class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-colors" onclick="closePanelisModal()">Batal</button>
                        <button type="button" id="btn-prev" class="hidden px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-colors" onclick="prevStep()">Sebelumnya</button>
                        <button type="button" id="btn-next" class="px-6 py-2 text-sm font-bold text-white bg-teal-500 rounded-xl hover:bg-teal-600 focus:outline-none transition-colors" onclick="nextStep()">Next</button>
                        <button type="submit" id="btn-submit" class="hidden px-6 py-2 text-sm font-bold text-white bg-teal-500 rounded-xl hover:bg-teal-600 focus:outline-none transition-colors">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* ── Panelis Review Table: Perjelas garis & judul kolom Capitalize ── */
    .panelis-review-wrapper .prem-table th {
        text-transform: none;
        letter-spacing: 0;
        font-size: 0.8rem;
        color: #1e293b;
        border-bottom: 2px solid #cbd5e1;
        border-right: 1px solid #d1d5db;
        background: #f1f5f9;
    }
    .panelis-review-wrapper .prem-table th:last-child {
        border-right: none;
    }
    .panelis-review-wrapper .prem-table td {
        border-bottom: 1px solid #d1d5db;
        border-right: 1px solid #e5e7eb;
    }
    .panelis-review-wrapper .prem-table td:last-child {
        border-right: none;
    }
    .panelis-review-wrapper .prem-table tbody tr:last-child td {
        border-bottom: 1px solid #d1d5db;
    }
    .panelis-review-wrapper .prem-card {
        border: 1.5px solid #cbd5e1;
    }
</style>

@push('scripts')
<script>
    const panelisUsers    = @json($panelisUsers);
    const panelisCompanies = @json($companies);

    let currentStep = 0;
    let selectedCompanyIds = [];

    const modal          = document.getElementById('panelisWizardModal');
    const step1          = document.getElementById('step-1');
    const step2Container = document.getElementById('step-2-container');
    const stepFinal      = document.getElementById('step-final');
    const btnPrev        = document.getElementById('btn-prev');
    const btnNext        = document.getElementById('btn-next');
    const btnSubmit      = document.getElementById('btn-submit');
    const btnCancel      = document.getElementById('btn-cancel');
    const wizardForm     = document.getElementById('wizardForm');

    function openPanelisModal(talentId, talentName) {
        wizardForm.action = `/pdc-admin/panelis-review/send/${talentId}`;
        wizardForm.reset();
        document.querySelectorAll('.company-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAllCompanies').checked = false;
        step2Container.innerHTML = '';
        document.getElementById('final-panelis-list').innerHTML = '';
        document.getElementById('step-1-error').classList.add('hidden');
        currentStep = 0;
        updateView();
        modal.style.display = 'block';
    }

    function closePanelisModal() { modal.style.display = 'none'; }

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

    function prevStep() { currentStep--; updateView(); }

    function toggleAllCompanies(selectAllCb) {
        document.querySelectorAll('.company-checkbox').forEach(cb => cb.checked = selectAllCb.checked);
    }

    function updateCompanySelectAll() {
        const all     = document.querySelectorAll('.company-checkbox');
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
                htmlList = `<div class="text-sm text-gray-500 italic px-2">Tidak ada panelis di perusahaan ini.</div>`;
            } else {
                selectAllHtml = `<label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="selectAllPanelis_${compId}" onchange="toggleAllPanelis(this, ${compId})" class="w-4 h-4 rounded border-gray-400 text-teal-600 focus:ring-teal-500"><span class="text-sm text-gray-600">Pilih semua</span></label>`;
                compPanelis.forEach(panelis => {
                    const isChecked = currentSelections.includes(panelis.id.toString()) ? 'checked' : '';
                    const roleName = panelis.position?.position_name || 'Panelis';
                    htmlList += `<label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors [&:has(:checked)]:border-teal-500 [&:has(:checked)]:bg-teal-50"><input type="checkbox" name="panelis_ids[]" value="${panelis.id}" class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 panelis-checkbox-${compId} panelis-checkbox-global" ${isChecked} onchange="updatePanelisSelectAll(${compId})"><span class="text-sm font-medium text-gray-800">${panelis.nama} - ${roleName}</span></label>`;
                });
            }

            const stepHtml = `<div id="step-comp-${compId}" class="modal-step company-step"><div class="flex items-center justify-between mb-3"><h4 class="text-base font-bold text-gray-900">${companyName}</h4><div>${selectAllHtml}</div></div><div class="space-y-2 max-h-72 overflow-y-auto">${htmlList}</div></div>`;
            step2Container.insertAdjacentHTML('beforeend', stepHtml);
        });
    }

    function toggleAllPanelis(selectAllCb, compId) {
        document.querySelectorAll(`.panelis-checkbox-${compId}`).forEach(cb => cb.checked = selectAllCb.checked);
    }

    function updatePanelisSelectAll(compId) {
        const all     = document.querySelectorAll(`.panelis-checkbox-${compId}`);
        const checked = document.querySelectorAll(`.panelis-checkbox-${compId}:checked`);
        const sa      = document.getElementById(`selectAllPanelis_${compId}`);
        if(sa) sa.checked = (all.length > 0 && all.length === checked.length);
    }

    function getSelectedPanelisIds() {
        return Array.from(document.querySelectorAll('.panelis-checkbox-global:checked')).map(cb => cb.value);
    }

    function populateFinalSummary() {
        const container   = document.getElementById('final-panelis-list');
        container.innerHTML = '';
        const selectedIds = getSelectedPanelisIds();
        if (selectedIds.length === 0) {
            container.innerHTML = '<div class="text-gray-500 italic">Tidak ada panelis yang dipilih. Data tidak dapat dikirim.</div>';
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
            selectedCompanyIds.forEach(compId => {
                const compPanelis = panelisUsers.filter(u => u.company_id == compId && selectedIds.includes(u.id.toString()));
                if (compPanelis.length > 0) {
                    const companyName = panelisCompanies.find(c => c.id == compId)?.nama_company || 'Unknown';
                    let listHtml = compPanelis.map(p => `<div class="px-4 py-2.5 border-b border-gray-100 last:border-0"><span class="text-sm font-medium text-gray-800">${p.nama} - ${p.position?.position_name || 'Panelis'}</span></div>`).join('');
                    container.innerHTML += `<div class="border border-gray-200 rounded-xl overflow-hidden"><div class="bg-gray-50 border-b border-gray-200 px-4 py-3"><h5 class="text-sm font-bold text-gray-900">${companyName}</h5></div><div class="bg-white">${listHtml}</div></div>`;
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
                document.querySelectorAll(`.talent-row[data-pos-group="${group}"]`).forEach(r => r.classList.add('group-hovered'));
            });
            row.addEventListener('mouseleave', () => {
                const group = row.dataset.posGroup;
                if (!group) return;
                document.querySelectorAll(`.talent-row[data-pos-group="${group}"]`).forEach(r => r.classList.remove('group-hovered'));
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initGroupHover);
</script>
<style>
    @keyframes lvwire-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush
