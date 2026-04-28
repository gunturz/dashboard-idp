<div>
    @if (session()->has('success_top'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] relative text-sm" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success_top') }}</span>
        </div>
    @endif

    {{-- Top Tabs --}}
    <div class="top-tabs" wire:ignore.self>
        <button class="top-tab-btn {{ $topTab === 'questions' ? 'active' : '' }}" 
                wire:click="setTopTab('questions')">Questions</button>
        <button class="top-tab-btn {{ $topTab === 'target' ? 'active' : '' }}" 
                wire:click="setTopTab('target')">Target Score Position</button>
    </div>

    <!-- Livewire Loading Overlay indicator -->
    <div wire:loading class="w-full text-center py-4">
        <svg class="animate-spin h-6 w-6 text-[#0f172a] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <div wire:loading.remove>
        {{-- ═══════════════════════════════ TAB: QUESTIONS ═══════════════════════════════ --}}
        @if($topTab === 'questions')
            <div id="panel-questions" class="tab-panel active">

                {{-- Sub Tabs --}}
                <div class="sub-tabs">
                    <button class="sub-tab-btn {{ $subTabQuestion === 'core' ? 'active' : '' }}" 
                            wire:click="setSubTabQuestion('core')">Core Kompetensi</button>
                    <button class="sub-tab-btn {{ $subTabQuestion === 'managerial' ? 'active' : '' }}" 
                            wire:click="setSubTabQuestion('managerial')">Managerial Kompetensi</button>
                </div>

                {{-- Core/Managerial loop --}}
                @php 
                    $comps = $subTabQuestion === 'core' ? $coreCompetencies : $managerialCompetencies;
                @endphp

                @foreach($comps as $comp)
                    @if($editingCompetenceId === $comp->id)
                        {{-- Edit Mode --}}
                        <div class="comp-card competence-card" id="comp-{{ $comp->id }}" data-competence-id="{{ $comp->id }}">
                            <form wire:submit.prevent="saveQuestions">
                                <div class="comp-card-title">{{ $comp->name }}</div>
                                <div class="overflow-x-auto w-full" style="-webkit-overflow-scrolling: touch;">
                                    <table class="comp-table min-w-[900px] md:min-w-full">
                                        <thead>
                                            <tr>
                                                <th>Level</th>
                                                <th>Questions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($lvl = 1; $lvl <= 5; $lvl++)
                                                <tr>
                                                    <td>{{ $lvl }}</td>
                                                    <td style="padding:0;">
                                                        <textarea wire:model.defer="editingQuestions.{{$lvl}}" style="width:100%; min-height:80px; padding:14px 20px; border:none; outline:none; resize:vertical; font-family:inherit; font-size:0.82rem; color:#475569;" placeholder="Masukkan pertanyaan level {{$lvl}}..."></textarea>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <div class="comp-card-footer" style="gap:12px;">
                                    <button type="button" class="btn-batal-ts" style="padding:8px 30px; width:auto;" wire:click="cancelEdit">Batal</button>
                                    <button type="submit" class="btn-simpan-ts" style="padding:8px 30px; width:auto;">Simpan</button>
                                </div>
                            </form>
                        </div>
                    @else
                        {{-- View Mode --}}
                        <div class="comp-card competence-card" id="comp-{{ $comp->id }}" data-competence-id="{{ $comp->id }}">
                            <div class="comp-card-title">{{ $comp->name }}</div>
                            <div class="overflow-x-auto w-full" style="-webkit-overflow-scrolling: touch;">
                                <table class="comp-table min-w-[900px] md:min-w-full">
                                    <thead>
                                        <tr>
                                            <th>Level</th>
                                            <th>Questions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($lvl = 1; $lvl <= 5; $lvl++)
                                            @php $q = $comp->questions->firstWhere('level', $lvl); @endphp
                                            <tr>
                                                <td>{{ $lvl }}</td>
                                                <td>{{ $q->question_text ?? '—' }}</td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <div class="comp-card-footer">
                                <button type="button" class="btn-edit-comp" wire:click="editQuestions({{ $comp->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- ═══════════════════════════════ TAB: TARGET SCORE ═══════════════════════════════ --}}
        @if($topTab === 'target')
            <div id="panel-target" class="tab-panel active">
                {{-- Position Sub Tabs --}}
                <div class="sub-tabs">
                    @foreach($positions as $index => $pos)
                        <button class="sub-tab-btn {{ $activePositionId === $pos->id ? 'active' : '' }}" 
                                wire:click="setActivePosition({{ $pos->id }})">
                            {{ $pos->position_name }}
                        </button>
                    @endforeach
                </div>

                {{-- Panels per Active Position --}}
                @if($activePositionId)
                    <div id="pos-panel-{{ $activePositionId }}" class="pos-panel active">
                        
                        <form wire:submit.prevent="saveTargetScores">
                            
                            {{-- ─ CORE COMPETENCIES ─ --}}
                            <div class="comp-card" id="target-core-section">
                                <div class="comp-card-title">Core Competencies</div>
                                <div class="overflow-x-auto w-full" style="-webkit-overflow-scrolling: touch;">
                                    <table class="ts-table {{ $editingTargetScoreMode ? '' : 'view-mode' }} min-w-[900px] md:min-w-full">
                                        <thead>
                                            <tr>
                                                <th style="width:22%;">Kompetensi</th>
                                                <th colspan="5">Level</th>
                                                <th style="width:18%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($coreCompetencies as $comp)
                                                <tr>
                                                    <td class="ts-comp-name">{{ $comp->name }}</td>
                                                    @for($lvl=1; $lvl<=5; $lvl++)
                                                        <td style="width:12%;">
                                                            @if($editingTargetScoreMode)
                                                                <input type="radio" wire:model="editingTargetScores.{{$comp->id}}" value="{{ $lvl }}" id="ts_{{$activePositionId}}_{{$comp->id}}_{{$lvl}}" class="hidden">
                                                                @php $checked = isset($editingTargetScores[$comp->id]) && (int) $editingTargetScores[$comp->id] === $lvl; @endphp
                                                            @else 
                                                                @php $checked = isset($targetScoresLookup[$comp->id]) && (int) $targetScoresLookup[$comp->id] === $lvl; @endphp
                                                                <input type="radio" disabled {{ $checked ? 'checked' : '' }} id="ts_{{$activePositionId}}_{{$comp->id}}_{{$lvl}}" class="hidden">
                                                            @endif
                                                            <label for="ts_{{$activePositionId}}_{{$comp->id}}_{{$lvl}}" class="ts-radio-label {{ $checked ? 'is-checked' : '' }}">{{ $lvl }}</label>
                                                        </td>
                                                    @endfor
                                                    
                                                    @if($loop->first)
                                                        <td rowspan="{{ $coreCompetencies->count() }}" style="vertical-align: middle;">
                                                            @if($editingTargetScoreMode)
                                                                <div class="flex flex-col gap-3 px-2 sm:px-4">
                                                                    <button type="submit" class="btn-simpan-ts">Simpan</button>
                                                                    <button type="button" class="btn-batal-ts" wire:click="cancelEdit">Batal</button>
                                                                </div>
                                                            @else
                                                                <div class="flex flex-col gap-3 px-2 sm:px-4">
                                                                    <button type="button" class="btn-edit-ts" wire:click="editTargetScore('core')">Edit</button>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ─ MANAGERIAL COMPETENCIES ─ --}}
                            <div class="comp-card mt-6" id="target-managerial-section">
                                <div class="comp-card-title">Managerial Competencies</div>
                                <div class="overflow-x-auto w-full" style="-webkit-overflow-scrolling: touch;">
                                    <table class="ts-table {{ $editingTargetScoreMode ? '' : 'view-mode' }} min-w-[900px] md:min-w-full">
                                        <thead>
                                            <tr>
                                                <th style="width:22%;">Kompetensi</th>
                                                <th colspan="5">Level</th>
                                                <th style="width:18%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($managerialCompetencies as $comp)
                                                <tr>
                                                    <td class="ts-comp-name">{{ $comp->name }}</td>
                                                    @for($lvl=1; $lvl<=5; $lvl++)
                                                        <td style="width:12%;">
                                                            @if($editingTargetScoreMode)
                                                                <input type="radio" wire:model="editingTargetScores.{{$comp->id}}" value="{{ $lvl }}" id="ts_{{$activePositionId}}_{{$comp->id}}_{{$lvl}}" class="hidden">
                                                                @php $checked = isset($editingTargetScores[$comp->id]) && (int) $editingTargetScores[$comp->id] === $lvl; @endphp
                                                            @else 
                                                                @php $checked = isset($targetScoresLookup[$comp->id]) && (int) $targetScoresLookup[$comp->id] === $lvl; @endphp
                                                                <input type="radio" disabled {{ $checked ? 'checked' : '' }} id="ts_{{$activePositionId}}_{{$comp->id}}_{{$lvl}}" class="hidden">
                                                            @endif
                                                            <label for="ts_{{$activePositionId}}_{{$comp->id}}_{{$lvl}}" class="ts-radio-label {{ $checked ? 'is-checked' : '' }}">{{ $lvl }}</label>
                                                        </td>
                                                    @endfor
                                                    
                                                    @if($loop->first)
                                                        <td rowspan="{{ $managerialCompetencies->count() }}" style="vertical-align: middle;">
                                                            @if($editingTargetScoreMode)
                                                                <div class="flex flex-col gap-3 px-2 sm:px-4">
                                                                    <button type="submit" class="btn-simpan-ts">Simpan</button>
                                                                    <button type="button" class="btn-batal-ts" wire:click="cancelEdit">Batal</button>
                                                                </div>
                                                            @else
                                                                <div class="flex flex-col gap-3 px-2 sm:px-4">
                                                                    <button type="button" class="btn-edit-ts" wire:click="editTargetScore('managerial')">Edit</button>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const scrollToCompetence = (competenceId) => {
                if (!competenceId) return;

                const target = document.getElementById(`comp-${competenceId}`);
                if (!target) return;

                requestAnimationFrame(() => {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    window.location.hash = `comp-${competenceId}`;
                });
            };

            Livewire.on('scroll-to-competence', ({ competenceId }) => {
                scrollToCompetence(competenceId);
            });

            Livewire.on('scroll-to-target-section', ({ section }) => {
                const targetId = section === 'managerial'
                    ? 'target-managerial-section'
                    : 'target-core-section';

                const target = document.getElementById(targetId);
                if (!target) return;

                requestAnimationFrame(() => {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    window.location.hash = targetId;
                });
            });

            const hash = window.location.hash.replace('#', '');
            if (hash.startsWith('comp-')) {
                const competenceId = hash.replace('comp-', '');
                scrollToCompetence(competenceId);
            }
            if (hash === 'target-core-section' || hash === 'target-managerial-section') {
                const target = document.getElementById(hash);
                if (target) {
                    requestAnimationFrame(() => {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                }
            }
        });
    </script>
</div>
