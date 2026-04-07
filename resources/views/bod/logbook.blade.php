<x-bod.layout title="LogBook BOD – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Back button ── */
            .btn-back {
                display: inline-flex; align-items: center; gap: 8px;
                padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 10px;
                background: white; color: #475569; font-weight: 600; font-size: 0.85rem;
                text-decoration: none; transition: all 0.2s; margin-bottom: 20px;
            }
            .btn-back:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

            /* ── Section title ── */
            .section-title {
                display: flex; align-items: center; gap: 10px;
                font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 20px;
            }

            /* ── Tab pills ── */
            .tab-pill-wrap {
                display: flex;
                background: #e2e8f0;
                padding: 4px;
                border-radius: 9999px;
                width: fit-content;
                margin-bottom: 24px;
                gap: 2px;
            }
            .tab-pill {
                padding: 9px 36px;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 700;
                color: #475569;
                cursor: pointer;
                transition: all 0.2s;
                background: transparent;
                border: none;
                outline: none;
                white-space: nowrap;
            }
            .tab-pill:hover { color: #1e293b; }
            .tab-pill.active {
                background: #2e3746;
                color: white;
                box-shadow: 0 2px 12px rgba(46,55,70,0.22);
            }

            /* ── Table ── */
            .log-table-wrap {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                background: white;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }
            .log-table {
                width: 100%;
                border-collapse: collapse;
            }
            .log-table th {
                background: #f8fafc;
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
                padding: 14px 18px;
                text-align: center;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                white-space: nowrap;
            }
            .log-table th:last-child { border-right: none; }
            .log-table td {
                padding: 14px 18px;
                font-size: 0.85rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                text-align: center;
                vertical-align: middle;
            }
            .log-table td:first-child { font-weight: 600; }
            .log-table td:last-child { border-right: none; }
            .log-table tbody tr:last-child td { border-bottom: none; }
            .log-table tbody tr:hover { background: #f8fffe; }

            .hidden { display: none !important; }

            .doc-link {
                display: inline-flex; align-items: center; gap: 4px;
                font-size: 0.75rem; color: #0d9488; font-weight: 600;
                background: #f0fdfa; padding: 3px 8px; border-radius: 6px;
                border: 1px solid #99f6e4; text-decoration: none; max-width: 120px;
                white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            }
            .doc-link:hover { color: #0f766e; }

            /* ── Scrollable on mobile ── */
            .overflow-x-auto { overflow-x: auto; }
        </style>
    </x-slot>

    {{-- Back to talent detail, with anchor to logbook section --}}
    <a href="{{ route('bod.detail_talent', $talent->id) }}#logbook-section" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
        </svg>
        Kembali
    </a>

    {{-- Title --}}
    <div class="section-title">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
        </svg>
        LogBook
    </div>

    {{-- Tab Pills --}}
    <div class="tab-pill-wrap">
        <button class="tab-pill active" id="tab-exposure"  onclick="switchTab('exposure')">Exposure</button>
        <button class="tab-pill"        id="tab-mentoring" onclick="switchTab('mentoring')">Mentoring</button>
        <button class="tab-pill"        id="tab-learning"  onclick="switchTab('learning')">Learning</button>
    </div>

    {{-- ══════════ EXPOSURE TABLE ══════════ --}}
    <div id="panel-exposure" class="log-table-wrap overflow-x-auto">
        <table class="log-table" style="min-width:860px;">
            <thead>
                <tr>
                    <th>Mentor</th>
                    <th>Tema</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>Dokumentasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exposureActivities as $act)
                    <tr>
                        <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                        <td class="font-semibold text-[#1e293b]">{{ $act->theme ?? '-' }}</td>
                        <td class="whitespace-nowrap">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d F Y') : '-' }}</td>
                        <td>{{ $act->location ?? '-' }}</td>
                        <td>{{ $act->activity ?? '-' }}</td>
                        <td>{{ $act->description ?? '-' }}</td>
                        <td>
                            @php
                                $paths = []; $names = [];
                                if ($act->document_path) {
                                    if (str_starts_with($act->document_path, '["')) {
                                        $paths = json_decode($act->document_path, true);
                                        $names = explode(', ', $act->file_name);
                                    } else { $paths = [$act->document_path]; $names = [$act->file_name]; }
                                }
                            @endphp
                            @if(count($paths) > 0)
                                <div class="flex flex-col gap-1 items-center">
                                    @foreach($paths as $i => $path)
                                        <a href="{{ asset('storage/'.$path) }}" target="_blank" class="doc-link" title="{{ $names[$i] ?? 'Dokumen' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            {{ $names[$i] ?? 'Dokumen' }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-gray-400">Belum ada aktivitas Exposure.</td></tr>
                    <tr><td colspan="7" class="py-2 text-gray-200 text-xs">-</td></tr>
                    <tr><td colspan="7" class="py-2 text-gray-200 text-xs">-</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ══════════ MENTORING TABLE ══════════ --}}
    <div id="panel-mentoring" class="log-table-wrap overflow-x-auto hidden">
        <table class="log-table" style="min-width:900px;">
            <thead>
                <tr>
                    <th>Mentor</th>
                    <th>Tema</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Action Plan</th>
                    <th>Dokumentasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mentoringActivities as $act)
                    <tr>
                        <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                        <td class="font-semibold text-[#1e293b]">{{ $act->theme ?? '-' }}</td>
                        <td class="whitespace-nowrap">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d F Y') : '-' }}</td>
                        <td>{{ $act->location ?? '-' }}</td>
                        <td>{{ $act->description ?? '-' }}</td>
                        <td class="font-semibold text-[#0d9488]">{{ $act->action_plan ?? '-' }}</td>
                        <td>
                            @php
                                $paths = []; $names = [];
                                if ($act->document_path) {
                                    if (str_starts_with($act->document_path, '["')) {
                                        $paths = json_decode($act->document_path, true);
                                        $names = explode(', ', $act->file_name);
                                    } else { $paths = [$act->document_path]; $names = [$act->file_name]; }
                                }
                            @endphp
                            @if(count($paths) > 0)
                                <div class="flex flex-col gap-1 items-center">
                                    @foreach($paths as $i => $path)
                                        <a href="{{ asset('storage/'.$path) }}" target="_blank" class="doc-link" title="{{ $names[$i] ?? 'Dokumen' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            {{ $names[$i] ?? 'Dokumen' }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-gray-400">Belum ada aktivitas Mentoring.</td></tr>
                    <tr><td colspan="7" class="py-2 text-gray-200 text-xs">-</td></tr>
                    <tr><td colspan="7" class="py-2 text-gray-200 text-xs">-</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ══════════ LEARNING TABLE ══════════ --}}
    <div id="panel-learning" class="log-table-wrap overflow-x-auto hidden">
        <table class="log-table" style="min-width:860px;">
            <thead>
                <tr>
                    <th>Sumber</th>
                    <th>Tema</th>
                    <th>Tanggal</th>
                    <th>Platform</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>Dokumentasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($learningActivities as $act)
                    <tr>
                        <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                        <td class="font-semibold text-[#1e293b]">{{ $act->theme ?? '-' }}</td>
                        <td class="whitespace-nowrap">{{ $act->activity_date ? \Carbon\Carbon::parse($act->activity_date)->format('d F Y') : '-' }}</td>
                        <td>{{ $act->platform ?? '-' }}</td>
                        <td>{{ $act->activity ?? '-' }}</td>
                        <td>{{ $act->description ?? '-' }}</td>
                        <td>
                            @php
                                $paths = []; $names = [];
                                if ($act->document_path) {
                                    if (str_starts_with($act->document_path, '["')) {
                                        $paths = json_decode($act->document_path, true);
                                        $names = explode(', ', $act->file_name);
                                    } else { $paths = [$act->document_path]; $names = [$act->file_name]; }
                                }
                            @endphp
                            @if(count($paths) > 0)
                                <div class="flex flex-col gap-1 items-center">
                                    @foreach($paths as $i => $path)
                                        <a href="{{ asset('storage/'.$path) }}" target="_blank" class="doc-link" title="{{ $names[$i] ?? 'Dokumen' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            {{ $names[$i] ?? 'Dokumen' }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-gray-400">Belum ada aktivitas Learning.</td></tr>
                    <tr><td colspan="7" class="py-2 text-gray-200 text-xs">-</td></tr>
                    <tr><td colspan="7" class="py-2 text-gray-200 text-xs">-</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-slot name="scripts">
        <script>
            function switchTab(tab) {
                // Hide all panels
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    document.getElementById('panel-' + t).classList.add('hidden');
                    document.getElementById('tab-' + t).classList.remove('active');
                });
                // Show selected
                document.getElementById('panel-' + tab).classList.remove('hidden');
                document.getElementById('tab-' + tab).classList.add('active');
            }

            // Check URL hash for initial tab
            document.addEventListener('DOMContentLoaded', function () {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });
        </script>
    </x-slot>

</x-bod.layout>
