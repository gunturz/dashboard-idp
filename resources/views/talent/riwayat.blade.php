<x-talent.layout title="Riwayat Talent – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
             /* ── Page Header (Dashboard Style) ── */
             .page-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 32px;
            }

            .page-header-icon {
                width: 56px;
                height: 56px;
                border-radius: 18px;
                background: linear-gradient(135deg, #0f172a 0%, #38475a 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
                flex-shrink: 0;
                color: white;
            }

            .page-header-icon svg {
                width: 28px;
                height: 28px;
            }

            .page-header-title {
                font-size: 1.75rem;
                font-weight: 900;
                color: #1e293b;
                line-height: 1.1;
                letter-spacing: -0.02em;
            }

            .page-header-sub {
                font-size: 0.875rem;
                color: #64748b;
                margin-top: 4px;
                font-weight: 500;
            }

            /* ── Premium Card & Table ── */
            .prem-card {
                background: #f9fafb;
                border: 1px solid #e2e8f0;
                border-radius: 24px;
                overflow: hidden;
            }

            .prem-card:hover {
                transform: none !important;
            }

            .highlight-table {
                width: 100%;
                border-collapse: collapse;
            }

            .highlight-table thead {
                background: #f1f5f9;
            }

            .highlight-table th {
                padding: 12px 16px;
                text-align: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: #1e293b;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }

            .highlight-table th:last-child { border-right: none; }

            .highlight-table td {
                padding: 12px 16px;
                font-size: 0.82rem;
                color: #334155;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
            }

            .highlight-table td:last-child { border-right: none; }

            .highlight-table tr:hover td {
                background: #f8fafc;
            }

            /* Row hover removed per request */

            .talent-name-main {
                display: block;
                font-weight: 800;
                font-size: 1rem;
                color: #1e293b;
            }

            .talent-role-sub {
                display: block;
                font-size: 0.775rem;
                color: #64748b;
                font-style: italic;
                margin-top: 3px;
            }

            /* ── Dashboard Style Buttons ── */
            .btn-prem {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 24px;
                border-radius: 12px;
                font-size: 0.85rem;
                font-weight: 700;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                white-space: nowrap;
                cursor: pointer;
                border: none;
            }

            .btn-action-teal {
                padding: 0.75rem 1.5rem;
                background: linear-gradient(135deg, #0d9488, #10b981);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 0.95rem;
                font-weight: 700;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 10px 20px -5px rgba(13, 148, 136, 0.4);
                letter-spacing: 0.5px;
                white-space: nowrap;
            }

            .btn-action-teal:hover {
                background: linear-gradient(135deg, #0f766e, #059669);
                box-shadow: 0 15px 25px -5px rgba(13, 148, 136, 0.5);
                transform: translateY(-2px);
            }

            .btn-action-teal:active {
                transform: translateY(0);
                background: linear-gradient(135deg, #115e59, #065f46);
                box-shadow: 0 5px 15px rgba(13, 148, 136, 0.3);
            }

            .btn-back-prem {
                background: white;
                border: 1.5px solid #e2e8f0;
                color: #475569;
                font-weight: 700;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            }

            /* Back button hover simplified */
            .btn-back-prem:active {
                transform: scale(0.98);
            }

            .animate-reveal {
                animation: reveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            @keyframes reveal {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </x-slot>


    <div class="w-full px-4 lg:px-6 pt-5 pb-6 flex-grow animate-reveal">
        {{-- Header Section (Dashboard Style) --}}
        <div class="page-header mt-2">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h1 class="page-header-title">Riwayat Talent</h1>
                <p class="page-header-sub">Ringkasan perjalan program pengembangan Anda</p>
            </div>
        </div>

        {{-- Table Section (Dashboard Style) --}}
        <div class="prem-card mb-12 overflow-x-auto">
            <table class="highlight-table">
                <thead>
                    <tr>
                        <th style="width: 25%; text-align: left;">Talent</th>
                        <th style="width: 30%; text-align: left;">Perusahaan</th>
                        <th style="width: 15%;">Start Date</th>
                        <th style="width: 15%;">Due Date</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        @php
                            $startDate = \Carbon\Carbon::parse($session->created_at);
                            $dueDate = \Carbon\Carbon::parse($session->created_at)->addMonths(6);
                            // Gunakan posisi yang di-snapshot saat sesi dibuat
                            $posName   = $session->source_position_name ?? optional($user->position)->position_name ?? 'Staff';
                            $targetPos = $session->target_position_name ?? optional($user->promotion_plan)->targetPosition?->position_name ?? 'Supervisor';
                        @endphp
                        <tr>
                            <td style="text-align: left;">
                                <span class="talent-name-main">{{ $user->nama }}</span>
                                <span class="talent-role-sub">{{ $posName }} – {{ $targetPos }}</span>
                            </td>
                            <td style="text-align: left;">
                                {{ optional($user->company)->nama_perusahaan ?? 'PT Tiga Serangkai Pustaka Mandiri' }}
                            </td>
                            <td class="text-center font-bold text-gray-500">
                                {{ $startDate->translatedFormat('d F Y') }}
                            </td>
                            <td class="text-center font-bold text-gray-500">
                                {{ $dueDate->translatedFormat('d F Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('talent.riwayat.detail', $session->id) }}" class="btn-action-teal">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <p class="font-bold text-lg">Belum ada riwayat</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-talent.layout>
