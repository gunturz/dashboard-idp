<div>
    {{-- Summary Cards --}}
    <div class="prem-stat-grid" style="grid-template-columns:repeat(4,1fr)">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
            </div>
            <div class="prem-stat-value">{{ $total }}</div>
            <div class="prem-stat-label">Total Permintaan</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/></svg>
            </div>
            <div class="prem-stat-value">{{ $pending }}</div>
            <div class="prem-stat-label">Pending</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
            </div>
            <div class="prem-stat-value">{{ $approved }}</div>
            <div class="prem-stat-label">Approved</div>
        </div>
        <div class="prem-stat prem-stat-red">
            <div class="prem-stat-icon si-red">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
            </div>
            <div class="prem-stat-value">{{ $rejected }}</div>
            <div class="prem-stat-label">Rejected</div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 mb-6">
        {{-- Live Search --}}
        <div class="relative w-full sm:w-[40%]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent atau Project…" 
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" 
                wire:model.live.debounce.300ms="search">
        </div>

        {{-- Status Filter --}}
        <div class="relative w-full sm:w-[30%]">
            <select id="live-status-filter" class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all" 
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" 
                wire:model.live="statusFilter">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        {{-- Loading indicator --}}
        <div wire:loading class="flex items-center gap-1.5 text-xs text-[#14b8a6] font-medium">
            <svg style="width:14px;height:14px;animation:lvwire-spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle style="opacity:.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path style="opacity:.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Memfilter...
        </div>
    </div>

    {{-- Table --}}
    <div class="prem-card">
        <div class="prem-card-header">
            <span class="prem-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM9.75 17.25a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-.75zm2.25-3a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-3a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-4.5z" clip-rule="evenodd"/></svg>
                Daftar Permintaan Validasi
            </span>
        </div>
        <div class="overflow-x-auto">
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
                    @php
                        $finDec = 'Pending';
                        if ($project->finance_feedback) {
                            if (str_starts_with($project->finance_feedback, '[Approved]')) $finDec = 'Approved';
                            elseif (str_starts_with($project->finance_feedback, '[Rejected]')) $finDec = 'Rejected';
                        }
                    @endphp
                    <tr class="finance-row">
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
                                        class="w-full px-3 py-2 text-[11px] font-semibold text-white bg-[#0f172a] hover:bg-[#1e242e] rounded-lg transition-colors shadow-sm">
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
        </div>{{-- /overflow-x-auto --}}
    </div>{{-- /prem-card --}}
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
                        class="w-full py-3 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm">
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
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Talent</label>
                            <div id="fin-talent-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Perusahaan</label>
                            <div id="fin-company-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Departemen</label>
                            <div id="fin-dept-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Posisi Tujuan</label>
                            <div id="fin-pos-name" class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-5 text-left">
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Judul Project</label>
                            <input type="text" id="finance-proj-title" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] text-slate-500 font-semibold cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Lampiran</label>
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
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1.5">Catatan</label>
                            <textarea name="notes" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-[12px] text-gray-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none flex-grow min-h-[90px]" placeholder="cth: Pada slide ke 17. . .">{{ old('notes') }}</textarea>
                        </div>
                        <div class="flex flex-col">
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1.5">Kirim Kepada</label>
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
                    <button type="button" onclick="closeFinanceModal()" class="px-5 py-2.5 text-sm font-bold text-[#475569] bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#16c60c] hover:bg-[#14b00a] shadow-lg shadow-green-500/30 rounded-xl transition-all hover:-translate-y-px" onclick="this.innerHTML='Mengirim...';">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<style>  @keyframes lvwire-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } } </style>
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
@endpush
