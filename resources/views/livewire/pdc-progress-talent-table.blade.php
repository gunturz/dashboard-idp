<div>
    {{-- Stat Grid --}}
    <div class="prem-stat-grid mb-8" style="grid-template-columns: repeat(3, 1fr);">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalTalent }}</div>
            <div class="prem-stat-label">Total Talent Aktif</div>
        </div>
        <div class="prem-stat prem-stat-blue">
            <div class="prem-stat-icon si-blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalCompany }}</div>
            <div class="prem-stat-label">Perusahaan Terlibat</div>
        </div>
        <div class="prem-stat prem-stat-purple">
            <div class="prem-stat-icon si-purple">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalPositions }}</div>
            <div class="prem-stat-label">Target Posisi</div>
        </div>
    </div>

    {{-- Actions Row: Search + Button --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
        <div class="relative w-full sm:w-[40%]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Talent..."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            @if ($search)
                <button type="button" wire:click="$set('search', '')" class="btn-prem btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset
                </button>
            @endif

            <a href="{{ route('pdc_admin.development_plan') }}"
                class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-[#0f172a] hover:bg-[#1f2937] rounded-xl transition-all whitespace-nowrap shadow-lg shadow-slate-200 transform hover:scale-[1.02] active:scale-[0.98]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Development Plan
            </a>
        </div>
    </div>

    {{-- Loading indicator --}}
    <div wire:loading class="text-center py-6">
        <svg class="animate-spin h-6 w-6 text-[#0f172a] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </div>

    {{-- Grouped Data --}}
    <div wire:loading.remove>
        <div class="progress-talent-wrapper">
            @forelse ($groupedData as $companyId => $companyData)
                <div class="mb-8 company-section">
                    <h3 class="company-section-title">{{ $companyData['company']->nama_company ?? 'Unassigned' }}</h3>
                    <div class="overflow-x-auto border border-gray-200 rounded-xl overflow-hidden w-full">
                        <table class="w-full table-auto text-left bg-white">
                            <thead class="bg-slate-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="w-[18%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                        Posisi Yang Dituju</th>
                                    <th
                                        class="w-[18%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                        Talent</th>
                                    <th
                                        class="w-[16%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                        Departemen</th>
                                    <th
                                        class="w-[16%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                        Mentor</th>
                                    <th
                                        class="w-[14%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                        Atasan</th>
                                    <th
                                        class="w-[18%] py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">
                                        Aksi</th>
                                </tr>

                            </thead>
                            @foreach ($companyData['plan_groups'] as $groupKey => $posData)
                                <tbody class="group">
                                    @php
                                        $positionId = $posData['target_position_id'] ?? 0;
                                        $detailRouteParams = [
                                            'company_id' => $companyId,
                                            'position_id' => $positionId,
                                            'department_id' => $posData['department_id'] ?? null,
                                            'plan_created_at' => $posData['plan_created_at'] ?? null,
                                        ];
                                        $periodLabel = '-';
                                        if (!empty($posData['start_date']) && !empty($posData['target_date'])) {
                                            $periodLabel =
                                                \Carbon\Carbon::parse($posData['start_date'])->locale('id')->translatedFormat(
                                                    'd F Y',
                                                ) .
                                                ' - ' .
                                                \Carbon\Carbon::parse($posData['target_date'])->locale('id')->translatedFormat(
                                                    'd F Y',
                                                );
                                        }
                                        $groupLabel = trim(
                                            ($posData['targetPosition']->position_name ?? '-') .
                                            ' - ' .
                                            ($posData['department_name'] ?? '-'),
                                        );
                                        $talentNames = $posData['talents']->pluck('nama')->filter()->implode(', ');
                                    @endphp
                                    @foreach ($posData['talents'] as $index => $talent)
                                        <tr
                                            class="group-hover:bg-teal-50/50 transition duration-150 {{ $loop->last ? 'border-b border-gray-200' : '' }}">
                                            @if ($index === 0)
                                                <td rowspan="{{ count($posData['talents']) }}" class="px-5 py-4"
                                                    style="text-align:center; vertical-align:middle;">
                                                    <div class="flex flex-col items-center justify-center gap-2 px-4 py-2">
                                                        <div
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-teal-200/60 bg-teal-50/50">
                                                            <span
                                                                class="font-bold text-teal-900 text-sm leading-none">{{ $posData['targetPosition']->position_name ?? '-' }}</span>
                                                        </div>
                                                        <span class="text-[11px] text-slate-500 font-medium">{{ $periodLabel }}</span>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                                <div style="display: inline-block; text-align: center; width: 100%;">
                                                    <div class="font-bold text-sm text-slate-800 leading-tight">
                                                        {{ $talent->nama }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 font-medium mt-1">
                                                        {{ optional($talent->position)->position_name ?? 'Officer' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                                <span
                                                    class="text-sm text-slate-700">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                                            </td>
                                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                                <div class="flex flex-col gap-1.5 items-center justify-center">
                                                    @php
                                                        $mentorIds =
                                                            optional($talent->promotion_plan)->mentor_ids ?? [];
                                                        $mentorList = [];
                                                        if (!empty($mentorIds)) {
                                                            $mentorList = \App\Models\User::whereIn('id', $mentorIds)
                                                                ->pluck('nama')
                                                                ->toArray();
                                                        } elseif (optional($talent->mentor)->nama) {
                                                            $mentorList = [optional($talent->mentor)->nama];
                                                        }
                                                    @endphp
                                                    @forelse($mentorList as $mn)
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[0.75rem] font-semibold text-blue-700 bg-blue-50 border border-blue-200 whitespace-nowrap">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            {{ $mn }}
                                                        </span>
                                                    @empty
                                                        <span class="text-slate-400 text-sm italic">-</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                                <div class="flex flex-col gap-1.5 items-center justify-center">
                                                    @php $atasanName = optional($talent->atasan)->nama; @endphp
                                                    @if ($atasanName)
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[0.75rem] font-semibold text-purple-700 bg-purple-50 border border-purple-200 whitespace-nowrap">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-purple-500"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path
                                                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                                            </svg>
                                                            {{ $atasanName }}
                                                        </span>
                                                    @else
                                                        <span class="text-sm text-slate-700">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            @if ($index === 0)
                                                <td rowspan="{{ count($posData['talents']) }}" class="px-5 py-4"
                                                    style="vertical-align:middle;">
                                                    <div class="flex flex-col gap-1.5 py-1 w-full max-w-[120px] mx-auto">
                                                        <a href="{{ route('pdc_admin.detail', $detailRouteParams) }}"
                                                            class="btn-prem btn-teal inline-flex items-center justify-center h-9 w-full px-2"
                                                            style="margin: 0; font-size: 11px; white-space: nowrap;">
                                                            Lihat Detail
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 ml-1 shrink-0"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </a>
                                                        <div class="grid grid-cols-2 gap-1.5 w-full">
                                                            <a href="{{ route('pdc_admin.development_plan.edit', $detailRouteParams) }}"
                                                                class="inline-flex h-9 w-full items-center justify-center rounded-lg bg-blue-500 hover:bg-blue-600 border border-blue-600 hover:border-blue-700 transition-colors shadow-sm"
                                                                title="Edit development plan">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </a>
                                                            <button type="button"
                                                                class="inline-flex h-9 w-full items-center justify-center rounded-lg border border-red-500 bg-[#ef4444] text-white transition hover:bg-[#dc2626]"
                                                                title="Hapus progress talent"
                                                                wire:click="openDeleteModal('{{ route('pdc_admin.development_plan.destroy', $detailRouteParams) }}', '{{ addslashes($groupLabel) }}', '{{ addslashes($talentNames) }}')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6 7.5h12M9.75 7.5V6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v1.5m-7.5 0v10.125A1.875 1.875 0 008.625 19.5h6.75a1.875 1.875 0 001.875-1.875V7.5M10.5 10.5v5.25m3-5.25v5.25" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            @empty
                <div class="empty-prem">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto"
                        style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <h3>{{ $search ? 'Tidak Ada Data Talent' : 'Belum Ada Data Talent' }}</h3>
                    <p>{{ $search ? 'Tidak ada data progress talent yang cocok dengan pencarian Anda.' : 'Data akan muncul setelah talent memiliki development plan aktif.' }}
                    </p>
                </div>
            @endforelse
        </div>{{-- /progress-talent-wrapper --}}
    </div>

    {{-- Delete Confirmation Modal (handled via Livewire property, not JS) --}}
    @if ($showDeleteModal)
        <div class="delete-modal-backdrop" wire:click.self="$set('showDeleteModal', false)">
            <div class="delete-modal-panel">
                <div class="px-6 pt-6 pb-4">
                    <div
                        class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m0 3h.008v.008H12v-.008Zm-7.938 4.5h15.876c1.54 0 2.502-1.667 1.732-3L13.732 4.5c-.77-1.333-2.694-1.333-3.464 0L2.33 17.25c-.77 1.333.192 3 1.732 3Z" />
                        </svg>
                    </div>
                    <h3 class="text-center text-lg font-bold text-slate-800">Hapus Progress Talent?</h3>
                    <p class="mt-2 text-center text-sm leading-6 text-slate-500">
                        Progress talent untuk posisi <span
                            class="font-semibold text-slate-700">{{ $deletePositionName }}</span> dengan nama talent
                        <span class="font-semibold text-slate-700">{{ $deleteTalentNames }}</span> akan dihapus.
                        Tindakan ini tidak bisa dibatalkan.
                    </p>
                </div>
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        wire:click="$set('showDeleteModal', false)">
                        Batal
                    </button>
                    <form action="{{ $deleteAction }}" method="POST" id="livewire-delete-progress-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>