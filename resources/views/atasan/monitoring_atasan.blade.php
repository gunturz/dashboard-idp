<x-atasan.layout title="Monitoring – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 5px; height: 5px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

            .custom-scrollbar::-webkit-scrollbar { height: 8px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #0d9488; border-radius: 10px; border: 2px solid #f8fafc; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #0f766e; }

            .log-table-container {
                background: white; border-radius: 16px; border: 1px solid #e2e8f0;
                overflow: hidden; position: relative; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .pdc-log-table { width: 100%; border-collapse: collapse; }
            .pdc-log-table th {
                padding: 12px 16px; background: #f1f5f9; font-weight: 700; color: #1e293b;
                font-size: 0.8rem; text-align: center; border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }
            .pdc-log-table th:last-child { border-right: none; }
            .pdc-log-table td {
                padding: 12px 16px; color: #334155; font-size: 0.88rem; border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb; vertical-align: middle;
            }
            .pdc-log-table td:last-child { border-right: none; }
            .pdc-log-table tr:last-child td { border-bottom: 1px solid #d1d5db; }
            .pdc-log-table tr:hover td { background: #f8fafc; }

            .nav-tabs { display: flex; gap: 12px; }
            .tab-item {
                padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: white;
                color: #475569; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center;
                gap: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); cursor: pointer; transition: all 0.2s;
            }
            .tab-item:hover { background: #f1f5f9; }
            .tab-item.active { background: #f1f5f9; border-color: #94a3b8; color: #1e293b; }

            .section-title {
                display: flex; align-items: center; gap: 12px; font-size: 1.25rem;
                font-weight: 800; color: #1e293b; margin-top: 40px; margin-bottom: 24px;
            }

            /* IDP Donut Charts */
            .idp-card-container {
                background: #f8fafc; border-radius: 16px; padding: 24px;
                border: 1px solid #e2e8f0;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .donut-container {
                background: white; border-radius: 16px; padding: 30px;
                display: flex; justify-content: space-evenly; align-items: center;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                width: 100%;
            }

            /* Tables */
            .pdc-custom-table {
                width: 100%; border-collapse: collapse; background: white;
                border-radius: 12px; overflow: hidden; border: 1px solid #d1d5db;
            }
            .pdc-custom-table th {
                background: #f1f5f9; padding: 12px 16px; border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db; font-size: 0.8rem; font-weight: 700; color: #1e293b;
            }
            .pdc-custom-table th:last-child { border-right: none; }
            .pdc-custom-table td {
                padding: 12px 16px; border-bottom: 1px solid #d1d5db; border-right: 1px solid #e5e7eb;
                font-size: 0.88rem; color: #334155; text-align: center;
            }
            .pdc-custom-table td:last-child { border-right: none; }

            .btn-status-action {
                padding: 6px 16px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; transition: all 0.2s;
            }
            .btn-reject { border: 1.5px solid #ef4444; color: #ef4444; background: white; }
            .btn-approve { border: 1.5px solid #22c55e; color: #22c55e; background: white; }
            .btn-reject:hover { background: #ef4444; color: white; }
            .btn-approve:hover { background: #22c55e; color: white; }

            .filter-pills {
                display: flex; background: #e2e8f0; padding: 4px; border-radius: 9999px;
                width: fit-content; margin-bottom: 20px;
            }
            .pill {
                padding: 8px 32px; border-radius: 9999px; font-size: 0.875rem; font-weight: 700;
                color: #475569; cursor: pointer; transition: all 0.2s;
            }
            .pill:hover { background: #cbd5e1; color: #1e293b; }
            .pill.active {
                background: #0f172a; color: white; box-shadow: 0 2px 12px rgba(15, 23, 42,0.22);
            }

            /* Heatmap */
            .talent-gap-grid {
                display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 24px; margin-bottom: 48px;
            }
            .talent-card {
                background: white; border: 1px solid #e2e8f0; border-radius: 16px;
                padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            .talent-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
            .talent-info { display: flex; gap: 16px; }
            .talent-photo { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #f1f5f9; }
            .talent-meta h4 { font-size: 1.125rem; font-weight: 700; color: #1e293b; }
            .talent-meta p { font-size: 0.75rem; color: #64748b; font-style: italic; }

            .top-gap-label {
                text-align: right; font-size: 0.75rem; font-weight: 800; color: #1e293b;
                margin-bottom: 12px; display: block;
            }
            .gap-item {
                display: flex; justify-content: space-between; align-items: center;
                padding: 10px 16px; border-radius: 99px; margin-bottom: 10px;
                font-size: 0.875rem; font-weight: 600;
            }
            .gap-item.prio-1 { border: 1.5px solid #b91c1c; color: #991b1b; background: #fef2f2; }
            .gap-item.prio-2 { border: 1.5px solid #c2410c; color: #9a3412; background: #fff7ed; }
            .gap-item.prio-3 { border: 1.5px solid #1d4ed8; color: #1e40af; background: #eff6ff; }
            .gap-number {
                width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center;
                justify-content: center; color: white; font-size: 0.75rem; margin-right: 12px; font-weight: 800;
            }
            .gap-item.prio-1 .gap-number { background: #b91c1c; }
            .gap-item.prio-2 .gap-number { background: #c2410c; }
            .gap-item.prio-3 .gap-number { background: #1d4ed8; }

            .heatmap-container { background: white; border: 1px solid #d1d5db; border-radius: 12px; overflow: hidden; }
            .heatmap-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
            .heatmap-table th, .heatmap-table td { 
                border-bottom: 1px solid #d1d5db; border-right: 1px solid #e5e7eb; 
                padding: 12px 16px; text-align: center; 
            }
            .heatmap-table th { 
                background: #f1f5f9; font-weight: 700; color: #1e293b; 
                border-bottom: 2px solid #cbd5e1; border-right: 1px solid #d1d5db;
                font-size: 0.8rem;
            }
            .heatmap-table th:last-child { border-right: none; }
            .heatmap-table td:last-child { border-right: none; }
            .heatmap-table .th-main { background: #f1f5f9; font-weight: 700; color: #1e293b; }
            .heatmap-table .th-sub { font-size: 0.65rem; font-weight: 700; color: #475569; text-transform: uppercase; background: #f1f5f9; }
            .heatmap-table .td-left { text-align: left; font-weight: 600; color: #334155; white-space: nowrap; }
            .gap-badge { display: block; width: 100%; height: 100%; padding: 4px; border-radius: 4px; font-weight: 700; color: white; }
            .gap-none { background-color: #f1f5f9; color: #64748b; }
            .gap-ok { background-color: #cbd5e1; color: #1e293b; }
            .gap-small { background-color: #f97316; color: white; }
            .gap-large { background-color: #ef4444; color: white; }
            .legend { display: flex; gap: 16px; font-size: 0.65rem; font-weight: 700; color: #64748b; margin-bottom: 12px; text-transform: uppercase; }
            .legend-item { display: flex; align-items: center; gap: 4px; }
            .legend-box { width: 12px; height: 12px; border-radius: 2px; }


            /* ══ MOBILE ONLY — does NOT affect desktop ══ */
            @media (max-width: 767px) {
                .nav-tabs {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                    padding-bottom: 4px;
                }
                .tab-item {
                    padding: 6px 12px;
                    font-size: 0.75rem;
                    gap: 4px;
                    white-space: nowrap;
                    flex-shrink: 0;
                }
                .tab-item svg {
                    width: 18px;
                    height: 18px;
                }
                .talent-gap-grid {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }
                .talent-card {
                    padding: 16px;
                    border-radius: 12px;
                }
                .talent-photo {
                    width: 48px;
                    height: 48px;
                }
                .talent-meta h4 {
                    font-size: 0.95rem;
                }
                .section-title {
                    font-size: 1.05rem;
                    margin-top: 24px;
                    margin-bottom: 16px;
                }
                .heatmap-container {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }
                .heatmap-table {
                    min-width: 700px;
                }
                .legend {
                    flex-wrap: wrap;
                    gap: 8px;
                }
                .donut-container {
                    flex-wrap: wrap;
                    gap: 16px;
                    padding: 16px;
                }
                .donut-container .relative.w-48.h-48 {
                    width: 120px !important;
                    height: 120px !important;
                }
                .donut-container .text-3xl {
                    font-size: 1.25rem !important;
                }
                .idp-card-container {
                    padding: 16px;
                    border-radius: 12px;
                }
                .filter-pills {
                    padding: 3px;
                }
                .pill {
                    padding: 6px 20px;
                    font-size: 0.78rem;
                }
                .pdc-log-table th {
                    padding: 12px 16px;
                    font-size: 0.8rem;
                }
                .pdc-log-table td {
                    padding: 16px;
                    font-size: 0.8rem;
                }
                .pdc-custom-table th {
                    padding: 8px;
                    font-size: 0.75rem;
                }
                .pdc-custom-table td {
                    padding: 8px;
                    font-size: 0.78rem;
                }
            }
        </style>
    </x-slot>

    {{-- ── Page Header Removed to match pdc admin layout ── --}}
    
    {{-- LIVEWIRE COMPONENT --}}
    <livewire:atasan-monitoring-table />

    <x-slot name="scripts">
        <script>
            function switchSection(targetId, el) {
                document.getElementById('section-kompetensi').classList.add('hidden');
                document.getElementById('section-idp').classList.add('hidden');
                document.getElementById('section-project').classList.add('hidden');
                document.getElementById('section-logbook').classList.add('hidden');

                document.getElementById('section-' + targetId).classList.remove('hidden');

                document.querySelectorAll('.tab-item').forEach(tab => {
                    tab.classList.remove('btn-dark', 'active');
                    tab.classList.add('btn-ghost');
                });
                el.classList.add('btn-dark', 'active');
                el.classList.remove('btn-ghost');
            }

            function filterLog(typeId, el) {
                document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
                el.classList.add('active');

                document.querySelectorAll('.log-table-type').forEach(tableDiv => {
                    if (tableDiv.getAttribute('data-type') == typeId) {
                        tableDiv.classList.remove('hidden');
                    } else {
                        tableDiv.classList.add('hidden');
                    }
                });
            }


        </script>
    </x-slot>

    <!-- Generic Logbook Detail Modal -->
    <div id="logbookDetailModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-[500px] p-7 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="logbookDetailModalContent">
            <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-[#1e293b]">Detail Logbook</h3>
                <button onclick="closeLogbookDetailModal()" class="text-gray-400 hover:text-gray-600 bg-gray-50 rounded-full p-2 hover:bg-gray-200 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="text-sm" id="detailModalBody"></div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <button onclick="closeLogbookDetailModal()" class="w-full bg-[#f1f5f9] text-[#64748b] font-bold py-2.5 rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
            </div>
        </div>
    </div>
    <script>
        function openLogbookDetail(btn) {
            const htmlContent = btn.nextElementSibling.innerHTML;
            document.getElementById('detailModalBody').innerHTML = htmlContent;
            const modal = document.getElementById('logbookDetailModal');
            const content = document.getElementById('logbookDetailModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
        }
        function closeLogbookDetailModal() {
            const modal = document.getElementById('logbookDetailModal');
            const content = document.getElementById('logbookDetailModalContent');
            modal.classList.add('opacity-0'); content.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>
</x-atasan.layout>
