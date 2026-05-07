<x-talent.layout title="Dashboard Talent – Individual Development Plan" :user="$user" :notifications="$notifications"
    :mobileCollapsible="true" :showProfileCard="true">
    <x-slot name="styles">
        <style>
            /* ── Donut Chart ── */
            .donut-ring {
                transform: rotate(-90deg);
                transform-origin: 50% 50%;
            }

            /* ── Competency bar ── */
            @keyframes barReveal {
                from {
                    clip-path: inset(0 100% 0 0);
                }

                to {
                    clip-path: inset(0 0% 0 0);
                }
            }

            .bar-fill {
                animation: barReveal 0.9s cubic-bezier(0.4, 0, 0.2, 1) both;
                animation-delay: 0.35s;
            }

            /* ── Dropdown custom ── */
            .score-select {
                -webkit-appearance: none;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%230f172a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 8px center;
                background-size: 14px;
                padding: 0.4rem 2rem 0.4rem 0.75rem;
                min-width: 64px;
                border: 1.5px solid #cbd5e1;
                border-radius: 10px;
                font-size: 0.875rem;
                font-weight: 600;
                color: #0f172a;
                background-color: #f8fafc;
                cursor: pointer;
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            .score-select:focus {
                outline: none;
                border-color: #0f172a;
                box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.12);
            }

            .score-select:hover {
                border-color: #94a3b8;
                background-color: #fff;
            }

            .upload-area {
                border: 2px dashed #cbd5e1;
                transition: border-color 0.2s, background 0.2s;
            }

            .upload-area:hover,
            .upload-area.drag-over {
                border-color: #22c55e;
                background: #f0fdf4;
            }

            /* ── Action Buttons (Matching Login) ── */
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
            }

            .btn-action-teal:hover:not(:disabled) {
                background: linear-gradient(135deg, #0f766e, #059669);
                box-shadow: 0 15px 25px -5px rgba(13, 148, 136, 0.5);
                transform: translateY(-2px);
            }

            .btn-action-teal:active:not(:disabled) {
                transform: translateY(0);
                background: linear-gradient(135deg, #115e59, #065f46);
                box-shadow: 0 5px 15px rgba(13, 148, 136, 0.3);
            }

            .btn-action-teal:disabled {
                background: #cbd5e1;
                box-shadow: none;
                cursor: not-allowed;
                color: #64748b;
            }
        </style>
    </x-slot>

    <div class="w-full px-4 lg:px-6 pt-5 pb-6 space-y-8 flex-grow">

        {{-- Main Dashboard - Titles updated below --}}

        {{-- Main Dashboard Content (Kompetensi, IDP, Project) via Livewire --}}
        <livewire:talent-dashboard-content />

        {{-- ══════════════════════════════ RIWAYAT ══════════════════════════════ --}}
        <div class="space-y-4" id="Riwayat">
            <div class="page-header animate-title mb-2 mt-6">
                <div class="page-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="page-header-title">Riwayat Program IDP</div>
                    <div class="page-header-sub">Lihat ringkasan perjalanan dan pencapaian Anda</div>
                </div>
            </div>

            <div
                class="prem-card p-6 md:p-8 fade-up flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="md:pr-6 pr-0 w-full">
                    <div class="flex items-center gap-2 mb-2">
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Lihat ringkasan perjalanan program IDP Anda mulai dari
                        kompetensi, aktivitas logbook, hingga pencapaian yang telah dikompletasi.</p>
                </div>
                <a href="{{ route('talent.riwayat') }}" class="w-full md:w-auto btn-action-teal px-8 whitespace-nowrap">
                    Lihat Riwayat
                </a>
            </div>
        </div>
    </div> {{-- /wrapper Riwayat --}}

    </div> <!-- Tutup w-full px-6 flex-grow wrapper -->

</x-talent.layout>