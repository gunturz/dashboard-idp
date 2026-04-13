<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - Laporan Hasil Penilaian Promosi Talent</title>
    <style>
        @page {
            margin: 2.54cm !important;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .preview-container {
            width: 100%;
        }

        .page {
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2c3e50;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background-color: #34495e;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 12px;
            border-radius: 3px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 8px 10px;
            font-size: 13px;
            border: none;
        }

        .info-table .label {
            width: 200px;
            font-weight: bold;
            color: #555;
        }

        .info-table .separator {
            width: 20px;
            text-align: center;
            color: #7f8c8d;
        }

        .info-table .value {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table th {
            background-color: #95a5a6;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #7f8c8d;
        }

        table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #ecf0f1;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .gap-high {
            color: #e74c3c;
            font-weight: bold;
            background-color: #fadbd8;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }

        .gap-medium {
            color: #f39c12;
            font-weight: bold;
            background-color: #fef5e7;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }

        .gap-low {
            color: #27ae60;
            font-weight: bold;
            background-color: #d5f4e6;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }

        .subsection-title {
            background-color: transparent;
            color: #2c3e50;
            padding: 8px 0;
            font-size: 13px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
            border-bottom: 2px solid #34495e;
        }

        .page-break {
            margin-top: 25px;
        }

        .badge-progress {
            background-color: #3498db;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 11px;
        }

        .preview-header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        .project-title-row {
            background-color: transparent !important;
            color: #2c3e50;
        }

        .project-title-row td {
            font-weight: bold;
            font-size: 14px;
            padding: 12px !important;
        }

        .panelis-review-header {
            background-color: #7f8c8d !important;
            color: white;
        }

        .decision-approved {
            background-color: #d5f4e6;
            color: #27ae60;
            padding: 4px 10px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }

        .decision-rejected {
            background-color: #fadbd8;
            color: #e74c3c;
            padding: 4px 10px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }

        .decision-pending {
            background-color: #fef5e7;
            color: #f39c12;
            padding: 4px 10px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>

<body>
    @php
        $latestAssessment = $talent->assessmentSession;
        $details = optional($latestAssessment)->details;
        $topGaps = collect();
        if ($details) {
            $overrides = $details->filter(function ($d) {
                return str_starts_with($d->notes ?? '', 'priority_');
            })->sortBy(function ($d) {
                return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
            });
            if ($overrides->count() > 0) {
                $topGaps = $overrides->values();
            } else {
                $topGaps = $details->sortBy('gap_score')->take(3)->values();
            }
        }
    @endphp

    <div class="preview-container">
        <!-- HALAMAN 1 -->
        <div class="page">
            <div class="content-wrapper">
                <!-- Header -->
                <div class="header">
                    <div class="title">LAPORAN HASIL PENILAIAN PROMOSI TALENT</div>
                </div>

                <!-- Informasi Talent -->
                <div class="section">
                    <div class="section-title">Informasi Talent</div>
                    <table class="info-table">
                        <tr>
                            <td class="label">Nama</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $talent->nama }}</td>
                        </tr>
                        <tr>
                            <td class="label">Perusahaan</td>
                            <td class="separator">:</td>
                            <td class="value">{{ optional($talent->company)->nama_company ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Department</td>
                            <td class="separator">:</td>
                            <td class="value">{{ optional($talent->department)->nama_department ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Posisi Saat Ini</td>
                            <td class="separator">:</td>
                            <td class="value">{{ optional($talent->position)->position_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Atasan</td>
                            <td class="separator">:</td>
                            <td class="value">{{ optional($talent->atasan)->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Mentor</td>
                            <td class="separator">:</td>
                            <td class="value">{{ optional($talent->mentor)->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Posisi yang Di Tuju</td>
                            <td class="separator">:</td>
                            <td class="value"><strong
                                    style="color: #e74c3c;">{{ optional($talent->promotion_plan->targetPosition)->position_name ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Top 3 GAP Kompetensi -->
                <div class="section">
                    <div class="section-title">Top 3 GAP Kompetensi</div>
                    <table>
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">No</th>
                                <th width="60%">Kompetensi</th>
                                <th width="30%" class="text-center">GAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topGaps as $index => $detail)
                                @php
                                    $compName = optional($detail->competence)->name ?? 'Unknown';
                                    $gapVal = $detail->gap_score;
                                    $gapClass = 'gap-low';
                                    if ($gapVal <= -2)
                                        $gapClass = 'gap-high';
                                    elseif ($gapVal <= -1)
                                        $gapClass = 'gap-medium';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $compName }}</td>
                                    <td class="text-center">
                                        <span class="{{ $gapClass }}">{{ number_format($gapVal, 2) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center" style="padding: 15px;">Tidak ada gap kompetensi
                                        signifikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Score Kompetensi -->
                <div class="section">
                    <div class="section-title">Score Kompetensi</div>
                    <table style="font-size: 11px;">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="28%">Kompetensi</th>
                                <th width="10%" class="text-center">Standar</th>
                                <th width="11%" class="text-center">Skor Talent</th>
                                <th width="11%" class="text-center">Skor Atasan</th>
                                <th width="11%" class="text-center">Final Skor</th>
                                <th width="11%" class="text-center">GAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competencies as $index => $comp)
                                @php
                                    $detail = $latestAssessment ? $latestAssessment->details->where('competence_id', $comp->id)->first() : null;
                                    $selfScore = $detail ? $detail->score_talent : 0;
                                    $atasanScore = $detail ? $detail->score_atasan : 0;
                                    $finalScore = $atasanScore > 0 ? ($selfScore + $atasanScore) / 2 : ($selfScore > 0 ? $selfScore : 0);
                                    $std = $standards->get($comp->id) ?? 0;
                                    $gap = $detail ? $detail->gap_score : ($finalScore > 0 ? $finalScore - $std : 0);

                                    $gapClass = '';
                                    if ($gap <= -2)
                                        $gapClass = 'gap-high';
                                    elseif ($gap <= -1)
                                        $gapClass = 'gap-medium';
                                    elseif ($gap < 0)
                                        $gapClass = 'gap-low';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $comp->name }}</td>
                                    <td class="text-center">{{ number_format($std, 2) }}</td>
                                    <td class="text-center">{{ number_format($selfScore, 2) }}</td>
                                    <td class="text-center">{{ number_format($atasanScore, 2) }}</td>
                                    <td class="text-center"><strong>{{ number_format($finalScore, 2) }}</strong></td>
                                    <td class="text-center">
                                        @if($gap < 0)
                                            <span class="{{ $gapClass }}">{{ number_format($gap, 2) }}</span>
                                        @else
                                            <span style="color: #7f8c8d;">{{ number_format($gap, 2) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @php
            $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
            $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
            $learningCount = $talent->idpActivities->where('type_idp', 3)->count();

            $idpCharts = [
                ['label' => 'Exposure (Rotasi / Penugasan Khusus)', 'done' => min($exposureCount, 6), 'total' => 6, 'type_idp' => 1, 'short_label' => 'Exposure'],
                ['label' => 'Mentoring (Coaching & Mentoring)', 'done' => min($mentoringCount, 6), 'total' => 6, 'type_idp' => 2, 'short_label' => 'Mentoring'],
                ['label' => 'Learning (Training & Development)', 'done' => min($learningCount, 6), 'total' => 6, 'type_idp' => 3, 'short_label' => 'Learning'],
            ];
        @endphp

        <!-- HALAMAN 2 -->
        <div class="page page-break">
            <div class="content-wrapper">
                <!-- Monitoring IDP -->
                <div class="section">
                    <div class="section-title">Monitoring IDP</div>
                    <table>
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">No</th>
                                <th width="50%">IDP Type</th>
                                <th width="40%" class="text-center">Persentase Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $noIdp = 1; @endphp
                            @foreach($idpCharts as $chart)
                                @php
                                    $percent = ($chart['done'] / $chart['total']) * 100;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $noIdp++ }}</td>
                                    <td>{{ $chart['label'] }}</td>
                                    <td class="text-center">
                                        <span class="badge-progress">{{ number_format($percent, 2) }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- LogBook IDP -->
                <div class="section">
                    <div class="section-title">LogBook IDP</div>

                    @foreach($idpCharts as $chart)
                        @php
                            $activities = $talent->idpActivities->where('type_idp', $chart['type_idp']);
                        @endphp
                        <div class="subsection-title">{{ $chart['short_label'] }}</div>
                        <table style="font-size: 11px;">
                            <thead>
                                <tr>
                                    <th width="8%" class="text-center">No</th>
                                    @if($chart['type_idp'] == 1)
                                        <th width="46%">Tema</th>
                                        <th width="46%">Aktivitas</th>
                                    @elseif($chart['type_idp'] == 2)
                                        <th width="30%">Tema</th>
                                        <th width="32%">Deskripsi</th>
                                        <th width="30%">Action Plan</th>
                                    @elseif($chart['type_idp'] == 3)
                                        <th width="30%">Tema</th>
                                        <th width="32%">Sumber</th>
                                        <th width="30%">Platform</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $act)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        @if($chart['type_idp'] == 1)
                                            <td>{{ $act->theme ?: '-' }}</td>
                                            <td>{{ $act->activity ?: '-' }}</td>
                                        @elseif($chart['type_idp'] == 2)
                                            <td>{{ $act->theme ?: '-' }}</td>
                                            <td>{{ $act->description ?: '-' }}</td>
                                            <td>{{ $act->action_plan ?: '-' }}</td>
                                        @elseif($chart['type_idp'] == 3)
                                            <td>{{ $act->theme ?: '-' }}</td>
                                            <td>{{ $act->activity ?: '-' }}</td>
                                            <td>{{ $act->platform ?: '-' }}</td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        @php $colCount = $chart['type_idp'] == 1 ? 3 : 4; @endphp
                                        <td colspan="{{ $colCount }}" class="text-center">Belum ada aktivitas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- HALAMAN 3 -->
        <div class="page page-break">
            <div class="content-wrapper">
                <!-- Project Improvement -->
                <div class="section">
                    <div class="section-title">Project Improvement</div>
                    @php
                        $bodUsers = \App\Models\User::whereHas('roles', fn($q) => $q->whereIn('role_name', ['bod', 'bo_director', 'board_of_directors', 'board_of_director']))
                            ->with('company')
                            ->orderBy('nama')
                            ->get();
                        $totalRows = max(5, $bodUsers->count());
                    @endphp

                    @forelse($talent->improvementProjects as $proj)
                        <table style="margin-bottom: 25px;">
                            <!-- Baris Judul Project -->
                            <tr class="project-title-row">
                                <td colspan="5" style="vertical-align: top; text-align: left; height: 75px; padding: 12px;">
                                    <div style="font-size: 10px; font-weight: normal; color: #7f8c8d; margin-bottom: -15px;">Judul :</div>
                                    <div style="text-transform: uppercase; text-align: center; margin-top: 15px; font-weight: bold; width: 100%;">
                                        {{ $proj->title }}
                                    </div>
                                </td>
                            </tr>

                            <!-- Header Kolom Review BOD -->
                            <tr class="bod-review-header">
                                <th width="25%">Reviewer / Verifikator</th>
                                <th width="20%">Status Proyek</th>
                                <th width="35%">Feedback</th>
                                <th width="20%" class="text-center">Status</th>
                            </tr>

                            <!-- Review -->
                            @php
                                $noBOD = 1;
                                $hasReviewData = false;
                            @endphp
                            @for ($i = 0; $i < $bodUsers->count(); $i++)
                                @php 
                                    $bod = $bodUsers->get($i); 
                                    $hasScoreThisBod = ($i === 0 && ($proj->verify_at || $proj->feedback || $proj->status === 'Verified'));
                                @endphp
                                
                                @if ($hasScoreThisBod)
                                    @php $hasReviewData = true; @endphp
                                    <tr>
                                        <td class="text-center">{{ $noBOD++ }}</td>
                                        <td>
                                            @if ($bod)
                                                <strong>{{ $bod->nama }}</strong><br>
                                                @if (optional($bod->company)->nama_company)
                                                    <em style="font-size: 11px; color: #555;">{{ $bod->company->nama_company }}</em>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($proj->verify_at)
                                                
                                            @endif
                                        </td>
                                        <td>
                                            @if ($proj->feedback)
                                                {{ $proj->feedback }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($proj->status === 'Verified')
                                                <span style="font-weight: bold; color: #1e293b; display: block;">Ready in 1 – 2 Years</span>
                                                <em style="font-size: 10px; color: #64748b; display: block;">(Siap dengan pengembangan terarah)</em>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endfor

                            @if (!$hasReviewData)
                                <tr>
                                    <td colspan="5" class="text-center" style="padding: 20px; color: #7f8c8d; font-style: italic;">
                                        Belum ada BOD yang memberikan nilai.
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @empty
                        <p class="text-center" style="font-size: 12px; padding: 20px;">Belum ada Project Improvement yang
                            diajukan.</p>
                    @endforelse
                </div>

                <!-- Signature Section -->
                <div class="section" style="margin-top: 60px; page-break-inside: avoid;">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 50%; border: none; text-align: center; padding: 20px;">
                                <div style="margin-bottom: 80px;">
                                    <strong>Mengetahui,</strong><br>
                                    <strong>Head of People Development Center</strong>
                                </div>
                                <div style="border-bottom: 2px solid #000; width: 250px; margin: 0 auto;"></div>
                                <div style="margin-top: 10px;">
                                    <strong>Dr. Rahayu Wijayanti, M.Psi</strong><br>
                                    <small>NIK: 19850615.001</small>
                                </div>
                            </td>
                            <td style="width: 50%; border: none; text-align: center; padding: 20px;">
                                <div style="margin-bottom: 80px;">
                                    <strong>Menyetujui,</strong><br>
                                    <strong>Chief Executive Officer</strong>
                                </div>
                                <div style="border-bottom: 2px solid #000; width: 250px; margin: 0 auto;"></div>
                                <div style="margin-top: 10px;">
                                    <strong>Hendra Gunawan, S.E., M.B.A.</strong><br>
                                    <small>NIK: 19750523.002</small>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>