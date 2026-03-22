<x-pdc_admin.layout title="Mentor – PDC Admin" :user="$user">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
            </svg>
            <div>
                <h2 class="text-2xl font-bold text-[#2e3746]">Mentor</h2>
                <p class="text-sm text-gray-500">Daftar mentor program IDP.</p>
            </div>
        </div>
        <button class="bg-[#2e3746] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm hover:bg-[#1e2737] transition-colors" onclick="openManageModal()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Mentor
        </button>
    </div>

    {{-- Grid Cards --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        @foreach($mentors as $mentor)
            <div class="bg-[#f8fafc] rounded-2xl p-6 border border-[#e2e8f0] flex flex-col justify-between">
                <div>
                    {{-- Header Card --}}
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            @if($mentor->foto)
                                <img src="{{ asset('storage/' . $mentor->foto) }}" alt="{{ $mentor->nama }}" class="w-14 h-14 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-14 h-14 rounded-full bg-[#e2e8f0] flex items-center justify-center text-[#94a3b8] shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-[#2e3746] text-lg leading-tight">{{ $mentor->nama }}</h3>
                                <p class="text-xs text-gray-500 mt-1 font-medium">{{ $mentor->position->position_name ?? '—' }} - {{ $mentor->department->nama_department ?? '—' }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 bg-white border border-[#14b8a6] text-[#14b8a6] rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $mentor->mentees->count() }} Talent
                        </span>
                    </div>

                    {{-- Tengah --}}
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 font-medium mb-3">Talent yang dibimbing</p>
                        <div class="flex flex-col gap-2">
                            @foreach($mentor->mentees as $talent)
                                <div class="bg-white border border-[#e2e8f0] rounded-xl px-4 py-3 flex justify-between items-center whitespace-nowrap overflow-hidden text-ellipsis shadow-sm">
                                    <span class="font-bold text-[#2e3746] text-sm overflow-hidden text-ellipsis">{{ $talent->nama }}</span>
                                    <span class="text-xs font-medium text-[#475569] overflow-hidden text-ellipsis pl-4">
                                        {{ $talent->position->position_name ?? '—' }} 
                                        @if($talent->promotion_plan && $talent->promotion_plan->targetPosition)
                                            - {{ $talent->promotion_plan->targetPosition->position_name }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                            @if($mentor->mentees->isEmpty())
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
                    <span class="text-sm font-medium">{{ $mentor->email }}</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Manage Mentor Modal --}}
    <div id="modal-manage-mentor" style="display:none; position:fixed; inset:0; background:rgba(30,41,59,0.5); backdrop-filter:blur(2px); z-index:100; align-items:center; justify-content:center;">
        <div style="background:white; width:100%; max-width:650px; border-radius:12px; padding:32px; max-height:90vh; overflow-y:auto; box-shadow:0 10px 40px rgba(0,0,0,0.1);">
            <div class="flex items-center gap-3 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
                <h3 class="text-xl font-bold text-[#2e3746]">Kelola Mentor</h3>
            </div>
            
            <p class="text-sm font-bold text-[#2e3746] mb-3">Daftar Mentor</p>
            <div class="flex flex-col gap-3 mb-4 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar" style="scrollbar-width: thin;">
                @foreach($mentors as $m)
                    <div class="w-full bg-white border border-[#d1d5db] rounded-lg p-4 flex justify-between items-center transition-colors text-left mentor-card-item" 
                         onclick="handleCardClick({{ $m->id }}, '{{ addslashes($m->nama) }}', '{{ $m->position_id }}', '{{ $m->department_id }}', '{{ addslashes($m->email) }}', this)">
                        <div>
                            <p class="font-bold text-[#2e3746]">{{ $m->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $m->position->position_name ?? '—' }} - {{ $m->department->nama_department ?? '—' }}</p>
                        </div>
                        <span class="text-sm font-medium text-[#475569]">{{ $m->mentees->count() }} Talent</span>
                    </div>
                @endforeach
                @if($mentors->isEmpty())
                    <p class="text-sm text-gray-500 italic">Belum ada mentor terdaftar.</p>
                @endif
            </div>

            <div class="flex justify-end mb-4">
                <button type="button" class="text-sm font-medium text-[#94a3b8] flex items-center gap-1 hover:text-[#64748b]" id="btn-toggle-mode" onclick="enableEditMode()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Mentor
                </button>
            </div>

            <hr class="border-[#e2e8f0] mb-6">

            <form action="{{ route('pdc_admin.mentor.store') }}" method="POST" id="form-mentor">
                @csrf
                <input type="hidden" name="id" id="mentor-id" value="">

                <p class="text-sm font-bold text-[#2e3746] mb-4" id="form-title">Tambah Mentor</p>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-[#2e3746] mb-1.5 uppercase">NAMA</label>
                        <input type="text" name="nama" id="input-nama" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf]" placeholder="Masukkan nama" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#2e3746] mb-1.5 uppercase">JABATAN</label>
                        <select name="position_id" id="input-jabatan" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf] bg-white appearance-none" style="padding-right:30px; background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" required>
                            <option value="" disabled selected>Masukkan Jabatan</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#2e3746] mb-1.5 uppercase">DEPARTEMEN</label>
                        <select name="department_id" id="input-departemen" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf] bg-white appearance-none" style="padding-right:30px; background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" required>
                            <option value="" disabled selected>Masukkan Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#2e3746] mb-1.5 uppercase">EMAIL</label>
                        <input type="email" name="email" id="input-email" class="w-full border border-[#d1d5db] rounded-lg p-2.5 text-sm text-[#475569] outline-none focus:border-[#2dd4bf]" placeholder="Masukkan Email" required>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" class="bg-[#f5f0e6] text-[#2e3746] font-bold py-2.5 px-8 rounded-lg text-sm hover:bg-[#e8e2d4] transition-colors" id="btn-cancel" onclick="closeManageModal()">Tutup</button>
                    <button type="submit" class="bg-[#4ade80] text-white font-bold py-2.5 px-8 rounded-lg text-sm hover:bg-[#22c55e] transition-colors" id="btn-submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            let isEditMode = false;

            function openManageModal() {
                switchToCreateMode();
                document.getElementById('modal-manage-mentor').style.display = 'flex';
            }

            function closeManageModal() {
                document.getElementById('modal-manage-mentor').style.display = 'none';
            }

            function switchToCreateMode() {
                isEditMode = false;
                
                // Clear Form
                document.getElementById('mentor-id').value = '';
                document.getElementById('input-nama').value = '';
                document.getElementById('input-jabatan').value = '';
                document.getElementById('input-departemen').value = '';
                document.getElementById('input-email').value = '';

                document.getElementById('form-title').innerText = 'Tambah Mentor';
                
                const btnCancel = document.getElementById('btn-cancel');
                btnCancel.innerText = 'Tutup';
                btnCancel.onclick = closeManageModal;
                
                const btnSubmit = document.getElementById('btn-submit');
                btnSubmit.innerText = 'Tambah';
                
                document.getElementById('btn-toggle-mode').style.display = 'flex';

                // Make list read-only
                document.querySelectorAll('.mentor-card-item').forEach(el => {
                    el.style.cursor = 'default';
                    el.style.borderColor = '#d1d5db';
                    el.onmouseenter = null;
                    el.onmouseleave = null;
                });
            }

            function enableEditMode() {
                isEditMode = true;
                
                document.getElementById('form-title').innerText = 'Pilih mentor di atas untuk diedit';
                document.getElementById('btn-toggle-mode').style.display = 'none';

                // Ubah Batal behavior agar membatalkan edit mode ganti ke Tambah
                const btnCancel = document.getElementById('btn-cancel');
                btnCancel.innerText = 'Batal';
                btnCancel.onclick = switchToCreateMode; 

                // Make list clickable visually
                document.querySelectorAll('.mentor-card-item').forEach(el => {
                    el.style.cursor = 'pointer';
                    el.style.borderColor = '#d1d5db';
                    el.onmouseenter = () => { if (el.style.borderColor !== 'rgb(20, 184, 166)') el.style.borderColor = '#9ca3af'; };
                    el.onmouseleave = () => { if (el.style.borderColor !== 'rgb(20, 184, 166)') el.style.borderColor = '#d1d5db'; };
                });
            }

            function handleCardClick(id, nama, position_id, department_id, email, cardEl) {
                if (!isEditMode) return;

                // Highlight selected card (Teal-500: #14b8a6)
                document.querySelectorAll('.mentor-card-item').forEach(el => {
                    el.style.borderColor = '#d1d5db';
                });
                cardEl.style.borderColor = '#14b8a6';

                // Populate form
                document.getElementById('mentor-id').value = id;
                document.getElementById('input-nama').value = nama;
                document.getElementById('input-jabatan').value = position_id;
                document.getElementById('input-departemen').value = department_id;
                document.getElementById('input-email').value = email;

                document.getElementById('form-title').innerText = 'Edit Mentor';
                
                const btnSubmit = document.getElementById('btn-submit');
                btnSubmit.innerText = 'Simpan';
            }
        </script>
    </x-slot>
</x-pdc_admin.layout>
