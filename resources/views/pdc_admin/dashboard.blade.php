<x-pdc_admin.layout title="Dashboard PDC Admin – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .company-header {
                font-size: 1.125rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 12px;
                margin-top: 32px;
                padding-left: 4px;
            }

            .pdc-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                border: 1px solid #e2e8f0;
            }

            .pdc-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.875rem;
                text-transform: capitalize;
                white-space: nowrap;
            }

            .pdc-table td {
                text-align: center;
                padding: 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
                white-space: nowrap;
            }

            .target-position {
                font-weight: 700;
                color: #1e293b;
                display: block;
                font-size: 0.95rem;
            }

            .target-dept {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 2px;
            }

            .talent-name {
                font-weight: 700;
                color: #1e293b;
                display: block;
            }

            .talent-role {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
                display: block;
            }

            .action-link {
                color: #64748b;
                font-size: 0.75rem;
                text-decoration: none;
                transition: color 0.2s;
            }

            .action-link:hover {
                color: #0d9488;
                text-decoration: underline;
            }
        </style>
    </x-slot>

    <div class="flex items-center gap-3 mb-8">
        <div class="p-1.5 bg-gray-100 rounded-md border border-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-[#2e3746] animate-title">Progress Talent</h2>
    </div>

    @foreach($groupedData as $companyId => $companyData)
        <div class="mb-10">
            <h3 class="company-header">{{ $companyData['company']->nama_company ?? 'Unassigned' }}</h3>
            <div class="overflow-x-auto shadow-sm rounded-xl">
                <table class="pdc-table">
                    <thead>
                        <tr>
                            <th class="w-[20%]">Posisi yang Dituju</th>
                            <th class="w-[20%]">Talent</th>
                            <th class="w-[15%]">Departemen</th>
                            <th class="w-[15%]">Mentor</th>
                            <th class="w-[15%]">Atasan</th>
                            <th class="w-[15%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companyData['positions'] as $positionId => $posData)
                            @foreach($posData['talents'] as $index => $talent)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ count($posData['talents']) }}" class="bg-white">
                                            <span class="target-position">
                                                {{ $posData['targetPosition']->position_name ?? '-' }}
                                            </span>
                                            <span class="target-dept">
                                                {{ optional($posData['targetPosition']->department ?? null)->nama_department ?? optional($talent->department)->nama_department ?? '-' }}
                                            </span>
                                        </td>
                                    @endif
                                    <td>
                                        <span class="talent-name">{{ $talent->nama }}</span>
                                        <span class="talent-role">{{ optional($talent->position)->position_name ?? 'Officer' }}</span>
                                    </td>
                                    @if($index === 0)
                                        <td rowspan="{{ count($posData['talents']) }}" class="bg-white">
                                            {{ optional($talent->department)->nama_department ?? '-' }}
                                        </td>
                                    @endif
                                    <td>
                                        @php
                                            $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                                            if (!empty($mentorIds)) {
                                                $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->toArray();
                                                echo implode('<br>', $mentorNames) ?: '-';
                                            } else {
                                                echo optional($talent->mentor)->nama ?? '-';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ optional($talent->atasan)->nama ?? '-' }}</td>
                                    @if($index === 0)
                                        <td rowspan="{{ count($posData['talents']) }}" class="bg-white text-center">
                                            @if($positionId != 0)
                                                <a href="{{ route('pdc_admin.detail', ['company_id' => $companyId, 'position_id' => $positionId]) }}" class="action-link">Lihat Detail</a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    @if($groupedData->isEmpty())
        <div class="bg-white p-12 rounded-xl border border-dashed border-gray-300 text-center">
            <p class="text-gray-400">Belum ada data talent yang terdaftar.</p>
        </div>
    @endif
</x-pdc_admin.layout>
