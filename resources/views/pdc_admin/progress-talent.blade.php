<x-pdc_admin.layout title="Progress Talent - Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .talent-row.group-hovered td {
                background: #f0fdfa !important;
            }

            .delete-modal-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
                z-index: 60;
            }

            .delete-modal-panel {
                width: 100%;
                max-width: 420px;
                background: white;
                border-radius: 20px;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22);
                border: 1px solid #e2e8f0;
                overflow: hidden;
            }
        </style>
    </x-slot>

    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"/>
                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"/>
            </svg>
        </div>
        <div>
            <div class="page-header-title">Progress Talent</div>
            <div class="page-header-sub">Pantau perkembangan seluruh talent aktif</div>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pdc_admin.development_plan') }}" class="btn-prem btn-dark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Development Plan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 px-5 py-3.5 bg-green-50 border border-green-300 text-green-700 text-sm font-semibold rounded-xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @php
        $totalCompany = count($groupedData);
        $totalTalent = 0;
        $totalPositions = 0;
        foreach ($groupedData as $compData) {
            $totalPositions += count($compData['positions']);
            foreach ($compData['positions'] as $posData) {
                $totalTalent += count($posData['talents']);
            }
        }
    @endphp

    <div class="prem-stat-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalTalent }}</div>
            <div class="prem-stat-label">Total Talent Aktif</div>
        </div>
        <div class="prem-stat prem-stat-blue">
            <div class="prem-stat-icon si-blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalCompany }}</div>
            <div class="prem-stat-label">Perusahaan Terlibat</div>
        </div>
        <div class="prem-stat prem-stat-purple">
            <div class="prem-stat-icon si-purple">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $totalPositions }}</div>
            <div class="prem-stat-label">Target Posisi</div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
        <div class="relative w-full sm:w-[40%]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent..."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                oninput="filterProgressTalent()">
        </div>
        <button type="button" onclick="resetProgressFilters()" class="btn-prem btn-ghost w-full sm:w-auto mt-2 sm:mt-0" id="reset-filter-btn" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </button>
    </div>

    @forelse ($groupedData as $companyId => $companyData)
        <div class="mb-8 company-section">
            <h3 class="company-section-title">{{ $companyData['company']->nama_company ?? 'Unassigned' }}</h3>
            <div class="prem-card">
                <div class="overflow-x-auto">
                    <table class="prem-table">
                        <thead>
                            <tr>
                                <th class="w-[18%] text-left pl-6">Posisi yang Dituju</th>
                                <th class="w-[18%]">Talent</th>
                                <th class="w-[16%]">Departemen</th>
                                <th class="w-[16%]">Mentor</th>
                                <th class="w-[14%]">Atasan</th>
                                <th class="w-[18%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companyData['positions'] as $positionId => $posData)
                                @foreach ($posData['talents'] as $index => $talent)
                                    <tr class="talent-row"
                                        data-name="{{ strtolower($talent->nama) }}"
                                        data-pos-group="{{ $companyId }}-{{ $positionId }}">
                                        @if ($index === 0)
                                            <td rowspan="{{ count($posData['talents']) }}" class="text-left pl-6 border-r border-[#f1f5f9] position-cell">
                                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-teal-200/60 bg-teal-50/50">
                                                    <span class="font-bold text-teal-900 text-sm leading-none">{{ $posData['targetPosition']->position_name ?? '-' }}</span>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <span class="font-bold text-[#1e293b] block text-sm">{{ $talent->nama }}</span>
                                            <span class="text-xs text-[#64748b] italic block mt-0.5">{{ optional($talent->position)->position_name ?? 'Officer' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-[#475569] bg-slate-50 px-3 py-1.5 rounded-md border border-slate-100 whitespace-nowrap">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="flex flex-col gap-1.5 items-center justify-center">
                                                @php
                                                    $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                                                    if (!empty($mentorIds)) {
                                                        $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->toArray();
                                                        foreach ($mentorNames as $mn) {
                                                            echo '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[0.75rem] font-semibold text-blue-700 bg-blue-50 border border-blue-200 whitespace-nowrap"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>' . $mn . '</span>';
                                                        }
                                                    } else {
                                                        $mn = optional($talent->mentor)->nama;
                                                        if ($mn) {
                                                            echo '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[0.75rem] font-semibold text-blue-700 bg-blue-50 border border-blue-200 whitespace-nowrap"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>' . $mn . '</span>';
                                                        } else {
                                                            echo '<span class="text-slate-400 text-sm italic">-</span>';
                                                        }
                                                    }
                                                @endphp
                                            </div>
                                        </td>
                                        <td>
                                            @php $atasanName = optional($talent->atasan)->nama; @endphp
                                            @if($atasanName)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[0.75rem] font-semibold text-purple-700 bg-purple-50 border border-purple-200 whitespace-nowrap"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-purple-500" viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>{{ $atasanName }}</span>
                                            @else
                                                <span class="text-slate-400 text-sm italic">-</span>
                                            @endif
                                        </td>
                                        @if ($index === 0)
                                            <td rowspan="{{ count($posData['talents']) }}" class="action-cell">
                                                <div class="flex flex-col gap-1.5 py-1 w-full max-w-[120px] mx-auto">
                                                    <a href="{{ route('pdc_admin.detail', ['company_id' => $companyId, 'position_id' => $positionId]) }}"
                                                        class="btn-prem btn-teal text-xs inline-flex items-center justify-center h-9 w-full" style="margin: 0; padding: 0;">
                                                        Lihat Detail
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 ml-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg>
                                                    </a>
                                                    <div class="grid grid-cols-2 gap-1.5 w-full">
                                                        <a href="{{ route('pdc_admin.development_plan.edit', ['company_id' => $companyId, 'position_id' => $positionId]) }}"
                                                            class="inline-flex h-9 w-full items-center justify-center rounded-lg bg-[#f7f1e4] text-[#334155] transition hover:bg-[#e5dfcf]"
                                                            title="Edit development plan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L7.5 20.212 3 21l.788-4.5L16.862 4.487z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 6.75l2.25 2.25" />
                                                            </svg>
                                                        </a>
                                                        <button type="button"
                                                            class="inline-flex h-9 w-full items-center justify-center rounded-lg border border-red-500 bg-[#ef4444] text-white transition hover:bg-[#dc2626]"
                                                            title="Hapus progress talent"
                                                            onclick="openDeleteModal('{{ route('pdc_admin.development_plan.destroy', ['company_id' => $companyId, 'position_id' => $positionId]) }}', '{{ $posData['targetPosition']->position_name ?? '-' }}')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12M9.75 7.5V6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v1.5m-7.5 0v10.125A1.875 1.875 0 008.625 19.5h6.75a1.875 1.875 0 001.875-1.875V7.5M10.5 10.5v5.25m3-5.25v5.25" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-prem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            <h3>Belum Ada Data Talent</h3>
            <p>Data akan muncul setelah talent memiliki development plan aktif.</p>
        </div>
    @endforelse

    <div id="delete-progress-modal" class="delete-modal-backdrop hidden" onclick="handleDeleteBackdrop(event)">
        <div class="delete-modal-panel">
            <div class="px-6 pt-6 pb-4">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3h.008v.008H12v-.008Zm-7.938 4.5h15.876c1.54 0 2.502-1.667 1.732-3L13.732 4.5c-.77-1.333-2.694-1.333-3.464 0L2.33 17.25c-.77 1.333.192 3 1.732 3Z" />
                    </svg>
                </div>
                <h3 class="text-center text-lg font-bold text-slate-800">Hapus Progress Talent?</h3>
                <p class="mt-2 text-center text-sm leading-6 text-slate-500">
                    Progress talent untuk posisi <span id="delete-progress-position" class="font-semibold text-slate-700">-</span> akan dihapus.
                    Tindakan ini tidak bisa dibatalkan.
                </p>
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                    onclick="closeDeleteModal()">
                    Batal
                </button>
                <form id="delete-progress-form" method="POST">
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

    <x-slot name="scripts">
        <script>
            function openDeleteModal(action, positionName) {
                const modal = document.getElementById('delete-progress-modal');
                const form = document.getElementById('delete-progress-form');
                const positionLabel = document.getElementById('delete-progress-position');

                form.action = action;
                positionLabel.textContent = positionName || '-';
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeDeleteModal() {
                const modal = document.getElementById('delete-progress-modal');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            function handleDeleteBackdrop(event) {
                if (event.target.id === 'delete-progress-modal') {
                    closeDeleteModal();
                }
            }

            function filterProgressTalent() {
                const search = document.getElementById('live-search-input').value.toLowerCase();
                const rows = document.querySelectorAll('.talent-row');
                const resetBtn = document.getElementById('reset-filter-btn');

                resetBtn.style.display = search ? 'inline-flex' : 'none';

                const matchingGroups = new Set();
                if (search) {
                    rows.forEach(row => {
                        if (row.dataset.name.includes(search)) {
                            matchingGroups.add(row.dataset.posGroup);
                        }
                    });
                }

                const groupVisibility = {};

                rows.forEach(row => {
                    const groupKey = row.dataset.posGroup;
                    const isVisible = !search || matchingGroups.has(groupKey);

                    if (isVisible) {
                        row.style.display = '';
                        if (!groupVisibility[groupKey]) groupVisibility[groupKey] = [];
                        groupVisibility[groupKey].push(row);
                    } else {
                        row.style.display = 'none';
                    }
                });

                for (const groupKey in groupVisibility) {
                    const visibleRows = groupVisibility[groupKey];
                    const firstRow = visibleRows[0];

                    const allInGroup = document.querySelectorAll(`.talent-row[data-pos-group="${groupKey}"]`);
                    allInGroup.forEach(r => {
                        const posCell = r.querySelector('.position-cell');
                        const accCell = r.querySelector('.action-cell');
                        if (posCell) posCell.style.display = 'none';
                        if (accCell) accCell.style.display = 'none';
                    });

                    let posCell = firstRow.querySelector('.position-cell');
                    if (!posCell) {
                        posCell = allInGroup[0].querySelector('.position-cell');
                        if (posCell) firstRow.prepend(posCell);
                    }

                    if (posCell) {
                        posCell.style.display = '';
                        posCell.setAttribute('rowspan', visibleRows.length);
                    }

                    let accCell = firstRow.querySelector('.action-cell');
                    if (!accCell) {
                        accCell = allInGroup[0].querySelector('.action-cell');
                        if (accCell) firstRow.appendChild(accCell);
                    }

                    if (accCell) {
                        accCell.style.display = '';
                        accCell.setAttribute('rowspan', visibleRows.length);
                    }
                }

                document.querySelectorAll('.company-section').forEach(section => {
                    const hasVisible = section.querySelector('.talent-row[style="display: ;"]') ||
                        section.querySelector('.talent-row:not([style*="display: none"])');
                    section.style.display = hasVisible ? '' : 'none';
                });
            }

            function resetProgressFilters() {
                document.getElementById('live-search-input').value = '';
                filterProgressTalent();
            }

            function initGroupHover() {
                const rows = document.querySelectorAll('.talent-row');
                rows.forEach(row => {
                    row.addEventListener('mouseenter', () => {
                        const group = row.dataset.posGroup;
                        if (!group) return;
                        document.querySelectorAll(`.talent-row[data-pos-group="${group}"]`).forEach(r => {
                            r.classList.add('group-hovered');
                        });
                    });
                    row.addEventListener('mouseleave', () => {
                        const group = row.dataset.posGroup;
                        if (!group) return;
                        document.querySelectorAll(`.talent-row[data-pos-group="${group}"]`).forEach(r => {
                            r.classList.remove('group-hovered');
                        });
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                initGroupHover();

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeDeleteModal();
                    }
                });
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>
