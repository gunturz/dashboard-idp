<x-talent.layout title="Riwayat Talent – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
             /* ── Page Header (Dashboard Style) ── */
             .page-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 32px;
                margin-top: 20px;
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
                background: #f8fafc;
            }

            .highlight-table th {
                padding: 18px 24px;
                text-align: center;
                font-size: 0.75rem;
                font-weight: 800;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
            }

            .highlight-table th:last-child { border-right: none; }

            .highlight-table td {
                padding: 24px;
                font-size: 0.9rem;
                color: #334155;
                border-bottom: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }

            .highlight-table td:last-child { border-right: none; }

            /* Row hover removed per request */

            .talent-name-main {
                display: block;
                font-weight: 800;
                font-size: 1.05rem;
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

            .btn-emerald {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            }

            /* Button hover effect simplified */
            .btn-emerald:active {
                transform: scale(0.98);
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


    <div class="w-full px-4 lg:px-10 py-8 flex-grow animate-reveal">
        {{-- Header Section (Dashboard Style) --}}
        <div class="page-header">
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
                            $posName = optional($user->position)->position_name ?? 'Staff';
                            $targetPos = optional($user->promotion_plan)->targetPosition?->position_name ?? 'Manager';
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
                                <a href="{{ route('talent.riwayat.detail', $session->id) }}" class="btn-prem btn-emerald">
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

        {{-- Back Button Section --}}
        <div class="flex justify-end order-1">
            <a href="{{ route('talent.dashboard') }}" class="btn-prem btn-back-prem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>
</x-talent.layout>
