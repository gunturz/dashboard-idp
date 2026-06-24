<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - Laporan Hasil Penilaian Talent</title>
    @php
        $poppinsRegular =
            'file:///' .
            str_replace('\\', '/', storage_path('fonts/poppins_normal_59578db0d134e5107911b0772fcd36b3.ttf'));
        $poppinsLight =
            'file:///' . str_replace('\\', '/', storage_path('fonts/poppins_300_2e2883f4cf5280db5a8f5b456d9f76e7.ttf'));
        $poppinsMedium =
            'file:///' . str_replace('\\', '/', storage_path('fonts/poppins_500_e357e72d1459b7129a703bd036127015.ttf'));
        $poppinsSemiBold =
            'file:///' . str_replace('\\', '/', storage_path('fonts/poppins_600_7d20ab77d986921f47f6842ca5ca81b1.ttf'));
        $poppinsBold =
            'file:///' .
            str_replace('\\', '/', storage_path('fonts/poppins_bold_e92875066bf07ed4e7ee92062224b42c.ttf'));
        $libreRegular =
            'file:///' .
            str_replace('\\', '/', storage_path('fonts/libre_baskerville_normal_77dd107e43bb42406212ddbe1662875c.ttf'));
        $libreBold =
            'file:///' .
            str_replace('\\', '/', storage_path('fonts/libre_baskerville_bold_0df436a566c5292bde25190e2feb6d2f.ttf'));
    @endphp
    <style>
        @font-face {
            font-family: 'PoppinsPdf';
            font-style: normal;
            font-weight: 300;
            src: url('{{ $poppinsLight }}') format('truetype');
        }

        @font-face {
            font-family: 'PoppinsPdf';
            font-style: normal;
            font-weight: 400;
            src: url('{{ $poppinsRegular }}') format('truetype');
        }

        @font-face {
            font-family: 'PoppinsPdf';
            font-style: normal;
            font-weight: 500;
            src: url('{{ $poppinsMedium }}') format('truetype');
        }

        @font-face {
            font-family: 'PoppinsPdf';
            font-style: normal;
            font-weight: 600;
            src: url('{{ $poppinsSemiBold }}') format('truetype');
        }

        @font-face {
            font-family: 'PoppinsPdf';
            font-style: normal;
            font-weight: 700;
            src: url('{{ $poppinsBold }}') format('truetype');
        }

        @font-face {
            font-family: 'LibreBaskervillePdf';
            font-style: normal;
            font-weight: 400;
            src: url('{{ $libreRegular }}') format('truetype');
        }

        @font-face {
            font-family: 'LibreBaskervillePdf';
            font-style: normal;
            font-weight: 700;
            src: url('{{ $libreBold }}') format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 0cm;
        }

        html,
        body {
            font-family: 'PoppinsPdf', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* ===== COVER PAGE ===== */
        .preview-container {
            width: 100%;
        }

        /* Margin untuk halaman konten (bukan cover) */
        .content-page {
            padding: 2.54cm;
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
            font-family: 'LibreBaskervillePdf', serif;
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
            color: #000000;
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

        .profile-table {
            width: 78%;
            margin: 0 auto;
            text-align: left;
            font-size: 16px;
            line-height: 1.5;
            page-break-inside: avoid;
        }

        .profile-table th,
        .profile-table td {
            border: none !important;
            background-color: transparent !important;
            font-size: inherit;
            padding: 4px 9px !important;
            color: #000000 !important;
        }

        .profile-table th {
            font-weight: 700;
        }

        .profile-table td {
            font-weight: 400;
        }

        .profile-table tr,
        .profile-table tr:nth-child(even),
        .profile-table tr:hover {
            background-color: transparent !important;
        }

        .profile-page-content {
            position: relative;
            z-index: 10;
            padding: 76px 58px 48px;
            text-align: center;
        }

        .profile-logo-wrap {
            margin-top: 0;
            margin-bottom: 56px;
        }

        .profile-logo {
            height: 55px;
            width: auto;
            display: inline-block;
        }

        .profile-main-title {
            font-family: 'LibreBaskervillePdf', serif;
            font-size: 38px;
            font-weight: 700;
            color: #000000;
            line-height: 1.25;
            margin-bottom: 36px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-subtitle {
            font-size: 16px;
            color: #000000;
            margin: 0 auto 70px;
            padding: 0 72px;
            line-height: 1.45;
        }

        .profile-project-summary {
            margin-top: 70px;
            font-size: 16px;
            color: #000000;
            line-height: 1.45;
            padding: 0 72px;
            page-break-inside: avoid;
        }

        .pdf-footer-text {
            font-size: 12px;
            color: #828282;
            font-weight: 200;
            letter-spacing: 0.5px;
        }

        .idp-section-row,
        .idp-section-row>td,
        .idp-section-block,
        .idp-note {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .idp-section-title,
        .idp-activity-table {
            page-break-after: avoid !important;
        }

        .competency-score-table th,
        .competency-score-table td,
        .idp-activity-table th,
        .idp-activity-table td {
            font-size: 16px !important;
        }

        .panelis-company-name {
            font-family: 'PoppinsPdf', sans-serif !important;
            font-style: italic !important;
            font-weight: 400 !important;
            color: #666;
            font-size: 10px;
            margin-top: 2px;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    @php
        $latestAssessment = $talent->assessmentSession;
        $details = optional($latestAssessment)->details;
        $topGaps = collect();
        if ($details) {
            $overrides = $details
                ->filter(function ($d) {
                    return str_starts_with($d->notes ?? '', 'priority_');
                })
                ->sortBy(function ($d) {
                    return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
                });
            if ($overrides->count() > 0) {
                $topGaps = $overrides->values();
            } else {
                $topGaps = $details->sortBy('gap_score')->take(3)->values();
            }
        }
    @endphp

    <!-- FIXED BACKGROUND BORDER UNTUK HALAMAN DINAMIS (Logbook IDP dll.) -->
    <div style="position: fixed; top: 0; left: 0; width: 210mm; height: 297mm; z-index: -1;">
        <img src="{{ $border_image }}" style="width: 210mm; height: 297mm; display:block; margin:0; padding:0;"
            alt="Border">
    </div>

    <!-- GLOBALLY FIXED FOOTER FOR DYNAMIC PAGES -->
    <div style="position: fixed; bottom: 45px; left: 0; right: 0; text-align: center; z-index: -1;">
        <span class="pdf-footer-text">PDC | Laporan Hasil
            Penelitian Promosi Talent</span>
    </div>

    <div class="preview-container">
        <!-- COVER PAGE: full-bleed @page margin=0 approach (Halaman 1)-->
        <div
            style="width:210mm; height:297mm; page-break-after:always; page-break-inside:avoid; background:#ffffff; position:relative; overflow:hidden; margin: 0; padding: 0;">

            <!-- BUILDING PHOTO: absolutely positioned to fill the bottom, ditaruh di atas secara urutan HTML agar jadi background dan border kiri tidak terpotong -->
            <div
                style="position:absolute; bottom:0; left:0; width:210mm; height:297mm; overflow:hidden; z-index:1; margin:0; padding:0;">
                <img src="{{ $bg_image }}"
                    style="position:absolute; top:0; left:0; width:210mm; height:297mm; display:block; padding:0; margin:0;"
                    alt="Gedung Tiga Serangkai">
                <!-- Green overlay -->
                <div style="position:absolute; top:0; left:0; width:210mm; height:297mm;
                            background:linear-gradient(to bottom,
                                rgba(180,210,80,0.40) 0%,
                                rgba(58,170,53,0.62) 30%,
                                rgba(0,100,45,0.80) 100%);
                            z-index:2; margin:0; padding:0;">
                </div>
            </div>

            <!-- Left accent bar: full page height, from edge, dipisah di bawah building photo HTML nya supaya layer-nya lebih tinggi -->
            <div style="position:absolute; left:0; top:0; width:14px; height:297mm;
                        background:linear-gradient(to bottom, #f5c518 0%, #3aaa35 40%, #006633 100%);
                        z-index:10; margin:0; padding:0;">
            </div>

            <!-- TOP CONTENT with manual margin (like 2.54cm) -->
            <div style="padding: 2.54cm 2.54cm 0 2.8cm; position:relative; z-index:20; max-width: 210mm;">

                <!-- Logo -->
                <div style="margin-bottom:30px;">
                    <img src="{{ $logo_image }}" style="height:55px; width:auto; display:block;" alt="Logo TS dan PDC">
                </div>

                <!-- Judul -->
                <div style="font-family: 'LibreBaskervillePdf', serif; font-size:34px; font-weight:700; color:#000000; line-height:1.15;
                            margin-bottom:22px; text-transform:uppercase; letter-spacing:0.5px;">
                    Laporan Hasil Penelitian<br>Promosi Talent
                </div>

                <!-- Subtitle -->
                <div style="font-size:13px; color:#000000; margin-bottom:5px;">Disusun melalui program:</div>
                <div style="font-size:16px; color:#000000;">
                    <strong>IDP (<em>Individual Development Plan</em>)</strong>
                </div>
            </div>

        </div>

        <!-- HALAMAN PROFILE TALENT (Halaman 2) -->
        <div
            style="width:210mm; height:297mm; page-break-after:always; page-break-inside:avoid; position:relative; overflow:hidden; margin: 0; padding: 0;">
            <img src="{{ $border_image }}"
                style="position:absolute; top:0; left:0; width:210mm; height:297mm; display:block; z-index:1;"
                alt="Border">

            <div class="profile-page-content">

                <!-- Logo -->
                <div class="profile-logo-wrap">
                    <img src="{{ $logo_image }}" class="profile-logo" alt="Logo TS dan PDC">
                </div>

                <!-- Judul -->
                <div class="profile-main-title">
                    Laporan Hasil Penelitian<br>Promosi Talent
                </div>

                <!-- Subtitle -->
                <div class="profile-subtitle">
                    Laporan ini disusun berdasarkan hasil observasi mendalam, evaluasi kompetensi teknis, serta tinjauan
                    proyek perbaikan yang telah dilaksanakan oleh talent
                </div>

                <!-- Table Data -->
                <table class="profile-table">
                    <tr>
                        <th style="width: 35%;">Nama</th>
                        <td style="width: 5%;">:</td>
                        <td style="width: 60%;">{{ $talent->nama }}</td>
                    </tr>
                    <tr>
                        <th>Perusahaan</th>
                        <td>:</td>
                        <td>
                            {{ optional($talent->company)->nama_company ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>:</td>
                        <td>
                            {{ optional($talent->department)->nama_department ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Posisi Saat Ini</th>
                        <td>:</td>
                        <td>
                            {{ optional($talent->position)->position_name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Atasan</th>
                        <td>:</td>
                        <td>{{ optional($talent->atasan)->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Mentor</th>
                        <td>:</td>
                        <td>{{ optional($talent->mentor)->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Posisi yang Dituju</th>
                        <td>:</td>
                        <td>
                            {{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>:</td>
                        <td>
                            @if (optional($talent->promotion_plan)->start_date && optional($talent->promotion_plan)->target_date)
                                {{ \Carbon\Carbon::parse($talent->promotion_plan->start_date)->locale('id')->translatedFormat('d F Y') }}
                                -
                                {{ \Carbon\Carbon::parse($talent->promotion_plan->target_date)->locale('id')->translatedFormat('d F Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="profile-project-summary">
                    @php
                        $improvementTitle = '-';
                        $latestProject = $talent->improvementProjects ? $talent->improvementProjects->first() : null;
                        if ($latestProject) {
                            $improvementTitle = $latestProject->title;
                        }

                        $exposureCount = $talent->idpActivities
                            ? $talent->idpActivities->where('type_idp', 1)->count()
                            : 0;
                        $mentoringCount = $talent->idpActivities
                            ? $talent->idpActivities->where('type_idp', 2)->count()
                            : 0;
                        $learningCount = $talent->idpActivities
                            ? $talent->idpActivities->where('type_idp', 3)->count()
                            : 0;

                        $exposurePct = min(100, round(($exposureCount / 6) * 100));
                        $mentoringPct = min(100, round(($mentoringCount / 6) * 100));
                        $learningPct = min(100, round(($learningCount / 6) * 100));
                    @endphp
                    Telah berhasil menuntaskan <em>project improvement</em> dengan judul<br>
                    <strong>"{{ $improvementTitle }}"</strong>
                    <br><br><br>
                    yang dibuktikan dengan perolehan skor penilaian <strong>Exposure {{ $exposurePct }}%, Mentoring
                        {{ $mentoringPct }}% dan Learning {{ $learningPct }}%</strong> dari persentase maksimal 100%
                </div>
            </div>
        </div>

        <!-- HALAMAN SKOR KOMPETENSI (Halaman 3) -->
        <div
            style="width:210mm; height:297mm; page-break-after:always; page-break-inside:avoid; position:relative; overflow:hidden; margin: 0; padding: 0;">
            <img src="{{ $border_image }}"
                style="position:absolute; top:0; left:0; width:210mm; height:297mm; display:block; z-index:1;"
                alt="Border">

            <!-- Content -->
            <div style="position:relative; z-index:10; padding: 100px 55px 60px 55px;">

                <!-- Judul Halaman -->
                <div
                    style="font-family: 'PoppinsPdf', sans-serif; font-size:22px; font-weight:700; color:#000000; text-align:center; margin-bottom:40px;">
                    Skor Kompetensi
                </div>

                <!-- Tabel Skor Kompetensi -->
                <table class="competency-score-table"
                    style="width:100%; border-collapse:collapse; font-size:16px; margin-top:40px;">
                    <thead>
                        <tr>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:center; border:none; width:5%;">
                                No</th>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:left; border:none; width:30%;">
                                Kompetensi</th>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:center; border:none; width:13%;">
                                Standar</th>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:center; border:none; width:13%;">
                                Skor Talent</th>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:center; border:none; width:13%;">
                                Skor Atasan</th>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:center; border:none; width:13%;">
                                Final Skor</th>
                            <th
                                style="background-color:#d4e6e1; color:#000000; padding:10px 8px; text-align:center; border:none; width:13%;">
                                GAP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competencies as $index => $comp)
                            @php
                                $detailRow = $latestAssessment
                                    ? $latestAssessment->details->where('competence_id', $comp->id)->first()
                                    : null;
                                $selfScore2 = $detailRow ? $detailRow->score_talent : 0;
                                $atasanScore2 = $detailRow ? $detailRow->score_atasan : 0;
                                $finalScore2 =
                                    $atasanScore2 > 0
                                    ? ($selfScore2 + $atasanScore2) / 2
                                    : ($selfScore2 > 0
                                        ? $selfScore2
                                        : 0);
                                $std2 = $standards->get($comp->id) ?? 0;
                                $gap2 = $detailRow
                                    ? $detailRow->gap_score
                                    : ($finalScore2 > 0
                                        ? $finalScore2 - $std2
                                        : 0);
                                $hasData2 = $detailRow && ($selfScore2 > 0 || $atasanScore2 > 0);
                            @endphp
                            <tr style="border-bottom: 1px solid #b2d8d0;">
                                <td style="padding:14px 10px; text-align:center; border:none; color:#000000;">
                                    {{ $index + 1 }}
                                </td>
                                <td style="padding:14px 10px; text-align:left; border:none; color:#000000;">
                                    {{ $comp->name }}
                                </td>
                                <td style="padding:14px 10px; text-align:center; border:none; color:#000000;">
                                    {{ $hasData2 ? number_format($std2, 2) : '' }}
                                </td>
                                <td style="padding:14px 10px; text-align:center; border:none; color:#000000;">
                                    {{ $hasData2 ? number_format($selfScore2, 2) : '' }}
                                </td>
                                <td style="padding:14px 10px; text-align:center; border:none; color:#000000;">
                                    {{ $hasData2 ? number_format($atasanScore2, 2) : '' }}
                                </td>
                                <td style="padding:14px 10px; text-align:center; border:none; color:#000000;">
                                    {{ $hasData2 ? number_format($finalScore2, 2) : '' }}
                                </td>
                                <td style="padding:14px 10px; text-align:center; border:none;">
                                    @if ($hasData2)
                                        @if ($gap2 <= -2)
                                            <span style="color:#e74c3c; font-weight:bold;">{{ number_format($gap2, 2) }}</span>
                                        @elseif($gap2 < -1)
                                            <span style="color:#e74c3c; font-weight:bold;">{{ number_format($gap2, 2) }}</span>
                                        @elseif($gap2 < 0)
                                            <span style="color:#f39c12; font-weight:bold;">{{ number_format($gap2, 2) }}</span>
                                        @elseif($gap2 == 0)
                                            <span style="color:#95a5a6; font-weight:bold;">{{ number_format($gap2, 2) }}</span>
                                        @else
                                            <span style="color:#2980b9; font-weight:bold;">{{ number_format($gap2, 2) }}</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- HALAMAN LOGBOOK IDP (Halaman 4+) -->
        @php
            $exposureRows = $talent->idpActivities ? $talent->idpActivities->where('type_idp', 1) : collect();
            $mentoringRows = $talent->idpActivities ? $talent->idpActivities->where('type_idp', 2) : collect();
            $learningRows = $talent->idpActivities ? $talent->idpActivities->where('type_idp', 3) : collect();
        @endphp

        <table
            style="width: 100%; border: none; border-collapse: collapse; margin:0; padding:0; page-break-inside: auto; position:relative; z-index:10;">
            <thead>
                <tr>
                    <td
                        style="height: 70px; border: none; background: transparent; padding:0; margin:0; line-height:0;">
                        &nbsp;</td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td
                        style="height: 125px; border: none; background: transparent; padding:0; margin:0; line-height:0;">
                        &nbsp;</td>
                </tr>
            </tfoot>
            <tbody>
                <!-- Header IDP -->
                <tr>
                    <td style="border: none; padding: 0 55px 0 45px; vertical-align: top; background: transparent;">
                        <div
                            style="font-family: 'PoppinsPdf', sans-serif; font-size:22px; font-weight:700; color:#000000; text-align:center; margin-bottom:40px; margin-top:-80px;">
                            LogBook IDP
                        </div>
                    </td>
                </tr>

                <!-- EXPOSURE -->
                <tr class="idp-section-row">
                    <td style="border: none; padding: 0 55px 0 45px; vertical-align: top; background: transparent;">
                        <div class="idp-section-block" style="margin-bottom: 40px;">
                            <div class="idp-section-title" style="page-break-after: avoid;">
                                <div
                                    style="font-family: 'PoppinsPdf', sans-serif; font-size: 16px; font-weight: 700; color: #000000; padding-bottom: 5px; margin-bottom: 15px; border-bottom: 2px solid #b2d8d0; display: inline-block;">
                                    Exposure 70%
                                </div>
                            </div>
                            <table class="idp-activity-table"
                                style="width:100%; border-collapse: collapse; font-size: 16px; margin-bottom: 12px;">
                                <thead>
                                    <tr>
                                        <th
                                            style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px; width: 10%; text-align: center; border: none;">
                                            No</th>
                                        <th
                                            style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px; width: 90%; text-align: center; border: none;">
                                            Tema</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($exposureRows as $index => $row)
                                        <tr style="border-bottom: 1px solid #b2d8d0;">
                                            <td
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000;">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000;">
                                                {{ $row->theme ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr style="border-bottom: 1px solid #b2d8d0;">
                                            <td colspan="2"
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000; font-style: italic;">
                                                Tidak ada data aktivitas Exposure.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="idp-note"
                                style="font-size: 12px; font-style: italic; color: #000000; line-height:1.4;">
                                *Pencapaian pada aspek <strong>exposure</strong> merepresentasikan keterlibatan aktif
                                talent dalam penyelesaian problem nyata di lapangan melalui proyek perbaikan strategis
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- MENTORING -->
                <tr class="idp-section-row">
                    <td style="border: none; padding: 0 55px 0 45px; vertical-align: top; background: transparent;">
                        <div class="idp-section-block" style="margin-bottom: 40px;">
                            <div class="idp-section-title" style="page-break-after: avoid;">
                                <div
                                    style="font-family: 'PoppinsPdf', sans-serif; font-size: 16px; font-weight: 700; color: #000000; padding-bottom: 5px; margin-bottom: 15px; border-bottom: 2px solid #b2d8d0; display: inline-block;">
                                    Mentoring 20%
                                </div>
                            </div>
                            <table class="idp-activity-table"
                                style="width:100%; border-collapse: collapse; font-size: 16px; margin-bottom: 12px;">
                                <thead>
                                    <tr>
                                        <th
                                            style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px; width: 10%; text-align: center; border: none;">
                                            No</th>
                                        <th
                                            style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px; width: 90%; text-align: center; border: none;">
                                            Tema</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mentoringRows as $index => $row)
                                        <tr style="border-bottom: 1px solid #b2d8d0;">
                                            <td
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000;">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000;">
                                                {{ $row->theme ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr style="border-bottom: 1px solid #b2d8d0;">
                                            <td colspan="2"
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000; font-style: italic;">
                                                Tidak ada data aktivitas Mentoring.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="idp-note"
                                style="font-size: 12px; font-style: italic; color: #000000; line-height:1.4;">
                                *Melalui sesi <strong>mentoring</strong>, talent menunjukkan peningkatan signifikan
                                dalam aspek pengambilan keputusan dan pola pikir kepemimpinan yang selaras dengan nilai
                                organisasi.
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- LEARNING -->
                <tr class="idp-section-row">
                    <td style="border: none; padding: 0 55px 0 45px; vertical-align: top; background: transparent;">
                        <div
                            style="font-family: 'PoppinsPdf', sans-serif; font-size:22px; font-weight:700; color:transparent; text-align:center; margin-bottom:40px; margin-top:-20px;">
                            LogBook IDP
                        </div>
                        <div class="idp-section-block" style="margin-bottom: 40px;">
                            <div class="idp-section-title" style="page-break-after: avoid;">
                                <div
                                    style="font-family: 'PoppinsPdf', sans-serif; font-size: 16px; font-weight: 700; color: #000000; padding-bottom: 5px; margin-bottom: 15px; border-bottom: 2px solid #b2d8d0; display: inline-block;">
                                    Learning 10%
                                </div>
                            </div>
                            <table class="idp-activity-table"
                                style="width:100%; border-collapse: collapse; font-size: 16px; margin-bottom: 12px;">
                                <thead>
                                    <tr>
                                        <th
                                            style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px; width: 10%; text-align: center; border: none;">
                                            No</th>
                                        <th
                                            style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px; width: 90%; text-align: center; border: none;">
                                            Tema</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($learningRows as $index => $row)
                                        <tr style="border-bottom: 1px solid #b2d8d0;">
                                            <td
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000;">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000;">
                                                {{ $row->theme ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr style="border-bottom: 1px solid #b2d8d0;">
                                            <td colspan="2"
                                                style="padding: 12px 10px; text-align: center; border:none; color: #000000; font-style: italic;">
                                                Tidak ada data aktivitas Learning.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="idp-note"
                                style="font-size: 12px; font-style: italic; color: #000000; line-height:1.4;">
                                *Aspek <strong>learning</strong> mengonfirmasi bahwa talent telah menguasai landasan
                                teoritis dan teknis yang diperlukan untuk memikul tanggung jawab pada level jabatan.
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- HALAMAN PENILAIAN PANELIS -->
    @php
        $panelisAssessments = $talent->panelisAssessments ?? collect();
        $totalScore = 0;
        $panelisCount = 0;
        foreach ($panelisAssessments as $pa) {
            if (is_numeric($pa->panelis_score)) {
                $totalScore += $pa->panelis_score * 2;
                $panelisCount++;
            }
        }
        $averageScore = $panelisCount > 0 ? $totalScore / $panelisCount : 0;
    @endphp
    <table
        style="width: 100%; border: none; border-collapse: collapse; margin:0; padding:0; page-break-before: always; page-break-inside: auto; position:relative; z-index:10;">
        <thead>
            <tr>
                <td style="border: none; background: transparent; padding:0; margin:0; line-height:0;">
                    <div style="height: 70px;"></div>
                </td>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td style="border: none; background: transparent; padding:0; margin:0; line-height:0;">
                    <div style="height: 80px;"></div>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td style="border: none; padding: 0 55px 0 45px; vertical-align: top; background: transparent;">

                    <!-- Intro paragraph -->
                    <div
                        style="font-size: 16px; color: #000000; line-height: 1.7; margin-bottom: 30px; margin-top: -10px;">
                        Berikut adalah rincian perolehan skor evaluasi yang diberikan oleh Panelis berdasarkan
                        rangkaian aktivitas penilaian dan status capaian kompetensi talent:
                    </div>

                    <!-- Tabel Panelis -->
                    <table style="width: 100%; border-collapse: collapse; font-size: 16px;">
                        <thead>
                            <tr>
                                <th
                                    style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: none; width: 8%;">
                                    No</th>
                                <th
                                    style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px 8px; text-align: left; border: none; width: 45%;">
                                    Nama</th>
                                <th
                                    style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: none; width: 12%;">
                                    Score</th>
                                <th
                                    style="background-color: #d4e6e1; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: none; width: 35%;">
                                    Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($panelisAssessments as $index => $pa)
                                @php
                                    $rekomendasi = $pa->panelis_rekomendasi ?? '';
                                    // Pisahkan teks utama dan keterangan dalam tanda (..)
                                    preg_match('/^(.*?)(\(.*?\))?\s*$/', $rekomendasi, $matches);
                                    $statusMain = trim($matches[1] ?? $rekomendasi);
                                    $statusSub = trim($matches[2] ?? '');
                                @endphp
                                <tr style="border-bottom: 1px solid #b2d8d0;">
                                    <td
                                        style="padding: 14px 8px; text-align: center; border: none; color: #000000; vertical-align: top;">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td style="padding: 14px 8px; text-align: left; border: none; vertical-align: top;">
                                        <div style="font-weight: bold; color: #000000; font-size: 11.5px;">
                                            {{ optional($pa->panelis)->nama ?? '-' }}
                                        </div>
                                        <div class="panelis-company-name"
                                            style="font-family: 'PoppinsPdf', sans-serif !important; font-style: italic !important; font-weight: 400 !important; color: #666; font-size: 10px; margin-top: 2px; line-height: 1.4;">
                                            {{ optional(optional($pa->panelis)->company)->nama_company ?? '' }}
                                        </div>
                                    </td>
                                    <td
                                        style="padding: 14px 8px; text-align: center; border: none; color: #000000; vertical-align: top;">
                                        {{ is_numeric($pa->panelis_score) ? $pa->panelis_score * 2 : '-' }}
                                    </td>
                                    <td
                                        style="padding: 14px 8px; text-align: center; border: none; vertical-align: top; line-height: 1.4;">
                                        @if ($statusMain)
                                            <div style="color: #000000; font-size: 11px;">{{ $statusMain }}</div>
                                        @endif
                                        @if ($statusSub)
                                            <div style="color: #000000; font-size: 10px; font-style: italic; margin-top: 2px;">
                                                {{ $statusSub }}
                                            </div>
                                        @endif
                                        @if (!$statusMain && !$statusSub)
                                            <span style="color: #000000;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr style="border-bottom: 1px solid #b2d8d0;">
                                    <td colspan="4"
                                        style="padding: 14px 8px; text-align: center; border: none; color: #000000; font-style: italic;">
                                        Belum ada penilaian dari Panelis.
                                    </td>
                                </tr>
                            @endforelse

                            @if ($panelisAssessments->isNotEmpty())
                                <tr
                                    style="border-top: 1.5px solid #b2d8d0; border-bottom: 1.5px solid #b2d8d0; background-color: #f4f9f7;">
                                    <td style="padding: 14px 8px; border: none;"></td>
                                    <td
                                        style="padding: 14px 8px; text-align: left; border: none; color: #000000; font-weight: bold; font-size: 13px;">
                                        Rata-rata Skor
                                    </td>
                                    <td
                                        style="padding: 14px 8px; text-align: center; border: none; color: #000000; font-weight: bold; font-size: 13px;">
                                        {{ $panelisCount > 0 ? number_format($averageScore, 2) : '-' }}
                                    </td>
                                    <td style="padding: 14px 8px; border: none;"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>

    <!-- BAGIAN KESIMPULAN -->
    @php
        $adminUser = auth()->user();
        $statusPromotion = optional($talent->promotion_plan)->status_promotion ?? '';
        if (str_contains($statusPromotion, 'Not Promoted')) {
            $statusLabel = 'Not Promoted';
        } elseif (str_contains($statusPromotion, 'Not Ready')) {
            $statusLabel = 'Not Ready';
        } elseif (str_contains($statusPromotion, '> 2') || str_contains($statusPromotion, 'over 2')) {
            $statusLabel = 'Ready in > 2 Years';
        } elseif (
            str_contains($statusPromotion, '1-2') ||
            str_contains($statusPromotion, '1–2') ||
            str_contains($statusPromotion, '1 - 2') ||
            str_contains($statusPromotion, '1 – 2')
        ) {
            $statusLabel = 'Ready in 1 – 2 Years';
        } elseif (str_contains($statusPromotion, 'Promoted')) {
            $statusLabel = 'Ready Now';
        } else {
            $statusLabel = $statusPromotion ?: '-';
        }

        $panelisAssessments = $talent->panelisAssessments ?? collect();
        $totalScore = 0;
        $panelisCount = 0;
        foreach ($panelisAssessments as $pa) {
            if (is_numeric($pa->panelis_score)) {
                $totalScore += $pa->panelis_score * 2;
                $panelisCount++;
            }
        }
        $averageScore = $panelisCount > 0 ? $totalScore / $panelisCount : 0;

        $exportDate = \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y');
    @endphp

    <div style="page-break-inside: avoid; padding: 60px 55px 40px 45px; position: relative; z-index: 10;">
        <div style="font-size: 16px; color: #000000; line-height: 1.9; text-align: justify; margin-bottom: 60px;">
            Berdasarkan hasil evaluasi komprehensif dan penilaian (<em>assessment</em>) mendalam
            yang telah dilakukan, dengan ini <strong>Saudara/i {{ $talent->nama }}</strong>
            mendapatkan rekomendasi dari Atasan, Mentor dan Panelis <strong><em>{{ $statusLabel }}</em></strong> untuk
            posisi yang dituju.
        </div>

        <table style="width: 100%; border: none; border-collapse: collapse; margin-top: 40px;">
            <tr>
                <td style="width: 55%; border: none; background: transparent;"></td>
                <td style="width: 45%; border: none; background: transparent; padding: 0; vertical-align: top;">
                    <div style="font-size: 14px; color: #000000; margin-bottom: 6px;">Surakarta, {{ $exportDate }}
                    </div>
                    <div style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 90px;">Head of
                        People Development Center</div>
                    <div style="border-top: 1.5px solid #555; padding-top: 6px; width: 220px;">
                        <div style="font-size: 16px; color: #000000; font-weight: bold;">Wisnu Wijaya Putra</div>
                        <div style="font-size: 14px; color: #000000; margin-top: 2px;">ID : 0320240114</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>