<x-pdc_admin.layout title="Detail Archive Talent – Individual Development Plan" :user="$user" :hideSidebar="true">
    <x-slot name="styles">
        <style>
            /* Scrollbar */
            ::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 20px;
            }

            /* Back button */
            .btn-back-bottom {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 32px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                background: #f8fafc;
                color: #475569;
                font-weight: 600;
                font-size: 0.85rem;
                text-decoration: none;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-back-bottom:hover {
                background: #cbd5e1;
                color: #1e293b;
            }

            /* Next button */
            .btn-next-bottom {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 32px;
                border: none;
                border-radius: 10px;
                background: #14b8a6;
                color: white;
                font-weight: 600;
                font-size: 0.85rem;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-next-bottom:hover {
                background: #0d9488;
            }

            /* Profile header card */
            .profile-card {
                background: #0f172a;
                border: none;
                border-radius: 0;
                padding: 24px;
                margin-bottom: 24px;
                margin-top: -32px;
                margin-left: -16px;
                margin-right: -16px;
                width: calc(100% + 32px);
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
                color: white;
            }

            @media(min-width: 1024px) {
                .profile-card {
                    margin-left: -24px;
                    margin-right: -24px;
                    width: calc(100% + 48px);
                    padding-left: 24px;
                    padding-right: 24px;
                }
            }

            .profile-col-1 {
                display: flex;
                align-items: center;
                gap: 16px;
                border-right: 1px dashed rgba(255, 255, 255, 0.2);
                padding-right: 16px;
            }

            .profile-col-general {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 12px;
            }

            .profile-col-general:nth-child(2) {
                border-right: 1px dashed rgba(255, 255, 255, 0.2);
                padding-right: 16px;
            }

            .profile-avatar {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid rgba(255, 255, 255, 0.3);
                flex-shrink: 0;
            }

            .profile-info h3 {
                font-size: 1.1rem;
                font-weight: 800;
                color: white;
                margin-bottom: 2px;
            }

            .profile-info p {
                font-size: 0.78rem;
                color: #cbd5e1;
                font-style: italic;
            }

            .meta-item {
                font-size: 0.78rem;
                color: #cbd5e1;
                display: grid;
                grid-template-columns: 120px 1fr;
                gap: 8px;
                align-items: center;
            }

            .meta-item strong {
                color: white;
                font-weight: 700;
            }

            /* Nav Tabs */
            .nav-tabs-container {
                display: flex;
                justify-content: center;
                margin-bottom: 32px;
                width: 100%;
            }

            .nav-tabs {
                display: flex;
                background: #e2e8f0;
                padding: 4px;
                border-radius: 99px;
                width: 100%;
                max-width: 900px;
                overflow-x: auto;
                -ms-overflow-style: none; /* IE and Edge */
                scrollbar-width: none; /* Firefox */
            }

            .nav-tabs::-webkit-scrollbar {
                display: none; /* Chrome, Safari and Opera */
            }

            .tab-item {
                flex: 1;
                text-align: center;
                padding: 10px 0;
                font-size: 0.85rem;
                font-weight: 700;
                color: #475569;
                cursor: pointer;
                border-radius: 99px;
                transition: all 0.2s;
            }

            @media(max-width: 768px) {
                .tab-item {
                    flex: 0 0 auto;
                    padding: 10px 24px;
                    white-space: nowrap;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            }

            .tab-item.active {
                background: #0f172a;
                color: white;
            }

            /* Section title */
            .section-title {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 24px;
            }

            .sub-section-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 1rem;
                font-weight: 800;
                color: #475569;
                margin-bottom: 16px;
                margin-top: 16px;
            }

            /* Logbook Specific */
            .logbook-pill {
                background: #0f172a;
                color: white;
                padding: 6px 16px;
                border-radius: 99px;
                font-size: 0.75rem;
                font-weight: 700;
                display: inline-block;
                margin-bottom: 16px;
                margin-top: 24px;
            }

            .logbook-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.8125rem;
                margin-bottom: 24px;
            }

            .logbook-table th {
                background: #f8fafc;
                font-weight: 700;
                color: #1e293b;
                text-align: center;
                padding: 12px;
                border: 1px solid #e2e8f0;
            }

            .logbook-table td {
                padding: 12px;
                border: 1px solid #e2e8f0;
                text-align: center;
                color: #475569;
            }

            .empty-row td {
                padding: 24px !important;
                color: #cbd5e1 !important;
                text-align: center;
            }

            /* Finance Specific */
            .finance-box {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 24px;
            }

            .finance-row {
                display: grid;
                grid-template-columns: 200px 1fr;
                gap: 16px;
                margin-bottom: 16px;
                align-items: center;
                font-size: 0.85rem;
            }

            .finance-row strong {
                color: #1e293b;
                font-weight: 800;
            }

            .finance-row span {
                color: #475569;
            }

            .finance-textarea-box {
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px;
                min-height: 80px;
                color: #475569;
                font-size: 0.85rem;
                font-weight: 500;
            }

            .finance-header-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 24px;
            }

            .finance-info-grid {
                display: grid;
                gap: 12px;
            }

            .finance-pill {
                background: #0d9488;
                color: white;
                padding: 6px 16px;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            /* Heatmap table */
            .heatmap-container {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                margin-top: 16px;
            }

            .heatmap-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.8125rem;
            }

            .heatmap-table th,
            .heatmap-table td {
                border: 1px solid #e2e8f0;
                padding: 9px 14px;
                text-align: center;
            }

            .heatmap-table .th-main {
                background: #f8fafc;
                font-weight: 700;
                color: #1e293b;
            }

            .heatmap-table .th-sub {
                font-size: 0.65rem;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                background: #f8fafc;
            }

            .heatmap-table .td-left {
                text-align: left;
                font-weight: 600;
                color: #334155;
            }

            .gap-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 6px 16px;
                border-radius: 5px;
                font-weight: 700;
                min-width: 56px;
            }

            .gap-none {
                background: #f1f5f9;
                color: #64748b;
            }

            .gap-ok {
                background: #cbd5e1;
                color: #1e293b;
            }

            .gap-small {
                background: #f97316;
                color: white;
            }

            .gap-large {
                background: #ef4444;
                color: white;
            }

            /* TOP 3 GAP */
            .gap-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 14px 24px;
                border-radius: 99px;
                margin-bottom: 12px;
                font-size: 1rem;
                font-weight: 700;
                background: white;
                border: 1px solid #e2e8f0;
            }

            .gap-item.prio-1 {
                border: 1.5px solid #ef4444;
                color: #1e293b;
            }

            .gap-item.prio-2 {
                border: 1.5px solid #f97316;
                color: #1e293b;
            }

            .gap-item.prio-3 {
                border: 1.5px solid #8b5cf6;
                color: #1e293b;
            }

            .gap-number {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.85rem;
                margin-right: 16px;
                font-weight: 800;
            }

            .gap-item.prio-1 .gap-number {
                background: #ef4444;
            }

            .gap-item.prio-2 .gap-number {
                background: #f97316;
            }

            .gap-item.prio-3 .gap-number {
                background: #8b5cf6;
            }

            /* IDP Donut */
            .donut-container {
                background: white;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                padding: 32px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02);
                flex-wrap: wrap;
                gap: 24px;
                margin-bottom: 32px;
            }

            @media(max-width:768px) {
                .profile-card {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }

                .profile-col-1,
                .profile-col-general:nth-child(2) {
                    border-right: none;
                    padding-right: 0;
                    border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
                    padding-bottom: 16px;
                }

                .meta-item {
                    grid-template-columns: 1fr;
                    gap: 4px;
                }

                .finance-row {
                    grid-template-columns: 1fr;
                    gap: 4px;
                    margin-bottom: 12px;
                }

                .finance-box {
                    padding: 16px;
                }
            }
        </style>
    </x-slot>

    {{-- Profile Card --}}
    <div class="profile-card">
        {{-- Kolom 1: Profil --}}
        <div class="profile-col-1">
            <img src="{{ isset($talent) && $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(isset($talent) ? $talent->nama : 'Yayang Guntur') . '&background=e0f2fe&color=0284c7' }}"
                alt="{{ $talent->nama ?? 'Yayang Guntur' }}" class="profile-avatar">
            <div class="profile-info">
                <h3>{{ $talent->nama ?? 'Yayang Guntur' }}</h3>
                <p>Talent</p>
            </div>
        </div>

        {{-- Kolom 2: Perusahaan & Mentor --}}
        <div class="profile-col-general">
            <div class="meta-item">
                <strong>Perusahaan</strong><span>{{ isset($talent) && optional($talent->company)->nama_company ? $talent->company->nama_company : 'Tiga Serangkai' }}</span>
            </div>
            <div class="meta-item">
                <strong>Departemen</strong><span>{{ isset($talent) && optional($talent->department)->nama_department ? $talent->department->nama_department : 'Human Resource' }}</span>
            </div>
            <div class="meta-item"><strong>Jabatan yang
                    Dituju</strong><span>{{ isset($talent) && optional($talent->promotion_plan)->targetPosition ? $talent->promotion_plan->targetPosition->position_name : 'Manager' }}</span>
            </div>
        </div>

        {{-- Kolom 3: Departemen & Atasan --}}
        <div class="profile-col-general">
            <div class="meta-item"><strong>Mentor</strong>
                <span>
                    @php
                        if (isset($talent) && isset($talent->promotion_plan)) {
                            $mIds = $talent->promotion_plan->mentor_ids ?? [];
                            echo !empty($mIds)
                                ? \App\Models\User::whereIn('id', $mIds)->pluck('nama')->implode(', ')
                                : (optional($talent->mentor)->nama ?? 'Setyo');
                        } else {
                            echo 'Setyo';
                        }
                    @endphp
                </span>
            </div>
            <div class="meta-item">
                <strong>Atasan</strong><span>{{ isset($talent) && optional($talent->atasan)->nama ? $talent->atasan->nama : 'Turgun' }}</span>
            </div>
            <div class="meta-item"><strong>Periode</strong><span>01/01/2026 - 01/06/2026</span></div>
        </div>
    </div>

    {{-- Nav Tabs --}}
    <div class="nav-tabs-container">
        <div class="nav-tabs">
            <div class="tab-item active" onclick="switchSection('kompetensi', this)">Kompetensi</div>
            <div class="tab-item" onclick="switchSection('idp', this)">IDP Monitoring</div>
            <div class="tab-item" onclick="switchSection('finance', this)">Finance Validation</div>
            <div class="tab-item" onclick="switchSection('panelis', this)">Panelis Review</div>
        </div>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi" class="tab-section" style="display: block;">
        <div class="section-title">Kompetensi</div>

        <div class="sub-section-title">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                    clip-rule="evenodd"></path>
            </svg>
            TOP 3 GAP Kompetensi
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8 mt-4">
            @if(isset($gaps) && count($gaps) > 0)
                @foreach($gaps as $index => $gap)
                    <div class="gap-item prio-{{ $index + 1 }}">
                        <div class="flex items-center">
                            <span class="gap-number">{{ $index + 1 }}</span>
                            {{ optional($gap->competence)->name ?? '-' }}
                        </div>
                        <span>{{ number_format($gap->gap_score, 1) }}</span>
                    </div>
                @endforeach
            @else
                <!-- MOCKUP matching image -->
                <div class="gap-item prio-1">
                    <div class="flex items-center"><span class="gap-number">1</span>Integrity</div><span>-2</span>
                </div>
                <div class="gap-item prio-2">
                    <div class="flex items-center"><span class="gap-number">2</span>Problem Solving & Decision Making</div>
                    <span>-1.5</span>
                </div>
                <div class="gap-item prio-3">
                    <div class="flex items-center"><span class="gap-number">3</span>Leadership</div><span>-1</span>
                </div>
            @endif
        </div>

        <hr class="border-t-2 border-slate-200 my-8">

        <div class="sub-section-title">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                    clip-rule="evenodd"></path>
            </svg>
            Heatmap Kompetensi
        </div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4">
            <div class="heatmap-container overflow-x-auto m-0">
                <table class="heatmap-table">
                    <thead>
                        <tr>
                            <th class="th-main" style="width:300px;">Kompetensi</th>
                            <th class="th-main" style="width:70px;">Standar</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Skor Talent</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Skor Atasan</th>
                            <th class="th-sub border-b-2 border-slate-200 bg-white">Final Score</th>
                            <th class="th-sub bg-[#ef4444] border-[#ef4444] text-white" style="width: 120px;">Gap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($competencies) && count($competencies) > 0)
                            @foreach($competencies as $comp)
                                @php
                                    $standard = $standards[$comp->id] ?? 0;
                                    $detail = $talent->assessmentSession ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id) : null;
                                    $sT = $detail->score_talent ?? 0;
                                    $sA = $detail->score_atasan ?? 0;
                                    $gap = $detail->gap_score ?? 0;
                                    $final = $sA > 0 ? ($sT + $sA) / 2 : ($sT > 0 ? $sT : 0);
                                    $cls = $gap >= 0 ? 'gap-none' : ($gap <= -1.5 ? 'gap-large' : 'gap-small');
                                @endphp
                                <tr>
                                    <td class="td-left">{{ $comp->name }}</td>
                                    <td>{{ number_format((float) $standard, 1) }}</td>
                                    <td><span class="font-bold">{{ $sT ?: '-' }}</span></td>
                                    <td><span class="font-bold">{{ $sA ?: '-' }}</span></td>
                                    <td><span class="font-bold">{{ $final ?: '-' }}</span></td>
                                    <td class="text-center p-2"><span
                                            class="gap-badge {{ $cls }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Average row --}}
                            @php
                                $sess = $talent->assessmentSession;
                                $avgT = $sess ? $sess->details->avg('score_talent') ?? 0 : 0;
                                $avgA = $sess ? $sess->details->avg('score_atasan') ?? 0 : 0;
                                $avgGap = $sess ? $sess->details->avg('gap_score') ?? 0 : 0;
                                $avgCls = $avgGap >= 0 ? 'gap-none' : ($avgGap <= -1.5 ? 'gap-large' : 'gap-small');
                            @endphp
                            <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>{{ number_format(collect($standards)->avg() ?: 0, 1) }}</td>
                                <td>{{ number_format($avgT, 1) }}</td>
                                <td>{{ number_format($avgA, 1) }}</td>
                                <td>{{ number_format(($avgT + $avgA) / 2, 1) }}</td>
                                <td class="text-center p-2"><span
                                        class="gap-badge {{ $avgCls }}">{{ number_format($avgGap, 1) }}</span></td>
                            </tr>
                        @else
                            <!-- MOCKUP matching image -->
                            <tr>
                                <td class="td-left">Integrity</td>
                                <td>5</td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">4</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-none">0</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Communication</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Innovation & Creativity</td>
                                <td>3</td>
                                <td><span class="font-bold">4</span></td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-none">0</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Customer Orientation</td>
                                <td>3</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-none">0</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Teamwork</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Leadership</td>
                                <td>4</td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">4</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Bussiness Acumen</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Problem Solving & Decision Making</td>
                                <td>4</td>
                                <td><span class="font-bold">2</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">2.5</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1.5</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Achievement Orientation</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr>
                                <td class="td-left">Strategic Thinking</td>
                                <td>4</td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td><span class="font-bold">3</span></td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-1</span></td>
                            </tr>
                            <tr class="font-bold bg-gray-50 border-t-2 border-slate-200">
                                <td class="td-left">Nilai Rata-Rata</td>
                                <td>3.9</td>
                                <td>2.8</td>
                                <td>3.1</td>
                                <td>3.0</td>
                                <td class="text-center p-2"><span class="gap-badge gap-small">-0.95</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================================= SECTION: IDP MONITORING ================================= --}}
    <div id="section-idp" class="tab-section" style="display: none;">
        <div class="section-title">IDP Monitoring</div>

        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-8 w-full overflow-hidden">
            <div class="sub-section-title m-0 mb-6">
                <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                IDP Monitoring
            </div>

            <div class="donut-container p-6 md:p-12">
                @php
                    $charts = [
                        ['label' => 'Exposure', 'done' => isset($exposureCount) ? min($exposureCount, 6) : 0, 'total' => 6, 'color' => '#475569'],
                        ['label' => 'Mentoring', 'done' => isset($mentoringCount) ? min($mentoringCount, 6) : 0, 'total' => 6, 'color' => '#eab308'],
                        ['label' => 'Learning', 'done' => isset($learningCount) ? min($learningCount, 6) : 0, 'total' => 6, 'color' => '#14b8a6'],
                    ];
                    $r = 44;
                    $circ = 2 * M_PI * $r;
                @endphp
                @foreach($charts as $chart)
                    @php $pct = $chart['done'] / $chart['total'];
                        $filled = $pct * $circ;
                    $empty = $circ - $filled; @endphp
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative w-40 h-40">
                            <!-- Drop shadow SVG -->
                            <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90 absolute">
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" class="stroke-slate-200"
                                    stroke-width="12" />
                            </svg>
                            <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90 relative"
                                style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                                <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}"
                                    stroke-width="12"
                                    stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}"
                                    stroke-linecap="butt" />
                            </svg>
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center bg-white rounded-full m-3 border border-slate-100 shadow-inner">
                                <span
                                    class="text-[1.45rem] font-extrabold text-slate-800 tracking-tight">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                <span class="text-[0.7rem] font-bold text-slate-400 italic">{{ round($pct * 100) }}%</span>
                            </div>
                        </div>
                        <div class="border border-slate-300 bg-white px-6 py-1.5 rounded-full shadow-sm mt-2">
                            <span class="text-[0.8rem] font-bold text-slate-700">{{ $chart['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="border-t-2 border-slate-200 my-8">

        <div class="sub-section-title">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z">
                </path>
            </svg>
            LogBook
        </div>

        {{-- Exposure Logbook --}}
        @php $exposureActivities = $talent->idpActivities->filter(fn($a) => str_contains(strtolower(optional($a->type)->type_name ?? ''), 'exposure')); @endphp
        <div class="logbook-pill">Exposure</div>
        <div class="overflow-x-auto w-full">
            <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden min-w-[600px]">
                <thead>
                    <tr>
                        <th style="width: 20%;">Mentor</th>
                        <th style="width: 25%;">Tema</th>
                        <th style="width: 15%;">Tanggal Pengiriman</th>
                        <th style="width: 15%;">Tanggal Pelaksanaan</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exposureActivities as $act)
                        @php
                            $statusColor = match (strtolower($act->status ?? '')) {
                                'approved' => 'text-green-600', 'rejected' => 'text-red-600', default => 'text-yellow-600'
                            };
                            $dotColor = match (strtolower($act->status ?? '')) {
                                'approved' => 'bg-green-500', 'rejected' => 'bg-red-500', default => 'bg-yellow-500'
                            };
                        @endphp
                        <tr>
                            <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                            <td>{{ $act->theme ?? '-' }}</td>
                            <td>{{ $act->updated_at ? $act->updated_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $act->activity_date ?? '-' }}</td>
                            <td><span
                                    class="text-[0.7rem] font-bold {{ $statusColor }} flex items-center justify-center gap-1.5"><span
                                        class="w-1.5 h-1.5 {{ $dotColor }} rounded-full"></span>{{ ucfirst($act->status ?? 'Pending') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                    class="text-xs font-bold text-slate-600 flex items-center justify-center gap-1.5 hover:text-[#14b8a6] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6" class="text-center text-slate-400 text-sm py-4">Belum ada aktivitas Exposure</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mentoring Logbook --}}
        @php $mentoringActivities = $talent->idpActivities->filter(fn($a) => str_contains(strtolower(optional($a->type)->type_name ?? ''), 'mentor')); @endphp
        <div class="logbook-pill">Mentoring</div>
        <div class="overflow-x-auto w-full">
            <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden min-w-[600px]">
                <thead>
                    <tr>
                        <th style="width: 20%;">Mentor</th>
                        <th style="width: 25%;">Tema</th>
                        <th style="width: 15%;">Tanggal Pengiriman</th>
                        <th style="width: 15%;">Tanggal Pelaksanaan</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mentoringActivities as $act)
                        @php
                            $statusColor = match (strtolower($act->status ?? '')) {
                                'approved' => 'text-green-600', 'rejected' => 'text-red-600', default => 'text-yellow-600'
                            };
                            $dotColor = match (strtolower($act->status ?? '')) {
                                'approved' => 'bg-green-500', 'rejected' => 'bg-red-500', default => 'bg-yellow-500'
                            };
                        @endphp
                        <tr>
                            <td>{{ optional($act->verifier)->nama ?? '-' }}</td>
                            <td>{{ $act->theme ?? '-' }}</td>
                            <td>{{ $act->updated_at ? $act->updated_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $act->activity_date ?? '-' }}</td>
                            <td><span
                                    class="text-[0.7rem] font-bold {{ $statusColor }} flex items-center justify-center gap-1.5"><span
                                        class="w-1.5 h-1.5 {{ $dotColor }} rounded-full"></span>{{ ucfirst($act->status ?? 'Pending') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                    class="text-xs font-bold text-slate-600 flex items-center justify-center gap-1.5 hover:text-[#14b8a6] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6" class="text-center text-slate-400 text-sm py-4">Belum ada aktivitas Mentoring</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Learning Logbook --}}
        @php $learningActivities = $talent->idpActivities->filter(fn($a) => str_contains(strtolower(optional($a->type)->type_name ?? ''), 'learn')); @endphp
        <div class="logbook-pill">Learning</div>
        <div class="overflow-x-auto w-full">
            <table class="logbook-table shadow-sm bg-white rounded-xl overflow-hidden min-w-[600px]">
                <thead>
                    <tr>
                        <th style="width: 20%;">Sumber</th>
                        <th style="width: 25%;">Tema</th>
                        <th style="width: 15%;">Tanggal Pengiriman</th>
                        <th style="width: 15%;">Tanggal Pelaksanaan</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($learningActivities as $act)
                        @php
                            $statusColor = match (strtolower($act->status ?? '')) {
                                'approved' => 'text-green-600', 'rejected' => 'text-red-600', default => 'text-yellow-600'
                            };
                            $dotColor = match (strtolower($act->status ?? '')) {
                                'approved' => 'bg-green-500', 'rejected' => 'bg-red-500', default => 'bg-yellow-500'
                            };
                        @endphp
                        <tr>
                            <td>{{ $act->platform ?? '-' }}</td>
                            <td>{{ $act->theme ?? '-' }}</td>
                            <td>{{ $act->updated_at ? $act->updated_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $act->activity_date ?? '-' }}</td>
                            <td><span
                                    class="text-[0.7rem] font-bold {{ $statusColor }} flex items-center justify-center gap-1.5"><span
                                        class="w-1.5 h-1.5 {{ $dotColor }} rounded-full"></span>{{ ucfirst($act->status ?? 'Pending') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}"
                                    class="text-xs font-bold text-slate-600 flex items-center justify-center gap-1.5 hover:text-[#14b8a6] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6" class="text-center text-slate-400 text-sm py-4">Belum ada aktivitas Learning</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================================= SECTION: FINANCE VALIDATION ================================= --}}
    <div id="section-finance" class="tab-section" style="display: none;">
        <div class="section-title">Finance Validation</div>

        @php $projects = $talent->improvementProjects; @endphp

        @forelse($projects as $project)
            @php
                $verifier = $project->verifier;
                $statusBadgeColor = match (strtolower($project->status ?? '')) {
                    'approved' => 'border-green-500 text-green-600 bg-green-50/50',
                    'rejected' => 'border-red-500 text-red-600 bg-red-50/50',
                    'pending' => 'border-yellow-500 text-yellow-600 bg-yellow-50/50',
                    default => 'border-slate-400 text-slate-600 bg-slate-50',
                };
                $dotBadgeColor = match (strtolower($project->status ?? '')) {
                    'approved' => 'bg-green-500',
                    'rejected' => 'bg-red-500',
                    'pending' => 'bg-yellow-500',
                    default => 'bg-slate-400',
                };
            @endphp
            <!-- ================= DESKTOP VIEW ================= -->
            <div class="hidden md:block bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-4">
                <div class="finance-box shadow-sm">
                    <div class="finance-header-row">
                        <div class="finance-info-grid">
                            <div class="finance-row"><strong>Nama Finance</strong><span>{{ optional($verifier)->nama ?? '-' }}</span></div>
                            <div class="finance-row"><strong>Email</strong><span>{{ optional($verifier)->email ?? '-' }}</span></div>
                            <div class="finance-row"><strong>Perusahaan</strong><span>{{ optional($talent->company)->nama_company ?? '-' }}</span></div>
                            <div class="finance-row mb-0"><strong>Judul Project</strong><span>{{ $project->title ?? '-' }}</span></div>
                        </div>
                        <div class="finance-pill">
                            Tanggal &nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $project->verify_at ? $project->verify_at->format('d M Y') : '-' }}
                        </div>
                    </div>

                    <div class="mt-4 mb-2"><strong class="text-[0.8rem] text-slate-800">Catatan Admin</strong></div>
                    <div class="finance-textarea-box">{{ $project->feedback ?? '-' }}</div>

                    <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Feedback Finance</strong></div>
                    <div class="finance-textarea-box">
                        {{ preg_replace('/^\[(?:Approved|Rejected|Batal)\]\s*/i', '', $project->finance_feedback ?? '-') }}
                    </div>

                    <hr class="border-t border-slate-200 my-6">

                    <div class="flex items-center justify-between">
                        @if($project->document_path)
                            <a href="{{ route('files.preview', ['path' => $project->document_path]) }}" target="_blank"
                                class="px-6 py-2 border border-slate-300 bg-white rounded-lg text-xs font-bold flex items-center gap-2 hover:bg-slate-50 transition-colors text-slate-700 shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2 6h16v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm4 2a1 1 0 00-1 1v2a1 1 0 001 1h8a1 1 0 001-1V9a1 1 0 00-1-1H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Preview File
                            </a>
                        @else
                            <span class="text-xs text-slate-400">-</span>
                        @endif
                        <div
                            class="px-8 py-2 border rounded-full font-bold text-[0.8rem] flex items-center gap-2 shadow-sm {{ $statusBadgeColor }}">
                            <span class="w-2 h-2 rounded-full {{ $dotBadgeColor }}"></span>
                            {{ ucfirst($project->status ?? 'Pending') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= MOBILE VIEW ================= -->
            <div class="block md:hidden bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-8 w-full overflow-hidden">
                <div class="flex justify-end mb-4">
                    <div class="finance-pill">
                        Tanggal &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $project->verify_at ? $project->verify_at->format('d M Y') : '-' }}
                    </div>
                </div>
                <div class="finance-box shadow-sm">
                    <div class="finance-info-grid">
                        <div class="finance-row"><strong>Nama Finance</strong><span>{{ optional($verifier)->nama ?? '-' }}</span></div>
                        <div class="finance-row"><strong>Email</strong><span>{{ optional($verifier)->email ?? '-' }}</span></div>
                        <div class="finance-row"><strong>Perusahaan</strong><span>{{ optional($talent->company)->nama_company ?? '-' }}</span></div>
                        <div class="finance-row mb-0"><strong>Judul Project</strong><span>{{ $project->title ?? '-' }}</span></div>
                    </div>

                    <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Catatan Admin</strong></div>
                    <div class="finance-textarea-box">{{ $project->feedback ?? '-' }}</div>

                    <div class="mt-6 mb-2"><strong class="text-[0.8rem] text-slate-800">Feedback Finance</strong></div>
                    <div class="finance-textarea-box">
                        {{ preg_replace('/^\[(?:Approved|Rejected|Batal)\]\s*/i', '', $project->finance_feedback ?? '-') }}
                    </div>

                    <hr class="border-t border-slate-200 my-6">

                    <div class="flex flex-row items-center justify-between gap-2">
                        @if($project->document_path)
                            <a href="{{ route('files.preview', ['path' => $project->document_path]) }}" target="_blank"
                                class="px-3 sm:px-6 py-2 border border-slate-300 bg-white rounded-lg text-[0.7rem] sm:text-xs font-bold flex justify-center items-center gap-1.5 sm:gap-2 hover:bg-slate-50 transition-colors text-slate-700 shadow-sm flex-1 mr-1 sm:mr-2">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2 6h16v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm4 2a1 1 0 00-1 1v2a1 1 0 001 1h8a1 1 0 001-1V9a1 1 0 00-1-1H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="whitespace-nowrap">Preview File</span>
                            </a>
                        @else
                            <span class="text-xs text-slate-400 flex-1">-</span>
                        @endif
                        <div
                            class="shrink-0 px-4 sm:px-8 py-2 border rounded-full font-bold text-[0.75rem] sm:text-[0.8rem] flex justify-center items-center gap-1.5 sm:gap-2 shadow-sm {{ $statusBadgeColor }}">
                            <span class="w-2 h-2 rounded-full shrink-0 {{ $dotBadgeColor }}"></span>
                            <span class="whitespace-nowrap">{{ ucfirst($project->status ?? 'Pending') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mt-4 mb-4 text-center text-slate-400">
                Belum ada Project Improvement
            </div>
        @endforelse
    </div>

    {{-- ================================= SECTION: PANELIS REVIEW ================================= --}}
    <div id="section-panelis" class="tab-section" style="display: none;">
        <div class="section-title mb-2">Panelis Review</div>
        @php
            $latestProject = $talent->improvementProjects->sortByDesc('updated_at')->first();
            $panelisAspects = [
                ['name' => 'Pemahaman Bisnis & Strategi', 'indicator' => 'Memahami konteks industri, Business proses dan arah perusahaan'],
                ['name' => 'Identifikasi Masalah', 'indicator' => 'Masalah yang diangkat relevan, kritis, dan berbasis data'],
                ['name' => 'Analisis Akar Masalah', 'indicator' => "Penggunaan tools (Fishbone, 5 Why's atau yang lain), logis dan mendalam"],
                ['name' => 'Solusi yang Ditawarkan', 'indicator' => 'Solusi konkret, realistis, dan menjawab akar masalah'],
                ['name' => 'Rencana Implementasi', 'indicator' => 'Timeline jelas, tahapan logis, melibatkan stakeholder'],
                ['name' => 'Target Dampak & KPI', 'indicator' => 'Indikator keberhasilan terukur, baseline–target jelas'],
                ['name' => 'Risiko & Mitigasi', 'indicator' => 'Mengenali risiko dan menyusun strategi antisipasi'],
                ['name' => 'Gaya Presentasi & Penguasaan Materi', 'indicator' => 'Komunikatif, percaya diri, menjawab pertanyaan'],
                ['name' => 'Refleksi Peran sebagai GM', 'indicator' => 'Menunjukkan kesiapan mindset kepemimpinan, Strategic Thingking dan Conceptual thinking.'],
                ['name' => 'Nilai Tambah', 'indicator' => 'Inisiatif ekstra, kolaborasi, atau insight mendalam'],
            ];
        @endphp
        <p class="text-slate-600 mb-6 text-[1rem]">{{ optional($latestProject)->title ?? '-' }}</p>

        <div class="bg-white rounded-xl border border-slate-200 mt-2 shadow-sm overflow-hidden p-0 w-full">
            <div class="overflow-x-auto w-full">
                <table class="logbook-table mb-0 border-none min-w-[900px]">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th style="width: 22%;" class="border-0 border-r border-slate-200">Panelis</th>
                        <th style="width: 22%;" class="border-0 border-r border-slate-200">Perusahaan</th>
                        <th style="width: 9%;" class="border-0 border-r border-slate-200">Skor</th>
                        <th style="width: 20%;" class="border-0 border-r border-slate-200">Feedback</th>
                        <th style="width: 17%;" class="border-0 border-r border-slate-200">Status</th>
                        <th style="width: 10%;" class="border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($talent->panelisAssessments as $idx => $assessment)
                        @php
                            $rekomen = $assessment->panelis_rekomendasi ?? '';
                            $rekomenDesc = '';
                            if (str_contains($rekomen, 'Ready Now'))
                                $rekomenDesc = 'Siap dipromosikan dalam < 6 bulan';
                            elseif (str_contains($rekomen, '1'))
                                $rekomenDesc = 'Siap dengan pengembangan terarah';
                            elseif (str_contains($rekomen, '2'))
                                $rekomenDesc = 'Masih membutuhkan pengembangan signifikan';
                            elseif (str_contains($rekomen, 'Not Ready'))
                                $rekomenDesc = 'Belum direkomendasikan untuk jalur suksesi';
                        @endphp
                        <tr class="border-b border-slate-200">
                            <td class="font-bold text-slate-800 text-left pl-6 border-0 border-r border-slate-200">
                                {{ optional($assessment->panelis)->nama ?? '-' }}</td>
                            <td class="font-bold text-slate-700 text-left pl-6 border-0 border-r border-slate-200">
                                {{ optional(optional($assessment->panelis)->company)->nama_company ?? '-' }}</td>
                            <td class="font-bold text-slate-800 border-0 border-r border-slate-200">
                                {{ $assessment->panelis_score ?? '-' }} / 50</td>
                            <td class="text-slate-700 border-0 border-r border-slate-200 text-xs">
                                {{ Str::limit($assessment->panelis_komentar ?? '-', 60) }}</td>
                            <td class="border-0 border-r border-slate-200 text-left px-4">
                                @if($rekomen)
                                    <div class="font-bold text-slate-800 text-[0.8rem]">{{ $rekomen }}</div>
                                    @if($rekomenDesc)
                                    <div class="text-[0.65rem] text-slate-500 mt-0.5">{{ $rekomenDesc }}</div>@endif
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="border-0 text-center px-4">
                                <!-- Desktop Button -->
                                <button onclick="openPanelisModal({{ $idx }})"
                                    class="hidden md:inline-block text-xs font-bold text-white bg-teal-500 hover:bg-teal-600 px-3 py-1.5 rounded-lg transition-colors">
                                    Lihat Detail
                                </button>
                                <!-- Mobile Button -->
                                <button onclick="openPanelisModal({{ $idx }})"
                                    class="md:hidden mx-auto whitespace-nowrap px-4 py-2 border border-slate-300 bg-white rounded-lg text-xs font-bold flex items-center justify-center gap-2 hover:bg-slate-50 transition-colors text-slate-700 shadow-sm w-max">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-slate-400 text-sm py-6">Belum ada penilaian Panelis</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        {{-- ======= DATA JSON untuk modal (pass dari PHP ke JS) ======= --}}
        @php
            $panelisModalDataRaw = $talent->panelisAssessments->map(function ($a) {
                return [
                    'nama' => optional($a->panelis)->nama ?? '-',
                    'perusahaan' => optional(optional($a->panelis)->company)->nama_company ?? '-',
                    'score' => $a->panelis_score ?? 0,
                    'scores_json' => is_string($a->panelis_scores_json) ? json_decode($a->panelis_scores_json, true) : ($a->panelis_scores_json ?? []),
                    'komentar' => $a->panelis_komentar ?? '',
                    'rekomendasi' => $a->panelis_rekomendasi ?? '',
                    'tanggal' => $a->panelis_tanggal_penilaian ? $a->panelis_tanggal_penilaian->format('d/m/Y') : '-',
                ];
            })->values();
        @endphp
        <script>
            const panelisModalData = @json($panelisModalDataRaw);

            const panelisAspects = @json($panelisAspects);

            const talentInfo = {
                nama: "{{ $talent->nama ?? '-' }}",
                foto: "{{ $talent->foto ? asset('storage/' . $talent->foto) : '' }}",
                perusahaan: "{{ optional($talent->company)->nama_company ?? '-' }}",
                departemen: "{{ optional($talent->department)->nama_department ?? '-' }}",
                jabatan: "{{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}",
                mentor: "{{ optional($talent->mentor)->nama ?? '-' }}",
                atasan: "{{ optional($talent->atasan)->nama ?? '-' }}",
                project: "{{ optional($latestProject)->title ?? '-' }}",
            };

            function openPanelisModal(idx) {
                const data = panelisModalData[idx];
                const el = id => document.getElementById(id);

                let scores = [];
                if (Array.isArray(data.scores_json)) {
                    scores = data.scores_json;
                } else if (typeof data.scores_json === 'string') {
                    try { scores = JSON.parse(data.scores_json); } catch (e) { }
                } else if (typeof data.scores_json === 'object' && data.scores_json !== null) {
                    scores = Object.values(data.scores_json);
                }

                // Set project title
                el('pm-project').textContent = talentInfo.project;

                // Tabel aspek
                let rows = '';
                panelisAspects.forEach((asp, i) => {
                    const s = parseInt(scores[i]) || 0;
                    rows += `<tr>
                        <td class="text-left px-5 py-4 text-[0.85rem] font-bold text-slate-700 border-b border-slate-200">${asp.name}</td>
                        <td class="text-left px-5 py-4 text-[0.85rem] text-slate-600 border-b border-l border-slate-200">${asp.indicator}</td>
                        <td class="text-center px-4 py-4 border-b border-l border-slate-200">
                            ${s > 0 ? `<span class="inline-flex items-center justify-center w-10 h-10 rounded-[6px] bg-[#14b8a6] text-white font-bold text-[1.1rem]">${s}</span>` : '<span class="text-slate-300 text-sm">-</span>'}
                        </td>
                    </tr>`;
                });
                el('pm-aspek-rows').innerHTML = rows;

                // Komentar, rekomendasi, skor
                el('pm-komentar').textContent = data.komentar || '-';
                el('pm-skor').textContent = data.score + ' / 50';

                const rekomen = data.rekomendasi || '';
                let rekomenDesc = '';
                if (rekomen.includes('Ready Now')) rekomenDesc = 'Siap dipromosikan dalam < 6 bulan';
                else if (rekomen.includes('1')) rekomenDesc = 'Siap dengan pengembangan terarah';
                else if (rekomen.includes('2')) rekomenDesc = 'Masih membutuhkan pengembangan signifikan';
                else if (rekomen.includes('Not Ready')) rekomenDesc = 'Belum direkomendasikan';
                el('pm-rekomen').innerHTML = rekomen
                    ? `<span class="inline-flex items-center gap-3"><span class="w-6 h-6 rounded bg-[#14b8a6] inline-block flex-shrink-0"></span> <strong>${rekomen}</strong> <span class="text-slate-500 font-normal">(${rekomenDesc})</span></span>`
                    : '-';

                // Show detail page, hide others
                document.getElementById('section-panelis').style.display = 'none';
                document.getElementById('bottom-navigation-container').style.display = 'none';
                document.querySelector('.nav-tabs-container').style.display = 'none'; // hide tabs
                document.getElementById('section-panelis-detail').style.display = 'block';

                // Scroll to top of content
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function closePanelisModal() {
                document.getElementById('section-panelis-detail').style.display = 'none';
                document.getElementById('section-panelis').style.display = 'block';
                document.getElementById('bottom-navigation-container').style.display = 'flex';
                document.querySelector('.nav-tabs-container').style.display = ''; // show tabs

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        </script>
    </div>

    {{-- ======= PANELIS DETAIL VIEW ======= --}}
    <div id="section-panelis-detail" style="display: none;">
        <div class="bg-white p-2">
            <p id="pm-project" class="font-bold text-slate-800 text-[1.05rem] mb-5"></p>

            {{-- Aspek Table --}}
            <div class="overflow-x-auto overflow-y-hidden rounded-xl border border-slate-200 mb-5 w-full bg-white">
                <table class="w-full text-sm border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left px-5 py-4 font-bold text-slate-700 w-[30%]">Aspek yang Dinilai</th>
                            <th class="text-left px-5 py-4 font-bold text-slate-700 border-l border-slate-200">Indikator
                                Penilaian</th>
                            <th
                                class="text-center px-4 py-4 font-bold text-slate-700 border-l border-slate-200 w-[100px]">
                                Skor Penilaian</th>
                        </tr>
                    </thead>
                    <tbody id="pm-aspek-rows"></tbody>
                </table>
            </div>

            {{-- Komentar --}}
            <div class="border border-slate-200 rounded-xl mb-6 overflow-hidden">
                <div class="bg-slate-50 px-5 py-3 text-[0.85rem] font-bold text-slate-800 border-b border-slate-200">
                    Komentar / Catatan Panelis:</div>
                <div id="pm-komentar" class="px-5 py-6 text-[0.85rem] text-slate-600 bg-white min-h-[90px]"></div>
            </div>

            {{-- Rekomendasi & Skor --}}
            <div class="border border-slate-200 rounded-xl p-5 mb-5 flex flex-col gap-4 bg-white">
                <div id="pm-rekomen" class="text-[0.85rem] text-slate-700 w-full mb-2"></div>
                <hr class="border-t border-slate-100">
                <div class="flex items-center gap-4 text-[0.85rem] font-bold text-slate-700">
                    Skor <span id="pm-skor"
                        class="border border-slate-200 text-teal-600 rounded-lg px-6 py-2 bg-white font-bold text-[0.95rem] min-w-[85px] text-center"></span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end pt-4">
                <button onclick="closePanelisModal()"
                    class="px-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition-colors shadow-sm text-sm">
                    Kembali
                </button>
            </div>
        </div>
    </div>


    {{-- Bottom Navigation --}}
    <div class="flex justify-end items-center mt-8 mb-4" id="bottom-navigation-container">
        <a href="{{ route('pdc_admin.progress_archive') }}" class="btn-back-bottom shadow-sm"
            style="padding-left: 2rem; padding-right: 2rem;">
            Kembali
        </a>
    </div>

    <x-slot name="scripts">
        <script>
            const sections = ['kompetensi', 'idp', 'finance', 'panelis'];
            let currentSectionIndex = 0;

            document.addEventListener("DOMContentLoaded", function () {
                // Ensure correct initial state
                switchSection('kompetensi', document.querySelector('.tab-item.active'));
            });

            function switchSection(sectionId, element) {
                // hide all sections
                document.querySelectorAll('.tab-section').forEach(el => {
                    el.style.display = 'none';
                });

                // remove active class from all tabs
                document.querySelectorAll('.tab-item').forEach(el => {
                    el.classList.remove('active');
                });

                // show target section
                document.getElementById('section-' + sectionId).style.display = 'block';

                // set active tab
                if (element) {
                    element.classList.add('active');
                } else {
                    document.querySelector('.tab-item:nth-child(' + (sections.indexOf(sectionId) + 1) + ')').classList.add('active');
                }

                currentSectionIndex = sections.indexOf(sectionId);

                const nextBtn = document.getElementById('btnNextSection');
                if (nextBtn) {
                    if (currentSectionIndex === sections.length - 1) {
                        nextBtn.style.display = 'none';
                    } else {
                        nextBtn.style.display = 'inline-flex';
                    }
                }

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Removed nextSection and prevSection as they are no longer needed
        </script>
    </x-slot>

</x-pdc_admin.layout>
