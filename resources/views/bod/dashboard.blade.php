<x-bod.layout title="Dashboard BOD – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .company-header {
                font-size: 1rem;
                font-weight: 700;
                color: #334155;
                margin-bottom: 0;
                padding: 16px;
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                text-align: center;
            }

            .bod-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
            }

            .bod-table th {
                background: #ffffff;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 12px 16px;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                font-size: 0.875rem;
                text-transform: capitalize;
                white-space: nowrap;
            }
            .bod-table th:last-child {
                border-right: none;
            }

            .bod-table td {
                text-align: center;
                padding: 14px 16px;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
            }
            .bod-table td:last-child {
                border-right: none;
            }
            
            .bod-table tr:last-child td {
                border-bottom: none;
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

            .company-table-wrapper {
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                overflow: hidden;
                margin-bottom: 24px;
            }
            .company-table-wrapper:last-child {
                margin-bottom: 0;
            }

            .btn-detail {
                color: #14b8a6;
                font-size: 0.8rem;
                font-weight: 600;
                text-decoration: none;
                transition: color 0.2s;
            }
            .btn-detail:hover {
                color: #0d9488;
                text-decoration: underline;
            }

            .highlight-container {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                padding: 16px;
                border: 1px solid #e2e8f0;
            }
        </style>
    </x-slot>

    {{-- Title --}}
    <div class="flex items-center gap-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
        </svg>
        <h2 class="text-2xl font-extrabold text-[#2e3746] animate-title">Dashboard</h2>
    </div>

    {{-- Tables grouped by Company --}}
    <div class="highlight-container">
        @forelse($groupedData as $companyId => $companyData)
            <div class="company-table-wrapper">
                <h4 class="company-header">{{ $companyData['company']->nama_company ?? 'Unassigned' }}</h4>
                <div class="overflow-x-auto">
                    <table class="bod-table">
                        <thead>
                            <tr>
                                <th class="w-[16%]">Posisi yang Dituju</th>
                                <th class="w-[16%]">Talent</th>
                                <th class="w-[16%]">Departemen</th>
                                <th class="w-[16%]">Mentor</th>
                                <th class="w-[16%]">Atasan</th>
                                <th class="w-[16%]">Aksi</th>
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
                                        <td>
                                            <a href="{{ route('bod.detail_talent', $talent->id) }}" class="btn-detail">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-400">
                Belum ada data progress talent.
            </div>
        @endforelse
    </div>

</x-bod.layout>
