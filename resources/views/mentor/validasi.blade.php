<x-mentor.layout title="Validasi – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .section-pill {
                display: inline-flex;
                align-items: center;
                background: #0f172a;
                color: #fff;
                font-size: 0.85rem;
                font-weight: 700;
                padding: 0.45rem 1.25rem;
                border-radius: 999px;
                margin-bottom: 1rem;
                letter-spacing: 0.01em;
            }

            .custom-scrollbar::-webkit-scrollbar { 
                height: 8px; 
            }
            .custom-scrollbar::-webkit-scrollbar-track { 
                background: #f8fafc; 
                border-radius: 10px; 
            }
            .custom-scrollbar::-webkit-scrollbar-thumb { 
                background: #0d9488; 
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
                background: #0f766e; 
            }

            .prem-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
                overflow: hidden;
                margin-bottom: 24px;
            }

            .btn-prem {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                font-size: 0.8rem;
                font-weight: 700;
                padding: 8px 16px;
                border-radius: 10px;
                border: none;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
                white-space: nowrap;
            }

            .btn-prem:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            }

            .btn-dark {
                background: #475569;
                color: #fff;
            }

            .btn-dark:hover {
                background: #334155;
                color: #fff;
            }

            .btn-ghost {
                background: #f1f5f9;
                color: #334155;
                border: 1px solid #e2e8f0;
            }

            .btn-ghost:hover {
                background: #e2e8f0;
                color: #1e293b;
            }

            .highlight-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.85rem;
            }

            .highlight-table th {
                background: #f8fafc;
                color: #475569;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                white-space: nowrap;
                font-size: 0.78rem;
            }

            .highlight-table td {
                padding: 14px 16px;
                color: #475569;
                border-top: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                text-align: center;
                vertical-align: middle;
            }

            .highlight-table th:last-child,
            .highlight-table td:last-child {
                border-right: none;
            }

            .highlight-table tbody tr:hover td {
                background: #f0fdfa;
            }

            .status-dot {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.82rem;
                font-weight: 600;
            }

            .status-dot::before {
                content: '';
                display: inline-block;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .status-pending::before  { background: #f59e0b; }
            .status-approved::before { background: #22c55e; }
            .status-rejected::before { background: #ef4444; }
            .status-pending  { color: #92400e; }
            .status-approved { color: #15803d; }
            .status-rejected { color: #b91c1c; }

            .btn-detail {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 0.78rem;
                font-weight: 600;
                color: #475569;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                text-decoration: none;
            }
            .btn-detail:hover { color: #0f172a; }

            .btn-pilih-aksi {
                background: #eab308;
                color: white;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 5px 14px;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                transition: background 0.15s;
            }
            .btn-pilih-aksi:hover { background: #ca8a04; }

            .btn-approved {
                display: inline-flex;
                align-items: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: #15803d;
                background: #dcfce7;
                border: 1px solid #bbf7d0;
                padding: 4px 12px;
                border-radius: 6px;
            }

            .btn-rejected {
                display: inline-flex;
                align-items: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: #b91c1c;
                background: #fee2e2;
                border: 1px solid #fecaca;
                padding: 4px 12px;
                border-radius: 6px;
            }

            @media (max-width: 767px) {
                main { padding: 16px !important; }
                .val-table th, .val-table td { padding: 10px 10px; font-size: 0.78rem; }
                .talent-selector-row { flex-direction: column !important; gap: 10px !important; }
            }
        </style>
    </x-slot>

        {{-- Livewire Component --}}
        <livewire:mentor-validasi-table />


    <x-slot name="scripts">
        <script>

            // Custom Dropdown Talent Logic
            function toggleTalentDropdown() {
                const menu = document.getElementById('dropdown-menu');
                const btn = document.getElementById('dropdown-btn');
                const text = document.getElementById('dropdown-text');
                const icon = document.getElementById('dropdown-icon');
                
                menu.classList.toggle('hidden');

                if (!menu.classList.contains('hidden')) {
                    // Open state
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-[#14b8a6]', 'ring-1', 'ring-[#14b8a6]');
                    text.classList.remove('text-slate-700');
                    text.classList.add('text-[#14b8a6]');
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('text-[#14b8a6]', 'rotate-180');
                } else {
                    // Closed state
                    btn.classList.remove('border-[#14b8a6]', 'ring-1', 'ring-[#14b8a6]');
                    btn.classList.add('border-gray-300');
                    text.classList.remove('text-[#14b8a6]');
                    text.classList.add('text-slate-700');
                    icon.classList.remove('text-[#14b8a6]', 'rotate-180');
                    icon.classList.add('text-gray-400');
                }
            }

            document.addEventListener('click', function(event) {
                const container = document.getElementById('custom-select-container');
                const menu = document.getElementById('dropdown-menu');
                const btn = document.getElementById('dropdown-btn');
                const text = document.getElementById('dropdown-text');
                const icon = document.getElementById('dropdown-icon');

                if (container && !container.contains(event.target)) {
                    if(!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        btn.classList.remove('border-[#14b8a6]', 'ring-1', 'ring-[#14b8a6]');
                        btn.classList.add('border-gray-300');
                        text.classList.remove('text-[#14b8a6]');
                        text.classList.add('text-slate-700');
                        icon.classList.remove('text-[#14b8a6]', 'rotate-180');
                        icon.classList.add('text-gray-400');
                    }
                }
            });

            function switchTab(tab) {
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    const panel = document.getElementById('panel-' + t);
                    const btn = document.getElementById('tab-' + t);
                    if (panel) panel.classList.add('hidden');
                    if (btn) {
                        btn.classList.remove('btn-dark', 'active');
                        btn.classList.add('btn-ghost', 'border-transparent', 'bg-transparent', 'hover:bg-slate-200/80');
                    }
                });
                const activePanel = document.getElementById('panel-' + tab);
                const activeBtn = document.getElementById('tab-' + tab);
                if (activePanel) activePanel.classList.remove('hidden');
                if (activeBtn) {
                    activeBtn.classList.remove('btn-ghost', 'border-transparent', 'bg-transparent', 'hover:bg-slate-200/80');
                    activeBtn.classList.add('btn-dark', 'active');
                }
                // Update URL hash without jumping
                if (history.pushState) {
                    history.pushState(null, null, '#' + tab);
                } else {
                    window.location.hash = '#' + tab;
                }
            }

            // Restore tab from hash on load
            document.addEventListener('DOMContentLoaded', function() {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }

                // Auto-dismiss flash success
                const flash = document.getElementById('flash-success');
                if (flash) {
                    setTimeout(() => {
                        flash.style.transition = 'opacity 0.6s ease';
                        flash.style.opacity = '0';
                        setTimeout(() => flash.remove(), 600);
                    }, 4000);
                }
            });
        </script>

    </x-slot>
</x-mentor.layout>
