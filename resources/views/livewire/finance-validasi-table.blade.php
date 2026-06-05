<div>
    {{-- Search Bar & Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Talent / Project"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-teal-500 transition-all">
        </div>
    </div>

    {{-- Validation List --}}
    <div class="space-y-6">
        @forelse($projects as $index => $project)
            <div class="prem-card">
                {{-- Card Header --}}
                <div class="prem-card-header !py-6 md:!py-8 cursor-pointer select-none hover:bg-gray-50 transition-colors !grid !grid-cols-1 md:!grid-cols-12 !gap-4 !items-center"
                    onclick="toggleAccordion('content-{{ $project->id }}', 'icon-{{ $project->id }}')">

                    {{-- Profile Info --}}
                    <div class="flex items-center gap-4 col-span-1 md:col-span-5 min-w-0">
                        <div class="flex-shrink-0">
                            @if ($project->talent->foto)
                                <img src="{{ asset('storage/' . $project->talent->foto) }}"
                                    alt="{{ $project->talent->nama }}"
                                    class="w-16 h-16 rounded-xl object-cover border-2 border-gray-100 shadow-sm">
                            @else
                                <div
                                    class="w-16 h-16 rounded-xl bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-2xl border-2 border-teal-50">
                                    {{ collect(explode(' ', $project->talent->nama ?? 'A'))->map(fn($n) => substr($n, 0, 1))->take(2)->join('') }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="text-gray-800" style="font-size: 0.9rem; font-weight: 600; line-height: 1.2;">
                                {{ $project->talent->nama ?? '-' }}
                            </p>
                            <p class="text-gray-500 italic leading-tight mt-0.5" style="font-size: 0.9rem;">
                                {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->position->position_name ?? '-') }}
                                &rarr;
                                {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->promotion_plan->targetPosition->position_name ?? '?') }}
                            </p>
                            <p class="text-gray-500 italic" style="font-size: 0.9rem;">
                                {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->talent->department->nama_department ?? '-') }}
                            </p>
                        </div>
                    </div>

                    {{-- Project Title --}}
                    <div class="col-span-1 md:col-span-4 py-2 md:py-0 md:px-6 flex items-center min-w-0">
                        <p class="text-gray-700" style="font-size: 0.9rem; font-weight: 700; line-height: 1.3;">
                            {{ str_ireplace(['pt ', 'pt.'], ['PT ', 'PT.'], $project->title) }}
                        </p>
                    </div>

                    {{-- Badge & Toggle --}}
                    <div class="flex items-center justify-between md:justify-end gap-6 col-span-1 md:col-span-3 mt-2 md:mt-0 justify-self-stretch md:justify-self-end">
                        <span
                            class="badge {{ $project->status == 'Pending' ? 'badge-amber' : ($project->status == 'Approved' ? 'badge-green' : 'badge-red') }}">
                            {{ $project->status == 'Pending' ? 'Review' : $project->status }}
                        </span>
                        <svg id="icon-{{ $project->id }}" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-teal-600 transition-transform duration-300 {{ $index === 0 && !$search ? 'transform rotate-180' : '' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Card Content --}}
                <div id="content-{{ $project->id }}"
                    class="px-6 border-gray-100 bg-white transition-all overflow-hidden {{ $index === 0 && !$search ? 'border-t pb-6 pt-5 max-h-[1000px] opacity-100' : 'pb-0 pt-0 max-h-0 opacity-0' }}">
                    <div class="flex flex-col lg:flex-row gap-6 items-start">
                        <form id="validation-form-{{ $project->id }}" action="{{ route('finance.permintaan_validasi.update', $project->id) }}" method="POST"
                            class="w-full flex flex-col lg:flex-row gap-6 items-start">
                            @csrf
                            @method('PATCH')
                            <div class="w-full lg:w-auto flex-grow flex flex-col gap-4">
                                {{-- Catatan dari Admin PDC (read-only) --}}
                                @if ($project->feedback)
                                    <div>
                                        <div class="font-bold text-gray-700 mb-1.5 flex items-center gap-2"
                                            style="font-size: 0.9rem;">
                                            Catatan Admin PDC:
                                        </div>
                                        <div class="w-full rounded-xl border border-gray-100 bg-gray-50/50 px-4 py-3 text-gray-600 leading-relaxed min-h-[60px]"
                                            style="font-size: 0.9rem;">
                                            {{ $project->feedback }}
                                        </div>
                                    </div>
                                @endif
                                {{-- Feedback Finance --}}
                                <div>
                                    <div class="font-bold text-gray-700 mb-1.5 flex items-center gap-2"
                                        style="font-size: 0.9rem;">
                                        Feedback Finance:
                                    </div>
                                    <textarea name="finance_feedback"
                                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-gray-700 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all min-h-[100px] resize-y"
                                        style="font-size: 0.9rem;" placeholder="Ketikkan feedback atau catatan persetujuan / penolakan di sini...">{{ $project->finance_feedback }}</textarea>
                                </div>
                            </div>
                            <div
                                class="flex flex-col gap-3 min-w-[240px] w-full lg:w-auto xl:w-[25%] flex-shrink-0 mt-2 lg:mt-5">
                                @if ($project->document_path)
                                    <a href="{{ route('files.preview', ['path' => $project->document_path]) }}"
                                        target="_blank"
                                        class="inline-flex justify-center items-center gap-2 px-3 py-2.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all w-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                        Preview Dokumen
                                    </a>
                                @else
                                    <button disabled type="button"
                                        class="btn-prem btn-ghost w-full py-3 opacity-50 cursor-not-allowed">
                                        Tidak Ada File
                                    </button>
                                @endif

                                @php
                                    $finDecision = null;
                                    if ($project->finance_feedback) {
                                        if (str_starts_with($project->finance_feedback, '[Approved]')) {
                                            $finDecision = 'Approved';
                                        } elseif (str_starts_with($project->finance_feedback, '[Rejected]')) {
                                            $finDecision = 'Rejected';
                                        }
                                    }
                                @endphp

                                @if ($finDecision)
                                    <div class="w-full flex flex-col gap-2">
                                        <div
                                            class="badge {{ $finDecision === 'Approved' ? 'badge-green' : 'badge-red' }} w-full py-2.5 justify-center text-[13px]">
                                            @if ($finDecision === 'Approved')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @endif
                                            Keputusan: {{ $finDecision }}
                                        </div>
                                        <p class="text-[10px] text-gray-400 text-center italic mt-1 leading-tight">
                                            Keputusan akhir akan ditentukan oleh PDC Admin berdasarkan feedback Anda.
                                        </p>
                                    </div>
                                @else
                                    <div class="grid grid-cols-2 gap-3 mt-2">
                                         <button type="submit" name="finance_decision" value="Approved"
                                             class="btn-prem btn-teal py-3 text-[13px]"
                                             onclick="showConfirmModal(event, 'validation-form-{{ $project->id }}', 'Approved', '{{ str_replace("'", "\\'", $project->talent->nama ?? '') }}', '{{ str_replace("'", "\\'", $project->title ?? '') }}')">
                                             Approve
                                         </button>
                                         <button type="submit" name="finance_decision" value="Rejected"
                                             class="btn-prem btn-red py-3 text-[13px]"
                                             onclick="showConfirmModal(event, 'validation-form-{{ $project->id }}', 'Rejected', '{{ str_replace("'", "\\'", $project->talent->nama ?? '') }}', '{{ str_replace("'", "\\'", $project->title ?? '') }}')">
                                             Reject
                                         </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-prem" style="border: none; padding: 20px;">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto"
                    style="background: linear-gradient(135deg, #ccfbf1, #99f6e4);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                        style="width: 32px !important; height: 32px !important; color: #0d9488 !important; margin: 0 !important;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3>Tidak ada permintaan</h3>
                <p>Belum ada permintaan yang menunggu validasi atau hasil pencarian tidak ditemukan.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($projects->hasPages())
            <div class="mt-4">
                {{ $projects->links('livewire.pagination-simple') }}
            </div>
        @endif
    </div>
</div>
