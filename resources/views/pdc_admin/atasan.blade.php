<x-pdc_admin.layout title="Atasan – PDC Admin" :user="$user">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0f172a]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            <div>
                <h2 class="text-2xl font-bold text-[#0f172a]">Atasan</h2>
                <p class="text-sm text-gray-500">Daftar atasan program IDP.</p>
            </div>
        </div>
        <button class="bg-[#0f172a] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm hover:bg-[#1e2737] transition-colors" onclick="openManageModal()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Atasan
        </button>
    </div>

    {{-- Grid Cards --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        @foreach($atasans as $atasan)
            <div class="bg-[#f8fafc] rounded-2xl p-6 border border-[#e2e8f0] flex flex-col justify-between">
                <div>
                    {{-- Header Card --}}
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            @if($atasan->foto)
                                <img src="{{ asset('storage/' . $atasan->foto) }}" alt="{{ $atasan->nama }}" class="w-14 h-14 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-14 h-14 rounded-full bg-[#e2e8f0] flex items-center justify-center text-[#94a3b8] shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-[#0f172a] text-lg leading-tight">{{ $atasan->nama }}</h3>
                                <p class="text-xs text-gray-500 mt-1 font-medium">{{ $atasan->position->position_name ?? '—' }} - {{ $atasan->department->nama_department ?? '—' }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 bg-white border border-[#14b8a6] text-[#14b8a6] rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $atasan->subordinates->count() }} Talent
                        </span>
                    </div>

                    {{-- Tengah --}}
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 font-medium mb-3">Talent yang dibimbing</p>
                        <div class="flex flex-col gap-2">
                            @foreach($atasan->subordinates as $talent)
                                <div class="bg-white border border-[#e2e8f0] rounded-xl px-4 py-3 flex justify-between items-center whitespace-nowrap overflow-hidden text-ellipsis shadow-sm">
                                    <span class="font-bold text-[#0f172a] text-sm overflow-hidden text-ellipsis">{{ $talent->nama }}</span>
                                    <span class="text-xs font-medium text-[#475569] overflow-hidden text-ellipsis pl-4">
                                        {{ $talent->position->position_name ?? '—' }}
                                        @if($talent->promotion_plan && $talent->promotion_plan->targetPosition)
                                            - {{ $talent->promotion_plan->targetPosition->position_name }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                            @if($atasan->subordinates->isEmpty())
                                <div class="text-sm text-gray-400 italic">Belum ada talent.</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Footer Card --}}
                <div class="flex items-center gap-3 text-[#475569]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <span class="text-sm font-medium">{{ $atasan->email }}</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Manage Atasan Modal --}}
    <div id="modal-manage-atasan" style="display:none; position:fixed; inset:0; background:rgba(30,41,59,0.5); backdrop-filter:blur(2px); z-index:100; align-items:center; justify-content:center;">
        <div style="background:white; width:100%; max-width:650px; border-radius:12px; padding:32px; max-height:90vh; overflow-y:auto; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
            <div class="flex items-center gap-3 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                <h3 class="text-xl font-bold text-[#0f172a]">Kelola Atasan</h3>
            </div>

            <p class="text-sm font-bold text-[#0f172a] mb-3">Daftar Atasan</p>
            <div class="flex flex-col gap-3 mb-4 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar" style="scrollbar-width: thin;">
                @foreach($atasans as $a)
                    <div class="w-full bg-white border border-[#d1d5db] rounded-lg p-4 flex justify-between items-center transition-colors text-left atasan-card-item"
                         onclick="handleCardClick({{ $a->id }}, '{{ addslashes($a->nama) }}', '{{ $a->position_id }}', '{{ $a->department_id }}', '{{ addslashes($a->email) }}', '{{ addslashes($a->username) }}', '{{ addslashes($a->remember_token ?? '') }}', this)">
                        <div>
                            <p class="font-bold text-[#0f172a]">{{ $a->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $a->position->position_name ?? '—' }} - {{ $a->department->nama_department ?? '—' }}</p>
                        </div>
                        <span class="text-sm font-medium text-[#475569]">{{ $a->subordinates->count() }} Talent</span>
                    </div>
                @endforeach
                @if($atasans->isEmpty())
                    <p class="text-sm text-gray-500 italic">Belum ada atasan terdaftar.</p>
                @endif
            </div>

            <div class="flex justify-end mb-4">
                <button type="button" class="text-sm font-medium text-[#94a3b8] flex items-center gap-1 hover:text-[#64748b]" id="btn-toggle-mode" onclick="enableEditMode()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Atasan
                </button>
            </div>

            <hr class="border-[#e2e8f0] mb-6">

            <form action="{{ route('pdc_admin.atasan.store') }}" method="POST" id="form-atasan">
                @csrf
                <input type="hidden" name="id" id="atasan-id" value="">

                <p class="text-sm font-bold text-[#0f172a] mb-4" id="form-title">Tambah Atasan</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase">NAMA</label>
                        <input type="text" name="nama" id="input-nama" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf]" placeholder="Masukkan nama" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase">JABATAN</label>
                        <select name="position_id" id="input-jabatan" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf] bg-white appearance-none" style="padding-right:30px; background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" required>
                            <option value="" disabled selected>Masukkan Jabatan</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase">DEPARTEMEN</label>
                        <select name="department_id" id="input-departemen" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf] bg-white appearance-none" style="padding-right:30px; background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" required>
                            <option value="" disabled selected>Masukkan Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase">EMAIL</label>
                        <input type="email" name="email" id="input-email" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf]" placeholder="Masukkan Email" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase">USERNAME</label>
                        <input type="text" name="username" id="input-username" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf]" placeholder="Masukkan Username" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase flex items-end justify-between">
                            <span>PASSWORD</span>
                            <span id="password-hint" class="hidden font-normal text-gray-400 normal-case" style="font-size:10px;">(Kosongkan jika tidak diubah)</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="input-password" class="w-full border border-[#d1d5db] rounded-lg p-2.5 pr-10 text-sm text-[#475569] outline-none focus:border-[#2dd4bf]" placeholder="Masukkan Password">
                            <button type="button" onclick="togglePassword('input-password', 'eye-icon-atasan')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                                <svg id="eye-icon-atasan" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" class="bg-[#F4F1EA] text-[#0f172a] font-bold py-2.5 px-8 rounded-lg text-sm hover:bg-[#eadecc] transition-colors" id="btn-cancel" onclick="closeManageModal()">Tutup</button>
                    <button type="submit" class="bg-[#14b8a6] text-white font-bold py-2.5 px-8 rounded-lg text-sm hover:bg-[#0d9488] transition-colors" id="btn-submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `;
                } else {
                    input.type = 'password';
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            }

            let isEditMode = false;

            function openManageModal() {
                switchToCreateMode();
                document.getElementById('modal-manage-atasan').style.display = 'flex';
            }

            function closeManageModal() {
                document.getElementById('modal-manage-atasan').style.display = 'none';
            }

            function switchToCreateMode() {
                isEditMode = false;

                document.getElementById('atasan-id').value = '';
                document.getElementById('input-nama').value = '';
                document.getElementById('input-jabatan').value = '';
                document.getElementById('input-departemen').value = '';
                document.getElementById('input-email').value = '';
                document.getElementById('input-username').value = '';
                document.getElementById('input-password').value = '';
                document.getElementById('password-hint').classList.add('hidden');
                document.getElementById('input-password').setAttribute('required', 'required');

                document.getElementById('form-title').innerText = 'Tambah Atasan';

                const btnCancel = document.getElementById('btn-cancel');
                btnCancel.innerText = 'Tutup';
                btnCancel.onclick = closeManageModal;

                const btnSubmit = document.getElementById('btn-submit');
                btnSubmit.innerText = 'Tambah';

                document.getElementById('btn-toggle-mode').style.display = 'flex';

                document.querySelectorAll('.atasan-card-item').forEach(el => {
                    el.style.cursor = 'default';
                    el.style.borderColor = '#d1d5db';
                    el.onmouseenter = null;
                    el.onmouseleave = null;
                });
            }

            function enableEditMode() {
                isEditMode = true;

                document.getElementById('form-title').innerText = 'Pilih atasan di atas untuk diedit';
                document.getElementById('btn-toggle-mode').style.display = 'none';

                const btnCancel = document.getElementById('btn-cancel');
                btnCancel.innerText = 'Batal';
                btnCancel.onclick = switchToCreateMode;

                document.querySelectorAll('.atasan-card-item').forEach(el => {
                    el.style.cursor = 'pointer';
                    el.style.borderColor = '#d1d5db';
                    el.onmouseenter = () => { if (el.style.borderColor !== 'rgb(20, 184, 166)') el.style.borderColor = '#9ca3af'; };
                    el.onmouseleave = () => { if (el.style.borderColor !== 'rgb(20, 184, 166)') el.style.borderColor = '#d1d5db'; };
                });
            }

            function handleCardClick(id, nama, position_id, department_id, email, username, password, cardEl) {
                if (!isEditMode) return;

                document.querySelectorAll('.atasan-card-item').forEach(el => {
                    el.style.borderColor = '#d1d5db';
                });
                cardEl.style.borderColor = '#14b8a6';

                document.getElementById('atasan-id').value = id;
                document.getElementById('input-nama').value = nama;
                document.getElementById('input-jabatan').value = position_id;
                document.getElementById('input-departemen').value = department_id;
                document.getElementById('input-email').value = email;
                document.getElementById('input-username').value = username;
                document.getElementById('input-password').value = password;
                document.getElementById('password-hint').classList.remove('hidden');
                document.getElementById('input-password').removeAttribute('required');

                document.getElementById('form-title').innerText = 'Edit Atasan';

                const btnSubmit = document.getElementById('btn-submit');
                btnSubmit.innerText = 'Simpan';
            }
        </script>
    </x-slot>
</x-pdc_admin.layout>
