<x-pdc_admin.layout title="Kompetensi – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Top Tabs ── */
            .top-tabs {
                display: flex;
                background: #e8ecf0;
                border-radius: 9999px;
                padding: 5px;
                gap: 4px;
                margin-bottom: 16px;
            }

            .top-tab-btn {
                flex: 1;
                padding: 11px 24px;
                border-radius: 9999px;
                border: none;
                font-size: 0.9rem;
                font-weight: 600;
                cursor: pointer;
                transition: all .2s;
                color: #64748b;
                background: transparent;
            }

            .top-tab-btn.active {
                background: #2e3746;
                color: white;
                box-shadow: 0 2px 8px rgba(0,0,0,.18);
            }

            /* ── Sub Tabs ── */
            .sub-tabs {
                display: flex;
                background: #e8ecf0;
                border-radius: 9999px;
                padding: 5px;
                gap: 4px;
                margin-bottom: 24px;
            }

            .sub-tab-btn {
                flex: 1;
                padding: 11px 24px;
                border-radius: 9999px;
                border: none;
                background: transparent;
                font-size: 0.9rem;
                font-weight: 600;
                color: #64748b;
                cursor: pointer;
                transition: all .2s;
            }

            .sub-tab-btn.active {
                background: #2e3746;
                color: white;
                box-shadow: 0 2px 8px rgba(0,0,0,.18);
            }

            /* ── Competency Card ── */
            .comp-card {
                border: 1px solid #dbe4ee;
                border-radius: 20px;
                overflow: hidden;
                margin-bottom: 24px;
                background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            }

            .comp-card-title {
                text-align: center;
                font-size: 1.55rem;
                font-weight: 800;
                color: #22324a;
                letter-spacing: -0.02em;
                padding: 22px 24px;
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
                border-bottom: 1px solid #e2e8f0;
            }

            .comp-table {
                width: 100%;
                border-collapse: collapse;
            }

            .comp-table thead tr {
                background: linear-gradient(180deg, #f8fbff 0%, #f1f5f9 100%);
            }

            .comp-table th {
                padding: 16px 22px;
                font-size: 0.92rem;
                font-weight: 800;
                color: #334155;
                letter-spacing: 0.01em;
                text-align: center;
                border-right: 1px solid #f1f5f9;
            }

            .comp-table th:first-child { width: 96px; }
            .comp-table th:last-child { border-right: none; }

            .comp-table td {
                padding: 18px 24px;
                font-size: 0.95rem;
                color: #64748b;
                vertical-align: top;
                border-top: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                line-height: 1.72;
                background: rgba(255, 255, 255, 0.82);
            }

            .comp-table td:first-child {
                text-align: center;
                font-weight: 800;
                font-size: 1.1rem;
                color: #23324b;
                vertical-align: middle;
                border-right: 1px solid #f1f5f9;
                background: #f8fbff;
            }
            .comp-table td:last-child { border-right: none; }

            .comp-table tbody tr:hover td { background: #f8fbff; }

            .question-text {
                font-size: 1.12rem;
                line-height: 1.8;
                color: #48627f;
                font-weight: 500;
            }

            .question-empty {
                font-size: 1rem;
                color: #94a3b8;
                font-style: italic;
            }

            .question-editor {
                width: 100%;
                min-height: 132px;
                padding: 18px 22px;
                border: none;
                outline: none;
                resize: vertical;
                font-family: inherit;
                font-size: 1.05rem;
                line-height: 1.75;
                color: #334155;
                background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            }

            .question-editor::placeholder {
                color: #94a3b8;
            }

            /* Edit button */
            .btn-edit-comp {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: #2e3746;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
                transition: all .2s;
                box-shadow: 0 8px 18px rgba(46, 55, 70, 0.16);
            }
            .btn-edit-comp:hover { background: #1e2737; }

            .comp-card-footer {
                padding: 16px 22px;
                display: flex;
                justify-content: flex-end;
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
                border-top: 1px solid #f1f5f9;
            }

            /* Panel visibility */
            .tab-panel { display: none; }
            .tab-panel.active { display: block; }
            .pos-panel { display: none; }
            .pos-panel.active { display: block; }

            /* Target Score Position table */
            .ts-table {
                width: 100%;
                border-collapse: collapse;
            }
            .ts-table th {
                padding: 14px 10px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #2e3746;
                text-align: center;
                background: #f8fafc;
                border-bottom: 2px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .ts-table th:last-child { border-right: none; }
            
            .ts-table td {
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                padding: 0;
                vertical-align: middle;
            }
            .ts-table td:last-child { border-right: none; }

            .ts-comp-name {
                padding: 16px 24px !important;
                font-weight: 500;
                color: #475569;
                text-align: left;
                width: 30%;
            }

            .ts-radio-label {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
                min-height: 56px;
                font-weight: 700;
                color: #2e3746;
                cursor: pointer;
                transition: background 0.2s, color 0.2s;
            }
            .ts-radio-label:hover { background: #f1f5f9; }
            input[type="radio"]:checked + .ts-radio-label {
                background: #14b8a6;
                color: white;
            }

            .btn-simpan-ts {
                background: #14b8a6;
                color: white;
                font-weight: 700;
                font-size: 0.8rem;
                border: none;
                border-radius: 6px;
                padding: 10px 0;
                width: 100%;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-simpan-ts:hover { background: #0d9488; }

            .btn-batal-ts {
                background: #F4F1EA;
                color: #2e3746;
                font-weight: 700;
                font-size: 0.8rem;
                border: none;
                border-radius: 6px;
                padding: 10px 0;
                width: 100%;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-batal-ts:hover { background: #eadecc; }

            .btn-edit-ts {
                background: #2e3746;
                color: white;
                font-weight: 700;
                font-size: 0.8rem;
                border: none;
                border-radius: 6px;
                padding: 10px 0;
                width: 100%;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-edit-ts:hover { background: #1e2737; }

            .ts-table.view-mode .ts-radio-label {
                pointer-events: none;
                opacity: 0.8;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .top-tabs, .sub-tabs {
                    flex-direction: column;
                    border-radius: 12px;
                }
                .top-tab-btn, .sub-tab-btn {
                    border-radius: 8px;
                    padding: 8px 16px;
                }
                .comp-table, .ts-table {
                    min-width: 900px;
                }
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Kompetensi</div>
            <div class="page-header-sub">Kelola pertanyaan assessment dan atur Target Score posisi pekerjaan.</div>
        </div>
    </div>

    {{-- Top Tabs --}}
    <div class="top-tabs">
        <button class="top-tab-btn active" id="topTab-questions" onclick="switchTopTab('questions')">Questions</button>
        <button class="top-tab-btn" id="topTab-target" onclick="switchTopTab('target')">Target Score Position</button>
    </div>

    {{-- ═══════════════════════════════ TAB: QUESTIONS ═══════════════════════════════ --}}
    <div id="panel-questions" class="tab-panel active">

        {{-- Sub Tabs --}}
        <div class="sub-tabs">
            <button class="sub-tab-btn active" id="subTab-core" onclick="switchSubTab('core')">Core Kompetensi</button>
            <button class="sub-tab-btn" id="subTab-managerial" onclick="switchSubTab('managerial')">Managerial Kompetensi</button>
        </div>

        {{-- Core Kompetensi Panel --}}
        <div id="panel-core" class="tab-panel active">
            @foreach($coreCompetencies as $comp)
                {{-- View Mode --}}
                <div class="comp-card" id="view-comp-{{ $comp->id }}">
                    <div class="comp-card-title">{{ $comp->name }}</div>
                    <table class="comp-table">
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
                    <div class="comp-card-footer">
                        <button class="btn-edit-comp" onclick="toggleEdit({{ $comp->id }}, true)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                </div>

                {{-- Edit Mode --}}
                <div class="comp-card" id="edit-comp-{{ $comp->id }}" style="display:none;">
                    <form action="{{ route('pdc_admin.competency.update_questions') }}" method="POST">
                        @csrf
                        <input type="hidden" name="competence_id" value="{{ $comp->id }}">
                        <div class="comp-card-title">{{ $comp->name }}</div>
                        <table class="comp-table">
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
                                        <td style="padding:0;">
                                            @if($q) <input type="hidden" name="questions[{{$lvl}}][id]" value="{{$q->id}}"> @endif
                                            <input type="hidden" name="questions[{{$lvl}}][level]" value="{{$lvl}}">
                                            <textarea name="questions[{{$lvl}}][text]" style="width:100%; min-height:80px; padding:14px 20px; border:none; outline:none; resize:vertical; font-family:inherit; font-size:0.82rem; color:#475569;" placeholder="Masukkan pertanyaan level {{$lvl}}...">{{ $q->question_text ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                        <div class="comp-card-footer" style="gap:12px;">
                            <button type="button" class="btn-batal-ts" style="padding:8px 30px; width:auto;" onclick="toggleEdit({{ $comp->id }}, false)">Batal</button>
                            <button type="submit" class="btn-simpan-ts" style="padding:8px 30px; width:auto;">Simpan</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Managerial Kompetensi Panel --}}
        <div id="panel-managerial" class="tab-panel">
            @foreach($managerialCompetencies as $comp)
                {{-- View Mode --}}
                <div class="comp-card" id="view-comp-{{ $comp->id }}">
                    <div class="comp-card-title">{{ $comp->name }}</div>
                    <table class="comp-table">
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
                    <div class="comp-card-footer">
                        <button class="btn-edit-comp" onclick="toggleEdit({{ $comp->id }}, true)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                </div>

                {{-- Edit Mode --}}
                <div class="comp-card" id="edit-comp-{{ $comp->id }}" style="display:none;">
                    <form action="{{ route('pdc_admin.competency.update_questions') }}" method="POST">
                        @csrf
                        <input type="hidden" name="competence_id" value="{{ $comp->id }}">
                        <div class="comp-card-title">{{ $comp->name }}</div>
                        <table class="comp-table">
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
                                        <td style="padding:0;">
                                            @if($q) <input type="hidden" name="questions[{{$lvl}}][id]" value="{{$q->id}}"> @endif
                                            <input type="hidden" name="questions[{{$lvl}}][level]" value="{{$lvl}}">
                                            <textarea name="questions[{{$lvl}}][text]" style="width:100%; min-height:80px; padding:14px 20px; border:none; outline:none; resize:vertical; font-family:inherit; font-size:0.82rem; color:#475569;" placeholder="Masukkan pertanyaan level {{$lvl}}...">{{ $q->question_text ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                        <div class="comp-card-footer" style="gap:12px;">
                            <button type="button" class="btn-batal-ts" style="padding:8px 30px; width:auto;" onclick="toggleEdit({{ $comp->id }}, false)">Batal</button>
                            <button type="submit" class="btn-simpan-ts" style="padding:8px 30px; width:auto;">Simpan</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <div id="panel-target" class="tab-panel">
        {{-- Position Sub Tabs --}}
        <div class="sub-tabs">
            @foreach($positions as $index => $pos)
                <button class="sub-tab-btn pos-tab-trigger {{ $index === 0 ? 'active' : '' }}" id="posTab-{{ $pos->id }}" onclick="switchPosTab({{ $pos->id }})">
                    {{ $pos->position_name }}
                </button>
            @endforeach
        </div>

        {{-- Panels per Position --}}
        @foreach($positions as $index => $pos)
            <div id="pos-panel-{{ $pos->id }}" class="pos-panel {{ $index === 0 ? 'active' : '' }}">
                
                {{-- ─ CORE COMPETENCIES ─ --}}
                <form id="ts-form-core-{{$pos->id}}" action="{{ route('pdc_admin.target_score.update', $pos->id) }}" method="POST">
                    @csrf
                    <div class="comp-card">
                        <div class="comp-card-title">Core Competencies</div>
                        <table class="ts-table view-mode" id="ts-table-core-{{$pos->id}}">
                            <thead>
                                <tr>
                                    <th style="width:22%;">Kompetensi</th>
                                    <th colspan="5">Level</th>
                                    <th style="width:18%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coreCompetencies as $comp)
                                    @php $targetVal = $targetScores[$pos->id][$comp->id] ?? null; @endphp
                                    <tr>
                                        <td class="ts-comp-name">{{ $comp->name }}</td>
                                        @for($lvl=1; $lvl<=5; $lvl++)
                                            <td style="width:12%;">
                                                <input type="radio" name="scores[{{$comp->id}}]" value="{{ $lvl }}" id="ts_{{$pos->id}}_{{$comp->id}}_{{$lvl}}" class="hidden" {{ $targetVal == $lvl ? 'checked' : '' }}>
                                                <label for="ts_{{$pos->id}}_{{$comp->id}}_{{$lvl}}" class="ts-radio-label">{{ $lvl }}</label>
                                            </td>
                                        @endfor
                                        
                                        @if($loop->first)
                                            <td rowspan="{{ $coreCompetencies->count() }}" style="vertical-align: middle;">
                                                <!-- View Mode Actions -->
                                                <div class="flex flex-col gap-3 px-2 sm:px-4" id="ts-actions-view-core-{{$pos->id}}">
                                                    <button type="button" class="btn-edit-ts" onclick="toggleTsEdit('core', {{ $pos->id }}, true)">Edit</button>
                                                </div>
                                                <!-- Edit Mode Actions -->
                                                <div class="flex flex-col gap-3 px-2 sm:px-4 hidden" id="ts-actions-edit-core-{{$pos->id}}" style="display:none;">
                                                    <button type="button" class="btn-simpan-ts" onclick="submitTsForm('core', {{ $pos->id }})">Simpan</button>
                                                    <button type="button" class="btn-batal-ts" onclick="cancelTsEdit('core', {{ $pos->id }})">Batal</button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                {{-- ─ MANAGERIAL COMPETENCIES ─ --}}
                <form id="ts-form-managerial-{{$pos->id}}" action="{{ route('pdc_admin.target_score.update', $pos->id) }}" method="POST">
                    @csrf
                    <div class="comp-card">
                        <div class="comp-card-title">Managerial Competencies</div>
                        <table class="ts-table view-mode" id="ts-table-managerial-{{$pos->id}}">
                            <thead>
                                <tr>
                                    <th style="width:22%;">Kompetensi</th>
                                    <th colspan="5">Level</th>
                                    <th style="width:18%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($managerialCompetencies as $comp)
                                    @php $targetVal = $targetScores[$pos->id][$comp->id] ?? null; @endphp
                                    <tr>
                                        <td class="ts-comp-name">{{ $comp->name }}</td>
                                        @for($lvl=1; $lvl<=5; $lvl++)
                                            <td style="width:12%;">
                                                <input type="radio" name="scores[{{$comp->id}}]" value="{{ $lvl }}" id="ts_{{$pos->id}}_{{$comp->id}}_{{$lvl}}" class="hidden" {{ $targetVal == $lvl ? 'checked' : '' }}>
                                                <label for="ts_{{$pos->id}}_{{$comp->id}}_{{$lvl}}" class="ts-radio-label">{{ $lvl }}</label>
                                            </td>
                                        @endfor
                                        
                                        @if($loop->first)
                                            <td rowspan="{{ $managerialCompetencies->count() }}" style="vertical-align: middle;">
                                                <!-- View Mode Actions -->
                                                <div class="flex flex-col gap-3 px-2 sm:px-4" id="ts-actions-view-managerial-{{$pos->id}}">
                                                    <button type="button" class="btn-edit-ts" onclick="toggleTsEdit('managerial', {{ $pos->id }}, true)">Edit</button>
                                                </div>
                                                <!-- Edit Mode Actions -->
                                                <div class="flex flex-col gap-3 px-2 sm:px-4 hidden" id="ts-actions-edit-managerial-{{$pos->id}}" style="display:none;">
                                                    <button type="button" class="btn-simpan-ts" onclick="submitTsForm('managerial', {{ $pos->id }})">Simpan</button>
                                                    <button type="button" class="btn-batal-ts" onclick="cancelTsEdit('managerial', {{ $pos->id }})">Batal</button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

            </div>
        @endforeach
    </div>

    {{-- (Edit Modal has been replaced by inline editing) --}}

    <x-slot name="scripts">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-wrap tables for mobile responsiveness without squashing
            document.querySelectorAll('.comp-table, .ts-table').forEach(table => {
                const wrapper = document.createElement('div');
                wrapper.style.overflowX = 'auto';
                wrapper.style.width = '100%';
                wrapper.style.WebkitOverflowScrolling = 'touch';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });
        });

        /* ── Top Tab Switcher ── */
        function switchTopTab(tab) {
            document.querySelectorAll('.top-tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('topTab-' + tab).classList.add('active');
            document.querySelectorAll('#panel-questions, #panel-target').forEach(p => {
                p.classList.remove('active');
                p.style.display = 'none';
            });
            const panel = document.getElementById('panel-' + tab);
            panel.classList.add('active');
            panel.style.display = 'block';
        }

        /* ── Sub Tab Switcher (Core/Managerial) ── */
        function switchSubTab(sub) {
            // Find the sub-tabs ONLY in the Questions panel to avoid conflicting with position subtabs
            const panelQs = document.getElementById('panel-questions');
            panelQs.querySelectorAll('.sub-tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('subTab-' + sub).classList.add('active');
            
            document.getElementById('panel-core').classList.remove('active');
            document.getElementById('panel-core').style.display = 'none';
            document.getElementById('panel-managerial').classList.remove('active');
            document.getElementById('panel-managerial').style.display = 'none';

            const panel = document.getElementById('panel-' + sub);
            panel.classList.add('active');
            panel.style.display = 'block';
        }

        /* ── Position Tab Switcher ── */
        function switchPosTab(posId) {
            document.querySelectorAll('.pos-tab-trigger').forEach(b => b.classList.remove('active'));
            document.getElementById('posTab-' + posId).classList.add('active');
            
            document.querySelectorAll('.pos-panel').forEach(p => {
                p.classList.remove('active');
                p.style.display = 'none';
            });
            const panel = document.getElementById('pos-panel-' + posId);
            panel.classList.add('active');
            panel.style.display = 'block';
        }

        /* ── Inline Edit Toggle ── */
        function toggleEdit(compId, show) {
            const viewCard = document.getElementById('view-comp-' + compId);
            const editCard = document.getElementById('edit-comp-' + compId);
            if (show) {
                viewCard.style.display = 'none';
                editCard.style.display = 'block';
            } else {
                viewCard.style.display = 'block';
                editCard.style.display = 'none';
            }
        }

        // Init panel visibility (CSS .active + display)
        document.querySelectorAll('.tab-panel').forEach(p => {
            p.style.display = p.classList.contains('active') ? 'block' : 'none';
        });

        /* ── Target Score Inline Edit + AJAX ── */
        function toggleTsEdit(type, posId, show) {
            const table = document.getElementById(`ts-table-${type}-${posId}`);
            const viewActions = document.getElementById(`ts-actions-view-${type}-${posId}`);
            const editActions = document.getElementById(`ts-actions-edit-${type}-${posId}`);
            
            if(show) {
                table.classList.remove('view-mode');
                viewActions.style.display = 'none';
                editActions.style.display = 'flex';
            } else {
                table.classList.add('view-mode');
                viewActions.style.display = 'flex';
                editActions.style.display = 'none';
            }
        }

        function cancelTsEdit(type, posId) {
            document.getElementById(`ts-form-${type}-${posId}`).reset();
            toggleTsEdit(type, posId, false);
        }

        function submitTsForm(type, posId) {
            const form = document.getElementById(`ts-form-${type}-${posId}`);
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(response.ok) {
                    toggleTsEdit(type, posId, false);
                } else {
                    alert('Gagal memperbarui Target Score.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data.');
            });
        }
    </script>
    </x-slot>

</x-pdc_admin.layout>
