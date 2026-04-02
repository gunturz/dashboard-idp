<x-pdc_admin.layout title="Dashboard PDC Admin – Individual Development Plan" :user="$user">
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

            .pdc-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
            }

            .pdc-table th {
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
            .pdc-table th:last-child {
                border-right: none;
            }

            .pdc-table td {
                text-align: center;
                padding: 14px 16px;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
            }
            .pdc-table td:last-child {
                border-right: none;
            }
            
            .pdc-table tr:last-child td {
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

            .summary-card {
                background: white;
                border-radius: 12px;
                padding: 24px;
                text-align: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: 140px;
                border: 2px solid transparent; /* default */
            }

            .summary-value {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 8px;
            }

            .summary-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
            }
            
            /* Specific Card Colors */
            .card-teal { border-color: #0d9488; }
            .card-teal .summary-value { color: #0d9488; }
            
            .card-green { border-color: #22c55e; }
            .card-green .summary-value { color: #22c55e; }
            
            .card-red { border-color: #ef4444; }
            .card-red .summary-value { color: #ef4444; }

            .section-title {
                font-size: 1.125rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 16px;
            }

            .role-list-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 16px 24px;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                margin-bottom: 12px;
                font-weight: 600;
                color: #334155;
                box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            }
            
            .role-list-value {
                color: #64748b;
                font-weight: 500;
            }

            .highlight-container {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                padding: 16px;
                border: 1px solid #e2e8f0;
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
        </style>
    </x-slot>

    {{-- Title --}}
    <div class="flex items-center gap-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
        </svg>
        <h2 class="text-2xl font-extrabold text-[#2e3746] animate-title">Dashboard</h2>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <a href="{{ route('pdc_admin.user_management') }}" class="summary-card card-teal hover:shadow-lg hover:bg-gray-100 transition-shadow duration-200">
            <div class="summary-value">{{ $totalUsers ?? 0 }}</div>
            <div class="summary-label">Total User</div>
        </a>
        <a href="{{ route('pdc_admin.progress_talent') }}" class="summary-card card-teal hover:shadow-lg hover:bg-gray-100 transition-shadow duration-200">
            <div class="summary-value">{{ $onProgressTalent ?? 0 }}</div>
            <div class="summary-label">On Progress</div>
        </a>
        <a href="{{ route('pdc_admin.finance_validation') }}" class="summary-card card-green hover:shadow-lg hover:bg-gray-100 transition-shadow duration-200">
            <div class="summary-value">{{ $pendingFinance ?? 0 }}</div>
            <div class="summary-label">Pending Finance Validation</div>
        </a>
        <div class="summary-card card-red hover:shadow-lg hover:bg-gray-100 transition-shadow duration-200">
            <div class="summary-value">{{ $pendingBOD ?? 0 }}</div>
            <div class="summary-label">Pending BOD Decision</div>
        </div>
    </div>

    {{-- Recent Highlight Progress --}}
    <div class="mb-10">
        <h3 class="section-title">Recent Highlight Progress</h3>
        
        <div class="highlight-container">
            @forelse($groupedData as $companyId => $companyData)
                <div class="company-table-wrapper">
                    <h4 class="company-header">{{ $companyData['company']->nama_company ?? 'Unassigned' }}</h4>
                    <div class="overflow-x-auto">
                        <table class="pdc-table">
                            <thead>
                                <tr>
                                    <th class="w-[20%]">Posisi yang Dituju</th>
                                    <th class="w-[20%]">Talent</th>
                                    <th class="w-[20%]">Departemen</th>
                                    <th class="w-[20%]">Mentor</th>
                                    <th class="w-[20%]">Atasan</th>
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
    </div>

    {{-- Total User by Role --}}
    <div>
        <h3 class="section-title">Total User by Role</h3>
        <div class="highlight-container bg-[#f8fafc] border-none shadow-none p-4">
            <div class="role-list-item">
                <span>Talent</span>
                <span class="role-list-value">{{ $roleCounts['Talent'] ?? 0 }} Users</span>
            </div>
            <div class="role-list-item">
                <span>Mentor</span>
                <span class="role-list-value">{{ $roleCounts['Mentor'] ?? 0 }} Users</span>
            </div>
            <div class="role-list-item">
                <span>Atasan</span>
                <span class="role-list-value">{{ $roleCounts['Atasan'] ?? 0 }} Users</span>
            </div>

            <div class="role-list-item">
                <span>Finance</span>
                <span class="role-list-value">{{ $roleCounts['Finance'] ?? 0 }} Users</span>
            </div>
            <div class="role-list-item">
                <span>BOD</span>
                <span class="role-list-value">{{ $roleCounts['BOD'] ?? 0 }} Users</span>
            </div>
        </div>
    </div>
</x-pdc_admin.layout>
