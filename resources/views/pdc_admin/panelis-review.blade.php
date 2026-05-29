<x-pdc_admin.layout title="Panelis Review – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Summary Cards ── */
            .panelis-stat-card {
                border-radius: 16px;
                padding: 20px 24px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                border: 2px solid;
                background: white;
                min-width: 160px;
                flex: 1;
            }

            .panelis-stat-card.teal {
                border-color: #14b8a6;
            }

            .panelis-stat-card.amber {
                border-color: #f59e0b;
            }

            .panelis-stat-card.green {
                border-color: #22c55e;
            }

            .panelis-stat-num {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 6px;
            }

            .panelis-stat-card.teal .panelis-stat-num {
                color: #14b8a6;
            }

            .panelis-stat-card.amber .panelis-stat-num {
                color: #f59e0b;
            }

            .panelis-stat-card.green .panelis-stat-num {
                color: #22c55e;
            }

            .panelis-stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
                line-height: 1.3;
            }

            /* ── Filters ── */
            .panelis-filter-input,
            .panelis-filter-select {
                height: 40px;
                padding: 0 12px;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                font-size: 0.85rem;
                color: #334155;
                background: white;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
                font-family: 'Poppins', sans-serif;
            }

            .panelis-filter-input:focus,
            .panelis-filter-select:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
            }

            .panelis-filter-select {
                padding-right: 32px;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 10px center;
                background-size: 16px;
            }

            /* ── Company Section ── */
            .company-header {
                font-size: 1.05rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 10px;
                margin-top: 28px;
                padding-left: 4px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .company-header::before {
                content: '';
                display: inline-block;
                width: 4px;
                height: 18px;
                background: linear-gradient(180deg, #14b8a6, #0d9488);
                border-radius: 99px;
                flex-shrink: 0;
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path fill-rule="evenodd"
                    d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Panelis Review</div>
            <div class="page-header-sub">Pantau &amp; kirim talent untuk penilaian panelis</div>
        </div>
    </div>

    {{-- ── Success Message ── --}}
    @if (session('success'))
        <div id="success-alert"
            class="flex items-center gap-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Livewire Component (Stats + Filters + Table + Modal) ── --}}
    <livewire:pdc-panelis-review-table />

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    setTimeout(function() {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 3000);
                }
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>
