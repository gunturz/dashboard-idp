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
                    <th style="width: 3%;">Validasi Finance</th>
                    <th style="width: 25%;">Feedback dari Finance</th>
                    <th style="width: 30%;">Aksi</th>
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
                        @php
                            $finDec = 'Pending';
                            if ($project->finance_feedback) {
                                if (str_starts_with($project->finance_feedback, '[Approved]')) $finDec = 'Approved';
                                elseif (str_starts_with($project->finance_feedback, '[Rejected]')) $finDec = 'Rejected';
                            }
                            $cleanFeedback = $project->finance_feedback ? preg_replace('/^\[(Approved|Rejected)\]\s*/', '', $project->finance_feedback) : '—';
                            if (trim($cleanFeedback) === '') $cleanFeedback = '—';
                        @endphp
                        <td>
                            @if ($finDec === 'Approved')
                                <span class="status-dot status-approve">Approved</span>
                            @elseif($finDec === 'Rejected')
                                <span class="status-dot status-rejected">Rejected</span>
                            @else
                                <span class="status-dot status-pending">Pending</span>
                            @endif
                        </td>
                        <td class="text-left text-xs text-gray-600">{{ $cleanFeedback }}</td>
                        <td>
                            @php
                                $isSentToFinance = !empty($project->feedback);
                                $alreadyActed = in_array($project->status, ['Verified', 'Rejected']);
                            @endphp
                            <div class="grid grid-cols-2 gap-2">
                                {{-- Tombol 1: Kirim Finance (hanya mengirim notifikasi ke finance) --}}
                                @if($isSentToFinance)
                                    <button type="button" disabled
                                        title="Sudah dikirim ke finance"
                                        class="w-full px-3 py-2 text-[11px] font-semibold text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                        ✓ Sudah Dikirim
                                    </button>
                                @else
                                    <button type="button"
                                        onclick="openFinanceModal('{{ addslashes($project->talent->nama ?? '-') }}', '{{ addslashes($project->talent->department->nama_department ?? '-') }}', '{{ addslashes($project->talent->promotion_plan->targetPosition->position_name ?? '-') }}', '{{ addslashes($project->talent->company->nama_company ?? '-') }}', {{ $project->id }}, '{{ addslashes($project->title) }}', '{{ $project->document_path ? asset('storage/' . $project->document_path) : '#' }}', '{{ $project->talent->company_id ?? '' }}')"
                                        title="Kirim project ini ke Finance untuk direview"
                                        class="w-full px-3 py-2 text-[11px] font-semibold text-white bg-[#2E3746] hover:bg-[#1e242e] rounded-lg transition-colors shadow-sm">
                                        Kirim Finance
                                    </button>
                                @endif

                                {{-- Tombol 2: Pilih Aksi (PDC Admin ubah status Approved/Rejected) --}}
                                @if($alreadyActed)
                                    @php
                                        $isVerified = $project->status === 'Verified';
                                    @endphp
                                    <div class="w-full px-3 py-2 text-[11px] font-semibold rounded-lg flex items-center justify-center gap-1 {{ $isVerified ? 'text-green-700 bg-green-50 border border-green-300' : 'text-red-600 bg-red-50 border border-red-300' }}">
                                        @if($isVerified)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                            Approved
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                            Rejected
                                        @endif
                                    </div>
                                @else
                                    <button type="button"
                                        onclick="openActionModal({{ $project->id }}, '{{ addslashes($project->talent->nama ?? '-') }}', '{{ route('pdc_admin.finance_validation.update', $project->id) }}')"
                                        title="Ubah status Project Improvement talent ini"
                                        class="w-full px-3 py-2 text-[11px] font-semibold text-white bg-[#F5A623] hover:bg-[#e0961e] rounded-lg transition-colors shadow-sm">
                                        Pilih Aksi
                                    </button>
                                @endif
                            </div>
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
    {{-- Action Modal (PDC Admin: ubah status Project Improvement) --}}
    <div id="actionModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-[440px] shadow-2xl overflow-hidden">
            {{-- Header --}}
            <div class="px-6 pt-6 pb-4 flex flex-col items-center text-center border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-1">Perbarui Status Project?</h3>
                <p class="text-gray-500 text-sm" id="actionModalDesc"></p>
            </div>

            {{-- Body removed --}}

            {{-- Footer: Reject / Approve --}}
            <div class="px-6 pt-5 pb-5 flex gap-3">
                <form id="rejectForm" method="POST" action="" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Rejected">
                    <button type="submit"
                        class="w-full py-3 text-sm font-bold text-white bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors shadow-sm">
                        ✕ Reject
                    </button>
                </form>
                <form id="approveForm" method="POST" action="" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Verified">
                    <button type="submit"
                        class="w-full py-3 text-sm font-bold text-white bg-[#22c55e] hover:bg-[#16a34a] rounded-xl transition-colors shadow-sm">
                        ✓ Approve
                    </button>
                </form>
            </div>
            <div class="px-6 pb-5">
                <button type="button" onclick="closeActionModal()"
                    class="w-full py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

    {{-- Finance Modal --}}
    <div id="financeModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4 @if($errors->any()) !flex @endif">
        <div class="bg-white rounded-2xl w-full max-w-[480px] shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-[#1e293b]">Kirim Permintaan Validasi Finance</h3>
                </div>
                <button onclick="closeFinanceModal()" type="button" class="text-gray-400 hover:text-gray-600 p-2 border border-gray-100 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('pdc_admin.finance.request') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" id="finance-proj-id" value="{{ old('project_id') }}">

                <div class="p-6">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada input yang terlewat:</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="bg-teal-50 border border-teal-200 rounded-lg p-3 flex gap-3 mb-4">
                        <div class="bg-teal-100 p-1.5 rounded-md shrink-0 self-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-xs text-teal-700 leading-relaxed font-medium">Sistem secara otomatis mengirim catatan kepada finance untuk segera direview. Harap isi pada catatan sesuai dengan kebutuhan Anda.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3 text-left">
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1">Talent</label>
                            <div id="fin-talent-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1">Perusahaan</label>
                            <div id="fin-company-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1">Departemen</label>
                            <div id="fin-dept-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1">Posisi Tujuan</label>
                            <div id="fin-pos-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-5 text-left">
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1">Judul Project</label>
                            <input type="text" id="finance-proj-title" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] text-slate-500 font-semibold cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1">Lampiran</label>
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 flex items-center h-[34px]">
                                <a id="finance-proj-file" href="#" target="_blank" class="text-blue-600 hover:underline font-semibold text-[12px] flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" />
                                    </svg>
                                    Lihat File
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div class="flex flex-col h-full">
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1.5">Catatan</label>
                            <textarea name="notes" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-[12px] text-gray-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none flex-grow min-h-[90px]" placeholder="cth: Pada slide ke 17. . .">{{ old('notes') }}</textarea>
                        </div>
                        <div class="flex flex-col">
                            <label class="block text-[11px] font-extrabold text-[#2e3746] uppercase mb-1.5">Kirim Kepada</label>
                            <div class="relative">
                                <select id="finance-assigned-select" name="assigned_finance_id" required class="w-full appearance-none rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-[12px] text-gray-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 pr-9">
                                    <option value="" disabled selected>Pilih email finance</option>
                                    @foreach($financeUsers as $finUser)
                                        <option value="{{ $finUser->id }}" data-company-id="{{ $finUser->company_id }}" @selected(old('assigned_finance_id') == $finUser->id) class="text-gray-700">{{ $finUser->email }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-teal-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 flex justify-end gap-3">
                    <button type="button" onclick="closeFinanceModal()" class="px-5 py-2.5 text-sm font-bold text-[#1e293b] bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#16c60c] hover:bg-[#14b00a] shadow-lg shadow-green-500/30 rounded-xl transition-all hover:-translate-y-px" onclick="this.innerHTML='Mengirim...';">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openActionModal(projectId, talentName, actionUrl) {
            document.getElementById('actionModalDesc').innerHTML =
                'Pilih status untuk project improvement milik <strong>' + talentName +
                '</strong>.<br><span class="text-xs text-gray-400">Tindakan ini akan langsung memperbarui status di sistem.</span>';
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

        const allFinanceOptions = [];
        document.addEventListener('DOMContentLoaded', () => {
            const selectEl = document.getElementById('finance-assigned-select');
            if (selectEl) {
                selectEl.querySelectorAll('option[data-company-id]').forEach(opt => {
                    allFinanceOptions.push({
                        value: opt.value,
                        text: opt.text,
                        companyId: opt.getAttribute('data-company-id'),
                        selected: opt.selected
                    });
                });
            }
        });

        function openFinanceModal(talentName, deptName, posName, companyName, projId, projTitle, projFileUrl, companyId) {
            document.getElementById('fin-talent-name').textContent = talentName || '-';
            document.getElementById('fin-dept-name').textContent = deptName || '-';
            document.getElementById('fin-pos-name').textContent = posName || '-';
            document.getElementById('fin-company-name').textContent = companyName || '-';
            
            document.getElementById('finance-proj-id').value = projId;
            document.getElementById('finance-proj-title').value = projTitle;
            document.getElementById('finance-proj-file').href = projFileUrl;
            
            const selectEl = document.getElementById('finance-assigned-select');
            if (selectEl && companyId) {
                // Clear existing options except the first placeholder
                while (selectEl.options.length > 1) {
                    selectEl.remove(1);
                }
                let hasMatch = false;
                allFinanceOptions.forEach(opt => {
                    if (opt.companyId == companyId) {
                        const newOption = new Option(opt.text, opt.value, false, opt.selected);
                        newOption.className = "text-gray-700";
                        selectEl.add(newOption);
                        hasMatch = true;
                    }
                });
                
                if (!hasMatch) {
                    const noOption = new Option("Belum ada akun finance untuk perusahaan ini", "", true, true);
                    noOption.disabled = true;
                    selectEl.add(noOption);
                } else {
                    selectEl.value = '';
                }
            }

            const modal = document.getElementById('financeModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeFinanceModal() {
            const modal = document.getElementById('financeModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
            modal.classList.remove('!flex'); // remove error state visibility tag
        }
    </script>

</x-pdc_admin.layout>
