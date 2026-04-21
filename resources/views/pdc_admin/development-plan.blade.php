<x-pdc_admin.layout title="Development Plan – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            .field-row {
                display: flex;
                align-items: center;
                gap: 24px;
                padding: 18px 0;
            }

            .field-label {
                font-size: 0.875rem;
                font-weight: 700;
                color: #2e3746;
                flex-shrink: 0;
                width: 160px;
            }

            .talent-block {
                padding: 24px 0;
                border-bottom: 1px solid #e8ecf0;
            }

            .talent-block-grid {
                display: grid;
                grid-template-columns: 160px 1fr 100px 1fr;
                align-items: center;
                gap: 24px;
            }

            .mentor-label {
                font-size: 0.875rem;
                font-weight: 700;
                color: #2e3746;
                text-align: right;
            }

            .btn-add-mentor {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 0.75rem;
                font-weight: 600;
                color: #475569;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 6px 16px;
                cursor: pointer;
                background: white;
                transition: all .2s;
            }
            .btn-add-mentor:hover { border-color: #cbd5e1; background: #f8fafc; }

            .btn-add-talent {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 0.85rem;
                font-weight: 600;
                color: #475569;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 8px 24px;
                cursor: pointer;
                background: white;
                transition: all .2s;
                margin-top: 24px;
            }
            .btn-add-talent:hover { border-color: #cbd5e1; background: #f8fafc; }

            .btn-simpan {
                background: #14b8a6;
                color: white;
                font-weight: 700;
                font-size: 0.875rem;
                border: none;
                border-radius: 10px;
                padding: 10px 40px;
                cursor: pointer;
                transition: all .2s;
            }
            .btn-simpan:hover { background: #0d9488; transform: translateY(-1px); }

            .btn-batal {
                background: #F4F1EA;
                color: #2e3746;
                font-weight: 700;
                font-size: 0.875rem;
                border: none;
                border-radius: 10px;
                padding: 10px 40px;
                cursor: pointer;
                transition: all .2s;
                text-align: center;
                text-decoration: none;
            }
            .btn-batal:hover { background: #eadecc; transform: translateY(-1px); }

            .section-divider {
                border: none;
                border-top: 2px solid #e8ecf0;
                margin: 40px 0;
            }
            
            .talent-label {
                font-size: 0.875rem;
                font-weight: 700;
                color: #2e3746;
            }

            .dp-select {
                width: 100%;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                padding: 10px 14px;
                font-size: 0.875rem;
                color: #475569;
                background: #fff;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                padding-right: 36px;
                transition: border-color .2s, box-shadow .2s;
                cursor: pointer;
            }
            .dp-select:focus { outline: none; border-color: #2dd4bf; }
            
            .dp-date {
                background-image: none !important;
                padding-right: 14px !important;
            }
            
            .mentor-stack {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .mentor-row {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .btn-remove-talent {
                color: #ef4444;
                opacity: 0.5;
                transition: opacity 0.2s;
            }
            .btn-remove-talent:hover { opacity: 1; }

            .btn-back {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 500;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s;
                width: fit-content;
            }
            .btn-back:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            /* ── Responsive ── */
            @media (max-width: 1024px) {
                .field-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 12px;
                }
                .field-label {
                    width: 100%;
                }
                .talent-block-grid {
                    grid-template-columns: 1fr;
                    gap: 16px;
                }
                .mentor-label {
                    text-align: left;
                }
                .talent-label {
                    margin-bottom: -8px;
                }
            }
        </style>
    </x-slot>

    {{-- MAIN CONTAINER --}}
    <div class="mx-auto w-full">  

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM12.75 12a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V18a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V12z" clip-rule="evenodd" />
                <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963 5.23 5.23 0 00-3.434-1.279h-1.875a.375.375 0 01-.375-.375V5.25z" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Setup Development Plan</div>
            <div class="page-header-sub">Atur perusahaan, talent, mentor, dan tanggal untuk program baru.</div>
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
    <div class="prem-card p-8">
        <form method="POST" action="{{ route('pdc_admin.development_plan.store') }}" id="dev-plan-form">
            @csrf
            
            {{-- ── Perusahaan ── --}}
            <div class="field-row">
                <span class="field-label">Perusahaan</span>
                <div class="flex-1">
                    <select name="company_id" id="dp-company" class="dp-select" onchange="handleTalentFilterChange()">
                        <option value="">— Pilih Perusahaan —</option>
                        @foreach($companies as $c)
                            <option value="{{ $c->id }}" {{ old('company_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_company }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ── Departemen ── --}}
            <div class="field-row">
                <span class="field-label">Departemen</span>
                <div class="flex-1">
                    <select name="department_id" id="dp-department" class="dp-select" data-old="{{ old('department_id') }}" onchange="handleTalentFilterChange()">
                        <option value="">— Pilih Departemen —</option>
                    </select>
                </div>
            </div>

            {{-- ── Posisi yang Dituju ── --}}
            <div class="field-row">
                <span class="field-label">Posisi yang dituju</span>
                <div class="flex-1">
                    <select name="target_position_id" id="dp-position" class="dp-select" onchange="handleTalentFilterChange()">
                        <option value="">— Pilih Posisi —</option>
                        @foreach($positions as $p)
                            <option value="{{ $p->id }}" {{ old('target_position_id') == $p->id ? 'selected' : '' }}>{{ $p->position_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ── Talent Blocks ── --}}
            <div id="talent-rows-container" class="space-y-0"></div>

            {{-- Tambah Talent --}}
            <div class="flex items-center gap-4">
                <button type="button" onclick="addTalentRow()" class="btn-add-talent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Talent
                </button>
            </div>

            <hr class="section-divider">

            {{-- ── Atasan ── --}}
            <div class="field-row">
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

            {{-- ── Dates ── --}}
            <div class="field-row mb-12">
                <span class="field-label">Start Date</span>
                <div class="flex-1 flex gap-8 items-center" style="display: flex;">
                    <input type="date" name="start_date" class="dp-select dp-date" value="{{ old('start_date') }}" required style="width: 100%">
                    <span class="font-bold text-[#2e3746] text-[0.875rem] whitespace-nowrap">Due Date</span>
                    <input type="date" name="target_date" class="dp-select dp-date" value="{{ old('target_date') }}" required style="width: 100%">
                </div>
            </div>

            <div class="flex justify-end gap-3 pb-10">
                <a href="{{ route('pdc_admin.progress_talent') }}" class="btn-batal inline-flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="btn-simpan">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- ── Hidden template for a talent block ── --}}
    <template id="talent-row-template">
        <div class="talent-block" data-row-index="__IDX__">
            <div class="talent-block-grid">
                <div class="talent-label">Talent __NUM__</div>
                <div>
                    <select name="talents[__IDX__][talent_id]" class="dp-select talent-select">
                        <option value="">— Pilih Talent —</option>
                    </select>
                </div>
                <div class="mentor-label">Mentor</div>
                <div class="mentor-stack">
                    <div class="mentor-row">
                        <select name="talents[__IDX__][mentors][]" class="dp-select">
                            <option value="">— Pilih Mentor —</option>
                            __MENTOR_OPTIONS__
                        </select>
                        <button type="button" onclick="removeTalentRow(this)" class="btn-remove-talent" title="Hapus baris">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-3 pr-8">
                <button type="button" onclick="addMentor(this)" class="btn-add-mentor">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Mentor
                </button>
            </div>
        </div>
    </template>

    <x-slot name="scripts">
    <script>
    @php
        $mentorUsersJson = json_encode(
            $mentors->map(function ($m) {
                return [
                    'id' => $m->id,
                    'nama' => $m->nama,
                    'company_id' => $m->company_id,
                    'department_id' => $m->department_id,
                ];
            })->values()->all()
        );

        $atasanUsersJson = json_encode(
            $atasans->map(function ($a) {
                return [
                    'id' => $a->id,
                    'nama' => $a->nama,
                    'company_id' => $a->company_id,
                    'department_id' => $a->department_id,
                ];
            })->values()->all()
        );
    @endphp

    let talentRowIndex = 0;
    let cachedTalents = [];
    const mentorUsers = {!! $mentorUsersJson !!};
    const atasanUsers = {!! $atasanUsersJson !!};

    const mentorOptions = `
        @foreach($mentors as $m)
        <option value="{{ $m->id }}">{{ $m->nama }}</option>
        @endforeach
    `.trim();

    function handleTalentFilterChange() {
        const companyId = document.getElementById('dp-company')?.value || '';
        loadTalentsByCompany(companyId);
        refreshMentorOptions();
        refreshAtasanOptions();
    }

    function getFilteredUsers(users) {
        const companyId = document.getElementById('dp-company')?.value || '';
        const departmentId = document.getElementById('dp-department')?.value || '';

        return users.filter(user => {
            if (!companyId) return false;
            if (String(user.company_id ?? '') !== String(companyId)) return false;
            if (departmentId && String(user.department_id ?? '') !== String(departmentId)) return false;
            return true;
        });
    }

    function buildOptions(users, placeholder) {
        return [`<option value="">${placeholder}</option>`]
            .concat(users.map(user => `<option value="${user.id}">${user.nama}</option>`))
            .join('');
    }

    function refreshMentorOptions() {
        const filteredMentors = getFilteredUsers(mentorUsers);
        const mentorHtml = buildOptions(filteredMentors, ' Pilih Mentor');

        document.querySelectorAll('.mentor-stack select').forEach(select => {
            const currentValue = select.value;
            select.innerHTML = mentorHtml;
            if (filteredMentors.some(user => String(user.id) === String(currentValue))) {
                select.value = currentValue;
            }
        });
    }

    function refreshAtasanOptions() {
        const atasanSelect = document.getElementById('dp-atasan');
        if (!atasanSelect) return;

        const filteredAtasans = getFilteredUsers(atasanUsers);
        const currentValue = atasanSelect.value;
        atasanSelect.innerHTML = buildOptions(filteredAtasans, ' Pilih Atasan');
        if (filteredAtasans.some(user => String(user.id) === String(currentValue))) {
            atasanSelect.value = currentValue;
        }
    }

    async function loadTalentsByCompany(companyId) {
        cachedTalents = [];
        const deptSelect = document.getElementById('dp-department');
        const positionSelect = document.getElementById('dp-position');
        
        if (!companyId) {
            document.querySelectorAll('.talent-select').forEach(s => { s.innerHTML = '<option value="">— Pilih Talent —</option>'; });
            deptSelect.innerHTML = '<option value="">— Pilih Departemen —</option>';
            return;
        }

        // Fetch Departments
        await fetch(`/register/departments?company_id=${companyId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            const oldDeptVal = deptSelect.getAttribute('data-old') || deptSelect.value;
            deptSelect.innerHTML = '<option value="">— Pilih Departemen —</option>';
            data.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.id;
                opt.textContent = d.nama_department;
                if (d.id == oldDeptVal) {
                    opt.selected = true;
                }
                deptSelect.appendChild(opt);
            });
            // Clear data-old so it doesn't persistently override future manual selections 
            // if we select a different company later.
            deptSelect.removeAttribute('data-old');
        })
        .catch(err => console.error('Error fetching departments:', err));

        const params = new URLSearchParams({ company_id: companyId });
        if (deptSelect.value) {
            params.set('department_id', deptSelect.value);
        }
        if (positionSelect?.value) {
            params.set('target_position_id', positionSelect.value);
        }

        const resp = await fetch(`/pdc-admin/talents-by-company?${params.toString()}`, {
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
        refreshMentorOptions();
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
        const stack   = block.querySelector('.mentor-stack');
        const idx     = block.getAttribute('data-row-index');

        const div = document.createElement('div');
        div.className = 'mentor-row mt-3';
        div.innerHTML = `
            <select name="talents[${idx}][mentors][]" class="dp-select">
                <option value="">— Pilih Mentor —</option>
                ${mentorOptions}
            </select>
            <button type="button" onclick="this.parentElement.remove()" class="btn-remove-talent" title="Hapus mentor">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        stack.appendChild(div);
        refreshMentorOptions();
    }

    document.addEventListener('DOMContentLoaded', function () {
        addTalentRow();
        refreshAtasanOptions();
        refreshMentorOptions();

        // If there was an old company_id (after validation fail), pre-load talents
        const oldCompanyId = document.getElementById('dp-company')?.value;
        if (oldCompanyId) loadTalentsByCompany(oldCompanyId);
    });
    </script>
    </x-slot>

    </div>
</x-pdc_admin.layout>
