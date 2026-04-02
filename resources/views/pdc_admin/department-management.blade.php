<x-pdc_admin.layout title="Department Management – {{ $company->nama_company }}" :user="$user">
    <x-slot name="styles">
        <style>
            .dept-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                padding: 16px 20px;
                transition: box-shadow 0.15s;
            }
            .dept-row:hover {
                box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            }
            .dept-name {
                font-size: 0.95rem;
                font-weight: 600;
                color: #2e3746;
            }
        </style>
    </x-slot>

    {{-- Header & Back Button --}}
    <div class="mb-10">
        <a href="{{ route('pdc_admin.company_management') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <h2 class="text-3xl font-black text-[#2e3746] text-center">{{ $company->nama_company }}</h2>
    </div>

    {{-- Main Card --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-sm p-8 max-w-5xl mx-auto mb-10">
        <h3 class="text-lg font-bold text-[#2e3746] mb-6">Daftar Departemen</h3>

        {{-- Toolbar --}}
        <div class="flex items-center justify-between gap-4 mb-8">
            <div class="relative w-80">
                <input type="text" id="searchDept" onkeyup="filterDepts()"
                    placeholder="Cari nama departemen.."
                    class="w-full border-2 border-[#14b8a6] rounded-xl py-2.5 pl-4 pr-10 text-sm outline-none focus:ring-1 focus:ring-[#14b8a6]">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <button onclick="openAddDeptModal()"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-[#2e3746] hover:bg-[#1f2937] rounded-xl transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Departemen
            </button>
        </div>

        {{-- Dept List --}}
        <div class="space-y-3" id="deptList">
            @forelse($departments as $dept)
                <div class="dept-row dept-item">
                    <span class="dept-name">{{ $dept->nama_department }}</span>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            onclick="openEditDeptModal({{ $dept->id }}, '{{ addslashes($dept->nama_department) }}')"
                            class="flex items-center justify-center w-9 h-9 bg-[#F4F1EA] hover:bg-[#eadecc] border border-[#e5e1d8] rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#475569]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button type="button"
                            onclick="openDeleteDeptModal({{ $dept->id }}, '{{ addslashes($dept->nama_department) }}')"
                            class="flex items-center justify-center w-9 h-9 bg-[#EF4444] hover:bg-[#dc2626] rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-12 italic">Belum ada departemen untuk perusahaan ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Modals --}}
    {{-- Add Modal --}}
    <div id="addDeptModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
            <h3 class="text-xl font-black text-[#2e3746] mb-1">Tambah Departemen</h3>
            <p class="text-sm text-gray-400 mb-6">Masukkan nama departemen baru</p>
            <form method="POST" action="{{ route('pdc_admin.department.store') }}">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">
                <input type="text" name="nama_department" placeholder="Nama departemen"
                    class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#2e3746] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-6">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('addDeptModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#22c55e] hover:bg-[#16a34a] rounded-xl transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editDeptModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
            <h3 class="text-xl font-black text-[#2e3746] mb-1">Edit Departemen</h3>
            <p class="text-sm text-gray-400 mb-6">Ganti nama departemen</p>
            <form method="POST" id="editDeptForm" action="">
                @csrf
                @method('PUT')
                <input type="text" name="nama_department" id="editDeptInput" placeholder="Nama departemen"
                    class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#2e3746] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-6">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('editDeptModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#22c55e] hover:bg-[#16a34a] rounded-xl transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteDeptModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl p-8 text-center" x-data>
            <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Departemen?</h3>
            <p class="text-gray-500 text-sm mb-7" id="deleteDeptDesc"></p>
            <form id="deleteDeptForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('deleteDeptModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors shadow-sm">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function openModal(id) {
                const m = document.getElementById(id);
                m.classList.remove('hidden');
                m.style.display = 'flex';
            }
            function closeModal(id) {
                const m = document.getElementById(id);
                m.style.display = 'none';
                m.classList.add('hidden');
            }

            function openAddDeptModal() { openModal('addDeptModal'); }

            function openEditDeptModal(id, name) {
                document.getElementById('editDeptInput').value = name;
                document.getElementById('editDeptForm').action = '/pdc-admin/department/' + id;
                openModal('editDeptModal');
            }

            function openDeleteDeptModal(id, name) {
                document.getElementById('deleteDeptDesc').textContent = 'Departemen "' + name + '" akan dihapus secara permanen.';
                document.getElementById('deleteDeptForm').action = '/pdc-admin/department/' + id;
                openModal('deleteDeptModal');
            }

            function filterDepts() {
                const q = document.getElementById('searchDept').value.toLowerCase();
                document.querySelectorAll('.dept-item').forEach(item => {
                    const name = item.querySelector('.dept-name').innerText.toLowerCase();
                    item.style.display = name.includes(q) ? '' : 'none';
                });
            }
        </script>
    </x-slot>
</x-pdc_admin.layout>
