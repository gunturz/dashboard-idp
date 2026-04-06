<x-pdc_admin.layout title="Finance Validation – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            /* Summary Cards */
            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 24px;
                text-align: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 140px;
                border: 2px solid transparent;
            }

            .stat-card .stat-number {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 8px;
                color: #2e3746;
            }

            .stat-card .stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
            }

            .card-default { border-color: #0d9488; }
            .card-default .stat-number { color: #0d9488; }
            .card-pending  { border-color: #f59e0b; }
            .card-pending .stat-number  { color: #f59e0b; }
            .card-approved { border-color: #22c55e; }
            .card-approved .stat-number { color: #22c55e; }
            .card-rejected { border-color: #ef4444; }
            .card-rejected .stat-number { color: #ef4444; }

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
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="stat-card card-default">
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card card-pending">
            <div class="stat-number">{{ $pending }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card card-approved">
            <div class="stat-number">{{ $approved }}</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card card-rejected">
            <div class="stat-number">{{ $rejected }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="fv-table-wrapper">
        <div class="fv-table-title">Daftar Permintaan Validasi</div>
        <table class="fv-table">
            <thead>
                <tr>
                    <th style="width: 16%;">Talent</th>
                    <th style="width: 22%;">Judul Project Improvement</th>
                    <th style="width: 7%;">File</th>
                    <th style="width: 14%;">Validasi Finance</th>
                    <th style="width: 25%;">Feedback dari Finance</th>
                    <th style="width: 16%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>
                            <p class="font-bold text-gray-800 text-sm">{{ $project->talent->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-500 italic mt-1">
                                {{ $project->talent->position->position_name ?? '-' }}
                                &rarr;
                                {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}
                            </p>
                        </td>
                        <td class="text-left">{{ $project->title }}</td>
                        <td>
                            @if($project->document_path)
                                <a href="{{ asset('storage/' . $project->document_path) }}" target="_blank" class="file-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td>
                            @if($project->status === 'Verified')
                                <span class="status-dot status-approve">Approved</span>
                            @elseif($project->status === 'Rejected')
                                <span class="status-dot status-rejected">Rejected</span>
                            @else
                                <span class="status-dot status-pending">Pending</span>
                            @endif
                        </td>
                        <td class="text-left text-xs text-gray-600">{{ $project->finance_feedback ?? '—' }}</td>
                        <td>
                            @if(in_array($project->status, ['Verified', 'Rejected']))
                                <button type="button" disabled
                                    class="w-full px-4 py-2 text-sm font-semibold text-gray-400 bg-white border border-gray-300 rounded-lg cursor-default">
                                    Sudah Dipilih
                                </button>
                            @else
                                <button type="button"
                                    onclick="openActionModal({{ $project->id }}, '{{ addslashes($project->talent->nama ?? '-') }}', '{{ route('pdc_admin.finance_validation.update', $project->id) }}')"
                                    class="w-full px-4 py-2 text-sm font-semibold text-white bg-[#F5A623] hover:bg-[#e0961e] rounded-lg transition-colors shadow-sm">
                                    Pilih Aksi
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-gray-400 text-sm text-center">Belum ada permintaan validasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Action Modal --}}
    <div id="actionModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-[420px] shadow-2xl p-8 flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full bg-[#E5B224] flex items-center justify-center mb-5">
                <span class="text-white text-5xl font-bold">!</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">Update Status?</h3>
            <p class="text-gray-500 text-sm mb-7" id="actionModalDesc"></p>

            <div class="flex gap-3 w-full mb-3">
                <form id="rejectForm" method="POST" action="" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Rejected">
                    <button type="submit"
                        class="w-full py-3 text-sm font-bold text-white bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors shadow-sm">
                        Reject
                    </button>
                </form>
                <form id="approveForm" method="POST" action="" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Verified">
                    <button type="submit"
                        class="w-full py-3 text-sm font-bold text-white bg-[#22c55e] hover:bg-[#16a34a] rounded-xl transition-colors shadow-sm">
                        Approve
                    </button>
                </form>
            </div>
            <button type="button" onclick="closeActionModal()"
                class="w-full py-3 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                Batal
            </button>
        </div>
    </div>

    <script>
        function openActionModal(projectId, talentName, actionUrl) {
            document.getElementById('actionModalDesc').innerHTML =
                'Pilih status untuk Project Improvemen <strong>' + talentName + '</strong>.<br>Tindakan ini akan langsung memperbarui sistem pada Talent';
            document.getElementById('rejectForm').action  = actionUrl;
            document.getElementById('approveForm').action = actionUrl;

            const modal = document.getElementById('actionModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeActionModal() {
            const modal = document.getElementById('actionModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }
    </script>

</x-pdc_admin.layout>
