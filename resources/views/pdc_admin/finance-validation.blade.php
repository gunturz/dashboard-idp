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

            .card-default {
                border-color: #0d9488;
            }

            .card-default .stat-number {
                color: #0d9488;
            }

            .card-pending {
                border-color: #f59e0b;
            }

            .card-pending .stat-number {
                color: #f59e0b;
            }

            .card-approved {
                border-color: #22c55e;
            }

            .card-approved .stat-number {
                color: #22c55e;
            }

            .card-rejected {
                border-color: #ef4444;
            }

            .card-rejected .stat-number {
                color: #ef4444;
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

            .fv-table th:last-child {
                border-right: none;
            }

            .fv-table td {
                padding: 16px 20px;
                font-size: 0.875rem;
                color: #475569;
                text-align: center;
                border-top: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }

            .fv-table td:last-child {
                border-right: none;
            }

            .fv-table tbody tr:hover {
                background: #fafafa;
            }

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

            .status-approve::before {
                background: #22c55e;
            }

            .status-pending::before {
                background: #f59e0b;
            }

            .status-rejected::before {
                background: #ef4444;
            }

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

            .btn-reject:hover {
                background: #fef2f2;
            }

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

            .btn-approve:hover {
                background: #f0fdf4;
            }

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

            .file-link:hover {
                color: #2563eb;
                text-decoration: underline;
            }
        </style>
    </x-slot>

    <div class="flex items-center gap-2 mb-8 px-2 animate-title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-[#2e3746]">
            <path
                d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
            <path fill-rule="evenodd"
                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z"
                clip-rule="evenodd" />
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
                    <th style="width: 25%;">Feedback</th>
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
                            @if ($project->document_path)
                                <a href="{{ asset('storage/' . $project->document_path) }}" target="_blank"
                                    class="file-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td>
                            @if ($project->status === 'Verified')
                                <span class="status-dot status-approve">Approved</span>
                            @elseif($project->status === 'Rejected')
                                <span class="status-dot status-rejected">Rejected</span>
                            @else
                                <span class="status-dot status-pending">Pending</span>
                            @endif
                        </td>
                        <td class="text-left text-xs text-gray-600">{{ $project->feedback ?? '—' }}</td>
                        <td>
                            @if (in_array($project->status, ['Verified', 'Rejected']))
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
                        <td colspan="6" class="py-12 text-gray-400 text-sm text-center">Belum ada permintaan
                            validasi.</td>
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
                'Pilih status untuk Project Improvemen <strong>' + talentName +
                '</strong>.<br>Tindakan ini akan langsung memperbarui sistem pada Talent';
            document.getElementById('rejectForm').action = actionUrl;
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
