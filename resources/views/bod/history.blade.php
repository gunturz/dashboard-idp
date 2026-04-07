<x-bod.layout title="History BOD – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .history-table-wrap {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                background: white;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }

            .history-table {
                width: 100%;
                border-collapse: collapse;
            }

            .history-table th {
                background: #f8fafc;
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
                padding: 14px 24px;
                text-align: center;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .history-table th:last-child {
                border-right: none;
            }

            .history-table td {
                padding: 18px 24px;
                vertical-align: middle;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                font-size: 0.875rem;
                color: #334155;
                text-align: center;
            }
            .history-table td:first-child {
                text-align: left;
            }
            .history-table td:last-child {
                border-right: none;
            }

            .history-table tbody tr:last-child td {
                border-bottom: none;
            }

            .history-table tbody tr {
                transition: background 0.15s;
            }
            .history-table tbody tr:hover {
                background: #f8fffe;
            }

            .talent-name-cell {
                font-weight: 700;
                color: #1e293b;
                display: block;
                font-size: 0.9rem;
            }
            .talent-role-cell {
                font-size: 0.78rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 2px;
            }

            .feedback-text {
                font-weight: 600;
                color: #22c55e;
            }
            .feedback-text.rejected {
                color: #ef4444;
            }

            .score-text {
                font-weight: 800;
                font-size: 1.1rem;
                color: #1e293b;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .history-table th,
                .history-table td {
                    padding: 12px 14px;
                    font-size: 0.8rem;
                }
            }
        </style>
    </x-slot>

    {{-- Page Title --}}
    <div class="flex items-center gap-3 mb-8">
        <h2 class="text-2xl font-extrabold text-[#2e3746] animate-title">Riwayat Penilaian</h2>
    </div>

    {{-- History Table --}}
    <div class="history-table-wrap">
        <div class="overflow-x-auto">
            <table class="history-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Talent</th>
                        <th style="width: 25%;">Project</th>
                        <th style="width: 25%;">Feedback</th>
                        <th style="width: 25%;">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        @php
                            $talent = $project->talent;
                        @endphp
                        <tr>
                            <td>
                                <span class="talent-name-cell">{{ optional($talent)->nama ?? '-' }}</span>
                                <span class="talent-role-cell">
                                    {{ optional(optional($talent)->position)->position_name ?? 'Staff' }}
                                    – {{ optional(optional($talent)->department)->nama_department ?? 'Human Resource' }}
                                </span>
                            </td>
                            <td>{{ $project->title ?? 'Judul Project' }}</td>
                            <td>
                                <span class="feedback-text {{ $project->status === 'Rejected' ? 'rejected' : '' }}">
                                    {{ $project->status === 'Verified' ? 'Baik' : ($project->status === 'Rejected' ? 'Kurang' : '-') }}
                                </span>
                            </td>
                            <td>
                                <span class="score-text">
                                    {{ $project->finance_feedback ?? '80' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-400 py-8">
                                Belum ada riwayat penilaian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-bod.layout>
