<x-pdc_admin.layout title="Finance Validation – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            /* Summary Cards */
            .stat-card {
                background: #f0f2f5;
                border-radius: 16px;
                padding: 28px 24px 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-width: 170px;
                flex: 1;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            }

            .stat-card .stat-number {
                font-size: 2.8rem;
                font-weight: 800;
                color: #2e3746;
                line-height: 1;
                margin-bottom: 12px;
            }

            .stat-card .stat-label {
                font-size: 0.82rem;
                font-weight: 500;
                color: #64748b;
            }

            /* Table */
            .fv-table-wrapper {
                border: 1.5px solid #e2e8f0;
                border-radius: 14px;
                overflow-x: auto;
            }

            .fv-table-title {
                padding: 18px 24px;
                font-size: 1rem;
                font-weight: 700;
                color: #2e3746;
                white-space: nowrap;
            }

            .fv-table {
                width: 100%;
                border-collapse: collapse;
            }

            .fv-table thead tr {
                background: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }

            .fv-table th {
                padding: 14px 20px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #2e3746;
                text-align: center;
                border-right: 1px solid #f1f5f9;
            }

            .fv-table th:last-child { border-right: none; }

            .fv-table td {
                padding: 16px 20px;
                font-size: 0.875rem;
                color: #475569;
                text-align: center;
                border-top: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }

            .fv-table td:last-child { border-right: none; }

            .fv-table tbody tr:hover { background: #fafafa; }

            /* Status badges */
            .status-dot {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.825rem;
                font-weight: 600;
            }
            .status-dot::before {
                content: '';
                width: 9px;
                height: 9px;
                border-radius: 50%;
                flex-shrink: 0;
            }
            .status-approve::before { background: #22c55e; }
            .status-pending::before  { background: #f59e0b; }
            .status-rejected::before { background: #ef4444; }

            /* Action buttons */
            .btn-reject {
                padding: 6px 18px;
                border: 1.5px solid #ef4444;
                color: #ef4444;
                background: white;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                transition: all .15s;
            }
            .btn-reject:hover { background: #fef2f2; }

            .btn-approve {
                padding: 6px 18px;
                border: 1.5px solid #22c55e;
                color: #22c55e;
                background: white;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                transition: all .15s;
            }
            .btn-approve:hover { background: #f0fdf4; }

            .file-link {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 0.8rem;
                color: #3b82f6;
                text-decoration: none;
                font-weight: 500;
                transition: color .15s;
            }
            .file-link:hover { color: #2563eb; text-decoration: underline; }
        </style>
    </x-slot>

    <div class="flex items-center gap-2 mb-8 px-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.028 2.353 1.118V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.028-2.354-1.118V5z" clip-rule="evenodd" />
        </svg>
        <h2 class="text-2xl font-bold text-[#2e3746] animate-title">Finance Validation</h2>
    </div>

    {{-- Summary Cards --}}
    <div class="flex flex-wrap gap-5 mb-10">
        <div class="stat-card">
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #f59e0b;">{{ $pending }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #22c55e;">{{ $approved }}</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #ef4444;">{{ $rejected }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="fv-table-wrapper">
        <div class="fv-table-title">Daftar Permintaan Validasi</div>
        <table class="fv-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Talent</th>
                    <th style="width: 15%;">Judul Project Improvement</th>
                    <th>File</th>
                    <th>Catatan</th>
                    <th>Feedback dari Finance</th>
                    <th>Validasi Finance</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td class="px-6 py-4 border-r border-gray-300 text-center">
                            <p class="font-bold text-gray-800 text-sm">{{ $project->talent->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->position->position_name ?? '-' }} &rarr; {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">{{ $project->talent->department->nama_department ?? '-' }}</p>
                        </td>
                        <td class="text-left">{{ $project->title }}</td>
                        <td>
                            @if($project->document_path)
                                <a href="{{ asset('storage/' . $project->document_path) }}" target="_blank" class="file-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Lihat File
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="text-left text-xs">{{ $project->feedback ?? '—' }}</td>
                        <td class="text-left text-xs">{{ $project->finance_feedback ?? '—' }}</td>
                        <td>
                            @if($project->status === 'Verified')
                                <span class="status-dot status-approve">Approve</span>
                            @elseif($project->status === 'Pending')
                                <span class="status-dot status-pending">Pending</span>
                            @elseif($project->status === 'Rejected')
                                <span class="status-dot status-rejected">Rejected</span>
                            @else
                                <span class="status-dot status-pending">{{ $project->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-2">
                                <form method="POST" action="{{ route('pdc_admin.finance_validation.update', $project->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="btn-reject">Rejected</button>
                                </form>
                                <form method="POST" action="{{ route('pdc_admin.finance_validation.update', $project->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="Verified">
                                    <button type="submit" class="btn-approve">Approved</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-gray-400 text-sm text-center">Belum ada permintaan validasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-pdc_admin.layout>
