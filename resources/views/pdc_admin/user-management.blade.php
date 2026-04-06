<x-pdc_admin.layout title="User Management – PDC Admin" :user="$user">

    <x-slot name="styles">
        <style>
            .um-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            .um-table th,
            .um-table td {
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                padding: 12px 16px;
                text-align: center;
                vertical-align: middle;
            }

            .um-table th:last-child,
            .um-table td:last-child {
                border-right: none;
            }

            .um-table tbody tr:last-child td {
                border-bottom: none;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
            <path
                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
        </svg>
        <h2 class="text-2xl font-bold text-[#2e3746]">User Management</h2>
    </div>

    {{-- Summary Cards --}}
    @php
        $summaryCards = [
            'Talent' => $talents->count(),
            'Mentor' => $mentors->count(),
            'Atasan' => $atasans->count(),
            'Finance' => $finances->count(),
            'BOD' => $bods->count(),
        ];
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 xl:gap-6 mb-8">
        @foreach($summaryCards as $roleName => $count)
        <div onclick="filterRole('{{ $roleName }}')" data-role="{{ $roleName }}"
            class="role-card cursor-pointer border-2 rounded-xl p-6 min-h-[140px] flex flex-col items-center justify-center shadow-sm transition-colors bg-white border-[#14b8a6] hover:bg-teal-50">
            <span class="role-count text-[2.5rem] font-extrabold text-[#14b8a6] leading-none mb-2">{{ $count }}</span>
            <span class="role-label text-[0.8rem] font-medium text-gray-500 uppercase mt-1">{{ $roleName }}</span>
        </div>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="md:col-span-2 relative">
            <input type="text" id="searchInput" onkeyup="filterUsers()"
                class="peer w-full border border-slate-200 rounded-lg py-2.5 pl-4 pr-10 text-sm text-[#2e3746] placeholder-gray-400 outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] transition-colors"
                placeholder="Cari Nama">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 peer-focus:text-[#14b8a6] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <div class="md:col-span-1 relative">
            <select id="companyFilter" onchange="filterUsers()"
                class="w-full border border-slate-200 rounded-lg py-2.5 px-4 text-sm text-[#2e3746] outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] bg-white appearance-none transition-colors"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Perusahaan</option>
                @foreach($companies as $company)
                    <option value="{{ strtolower($company->nama_company) }}">{{ $company->nama_company }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-1 relative">
            <select id="departmentFilter" onchange="filterUsers()"
                class="w-full border border-slate-200 rounded-lg py-2.5 px-4 text-sm text-[#2e3746] outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] bg-white appearance-none transition-colors"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Departemen</option>
                @foreach($departments as $department)
                    <option value="{{ strtolower($department->nama_department) }}">{{ $department->nama_department }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Data Section --}}
    @php
        $userGroups = [
            ['title' => 'Talent', 'users' => $talents, 'showPosisi' => true, 'showMultiRole' => true],
            ['title' => 'Mentor', 'users' => $mentors, 'showPosisi' => true, 'showMultiRole' => true],
            ['title' => 'Atasan', 'users' => $atasans, 'showPosisi' => true, 'showMultiRole' => true],
            ['title' => 'Finance', 'users' => $finances, 'showPosisi' => false, 'showMultiRole' => false],
            ['title' => 'BOD', 'users' => $bods, 'showPosisi' => false, 'showMultiRole' => false],
        ];
    @endphp

    <div class="space-y-8">
        @foreach ($userGroups as $group)
            <div data-table-role="{{ $group['title'] }}" class="role-table-container border border-[#e2e8f0] rounded-xl overflow-hidden shadow-sm bg-white">
                {{-- Table Title --}}
                <div class="bg-[#f8fafc] border-b border-[#e2e8f0] py-3 text-center">
                    <h3 class="font-bold text-[#2e3746] leading-none">{{ $group['title'] }}</h3>
                </div>

                {{-- Table Data --}}
                <div class="overflow-x-auto">
                    <table class="um-table" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr class="bg-white">
                                @if($group['showMultiRole'])
                                    {{-- 7 columns: Email, Nama, Perusahaan, Departemen, Posisi, MultiRole, Aksi --}}
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:18%">Email</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:16%">Nama Lengkap</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:13%">Perusahaan</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:13%">Departemen</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:13%">Posisi saat ini</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:8%">Multi Role</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:13%">Aksi</th>
                                @else
                                    {{-- 5 columns for Finance/BOD: Email, Nama, Perusahaan, Departemen, Aksi --}}
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:22%">Email</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:22%">Nama Lengkap</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:18%">Perusahaan</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:18%">Departemen</th>
                                    <th class="text-sm font-bold text-[#2e3746] p-3" style="width:13%">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($group['users'] as $u)
                                <tr class="bg-white hover:bg-gray-50 transition-colors user-row">
                                    <td class="text-sm font-medium text-[#475569]">{{ $u->email }}</td>
                                    <td class="col-name text-sm font-bold text-[#2e3746]">{{ $u->nama }}</td>
                                    <td class="col-company text-sm font-medium text-[#475569]">
                                        {{ $u->company->nama_company ?? '—' }}</td>
                                    <td class="col-department text-sm font-medium text-[#475569]">
                                        {{ $u->department->nama_department ?? '—' }}</td>
                                    @if ($group['showPosisi'])
                                        <td class="text-sm font-medium text-[#475569]">
                                            {{ $u->position->position_name ?? '—' }}</td>
                                    @endif
                                    @if ($group['showMultiRole'])
                                        <td>
                                            <button type="button"
                                                onclick="openRoleModal({{ $u->id }}, {{ $u->roles->pluck('id') }})"
                                                class="flex items-center justify-center w-16 h-8 mx-auto bg-[#F5A623] hover:bg-[#e0961e] rounded-md transition-colors shadow-sm"
                                                title="Multi Role">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                                </svg>
                                            </button>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="flex flex-row items-center justify-center gap-2">
                                            <button type="button" onclick="openDeleteModal({{ $u->id }})"
                                                class="flex items-center justify-center w-16 h-8 bg-[#EF4444] hover:bg-[#dc2626] rounded-md transition-colors shadow-sm"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <button type="button"
                                                onclick="openResetPasswordModal({{ $u->id }})"
                                                class="flex items-center justify-center w-16 h-8 bg-[#F4F1EA] hover:bg-[#eadecc] border border-[#e5e1d8] rounded-md transition-colors shadow-sm"
                                                title="Reset Password">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#475569]"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    @php
                                        $cols = 5;
                                        if ($group['showPosisi']) {
                                            $cols++;
                                        }
                                        if ($group['showMultiRole']) {
                                            $cols++;
                                        }
                                    @endphp
                                    <td colspan="{{ $cols }}"
                                        class="py-10 text-center text-sm text-gray-400 italic">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Role Assignment Modal --}}
    <div id="roleModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 class="text-lg font-bold text-[#2e3746]">Assign Role</h3>
                <button type="button" onclick="closeRoleModal()"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="roleForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-500 mb-4">Pilih role yang akan ditetapkan untuk user ini (bisa lebih
                        dari satu).</p>
                    <div class="space-y-3">
                        @foreach ($rolesData as $roleData)
                            @if (!in_array(strtolower($roleData->role_name), ['admin', 'pdc admin', 'pdc_admin']))
                                <label
                                    class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors m-0">
                                    <input type="checkbox" name="roles[]" value="{{ $roleData->id }}"
                                        class="role-checkbox w-5 h-5 text-[#14b8a6] border-gray-300 rounded focus:ring-[#14b8a6]">
                                    <span
                                        class="ml-3 font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $roleData->role_name) }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeRoleModal()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div id="resetPasswordModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <form id="resetPasswordForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            <div class="bg-white rounded-2xl w-full shadow-2xl p-8 flex flex-col items-center text-center transform transition-all">
                <div class="w-20 h-20 rounded-full bg-[#E5B224] flex items-center justify-center mb-5">
                    <span class="text-white text-5xl font-bold">!</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi</h3>
                <p class="text-gray-900 text-[15px] mb-8">Apakah Anda yakin untuk mereset password user?</p>

                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeResetPasswordModal()"
                        class="flex-1 py-2.5 px-4 text-sm font-semibold text-gray-900 bg-white border border-gray-400 rounded-xl hover:bg-gray-50 transition-colors">Batalkan</button>
                    <button type="submit"
                        class="flex-1 py-2.5 px-4 text-sm font-semibold text-white bg-[#4e5a6a] rounded-xl hover:bg-[#3d4756] transition-colors shadow-sm">Ya, Yakin</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <form id="deleteForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            @method('DELETE')
            <div class="bg-white rounded-2xl w-full shadow-2xl p-8 flex flex-col items-center text-center transform transition-all">
                <div class="w-20 h-20 rounded-full bg-[#E5B224] flex items-center justify-center mb-5">
                    <span class="text-white text-5xl font-bold">!</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi</h3>
                <p class="text-gray-900 text-[15px] mb-8">Apakah Anda yakin untuk menghapus user?</p>

                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 py-2.5 px-4 text-sm font-semibold text-gray-900 bg-white border border-gray-400 rounded-xl hover:bg-gray-50 transition-colors">Batalkan</button>
                    <button type="submit"
                        class="flex-1 py-2.5 px-4 text-sm font-semibold text-white bg-[#4e5a6a] rounded-xl hover:bg-[#3d4756] transition-colors shadow-sm">Ya, Yakin</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function openRoleModal(userId, currentRoleIds) {
            const form = document.getElementById('roleForm');
            form.action = `/pdc-admin/assign-role/${userId}`;

            // Reset checkboxes
            document.querySelectorAll('.role-checkbox').forEach(cb => {
                cb.checked = false;
            });

            // Check current roles
            if (currentRoleIds && currentRoleIds.length) {
                document.querySelectorAll('.role-checkbox').forEach(cb => {
                    if (currentRoleIds.includes(parseInt(cb.value))) {
                        cb.checked = true;
                    }
                });
            }

            const modal = document.getElementById('roleModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeRoleModal() {
            const modal = document.getElementById('roleModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        function openResetPasswordModal(userId) {
            const form = document.getElementById('resetPasswordForm');
            form.action = `/pdc-admin/reset-password/${userId}`;

            const modal = document.getElementById('resetPasswordModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeResetPasswordModal() {
            const modal = document.getElementById('resetPasswordModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        function openDeleteModal(userId) {
            const form = document.getElementById('deleteForm');
            // Ganti route ini dengan route delete user yang sebenarnya
            form.action = `/pdc-admin/user/${userId}`;

            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }
        let activeRole = null;

        function filterRole(roleName) {
            // Toggle logic
            if (activeRole === roleName) {
                // Deselect if already selected
                activeRole = null;
            } else {
                // Select new role
                activeRole = roleName;
            }

            // Update cards styling
            document.querySelectorAll('.role-card').forEach(card => {
                const countSpan = card.querySelector('.role-count');
                const labelSpan = card.querySelector('.role-label');
                
                if (card.dataset.role === activeRole) {
                    card.classList.remove('bg-white', 'border-[#14b8a6]', 'hover:bg-teal-50');
                    card.classList.add('bg-[#5bb4a5]', 'border-[#5bb4a5]');
                    countSpan.classList.remove('text-[#14b8a6]');
                    countSpan.classList.add('text-white');
                    labelSpan.classList.remove('text-gray-500');
                    labelSpan.classList.add('text-white');
                } else {
                    card.classList.add('bg-white', 'border-[#14b8a6]', 'hover:bg-teal-50');
                    card.classList.remove('bg-[#5bb4a5]', 'border-[#5bb4a5]');
                    countSpan.classList.add('text-[#14b8a6]');
                    countSpan.classList.remove('text-white');
                    labelSpan.classList.add('text-gray-500');
                    labelSpan.classList.remove('text-white');
                }
            });

            // Terapkan ulang pencarian agar bisa menyembunyikan/menampilkan sesuai role aktif
            filterUsers();
        }

        function filterUsers() {
            let searchValue = document.getElementById('searchInput').value.toLowerCase();
            let companyValue = document.getElementById('companyFilter').value.toLowerCase();
            let departmentValue = document.getElementById('departmentFilter').value.toLowerCase();

            let isAnyFilterActive = searchValue !== "" || companyValue !== "" || departmentValue !== "";

            document.querySelectorAll('.role-table-container').forEach(container => {
                // Jika sedang memilih role spesifik dan box ini bukan role tersebut, langsung sembunyikan
                if (activeRole !== null && container.dataset.tableRole !== activeRole) {
                    container.classList.add('hidden');
                    return;
                }

                let tbody = container.querySelector('.um-table tbody');
                let rows = tbody.querySelectorAll('tr.user-row');
                let hasVisibleRow = false;
                
                rows.forEach(row => {
                    let name = row.querySelector('.col-name')?.innerText.toLowerCase() || "";
                    let company = row.querySelector('.col-company')?.innerText.toLowerCase() || "";
                    let department = row.querySelector('.col-department')?.innerText.toLowerCase() || "";

                    let matchSearch = name.includes(searchValue);
                    let matchCompany = companyValue === "" || company.includes(companyValue) || company === companyValue;
                    let matchDepartment = departmentValue === "" || department.includes(departmentValue) || department === departmentValue;

                    if (matchSearch && matchCompany && matchDepartment) {
                        row.style.display = '';
                        hasVisibleRow = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Tampilkan container jika ada filter aktif dan terdapat baris hasil filter,
                // atau jika tidak ada filter aktif sama sekali (dan activeRole match di atas)
                if (isAnyFilterActive) {
                    if (hasVisibleRow) {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                } else {
                    container.classList.remove('hidden');
                }
            });
        }
    </script>
</x-pdc_admin.layout>
