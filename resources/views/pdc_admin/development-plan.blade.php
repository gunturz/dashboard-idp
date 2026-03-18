<x-pdc_admin.layout title="Development Plan – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            .dp-select {
                width: 100%;
                border: 1.5px solid #2dd4bf;
                border-radius: 10px;
                padding: 10px 14px;
                font-size: 0.875rem;
                color: #1e293b;
                background: #fff;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                padding-right: 36px;
                transition: border-color .2s, box-shadow .2s;
                cursor: pointer;
            }
            .dp-select:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13,148,136,.15); }

            .field-row {
                display: flex;
                align-items: center;
                gap: 24px;
                padding: 18px 0;
                border-bottom: 1px solid #f1f5f9;
            }
            .field-row:last-child { border-bottom: none; }

            .field-label {
                font-size: 0.875rem;
                font-weight: 600;
                color: #1e293b;
                flex-shrink: 0;
                width: 160px;
            }

            .talent-block {
                border: 1.5px solid #e2e8f0;
                border-radius: 14px;
                padding: 18px 20px;
                margin-bottom: 12px;
                background: #fafafa;
                transition: border-color .2s, box-shadow .2s;
            }
            .talent-block:hover { border-color: #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,.05); }

            .talent-block-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 14px;
            }

            .talent-num-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 0.8rem;
                font-weight: 700;
                color: #2e3746;
                background: #e8ecf0;
                border-radius: 8px;
                padding: 4px 10px;
            }

            .btn-remove-talent {
                padding: 5px;
                border-radius: 7px;
                color: #ef4444;
                border: 1px solid #fecaca;
                background: #fff5f5;
                cursor: pointer;
                transition: all .15s;
            }
            .btn-remove-talent:hover { background: #fee2e2; }

            .mentor-entry {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 8px;
            }
            .mentor-label { font-size:.8rem; font-weight:600; color:#64748b; width:52px; flex-shrink:0; }

            .btn-add-mentor {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: .75rem;
                font-weight: 600;
                color: #64748b;
                border: 1px dashed #cbd5e1;
                border-radius: 8px;
                padding: 5px 12px;
                cursor: pointer;
                background: none;
                transition: all .15s;
                margin-top: 4px;
            }
            .btn-add-mentor:hover { color: #0d9488; border-color: #0d9488; background: #f0fdfa; }

            .btn-add-talent {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: .85rem;
                font-weight: 600;
                color: #334155;
                border: 1.5px dashed #cbd5e1;
                border-radius: 10px;
                padding: 9px 20px;
                cursor: pointer;
                background: #f8fafc;
                transition: all .2s;
                width: 100%;
                justify-content: center;
                margin-top: 4px;
            }
            .btn-add-talent:hover { border-color: #0d9488; color: #0d9488; background: #f0fdfa; }

            .btn-simpan {
                background: #22c55e;
                color: white;
                font-weight: 700;
                font-size: .875rem;
                border: none;
                border-radius: 12px;
                padding: 11px 36px;
                cursor: pointer;
                box-shadow: 0 2px 8px rgba(34,197,94,.25);
                transition: all .2s;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .btn-simpan:hover { background: #16a34a; box-shadow: 0 4px 16px rgba(34,197,94,.3); transform: translateY(-1px); }
            .btn-simpan:active { transform: translateY(0); }

            .section-divider {
                border: none;
                border-top: 1px solid #e8ecf0;
                margin: 6px 0;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="p-2 bg-[#2e3746] rounded-xl shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-extrabold text-[#2e3746] animate-title">Development Plan</h2>
            <p class="text-xs text-gray-400 font-medium mt-0.5">Atur rencana pengembangan talent beserta mentor dan atasan</p>
        </div>
    </div>

    {{-- Success banner --}}
    @if(session('success'))
        <div class="mb-6 px-5 py-3.5 bg-green-50 border border-green-300 text-green-700 text-sm font-semibold rounded-xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Error banner --}}
    @if($errors->any())
        <div class="mb-6 px-5 py-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl shadow-sm">
            <p class="font-semibold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <form method="POST" action="{{ route('pdc_admin.development_plan.store') }}" id="dev-plan-form">
            @csrf
            <div class="px-8 py-6">

                {{-- ── Perusahaan ── --}}
                <div class="field-row">
                    <span class="field-label">Perusahaan</span>
                    <div class="flex-1">
                        <select name="company_id" id="dp-company" class="dp-select" onchange="loadTalentsByCompany(this.value)">
                            <option value="">— Pilih Perusahaan —</option>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}" {{ old('company_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_company }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ── Posisi yang Dituju ── --}}
                <div class="field-row">
                    <span class="field-label">Posisi yang dituju</span>
                    <div class="flex-1">
                        <select name="target_position_id" id="dp-position" class="dp-select">
                            <option value="">— Pilih Posisi —</option>
                            @foreach($positions as $p)
                                <option value="{{ $p->id }}" {{ old('target_position_id') == $p->id ? 'selected' : '' }}>{{ $p->position_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="section-divider my-4">

                {{-- ── Talent Blocks ── --}}
                <div id="talent-rows-container" class="space-y-3 mb-3"></div>

                {{-- Tambah Talent --}}
                <button type="button" onclick="addTalentRow()" class="btn-add-talent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Talent
                </button>

                <hr class="section-divider my-6">

                {{-- ── Atasan ── --}}
                <div class="field-row" style="border-bottom:none;">
                    <span class="field-label">Atasan</span>
                    <div class="flex-1">
                        <select name="atasan_id" id="dp-atasan" class="dp-select">
                            <option value="">— Pilih Atasan —</option>
                            @foreach($atasans as $a)
                                <option value="{{ $a->id }}" {{ old('atasan_id') == $a->id ? 'selected' : '' }}>{{ $a->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="border-t border-gray-100 px-8 py-5 flex justify-end">
                <button type="submit" class="btn-simpan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- ── Hidden template for a talent block ── --}}
    <template id="talent-row-template">
        <div class="talent-block" data-row-index="__IDX__">

            {{-- 2-column grid: left = Talent, right = Mentor stack --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0; align-items:start;">

                {{-- LEFT: Talent label + select --}}
                <div style="display:flex; align-items:center; gap:16px; padding:10px 20px 10px 0; border-right:1px solid #f1f5f9;">
                    <span style="font-size:.875rem; font-weight:700; color:#1e293b; flex-shrink:0; min-width:72px;">Talent __NUM__</span>
                    <select name="talents[__IDX__][talent_id]"
                        class="dp-select talent-select"
                        style="flex:1;">
                        <option value="">— Pilih Talent —</option>
                    </select>
                </div>

                {{-- RIGHT: Mentor stack + Tambah Mentor + Remove btn --}}
                <div style="padding:10px 0 10px 24px; position:relative;">
                    {{-- Remove button top-right --}}
                    <button type="button" onclick="removeTalentRow(this)"
                        class="btn-remove-talent"
                        style="position:absolute; top:10px; right:0;"
                        title="Hapus baris">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    {{-- Mentor entries --}}
                    <div class="mentor-entries" style="display:flex; flex-direction:column; gap:10px; padding-right:36px;">
                        <div class="mentor-entry" style="display:flex; align-items:center; gap:12px;">
                            <span style="font-size:.875rem; font-weight:600; color:#1e293b; flex-shrink:0; min-width:52px;">Mentor</span>
                            <select name="talents[__IDX__][mentors][]" class="dp-select" style="flex:1;">
                                <option value="">— Pilih Mentor —</option>
                                __MENTOR_OPTIONS__
                            </select>
                        </div>
                    </div>

                    {{-- Tambah Mentor --}}
                    <div style="display:flex; justify-content:flex-end; margin-top:10px; padding-right:36px;">
                        <button type="button" onclick="addMentor(this)" class="btn-add-mentor">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Mentor
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </template>

    <x-slot name="scripts">
    <script>
    let talentRowIndex = 0;
    let cachedTalents = [];

    const mentorOptions = `
        @foreach($mentors as $m)
        <option value="{{ $m->id }}">{{ $m->nama }}</option>
        @endforeach
    `.trim();

    async function loadTalentsByCompany(companyId) {
        cachedTalents = [];
        if (!companyId) {
            document.querySelectorAll('.talent-select').forEach(s => { s.innerHTML = '<option value="">— Pilih Talent —</option>'; });
            return;
        }
        const resp = await fetch(`/pdc-admin/talents-by-company?company_id=${companyId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        cachedTalents = await resp.json();
        document.querySelectorAll('.talent-select').forEach(sel => refreshTalentSelect(sel));
    }

    function refreshTalentSelect(sel) {
        const cur = sel.value;
        sel.innerHTML = '<option value="">— Pilih Talent —</option>';
        cachedTalents.forEach(t => {
            const o = document.createElement('option');
            o.value = t.id; o.textContent = t.nama;
            if (t.id == cur) o.selected = true;
            sel.appendChild(o);
        });
    }

    function addTalentRow() {
        const container = document.getElementById('talent-rows-container');
        const template  = document.getElementById('talent-row-template');
        const idx = talentRowIndex++;
        const num = container.querySelectorAll('.talent-block').length + 1;

        let html = template.innerHTML
            .replaceAll('__IDX__', idx)
            .replaceAll('__NUM__', num)
            .replace('__MENTOR_OPTIONS__', mentorOptions);

        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        const block = wrapper.firstElementChild;
        container.appendChild(block);
        refreshTalentSelect(block.querySelector('.talent-select'));
    }

    function removeTalentRow(btn) {
        btn.closest('.talent-block').remove();
        document.querySelectorAll('.talent-block').forEach((b, i) => {
            const badge = b.querySelector('.talent-num-badge');
            if (badge) badge.lastChild.textContent = ` Talent ${i + 1}`;
        });
    }

    function addMentor(btn) {
        const block   = btn.closest('.talent-block');
        const entries = block.querySelector('.mentor-entries');
        const idx     = block.getAttribute('data-row-index');

        const div = document.createElement('div');
        div.className = 'mentor-entry';
        div.style.cssText = 'display:flex; align-items:center; gap:12px;';
        div.innerHTML = `
            <span style="font-size:.875rem; font-weight:600; color:#1e293b; flex-shrink:0; min-width:52px;">Mentor</span>
            <select name="talents[${idx}][mentors][]" class="dp-select" style="flex:1;">
                <option value="">— Pilih Mentor —</option>
                ${mentorOptions}
            </select>
            <button type="button" onclick="this.parentElement.remove()"
                class="flex-shrink-0 btn-remove-talent" style="padding:4px;"
                title="Hapus mentor">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        entries.appendChild(div);
    }

    document.addEventListener('DOMContentLoaded', function () {
        addTalentRow();

        // If there was an old company_id (after validation fail), pre-load talents
        const oldCompanyId = document.getElementById('dp-company')?.value;
        if (oldCompanyId) loadTalentsByCompany(oldCompanyId);
    });
    </script>
    </x-slot>

</x-pdc_admin.layout>
