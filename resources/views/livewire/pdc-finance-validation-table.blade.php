<div>
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { $el.style.opacity = '0'; $el.style.transform = 'translateY(-10px)'; setTimeout(() => show = false, 500) }, 3000)" 
             class="flex items-center gap-3 mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-500"
             style="opacity: 1; transform: translateY(0);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="prem-stat-grid overflow-x-auto pb-2" style="grid-template-columns:repeat(4, minmax(140px, 1fr))">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $total }}</div>
            <div class="prem-stat-label">Total Permintaan</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $pending }}</div>
            <div class="prem-stat-label">Pending</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $approved }}</div>
            <div class="prem-stat-label">Approved</div>
        </div>
        <div class="prem-stat prem-stat-red">
            <div class="prem-stat-icon si-red">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="prem-stat-value">{{ $rejected }}</div>
            <div class="prem-stat-label">Rejected</div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 mb-6">
        {{-- Live Search --}}
        <div class="relative w-full sm:flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent atau Project…"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                wire:model.live.debounce.300ms="search">
        </div>

        {{-- Company Filter --}}
        <div class="relative w-full sm:w-60">
            <select id="live-company-filter"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                wire:model.live="companyFilter">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                @endforeach
            </select>
        </div>

        {{-- Status Filter --}}
        <div class="relative w-full sm:w-56">
            <select id="live-status-filter"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                wire:model.live="statusFilter">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    @if ($projects->isNotEmpty())
        @php
            $groupedProjects = $projects->groupBy(function ($project) {
                return $project->talent->company_id ?? 0;
            });
        @endphp

        <div class="space-y-8 mt-4">
            @foreach ($groupedProjects as $companyId => $companyProjects)
                @php
                    $companyName = $companyProjects->first()->talent->company->nama_company ?? 'Unassigned';
                @endphp
                <div class="company-section" data-company-id="{{ $companyId }}">
                    <h3 class="company-section-title mb-3">
                        {{ $companyName }}
                    </h3>
                    <div class="overflow-x-auto w-full border border-gray-200 rounded-2xl shadow-sm bg-white">
                        <table class="w-full table-auto text-left">
                            <thead class="bg-slate-50 border-b border-gray-200">
                                <tr>
                                    <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">Talent
                                    </th>
                                    <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">Judul
                                        Project Improvement</th>
                                    <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">File
                                    </th>
                                    <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Validasi Finance</th>
                                    <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                        Feedback Dari Finance</th>
                                    <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($companyProjects as $project)
                                    @php
                                        $finDec = 'Pending';
                                        if ($project->finance_feedback) {
                                            if (str_starts_with($project->finance_feedback, '[Approved]')) {
                                                $finDec = 'Approved';
                                            } elseif (str_starts_with($project->finance_feedback, '[Rejected]')) {
                                                $finDec = 'Rejected';
                                            }
                                        }
                                        $cleanFeedback = $project->finance_feedback
                                            ? preg_replace('/^\[(Approved|Rejected)\]\s*/', '', $project->finance_feedback)
                                            : '—';
                                        if (trim($cleanFeedback) === '') {
                                            $cleanFeedback = '—';
                                        }
                                    @endphp
                                    <tr class="hover:bg-teal-50/50 transition duration-150">
                                        <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                            <div style="display: inline-block; text-align: center; width: 100%;">
                                                <div class="font-bold text-sm text-slate-800 leading-tight">
                                                    {{ $project->talent->nama ?? '-' }}</div>
                                                <div class="text-[10px] text-gray-500 font-medium mt-1 italic leading-tight">
                                                    {{ $project->talent->position->position_name ?? '-' }}
                                                    <br>
                                                    &rarr;
                                                    {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                            <span
                                                class="text-sm text-slate-700 font-medium leading-relaxed">{{ $project->title }}</span>
                                        </td>
                                        <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                            @if ($project->document_path)
                                                <a href="{{ route('files.preview', ['path' => $project->document_path]) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[11px] font-bold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                        </path>
                                                    </svg>
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                            @if ($finDec === 'Approved')
                                                <span class="badge badge-green">Approved</span>
                                            @elseif($finDec === 'Rejected')
                                                <span class="badge badge-red">Rejected</span>
                                            @else
                                                <span class="badge badge-amber">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5" style="text-align:center; vertical-align:middle;">
                                            <div class="text-[12px] text-gray-600 leading-relaxed max-w-[200px] mx-auto">
                                                {{ $cleanFeedback }}</div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap" style="text-align:center; vertical-align:middle;">
                                            @php
                                                $isSentToFinance = !empty($project->feedback);
                                                $alreadyActed = in_array($project->status, ['Approved', 'Verified', 'Rejected']);
                                            @endphp
                                            <div class="flex items-center justify-center gap-2 flex-nowrap">
                                                @if ($isSentToFinance || $alreadyActed)
                                                    <button type="button" disabled
                                                        class="inline-flex items-center justify-center h-9 px-4 text-[11px] font-bold text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed flex-shrink-0">
                                                        ✓ Sudah Dipilih
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        onclick="openActionModal({{ $project->id }}, '{{ addslashes($project->talent->nama ?? '-') }}', '{{ route('pdc_admin.finance_validation.update', $project->id) }}', '{{ addslashes($project->talent->department->nama_department ?? '-') }}', '{{ addslashes($project->talent->promotion_plan->targetPosition->position_name ?? '-') }}', '{{ addslashes($project->talent->company->nama_company ?? '-') }}', '{{ addslashes($project->title) }}', '{{ $project->document_path ? route('files.preview', ['path' => $project->document_path]) : '#' }}', '{{ $project->talent->company_id ?? '' }}')"
                                                        class="inline-flex items-center justify-center h-9 px-5 text-[11px] font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-all shadow-sm hover:shadow-md flex-shrink-0">
                                                        Pilih Aksi
                                                    </button>
                                                @endif
                                                {{-- Tombol Hapus (icon-only, sesuai user management) --}}
                                                <button type="button"
                                                    wire:click="openDeleteModal({{ $project->id }}, '{{ addslashes($project->title) }}', '{{ addslashes($project->talent->nama ?? '-') }}')"
                                                    class="inline-flex items-center justify-center w-9 h-9 bg-[#EF4444] hover:bg-[#dc2626] rounded-lg transition-colors shadow-sm flex-shrink-0"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-prem" style="margin-top: 40px">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3>Belum Ada Project Improvement Talent</h3>
            <p>{{ $search || $statusFilter ? 'Tidak ada data validasi finance yang cocok dengan pencarian atau filter yang dipilih.' : 'Data akan muncul setelah talent meng-upload project improvement.' }}</p>
        </div>
    @endif
    <div id="actionModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl w-full max-w-[440px] shadow-2xl overflow-hidden">
            {{-- Header --}}
            <div class="px-6 pt-6 pb-4 flex flex-col items-center text-center border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-1">Pilih Tindakan Lanjutan</h3>
                <p class="text-gray-500 text-sm" id="actionModalDesc"></p>
            </div>

            {{-- Footer: Kirim Finance, Reject, Approve --}}
            <div class="px-6 pt-5 pb-5 flex flex-col gap-3">
                <button type="button" id="btnKirimFinance" onclick="kirimKeFinance()"
                    class="w-full py-3 text-sm font-bold text-white bg-[#0f172a] hover:bg-[#1e242e] rounded-xl transition-colors shadow-sm">
                    Kirim ke Finance
                </button>
                <div class="flex gap-3 w-full">
                    <form id="rejectForm" method="POST" action="" class="hidden">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Rejected">
                    </form>
                    <form id="approveForm" method="POST" action="" class="hidden">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Approved">
                    </form>
                    
                    <button type="button" onclick="openConfirmModal('Rejected')"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors shadow-sm">
                        ✕ Reject
                    </button>
                    <button type="button" onclick="openConfirmModal('Approved')"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm">
                        ✓ Approve
                    </button>
                </div>
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
    <div id="financeModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 @if ($errors->any()) !flex @endif"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl w-full max-w-[480px] shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-[#1e293b]">Kirim Permintaan Validasi Finance</h3>
                </div>
                <button onclick="closeFinanceModal()" type="button"
                    class="text-gray-400 hover:text-gray-600 p-2 border border-gray-100 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-xs text-teal-700 leading-relaxed font-medium">Sistem secara otomatis mengirim
                            catatan kepada finance untuk segera direview. Harap isi pada catatan sesuai dengan kebutuhan
                            Anda.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3 text-left">
                        <div>
                            <label
                                class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Talent</label>
                            <div id="fin-talent-name"
                                class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Perusahaan</label>
                            <div id="fin-company-name"
                                class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Departemen</label>
                            <div id="fin-dept-name"
                                class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Posisi
                                Tujuan</label>
                            <div id="fin-pos-name"
                                class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] font-bold text-slate-800">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-5 text-left">
                        <div>
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Judul
                                Project</label>
                            <input type="text" id="finance-proj-title"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[12px] text-slate-500 font-semibold cursor-not-allowed"
                                readonly>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1">Lampiran</label>
                            <a id="finance-proj-file" href="#" target="_blank"
                                class="inline-flex justify-center items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-[11px] font-bold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all w-full h-[34px]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Lihat File
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div class="flex flex-col h-full">
                            <label
                                class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1.5">Catatan</label>
                            <textarea name="notes" required
                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-[12px] text-gray-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none flex-grow min-h-[90px]"
                                placeholder="cth: Pada slide ke 17. . .">{{ old('notes') }}</textarea>
                        </div>
                        <div class="flex flex-col">
                            <label class="block text-[11px] font-extrabold text-[#0f172a] uppercase mb-1.5">Kirim
                                Kepada</label>
                            <div class="relative">
                                <select id="finance-assigned-select" name="assigned_finance_id" required
                                    class="w-full appearance-none rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-[12px] text-gray-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 pr-9">
                                    <option value="" disabled selected>Pilih nama finance</option>
                                    @foreach ($financeUsers as $finUser)
                                        <option value="{{ $finUser->id }}"
                                            data-company-id="{{ $finUser->company_id }}" @selected(old('assigned_finance_id') == $finUser->id)
                                            class="text-gray-700">
                                            {{ $finUser->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-teal-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 flex justify-end gap-3">
                    <button type="button" onclick="closeFinanceModal()"
                        class="px-5 py-2.5 text-sm font-bold text-[#475569] bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] shadow-lg shadow-teal-500/30 rounded-xl transition-all hover:-translate-y-px"
                        onclick="this.innerHTML='Mengirim...';">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Confirm Action (Mentor Design Style) --}}
    <div id="financeConfirmModal"
        class="hidden fixed inset-0 z-[110] flex items-center justify-center transition-opacity opacity-0"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
        <div class="bg-white rounded-[28px] shadow-2xl w-[calc(100%-2.5rem)] sm:w-full max-w-[400px] p-6 sm:p-8 text-center transform scale-90 transition-transform duration-400 ease-out border border-slate-100"
            id="financeConfirmModalContent">
            <div id="confirmIconContainer"
                class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-900 mb-6 shadow-xl shadow-slate-900/20">
                <svg id="confirmIconSvg" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Konfirmasi Tindakan</h3>
            <p class="text-[14px] text-slate-500 leading-relaxed mb-8 font-medium">
                Apakah Anda yakin ingin <span id="confirmActionText"
                    class="font-black text-slate-900 underline decoration-teal-400 decoration-2">...</span>
                project <span id="confirmProjectTitle" class="font-black text-slate-800">...</span> dari <span id="confirmTalentName" class="font-black text-slate-800">...</span>?
                <br><span class="text-slate-400 text-[12px] italic mt-2 block">Keputusan ini akan langsung mengubah status project talent.</span>
            </p>

            <div class="grid grid-cols-2 gap-4">
                <button type="button" onclick="closeConfirmModal()"
                    class="w-full bg-slate-100 text-slate-500 font-black py-3.5 rounded-2xl hover:bg-slate-200 transition-all duration-200">
                    Batal
                </button>
                <button type="button" id="confirmSubmitBtn" onclick="submitConfirmModal()"
                    class="w-full text-white font-black py-3.5 rounded-2xl transition-all duration-200">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>
    {{-- Delete Confirmation Modal (sesuai user-management style) --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-[120] items-center justify-center p-4 flex"
            style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);"
            wire:click.self="$set('showDeleteModal', false)">
            <div class="bg-white rounded-2xl w-full max-w-[400px] flex flex-col items-center shadow-2xl p-8 text-center transform transition-all">
                <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Hapus Project?</h3>
                <p class="text-gray-500 text-[15px] mb-8">
                    Project <strong class="text-gray-700">"{{ $deletingProjectTitle }}"</strong>
                    milik <strong class="text-gray-700">{{ $deletingTalentName }}</strong>
                    akan dihapus dan tidak dapat dikembalikan.
                </p>
                <div class="flex gap-4 w-full">
                    <button type="button" wire:click="$set('showDeleteModal', false)"
                        class="flex-1 py-3 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">
                        Batalkan
                    </button>
                    <button type="button" wire:click="confirmDelete"
                        class="flex-1 py-3 px-4 text-sm font-bold text-white bg-[#EF4444] rounded-xl hover:bg-[#dc2626] transition-colors shadow-sm">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>



@push('scripts')
    <style>
        @keyframes lvwire-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        let currentProjectData = {};

        function openActionModal(projectId, talentName, actionUrl, deptName, posName, companyName, projTitle, projFileUrl,
            companyId) {
            currentProjectData = {
                talentName,
                deptName,
                posName,
                companyName,
                projectId,
                projTitle,
                projFileUrl,
                companyId
            };
            document.getElementById('actionModalDesc').innerHTML =
                'Tentukan langkah selanjutnya untuk project <strong>' + talentName +
                '</strong>.<br><span class="text-xs text-gray-400">Anda dapat langsung memberikan keputusan atau meminta validasi dari pihak Finance.</span>';
            document.getElementById('rejectForm').action = actionUrl;
            document.getElementById('approveForm').action = actionUrl;

            const modal = document.getElementById('actionModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function kirimKeFinance() {
            closeActionModal();
            const p = currentProjectData;
            openFinanceModal(p.talentName, p.deptName, p.posName, p.companyName, p.projectId, p.projTitle, p.projFileUrl, p.companyId);
        }

        function closeActionModal() {
            const modal = document.getElementById('actionModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        const allFinanceOptions = [];
        function initFinanceOptions() {
            if (allFinanceOptions.length === 0) {
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
            }
        }
        document.addEventListener('DOMContentLoaded', initFinanceOptions);
        document.addEventListener('livewire:navigated', initFinanceOptions);

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

        let confirmDecisionValue = null;

        function openConfirmModal(decision) {
            confirmDecisionValue = decision;

            const modal = document.getElementById('financeConfirmModal');
            const modalContent = document.getElementById('financeConfirmModalContent');
            const actionText = document.getElementById('confirmActionText');
            const projectTitleSpan = document.getElementById('confirmProjectTitle');
            const talentNameSpan = document.getElementById('confirmTalentName');
            const iconContainer = document.getElementById('confirmIconContainer');
            const iconSvg = document.getElementById('confirmIconSvg');
            const submitBtn = document.getElementById('confirmSubmitBtn');

            actionText.textContent = decision === 'Approved' ? 'Approve' : 'Reject';
            projectTitleSpan.textContent = `"${currentProjectData.projTitle}"`;
            talentNameSpan.textContent = currentProjectData.talentName;

            // Reset classes
            iconContainer.className = "mx-auto flex h-20 w-20 items-center justify-center rounded-full mb-6 shadow-xl";
            submitBtn.className = "w-full text-white font-black py-3.5 rounded-2xl transition-all duration-200";

            if (decision === 'Approved') {
                iconContainer.classList.add('bg-[#14b8a6]', 'shadow-teal-500/30');
                submitBtn.classList.add('bg-[#14b8a6]', 'hover:bg-teal-600', 'hover:shadow-lg', 'hover:shadow-teal-500/30');
                iconSvg.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />`;
            } else {
                iconContainer.classList.add('bg-red-500', 'shadow-red-500/30');
                submitBtn.classList.add('bg-red-500', 'hover:bg-red-600', 'hover:shadow-lg', 'hover:shadow-red-500/30');
                iconSvg.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />`;
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-90');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeConfirmModal() {
            const modal = document.getElementById('financeConfirmModal');
            const modalContent = document.getElementById('financeConfirmModalContent');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-90');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 400);
        }

        function submitConfirmModal() {
            if (confirmDecisionValue === 'Approved') {
                closeConfirmModal();
                closeActionModal();
                document.getElementById('approveForm').submit();
            } else if (confirmDecisionValue === 'Rejected') {
                closeConfirmModal();
                closeActionModal();
                document.getElementById('rejectForm').submit();
            }
        }
    </script>
@endpush
