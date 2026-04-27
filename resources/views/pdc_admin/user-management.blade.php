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

            .um-email-cell {
                max-width: 220px;
            }

            .um-email-text {
                display: block;
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">User Management</div>
            <div class="page-header-sub">Kelola pengguna sistem, peran, dan pengaturan akses keamanan.</div>
        </div>
    </div>

    <livewire:pdc-user-management-table />

    {{-- Role Assignment Modal --}}
    <div id="roleModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 class="text-lg font-bold text-[#2e3746]">Assign Role</h3>
                <button type="button" onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="roleForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-500 mb-4">Pilih role yang akan ditetapkan untuk user ini (bisa lebih dari satu).</p>
                    <div class="space-y-3">
                        @foreach ($rolesData as $roleData)
                            @if (!in_array(strtolower($roleData->role_name), ['admin', 'pdc admin', 'pdc_admin']))
                                <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors m-0">
                                    <input type="checkbox" name="roles[]" value="{{ $roleData->id }}"
                                        class="role-checkbox w-5 h-5 text-[#14b8a6] border-gray-300 rounded focus:ring-[#14b8a6]">
                                    <span class="ml-3 font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $roleData->role_name) }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeRoleModal()" class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
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
                    <button type="button" onclick="closeResetPasswordModal()" class="flex-1 py-2.5 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit" class="flex-1 py-2.5 px-4 text-sm font-semibold text-white bg-[#4e5a6a] rounded-xl hover:bg-[#3d4756] transition-colors shadow-sm">Ya, Yakin</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <form id="deleteForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            @method('DELETE')
            <div class="bg-white rounded-2xl w-full flex flex-col items-center shadow-2xl p-8 text-center transform transition-all">
                <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Hapus User?</h3>
                <p class="text-gray-500 text-[15px] mb-8">Data user ini akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 py-3 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit" class="flex-1 py-3 px-4 text-sm font-bold text-white bg-[#EF4444] rounded-xl hover:bg-[#dc2626] transition-colors shadow-sm">Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            // ── Role Modal ──
            function openRoleModal(userId, currentRoleIds) {
                const form = document.getElementById('roleForm');
                form.action = `/pdc-admin/assign-role/${userId}`;
                const modal = document.getElementById('roleModal');
                document.querySelectorAll('.role-checkbox').forEach(cb => {
                    cb.checked = Array.isArray(currentRoleIds)
                        ? currentRoleIds.includes(parseInt(cb.value))
                        : false;
                });
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            function closeRoleModal() {
                const modal = document.getElementById('roleModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            // ── Delete Modal ──
            function openDeleteModal(userId) {
                const form = document.getElementById('deleteForm');
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

            // ── Reset Password Modal ──
            function openResetPasswordModal(userId) {
                const form = document.getElementById('resetPasswordForm');
                form.action = `/pdc-admin/user/${userId}/reset-password`;
                const modal = document.getElementById('resetPasswordModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            function closeResetPasswordModal() {
                const modal = document.getElementById('resetPasswordModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }
        </script>
    </x-slot>
</x-pdc_admin.layout>
