<div>
    {{-- Search Bar & Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari by Talent / Project..."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-teal-500 transition-all">
        </div>
        <div class="flex-shrink-0 w-full sm:w-48">
            <select wire:model.live="statusFilter" class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                <option value="">Semua Status</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>
    </div>

    {{-- Validation List --}}
    <div class="space-y-6">
        @forelse($projects as $index => $project)
        <div class="prem-card">
            {{-- Card Header --}}
            <div class="prem-card-header cursor-pointer select-none hover:bg-gray-50 transition-colors" onclick="toggleAccordion('content-{{ $project->id }}', 'icon-{{ $project->id }}')">
                
                {{-- Profile Info --}}
                <div class="flex items-center gap-4 w-full md:w-[40%]">
                    <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center overflow-hidden font-bold text-lg bg-teal-50 text-teal-700 border border-teal-100">
                        {{ collect(explode(' ', $project->talent->nama ?? 'A'))->map(fn($n)=>substr($n,0,1))->take(2)->join('') }}
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="font-bold text-gray-800 text-sm">{{ $project->talent->nama ?? '-' }}</p>
                        <p class="text-[11px] text-gray-500 italic leading-tight mt-0.5">{{ $project->talent->position->position_name ?? '-' }} &rarr; {{ $project->talent->promotion_plan->targetPosition->position_name ?? '?' }}</p>
                        <p class="text-[11px] text-gray-500 italic">{{ $project->talent->department->nama_department ?? '-' }}</p>
                    </div>
                </div>

                {{-- Project Title --}}
                <div class="w-full md:w-[35%] py-2 md:py-0 md:px-6 md:border-l border-gray-200 flex items-center">
                    <p class="font-bold text-gray-700 text-sm">{{ $project->title }}</p>
                </div>

                {{-- Badge & Toggle --}}
                <div class="flex items-center justify-between md:justify-end gap-6 ml-auto mt-2 md:mt-0">
                    <span class="badge {{ $project->status == 'Pending' ? 'badge-amber' : ($project->status == 'Approved' ? 'badge-green' : 'badge-red') }}">
                        {{ $project->status == 'Pending' ? 'Review' : $project->status }}
                    </span>
                    <svg id="icon-{{ $project->id }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600 transition-transform duration-300 {{ $index === 0 && !$search ? 'transform rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            {{-- Card Content --}}
            <div id="content-{{ $project->id }}" class="px-6 border-t border-gray-100 bg-white transition-all overflow-hidden {{ $index === 0 && !$search ? 'pb-6 pt-5 max-h-[1000px] opacity-100' : 'pb-0 pt-0 max-h-0 opacity-0' }}">
                <div class="flex flex-col lg:flex-row gap-6 items-start">
                    <form action="{{ route('finance.permintaan_validasi.update', $project->id) }}" method="POST" class="w-full flex flex-col lg:flex-row gap-6 items-start">
                        @csrf
                        @method('PATCH')
                        <div class="w-full lg:w-auto flex-grow flex flex-col gap-4">
                            {{-- Catatan dari Admin PDC (read-only) --}}
                            @if($project->feedback)
                            <div>
                                <div class="font-bold text-gray-700 text-[12px] mb-1.5 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    Catatan Admin PDC:
                                </div>
                                <div class="w-full rounded-xl border border-gray-100 bg-gray-50/50 px-4 py-3 text-xs text-gray-600 leading-relaxed min-h-[60px]">
                                    {{ $project->feedback }}
                                </div>
                            </div>
                            @endif
                            {{-- Feedback Finance --}}
                            <div>
                                <div class="font-bold text-gray-700 text-[12px] mb-1.5 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Feedback Finance:
                                </div>
                                <textarea name="finance_feedback" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-xs text-gray-700 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all min-h-[100px] resize-y" placeholder="Ketikkan feedback atau catatan persetujuan / penolakan di sini...">{{ $project->finance_feedback }}</textarea>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 min-w-[240px] w-full lg:w-auto xl:w-[25%] flex-shrink-0 mt-2 lg:mt-5">
                            @if($project->document_path)
                            <a href="{{ route('files.preview', ['path' => $project->document_path]) }}" target="_blank" class="btn-prem btn-ghost w-full py-3 shadow-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview Dokumen
                            </a>
                            @else
                            <button disabled type="button" class="btn-prem btn-ghost w-full py-3 opacity-50 cursor-not-allowed">
                                Tidak Ada File
                            </button>
                            @endif
                            
                            @php
                                $finDecision = null;
                                if ($project->finance_feedback) {
                                    if (str_starts_with($project->finance_feedback, '[Approved]')) $finDecision = 'Approved';
                                    elseif (str_starts_with($project->finance_feedback, '[Rejected]')) $finDecision = 'Rejected';
                                }
                            @endphp

                            @if($finDecision)
                                <div class="w-full flex flex-col gap-2">
                                    <div class="badge {{ $finDecision === 'Approved' ? 'badge-green' : 'badge-red' }} w-full py-2.5 justify-center text-[13px]">
                                        @if($finDecision === 'Approved')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                        @endif
                                        Keputusan: {{ $finDecision }}
                                    </div>
                                    <p class="text-[10px] text-gray-400 text-center italic mt-1 leading-tight">Keputusan akhir akan ditentukan oleh PDC Admin berdasarkan feedback Anda.</p>
                                </div>
                            @else
                                <div class="grid grid-cols-2 gap-3 mt-2">
                                    <button type="submit" name="finance_decision" value="Approved" class="btn-prem btn-teal py-3 text-[13px]">
                                        Approve
                                    </button>
                                    <button type="submit" name="finance_decision" value="Rejected" class="btn-prem btn-red py-3 text-[13px]">
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
        <div class="prem-card">
            <div class="empty-prem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3>Tidak ada permintaan</h3>
                <p>Tidak ada hasil yang sesuai dengan filter Anda.</p>
            </div>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($projects->hasPages())
            <div class="mt-4">
                {{ $projects->links('livewire.pagination-simple') }}
            </div>
        @endif
    </div>
</div>
