<x-pdc_admin.layout title="Dashboard PDC Admin – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ══ Page Header ══ */
            .dash-header {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 28px;
            }

            .dash-header-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                background: #0f172a;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
                flex-shrink: 0;
            }

            .dash-header-icon svg {
                color: white;
                width: 24px;
                height: 24px;
            }

            .dash-header-title {
                font-size: 1.6rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1.1;
            }

            .dash-header-sub {
                font-size: 0.8rem;
                color: #64748b;
                margin-top: 2px;
                font-weight: 400;
            }

            .dash-header-date {
                margin-left: auto;
                font-size: 0.78rem;
                color: #94a3b8;
                font-weight: 500;
                text-align: right;
            }

            .dash-header-date span {
                display: block;
                font-size: 1rem;
                font-weight: 700;
                color: #475569;
            }

            .animate-title {
                animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
            }

            @keyframes titleReveal {
                from {
                    opacity: 0;
                    transform: translateX(-20px)
                }

                to {
                    opacity: 1;
                    transform: translateX(0)
                }
            }

            /* ══ Vue App ══ */
            #pdc-dashboard-app {
                width: 100%;
            }

            /* ══ Main Grid ══ */
            .main-grid {
                display: grid;
                grid-template-columns: 320px 1fr;
                gap: 20px;
                align-items: start;
                margin-bottom: 24px;
            }

            @media(max-width:1024px) {
                .main-grid {
                    grid-template-columns: 1fr
                }
            }

            /* ══ Glass Card ══ */
            .glass-card {
                background: #f9fafb;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
                overflow: hidden;
            }

            .card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 18px 20px;
                border-bottom: 1px solid #e2e8f0;
                gap: 12px;
                flex-wrap: wrap;
            }

            .card-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: .9rem;
                font-weight: 700;
                color: #1e293b;
            }

            .card-title svg {
                width: 18px;
                height: 18px;
                color: #14b8a6;
                flex-shrink: 0;
            }

            .card-badge {
                font-size: .65rem;
                font-weight: 700;
                letter-spacing: .05em;
                color: #14b8a6;
                background: rgba(20, 184, 166, .1);
                border: 1px solid rgba(20, 184, 166, .25);
                border-radius: 99px;
                padding: 2px 10px;
                animation: pulseBadge 2s ease infinite;
            }

            @keyframes pulseBadge {

                0%,
                100% {
                    opacity: 1
                }

                50% {
                    opacity: .6
                }
            }

            /* ══ Chart ══ */
            .chart-container {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px 20px 8px;
            }

            .chart-center {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
                pointer-events: none;
            }

            .chart-total {
                font-size: 1.8rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1;
            }

            .chart-total-label {
                font-size: .7rem;
                color: #64748b;
                font-weight: 500;
                margin-top: 2px;
            }

            .legend-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 6px 12px;
                padding: 12px 20px 16px;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 7px;
                font-size: .78rem;
                color: #334155;
            }

            .legend-dot {
                width: 9px;
                height: 9px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .legend-label {
                flex: 1;
                color: #64748b;
            }

            .legend-val {
                font-weight: 700;
                color: #1e293b;
            }

            /* ══ Role List ══ */
            .role-list {
                padding: 12px 16px 16px;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .role-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 14px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, .02);
            }

            .role-item-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .role-item-name {
                flex: 1;
                font-size: .85rem;
                font-weight: 600;
                color: #334155;
            }

            .role-item-count {
                font-size: .85rem;
                font-weight: 700;
                color: #64748b;
            }

            /* ══ Table Card ══ */
            .search-box {
                display: flex;
                align-items: center;
                gap: 8px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 6px 12px;
            }

            .search-box svg {
                width: 15px;
                height: 15px;
                color: #94a3b8;
                flex-shrink: 0;
            }

            .search-input {
                border: none;
                background: transparent;
                font-size: .8rem;
                color: #334155;
                outline: none;
                width: 150px;
            }

            .search-input::placeholder {
                color: #94a3b8;
            }

            .empty-state {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 48px 20px;
                color: #94a3b8;
                gap: 12px;
                font-size: .85rem;
                font-weight: 500;
            }

            .empty-state svg {
                width: 40px;
                height: 40px;
            }

            .table-scroll {
                overflow-x: auto;
            }

            .highlight-table {
                width: 100%;
                border-collapse: collapse;
                font-size: .82rem;
            }

            .highlight-table th {
                background: #f1f5f9;
                color: #1e293b;
                font-weight: 700;
                text-align: left;
                padding: 11px 16px;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
                white-space: nowrap;
                font-size: .8rem;
                text-transform: none;
                letter-spacing: 0;
            }

            .highlight-table th:last-child {
                border-right: none;
            }

            .highlight-table td {
                padding: 13px 16px;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
                color: #334155;
            }

            .highlight-table td:last-child {
                border-right: none;
            }

            .table-row {
                transition: background .15s;
            }

            .table-row:hover td {
                background: #f0fdfa !important;
            }

            .row-even td {
                background: #fafbfc;
            }

            .td-position {
                font-weight: 700;
                color: #1e293b;
            }

            .td-sub {
                font-size: .7rem;
                color: #94a3b8;
                margin-top: 2px;
                font-style: italic;
            }

            .td-name {
                font-weight: 600;
                color: #1e293b;
            }

            .td-muted {
                color: #64748b;
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="dash-header animate-title">
        <div class="dash-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                <path
                    d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z" />
            </svg>
        </div>
        <div>
            <div class="dash-header-title">Dashboard</div>
            <div class="dash-header-sub">Individual Development Plan – PDC Admin</div>
        </div>
        <div class="dash-header-date hidden md:block">
            Hari ini
            <span>{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- ── Main Dashboard Content ── --}}
    <div id="pdc-dashboard-wrapper">
        <!-- Stats Grid -->
        @php
            $palette = ['#14b8a6', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444'];
            $roleLabels = ['Talent', 'Mentor', 'Atasan', 'Finance', 'Panelis'];
            $roleChartData = [];
            foreach ($roleLabels as $idx => $r) {
                $roleChartData[] = [
                    'label' => $r,
                    'value' => $roleCounts[$r] ?? 0,
                    'color' => $palette[$idx],
                ];
            }
            $roleChartDataJson = json_encode($roleChartData);
        @endphp

        <div class="prem-stat-grid" style="grid-template-columns: repeat(4, 1fr);">
            <a href="{{ route('pdc_admin.user_management') }}" class="prem-stat clickable prem-stat-teal">
                <div class="prem-stat-icon si-teal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg></div>
                <div class="prem-stat-value animate-counter" data-target="{{ (int) ($totalUsers ?? 0) }}">0</div>
                <div class="prem-stat-label">Total User</div>
            </a>
            <a href="{{ route('pdc_admin.progress_talent') }}" class="prem-stat clickable prem-stat-blue">
                <div class="prem-stat-icon si-blue"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg></div>
                <div class="prem-stat-value animate-counter" data-target="{{ (int) ($onProgressTalent ?? 0) }}">0</div>
                <div class="prem-stat-label">On Progress</div>
            </a>
            <a href="{{ route('pdc_admin.finance_validation') }}" class="prem-stat clickable prem-stat-green">
                <div class="prem-stat-icon si-green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"/><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"/></svg></div>
                <div class="prem-stat-value animate-counter" data-target="{{ (int) ($pendingFinance ?? 0) }}">0</div>
                <div class="prem-stat-label">Pending Finance</div>
            </a>
            <a href="{{ route('pdc_admin.panelis_review') }}" class="prem-stat clickable prem-stat-amber">
                <div class="prem-stat-icon si-amber"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg></div>
                <div class="prem-stat-value animate-counter" data-target="{{ (int) ($pendingPanelis ?? 0) }}">0</div>
                <div class="prem-stat-label">Pending Panelis</div>
            </a>
        </div>

        <!-- Main Grid -->
        <div class="main-grid mt-6">
            <!-- Left: Chart + Role Breakdown -->
            <div>
                <div class="glass-card" style="padding-bottom:8px">
                    <div class="card-header">
                        <span class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" />
                            </svg>
                            Distribusi User
                        </span>
                    </div>
                    <div class="chart-container">
                        <canvas id="donutCanvas" width="240" height="240"></canvas>
                        <div class="chart-center">
                            <div class="chart-total animate-counter" data-target="{{ (int) ($totalUsers ?? 0) }}">0
                            </div>
                            <div class="chart-total-label">Total User</div>
                        </div>
                    </div>
                    <div class="role-list" style="padding-top:8px;">
                        @foreach ($roleChartData as $item)
                            <div class="role-item">
                                <span class="role-item-dot" style="background: {{ $item['color'] }}"></span>
                                <span class="role-item-name">{{ $item['label'] }}</span>
                                <span class="role-item-count">{{ $item['value'] }} users</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Progress Table (Livewire) -->
            <div class="glass-card" style="display:flex;flex-direction:column">
                <livewire:pdc-dashboard-table />
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ── Animated Counter ─────────────────────────────────────────────────
                const counters = document.querySelectorAll('.animate-counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target') || '0', 10);
                    const duration = 1100;
                    const start = performance.now();
                    const step = (now) => {
                        const p = Math.min((now - start) / duration, 1);
                        const ease = 1 - Math.pow(1 - p, 3);
                        counter.innerText = Math.round(ease * target);
                        if (p < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                });

                // ── Draw Donut Canvas ──────────────────────────────────────────────
                const canvas = document.getElementById('donutCanvas');
                if (canvas) {
                    const ctx = canvas.getContext('2d');
                    const roleChartData = {!! $roleChartDataJson ?? '[]' !!};

                    const W = canvas.width, H = canvas.height;
                    const cx = W / 2, cy = H / 2;
                    const R = Math.min(W, H) / 2 - 14;
                    const r = R * 0.60;

                    const total = roleChartData.reduce((s, d) => s + (d.value || 0), 0) || 1;
                    ctx.clearRect(0, 0, W, H);
                    let startAngle = -Math.PI / 2;
                    const gap = 0.025;

                    roleChartData.forEach(seg => {
                        if (!seg.value) return;
                        const slice = (seg.value / total) * (2 * Math.PI) - gap;
                        ctx.beginPath();
                        ctx.moveTo(cx, cy);
                        ctx.arc(cx, cy, R, startAngle, startAngle + slice);
                        ctx.closePath();
                        const g = ctx.createLinearGradient(cx - R, cy - R, cx + R, cy + R);
                        g.addColorStop(0, seg.color + 'cc');
                        g.addColorStop(1, seg.color);
                        ctx.fillStyle = g;
                        ctx.shadowColor = seg.color + '55';
                        ctx.shadowBlur = 8;
                        ctx.fill();
                        startAngle += slice + gap;
                    });

                    // Inner hole
                    ctx.beginPath();
                    ctx.arc(cx, cy, r, 0, 2 * Math.PI);
                    ctx.fillStyle = '#ffffff';
                    ctx.shadowBlur = 0;
                    ctx.fill();
                }
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>
