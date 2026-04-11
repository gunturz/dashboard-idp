<x-pdc_admin.layout title="Lihat Penilaian Panelis – Individual Development Plan" :user="$user" :hideSidebar="true">
    <x-slot name="styles">
        <style>

            /* ── Section Title ── */
            .section-title {
                font-size: 1.2rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 16px;
                padding-left: 4px;
            }

            /* ── Penilaian Table ── */
            .penilaian-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
            }
            .penilaian-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 14px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                white-space: nowrap;
            }
            .penilaian-table td {
                text-align: center;
                padding: 18px 16px;
                border: 1px solid #e2e8f0;
                font-size: 0.875rem;
                color: #334155;
                vertical-align: middle;
                min-height: 60px;
            }
            .penilaian-table td.text-left-cell {
                text-align: left;
            }
            .status-text {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.85rem;
                display: block;
            }
            .status-sub {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 2px;
            }

            /* ── Bottom Buttons ── */
            .btn-batal {
                padding: 10px 28px;
                border-radius: 10px;
                border: 1.5px solid #e2e8f0;
                background: white;
                color: #475569;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }
            .btn-batal:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
            .btn-selesai {
                padding: 10px 28px;
                border-radius: 10px;
                border: none;
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: white;
                font-size: 0.875rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 8px rgba(245,158,11,0.35);
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }
            .btn-selesai:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 14px rgba(245,158,11,0.45);
            }
            .btn-selesai:active { transform: scale(0.97); }

            @media (max-width: 768px) {
            }
        </style>
    </x-slot>

    {{-- ── Talent Profile Header ── --}}
    @php
        $namaTalent = $talent->nama ?? '-';
        $parts = explode(' ', trim($namaTalent));
        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

        $mentorIds = optional($talent->promotion_plan)->mentor_ids ?? [];
        if (!empty($mentorIds)) {
            $mentorNames = \App\Models\User::whereIn('id', $mentorIds)->pluck('nama')->implode(', ');
        } else {
            $mentorNames = optional($talent->mentor)->nama ?? '-';
        }
    @endphp
    <div class="bg-[#2e3746] shadow-md py-6 mb-7 w-full -mt-4 md:-mt-8 -mx-4 lg:-mx-8 px-4 lg:px-8 max-w-[100vw] sm:max-w-none md:-mx-8" style="width: calc(100% + 4rem);">
        <div class="flex flex-col md:flex-row items-stretch divide-y md:divide-y-0 md:divide-x divide-white/20">

            <div class="flex items-center gap-5 px-6 md:px-10 flex-shrink-0 w-full md:w-1/3 py-4 md:py-2">
                <div class="flex-shrink-0">
                    @if ($talent->foto ?? false)
                        <img src="{{ asset('storage/' . $talent->foto) }}" alt="Foto Profil" class="w-24 h-24 rounded-[10px] object-cover border-2 border-white/30">
                    @else
                        <div class="w-24 h-24 rounded-[10px] bg-white/20 flex items-center justify-center border-2 border-white/30">
                            <span class="text-white text-3xl font-bold">{{ $initials }}</span>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-white font-bold text-base leading-tight">{{ $namaTalent }}</p>
                    <p class="text-white/80 text-xs mt-1">Talent</p>
                </div>
            </div>

            <div class="px-6 md:px-10 w-full md:w-1/3 flex flex-col justify-center py-4 md:py-2 space-y-3 text-sm">
                <div class="flex gap-2 items-center">
                    <span class="font-bold text-white w-36 flex-shrink-0">Perusahaan</span>
                    <span class="text-white/80">{{ optional($talent->company)->nama_company ?? '-' }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <span class="font-bold text-white w-36 flex-shrink-0">Departemen</span>
                    <span class="text-white/80">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <span class="font-bold text-white w-36 flex-shrink-0">Jabatan yang Dituju</span>
                    <span class="text-white/80">{{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
                </div>
            </div>

            <div class="px-6 md:px-10 w-full md:w-1/3 flex flex-col justify-center py-4 md:py-2 space-y-3 text-sm">
                <div class="flex gap-2 items-center">
                    <span class="font-bold text-white w-24 flex-shrink-0">Mentor</span>
                    <span class="text-white/80">{{ $mentorNames }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <span class="font-bold text-white w-24 flex-shrink-0">Atasan</span>
                    <span class="text-white/80">{{ optional($talent->atasan)->nama ?? '-' }}</span>
                </div>
            </div>

        </div>
    </div>


    {{-- ── Success Message ── --}}
    @if (session('success'))
        <div class="flex items-center gap-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Section Title ── --}}
    @php
        $projectTitle = optional($latestProject)->title
            ?? ('Penilaian Panelis – ' . (optional($talent->company)->nama_company ?? '-'));
    @endphp
    <h3 class="section-title">{{ $projectTitle }}</h3>

    {{-- ── Penilaian Table ── --}}
    <div class="overflow-x-auto rounded-xl shadow-sm mb-8">
        <table class="penilaian-table">
            <thead>
                <tr>
                    <th class="w-[22%]">Penilai Panelis</th>
                    <th class="w-[26%]">Perusahaan</th>
                    <th class="w-[12%]">Skor</th>
                    <th class="w-[15%]">Feedback</th>
                    <th class="w-[25%]">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Build rows: Panelis users (or at least 5 placeholder rows)
                    $totalRows = max(5, $panelisUsers->count());
                @endphp
                @for ($i = 0; $i < $totalRows; $i++)
                    @php 
                        $panelis = $panelisUsers->get($i); 
                        $isAssessor = $latestProject && $panelis && $latestProject->panelis_dinilai_oleh == $panelis->id;
                    @endphp
                    <tr>
                        {{-- Penilai Panelis --}}
                        <td class="text-left-cell">
                            @if ($panelis)
                                <span class="font-semibold text-[#1e293b]">{{ $panelis->nama }}</span>
                                @if ($panelis->position)
                                    <span class="block text-xs text-[#64748b] italic">{{ $panelis->position->position_name }}</span>
                                @endif
                            @endif
                        </td>

                        {{-- Perusahaan --}}
                        <td>
                            @if ($panelis && optional($panelis->company)->nama_company)
                                {{ $panelis->company->nama_company }}
                            @elseif ($i === 0 && optional($latestProject)->talent)
                                {{ optional($talent->company)->nama_company ?? '' }}
                            @endif
                        </td>

                        {{-- Skor --}}
                        <td>
                            @if ($isAssessor)
                                <span class="font-bold text-[#1e293b]">{{ $latestProject->panelis_score }} / 50</span>
                            @endif
                        </td>

                        {{-- Feedback --}}
                        <td>
                            @if ($isAssessor)
                                {{ $latestProject->panelis_komentar }}
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="text-left-cell">
                            @if ($isAssessor && $latestProject->panelis_rekomendasi)
                                @php
                                    $rekomen = $latestProject->panelis_rekomendasi;
                                    $desc = '';
                                    if(str_contains($rekomen, 'Ready Now')) $desc = 'Siap dipromosikan dalam < 6 bulan';
                                    elseif(str_contains($rekomen, '1 – 2')) $desc = 'Siap dengan pengembangan terarah';
                                    elseif(str_contains($rekomen, '> 2')) $desc = 'Masih membutuhkan pengembangan signifikan';
                                    elseif(str_contains($rekomen, 'Not Ready')) $desc = 'Belum direkomendasikan untuk jalur suksesi';
                                @endphp
                                <span class="status-text">{{ $rekomen }}</span>
                                @if($desc)
                                    <span class="status-sub">({{ $desc }})</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    {{-- ── Bottom Actions ── --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('pdc_admin.panelis_review') }}" class="btn-batal" id="batal-panelis-detail">Kembali</a>
        
        @php
            $isComplete = in_array(optional($talent->promotion_plan)->status_promotion, ['Approved Panelis', 'Rejected Panelis']);
        @endphp

        @if ($isComplete)
            <button class="btn-selesai" style="background: #e2e8f0; color: #64748b; box-shadow: none; cursor: default;" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Semua Penilaian Sudah Selesai
            </button>
        @else
            <form method="POST" action="{{ route('pdc_admin.panelis_review.complete', $talent->id) }}" id="form-selesai-panelis">
                @csrf
                <button type="submit" class="btn-selesai" id="selesai-panelis-detail">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Selesai
                </button>
            </form>
        @endif
    </div>
</x-pdc_admin.layout>
