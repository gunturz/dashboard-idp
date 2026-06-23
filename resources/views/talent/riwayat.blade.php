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

            .custom-scrollbar::-webkit-scrollbar {
                height: 8px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f8fafc;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #14b8a6;
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #0d9488;
            }

            @media (max-width: 767px) {
                .custom-scrollbar {
                    max-width: calc(100vw - 1.5rem);
                }
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                position: relative;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .pdc-log-table {
                width: 100%;
                border-collapse: collapse;
            }

            .pdc-log-table th {
                padding: 12px 16px;
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
                font-size: 0.8rem;
                text-align: center;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }

            .pdc-log-table th:last-child {
                border-right: none;
            }

            .pdc-log-table td {
                padding: 12px 16px;
                color: #334155;
                font-size: 0.88rem;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
            }

            .pdc-log-table td:last-child {
                border-right: none;
            }

            .pdc-log-table tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .pdc-log-table tr:hover td {
                background: #f8fafc;
            }

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

            .animate-reveal {
                animation: reveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            @keyframes reveal {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </x-slot>


    <div class="w-full px-4 lg:px-6 pt-5 pb-6 flex-grow animate-reveal">
        {{-- Header Section (Dashboard Style) --}}
        <div class="page-header mt-2">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h1 class="page-header-title">Riwayat Talent</h1>
                <p class="page-header-sub">Ringkasan perjalan program pengembangan Anda</p>
            </div>
        </div>

        {{-- Content Section --}}
        @if(!($isDecisionFinal ?? false))
            {{-- Keputusan PDC belum ditetapkan --}}
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mt-2">
                <div class="flex flex-col items-center justify-center py-8">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                        style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-base font-bold text-gray-700">Riwayat Belum Tersedia</p>
                    <p class="text-sm text-gray-500 mt-1 text-center max-w-md leading-relaxed">
                        Data riwayat program pengembangan Anda akan muncul setelah proses penilaian akhir selesai dan keputusan PDC telah ditetapkan.
                    </p>
                </div>
            </div>
        @else
            {{-- Table Section --}}
            <div class="mb-12 relative">
                {{-- Desktop View --}}
                <div class="hidden md:block rounded-xl overflow-hidden border border-gray-200 w-full overflow-x-auto">
                    <table class="w-full text-left bg-white min-w-[800px]">
                        <thead class="bg-slate-50 border-b border-gray-200">
                            <tr>
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Talent</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Perusahaan</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Start Date</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Due Date</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Rekomendasi</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $session)
                                @php
                                    $startDate = \Carbon\Carbon::parse($session->start_date ?? $session->created_at);
                                    $dueDate = \Carbon\Carbon::parse($session->target_date ?? $session->created_at)->addMonths(isset($session->target_date) ? 0 : 6);
                                    // Gunakan posisi yang di-snapshot saat sesi dibuat
                                    $posName = $session->source_position_name ?? optional($user->position)->position_name ?? 'Staff';
                                    $targetPos = $session->target_position_name ?? optional($user->promotion_plan)->targetPosition?->position_name ?? 'Supervisor';
                                @endphp
                                <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                    <td class="py-4 px-6 text-center">
                                        <span class="talent-name-main">{{ $user->nama }}</span>
                                        <span class="talent-role-sub">{{ $posName }} &rarr; {{ $targetPos }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-sm font-semibold text-slate-800 text-center">
                                        {{ optional($user->company)->nama_company ?? 'PT Tiga Serangkai Pustaka Mandiri' }}
                                    </td>
                                    <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap font-medium">
                                        {{ $startDate->locale('id')->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap font-medium">
                                        {{ $dueDate->locale('id')->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-center w-40">
                                        @php $promoStatus = $session->status_promotion; @endphp
                                        @if ($promoStatus === 'Promoted')
                                            <span class="inline-flex items-center gap-1.5 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                                Ready Now
                                            </span>
                                        @elseif ($promoStatus === 'Ready in 1-2 Years')
                                            <span class="inline-flex items-center gap-1.5 text-blue-600 text-[11px] font-bold bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                                                Ready 1–2 Years
                                            </span>
                                        @elseif ($promoStatus === 'Ready in > 2 Years')
                                            <span class="inline-flex items-center gap-1.5 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 flex-shrink-0"></span>
                                                Ready &gt;2 Years
                                            </span>
                                        @elseif ($promoStatus === 'Not Ready')
                                            <span class="inline-flex items-center gap-1.5 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                                                Not Ready
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-slate-600 text-[11px] font-bold bg-slate-50 px-3 py-1 rounded-full border border-slate-200">
                                                {{ $promoStatus ?? '-' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('talent.riwayat.detail', $session->id) }}"
                                            class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center text-gray-400">
                                        Belum ada riwayat aktivitas pengembangan yang dicatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View --}}
                <div class="block md:hidden log-table-container custom-scrollbar overflow-x-auto">
                    <table class="pdc-log-table w-full" style="min-width: 700px;">
                        <thead>
                            <tr>
                                <th style="width: 150px; font-size: 11px; padding: 8px;">Talent</th>
                                <th style="width: 150px; font-size: 11px; padding: 8px;">Perusahaan</th>
                                <th style="width: 100px; font-size: 11px; padding: 8px;">Start Date</th>
                                <th style="width: 100px; font-size: 11px; padding: 8px;">Due Date</th>
                                <th style="width: 110px; font-size: 11px; padding: 8px;">Rekomendasi</th>
                                <th style="width: 90px; font-size: 11px; padding: 8px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $session)
                                @php
                                    $startDate = \Carbon\Carbon::parse($session->start_date ?? $session->created_at);
                                    $dueDate = \Carbon\Carbon::parse($session->target_date ?? $session->created_at)->addMonths(isset($session->target_date) ? 0 : 6);
                                    $posName = $session->source_position_name ?? optional($user->position)->position_name ?? 'Staff';
                                    $targetPos = $session->target_position_name ?? optional($user->promotion_plan)->targetPosition?->position_name ?? 'Supervisor';
                                @endphp
                                <tr>
                                    <td class="text-center font-bold text-[#1e293b] text-[11px] p-2 leading-tight">
                                        <span class="block text-slate-800 text-[12px] font-extrabold">{{ $user->nama }}</span>
                                        <span class="block text-slate-500 text-[10px] italic font-medium mt-0.5">{{ $posName }} &rarr; {{ $targetPos }}</span>
                                    </td>
                                    <td class="text-center font-bold text-[#1e293b] text-[11px] p-2 whitespace-normal leading-tight">
                                        {{ optional($user->company)->nama_company ?? 'PT Tiga Serangkai Pustaka Mandiri' }}
                                    </td>
                                    <td class="text-center text-[10px] p-2 whitespace-nowrap font-medium text-slate-600">
                                        {{ $startDate->locale('id')->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="text-center text-[10px] p-2 whitespace-nowrap font-medium text-slate-600">
                                        {{ $dueDate->locale('id')->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="text-center p-2 whitespace-nowrap">
                                        @php $promoStatus = $session->status_promotion; @endphp
                                        @if ($promoStatus === 'Promoted')
                                            <span class="inline-flex items-center gap-1 text-green-600 text-[9px] font-bold bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                                                Ready Now
                                            </span>
                                        @elseif ($promoStatus === 'Ready in 1-2 Years')
                                            <span class="inline-flex items-center gap-1 text-blue-600 text-[9px] font-bold bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">
                                                Ready 1–2 Years
                                            </span>
                                        @elseif ($promoStatus === 'Ready in > 2 Years')
                                            <span class="inline-flex items-center gap-1 text-orange-500 text-[9px] font-bold bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100">
                                                Ready &gt;2 Years
                                            </span>
                                        @elseif ($promoStatus === 'Not Ready')
                                            <span class="inline-flex items-center gap-1 text-red-600 text-[9px] font-bold bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                                                Not Ready
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-slate-600 text-[9px] font-bold bg-slate-50 px-2 py-0.5 rounded-full border border-slate-200">
                                                {{ $promoStatus ?? '-' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center p-2">
                                        <a href="{{ route('talent.riwayat.detail', $session->id) }}"
                                            class="flex items-center justify-center w-6 h-6 rounded bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors border border-teal-100 mx-auto"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 px-6 text-center text-gray-400 text-xs">
                                        Belum ada riwayat aktivitas pengembangan yang dicatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-talent.layout>
