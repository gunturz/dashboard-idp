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
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
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
                box-shadow: 0 2px 8px rgba(245, 158, 11, 0.35);
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .btn-selesai:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 14px rgba(245, 158, 11, 0.45);
            }

            /* ── Decision Modal ── */
            #decisionModal,
            #confirmModal {
                display: none;
            }

            .decision-card {
                flex: 1;
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                padding: 24px 16px;
                text-align: center;
                cursor: pointer;
                transition: all 0.22s;
                background: white;
            }

            .decision-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            }

            .decision-card.promoted:hover {
                border-color: #22c55e;
            }

            .decision-card.not-promoted:hover {
                border-color: #ef4444;
            }

            .decision-card .card-icon {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 12px;
                font-size: 1.6rem;
            }

            .decision-card.promoted .card-icon {
                background: rgba(34, 197, 94, 0.12);
            }

            .decision-card.not-promoted .card-icon {
                background: rgba(239, 68, 68, 0.1);
            }

            .decision-card h4 {
                font-size: 1rem;
                font-weight: 800;
                margin-bottom: 4px;
            }

            .decision-card.promoted h4 {
                color: #16a34a;
            }

            .decision-card.not-promoted h4 {
                color: #dc2626;
            }

            .decision-card p {
                font-size: 0.78rem;
                color: #64748b;
                line-height: 1.4;
            }

            @media (max-width: 768px) {}

            @media (max-width: 768px) {}
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
    <div class="bg-[#0f172a] shadow-md py-6 mb-7 w-full -mt-4 md:-mt-8 -mx-4 lg:-mx-8 px-4 lg:px-8 max-w-[100vw] sm:max-w-none md:-mx-8"
        style="width: calc(100% + 4rem);">
        <div class="flex flex-col md:flex-row items-stretch divide-y md:divide-y-0 md:divide-x divide-white/20">

            <div class="flex items-center gap-5 px-6 md:px-10 flex-shrink-0 w-full md:w-1/3 py-4 md:py-2">
                <div class="flex-shrink-0">
                    @if ($talent->foto ?? false)
                        <img src="{{ asset('storage/' . $talent->foto) }}" alt="Foto Profil"
                            class="w-24 h-24 rounded-[10px] object-cover border-2 border-white/30">
                    @else
                        <div
                            class="w-24 h-24 rounded-[10px] bg-white/20 flex items-center justify-center border-2 border-white/30">
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
                    <span
                        class="text-white/80">{{ optional(optional($talent->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
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
        <div
            class="flex items-center gap-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Section Title ── --}}
    @php
        $projectTitle =
            optional($latestProject)->title ??
            'Penilaian Panelis – ' . (optional($talent->company)->nama_company ?? '-');
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
                        $assessment = $panelis
                            ? \App\Models\PanelisAssessment::where('user_id_talent', $talent->id)
                                ->where('panelis_id', $panelis->id)
                                ->first()
                            : null;
                        $isAssessor = $assessment !== null;
                    @endphp
                    <tr>
                        {{-- Penilai Panelis --}}
                        <td class="text-left-cell">
                            @if ($panelis)
                                <span class="font-semibold text-[#1e293b]">{{ $panelis->nama }}</span>
                                @if ($panelis->position)
                                    <span
                                        class="block text-xs text-[#64748b] italic">{{ $panelis->position->position_name }}</span>
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
                                <span class="font-bold text-[#1e293b]">{{ $assessment->panelis_score ?? 0 }} /
                                    50</span>
                            @endif
                        </td>

                        {{-- Feedback --}}
                        <td>
                            @if ($isAssessor)
                                {{ $assessment->panelis_komentar }}
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="text-left-cell">
                            @if ($isAssessor && $assessment->panelis_rekomendasi)
                                @php
                                    $rekomen = $assessment->panelis_rekomendasi;
                                    $desc = '';
                                    if (str_contains($rekomen, 'Ready Now')) {
                                        $desc = 'Siap dipromosikan dalam < 6 bulan';
                                    } elseif (str_contains($rekomen, '1 – 2')) {
                                        $desc = 'Siap dengan pengembangan terarah';
                                    } elseif (str_contains($rekomen, '> 2')) {
                                        $desc = 'Masih membutuhkan pengembangan signifikan';
                                    } elseif (str_contains($rekomen, 'Not Ready')) {
                                        $desc = 'Belum direkomendasikan untuk jalur suksesi';
                                    }
                                @endphp
                                <span class="status-text">{{ $rekomen }}</span>
                                @if ($desc)
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
            $statusPromo = optional($talent->promotion_plan)->status_promotion;
            $isComplete = in_array($statusPromo, ['Promoted', 'Not Promoted', 'Approved Panelis', 'Rejected Panelis']);
        @endphp

        @if ($isComplete)
            @if ($statusPromo === 'Promoted')
                <button class="btn-selesai"
                    style="background: #22c55e; box-shadow: 0 2px 8px rgba(34,197,94,0.3); cursor: default;" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />

                    </svg>
                    Diangkat ✓
                </button>
            @elseif ($statusPromo === 'Not Promoted')
                <button class="btn-selesai"
                    style="background: #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,0.3); cursor: default;" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Tidak Diangkat ✓
                </button>
            @else
                <button class="btn-selesai"
                    style="background: #e2e8f0; color: #64748b; box-shadow: none; cursor: default;" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Sudah Selesai
                </button>
            @endif
        @else
            <button type="button" class="btn-selesai" id="selesai-panelis-detail" onclick="openDecisionModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                Selesai
            </button>
        @endif
    </div>

    {{-- ── Hidden Form untuk submit keputusan ── --}}
    <form method="POST" action="{{ route('pdc_admin.panelis_review.complete', $talent->id) }}" id="form-decision">
        @csrf
        <input type="hidden" name="decision" id="decisionValue" value="">
    </form>

    {{-- ── MODAL STEP 1: Pilih Keputusan ── --}}
    <div id="decisionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(15,23,42,0.55); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in">
            {{-- Header --}}
            <div class="px-6 pt-6 pb-4">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="text-xl font-bold text-[#1e293b]">Decision</h3>
                    <button type="button" onclick="closeDecisionModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-[#64748b]">Tentukan hasil promosi untuk <span
                        class="font-semibold text-[#1e293b]">{{ $talent->nama }}</span></p>
            </div>
            {{-- Decision Cards --}}
            <div class="px-6 pb-2 flex gap-4">
                <div class="decision-card promoted" onclick="selectDecision('promoted')">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4>Promoted</h4>
                    <p>Talent berhasil dipromosikan ke posisi target</p>
                </div>
                <div class="decision-card not-promoted" onclick="selectDecision('not_promoted')">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4>Not Promoted</h4>
                    <p>Talent belum berhasil dipromosikan periode ini</p>
                </div>
            </div>
            {{-- Footer --}}
            <div class="px-6 py-4 flex justify-end">
                <button type="button" onclick="closeDecisionModal()"
                    class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
            </div>
        </div>
    </div>

    {{-- ── MODAL STEP 2: Konfirmasi ── --}}
    <div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(15,23,42,0.55); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
            {{-- Icon + Header --}}
            <div class="px-6 pt-7 pb-4 text-center">
                <div id="confirmIcon"
                    class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl"></div>
                <h3 class="text-lg font-bold text-[#1e293b] mb-2" id="confirmTitle"></h3>
                <p class="text-sm text-[#475569]" id="confirmDesc"></p>
            </div>
            {{-- Warning note --}}
            <div class="mx-6 mb-4 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                <p class="text-xs text-amber-700 font-medium">⚠️ Tindakan ini tidak dapat dibatalkan setelah
                    dikonfirmasi.</p>
            </div>
            {{-- Footer --}}
            <div class="px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
                <button type="button" onclick="backToDecision()"
                    class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Kembali</button>
                <button type="button" onclick="submitDecision()" id="confirmBtn"
                    class="px-6 py-2 text-sm font-bold text-white rounded-xl transition-colors">Ya, Konfirmasi</button>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            let pendingDecision = null;

            function openDecisionModal() {
                document.getElementById('decisionModal').style.display = 'flex';
            }

            function closeDecisionModal() {
                document.getElementById('decisionModal').style.display = 'none';
                pendingDecision = null;
            }

            function selectDecision(decision) {
                pendingDecision = decision;
                document.getElementById('decisionModal').style.display = 'none';

                const confirmIcon = document.getElementById('confirmIcon');
                const confirmTitle = document.getElementById('confirmTitle');
                const confirmDesc = document.getElementById('confirmDesc');
                const confirmBtn = document.getElementById('confirmBtn');

                if (decision === 'promoted') {
                    confirmIcon.innerHTML = '🏆';
                    confirmIcon.style.background = 'rgba(34,197,94,0.12)';
                    confirmTitle.textContent = 'Konfirmasi: Diangkat';
                    confirmDesc.innerHTML =
                        'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> sebagai <strong class="text-green-600">DIANGKAT</strong> ke posisi target.';
                    confirmBtn.style.background = '#22c55e';
                } else {
                    confirmIcon.innerHTML = '📋';
                    confirmIcon.style.background = 'rgba(239,68,68,0.1)';
                    confirmTitle.textContent = 'Konfirmasi: Tidak Diangkat';
                    confirmDesc.innerHTML =
                        'Anda akan menetapkan <strong>{{ addslashes($talent->nama) }}</strong> sebagai <strong class="text-red-600">TIDAK DIANGKAT</strong> pada periode ini.';
                    confirmBtn.style.background = '#ef4444';
                }

                document.getElementById('confirmModal').style.display = 'flex';
            }

            function backToDecision() {
                document.getElementById('confirmModal').style.display = 'none';
                document.getElementById('decisionModal').style.display = 'flex';
            }

            function submitDecision() {
                if (!pendingDecision) return;
                document.getElementById('decisionValue').value = pendingDecision;
                document.getElementById('form-decision').submit();
            }

            // Tutup modal jika klik overlay
            ['decisionModal', 'confirmModal'].forEach(id => {
                document.getElementById(id).addEventListener('click', function(e) {
                    if (e.target === this) {
                        if (id === 'decisionModal') closeDecisionModal();
                        else backToDecision();
                    }
                });
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>
