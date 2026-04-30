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
                padding: 16px 24px;
                background: #f8fafc;
                font-weight: 800;
                color: #475569;
                font-size: 0.875rem;
                text-align: center;
                white-space: nowrap;
                border-bottom: 1px solid #e2e8f0;
            }

            .pdc-log-table td {
                padding: 14px 24px;
                color: #64748b;
                font-size: 0.875rem;
                border-top: 1px solid #f1f5f9;
            }

            .pdc-log-table tr:hover td {
                background: #fafafa;
            }

            @media (max-width: 767px) {
                main { padding: 16px !important; }
                .val-table th, .val-table td { padding: 10px 10px; font-size: 0.78rem; }
                .talent-selector-row { flex-direction: column !important; gap: 10px !important; }
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h1 class="page-header-title">Validasi Logbook</h1>
            <p class="page-header-sub">Tinjau dan validasi aktivitas logbook talent Anda</p>
        </div>
    </div>

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
