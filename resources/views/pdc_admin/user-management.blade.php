<x-pdc_admin.layout title="User Management – PDC Admin" :user="$user">

    <x-slot name="styles">
        <style>
            .um-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }
            .um-table th, .um-table td {
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                padding: 12px 16px;
                text-align: center;
                vertical-align: middle;
            }
            .um-table th:last-child, .um-table td:last-child {
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
            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
        </svg>
        <h2 class="text-2xl font-bold text-[#2e3746]">User Management</h2>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 xl:gap-6 mb-8">
        <div class="bg-white border-2 border-[#14b8a6] rounded-xl p-5 flex flex-col items-center justify-center shadow-sm">
            <span class="text-3xl font-bold text-[#14b8a6] leading-none mb-1">{{ $talents->count() }}</span>
            <span class="text-xs font-semibold text-gray-500 uppercase mt-1">Talent</span>
        </div>
        <div class="bg-white border-2 border-[#14b8a6] rounded-xl p-5 flex flex-col items-center justify-center shadow-sm">
            <span class="text-3xl font-bold text-[#14b8a6] leading-none mb-1">{{ $mentors->count() }}</span>
            <span class="text-xs font-semibold text-gray-500 uppercase mt-1">Mentor</span>
        </div>
        <div class="bg-white border-2 border-[#14b8a6] rounded-xl p-5 flex flex-col items-center justify-center shadow-sm">
            <span class="text-3xl font-bold text-[#14b8a6] leading-none mb-1">{{ $atasans->count() }}</span>
            <span class="text-xs font-semibold text-gray-500 uppercase mt-1">Atasan</span>
        </div>
        <div class="bg-white border-2 border-[#14b8a6] rounded-xl p-5 flex flex-col items-center justify-center shadow-sm">
            <span class="text-3xl font-bold text-[#14b8a6] leading-none mb-1">{{ $finances->count() }}</span>
            <span class="text-xs font-semibold text-gray-500 uppercase mt-1">Finance</span>
        </div>
        <div class="bg-white border-2 border-[#14b8a6] rounded-xl p-5 flex flex-col items-center justify-center shadow-sm">
            <span class="text-3xl font-bold text-[#14b8a6] leading-none mb-1">{{ $bods->count() }}</span>
            <span class="text-xs font-semibold text-gray-500 uppercase mt-1">BOD</span>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="w-full md:w-3/4">
            <input type="text" class="w-full border border-[#d1d5db] rounded-lg p-2.5 px-4 text-sm text-[#475569] outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6]" placeholder="Cari Nama">
        </div>
        <div class="w-full md:w-1/4">
            <select class="w-full border border-[#d1d5db] rounded-lg p-2.5 px-4 text-sm text-[#475569] outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] bg-white appearance-none" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Posisi</option>
            </select>
        </div>
    </div>

    {{-- Data Section --}}
    @php
        $userGroups = [
            ['title' => 'Talent', 'users' => $talents, 'showPosisi' => true],
            ['title' => 'Mentor', 'users' => $mentors, 'showPosisi' => true],
            ['title' => 'Atasan', 'users' => $atasans, 'showPosisi' => true],
            ['title' => 'Finance', 'users' => $finances, 'showPosisi' => false],
            ['title' => 'BOD', 'users' => $bods, 'showPosisi' => false],
        ];
    @endphp

    <div class="space-y-8">
        @foreach($userGroups as $group)
            <div class="border border-[#e2e8f0] rounded-xl overflow-hidden shadow-sm bg-white">
                {{-- Table Title --}}
                <div class="bg-[#f8fafc] border-b border-[#e2e8f0] py-3 text-center">
                    <h3 class="font-bold text-[#2e3746] leading-none">{{ $group['title'] }}</h3>
                </div>
                
                {{-- Table Data --}}
                <div class="overflow-x-auto">
                    <table class="um-table">
                        <thead>
                            <tr class="bg-white">
                                <th class="text-sm font-bold text-[#2e3746] p-3 w-48">Email</th>
                                <th class="text-sm font-bold text-[#2e3746] p-3 w-48">Nama Lengkap</th>
                                <th class="text-sm font-bold text-[#2e3746] p-3 w-48">
                                    <div class="flex items-center justify-center gap-1">
                                        Perusahaan
                                    </div>
                                </th>
                                <th class="text-sm font-bold text-[#2e3746] p-3 w-48">Departemen</th>
                                @if($group['showPosisi'])
                                    <th class="text-sm font-bold text-[#2e3746] p-3 w-40">Posisi saat ini</th>
                                @endif
                                <th class="text-sm font-bold text-[#2e3746] p-3 w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($group['users'] as $u)
                                <tr class="bg-white hover:bg-gray-50 transition-colors">
                                    <td class="text-sm font-medium text-[#475569]">{{ $u->email }}</td>
                                    <td class="text-sm font-bold text-[#2e3746]">{{ $u->nama }}</td>
                                    <td class="text-sm font-medium text-[#475569]">{{ $u->company->nama_company ?? '—' }}</td>
                                    <td class="text-sm font-medium text-[#475569]">{{ $u->department->nama_department ?? '—' }}</td>
                                    @if($group['showPosisi'])
                                        <td class="text-sm font-medium text-[#475569]">{{ $u->position->position_name ?? '—' }}</td>
                                    @endif
                                    <td>
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick="openRoleModal({{ $u->id }}, {{ $u->roles->pluck('id') }})" class="p-2 text-gray-400 hover:text-[#14b8a6] hover:bg-teal-50 rounded-lg transition-colors" title="Edit Role">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button type="button" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    @php $cols = $group['showPosisi'] ? 6 : 5; @endphp
                                    <td colspan="{{ $cols }}" class="py-10 text-center text-sm text-gray-400 italic">Belum ada user.</td>
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
                        @foreach($rolesData as $roleData)
                            @if(!in_array(strtolower($roleData->role_name), ['admin', 'pdc admin', 'pdc_admin']))
                            <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors m-0">
                                <input type="checkbox" name="roles[]" value="{{ $roleData->id }}" class="role-checkbox w-5 h-5 text-[#14b8a6] border-gray-300 rounded focus:ring-[#14b8a6]">
                                <span class="ml-3 font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $roleData->role_name) }}</span>
                            </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeRoleModal()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
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
    </script>
</x-pdc_admin.layout>
