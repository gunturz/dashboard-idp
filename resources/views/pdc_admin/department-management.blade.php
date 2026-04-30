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
                color: #0f172a;
            }
            .btn-back {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 500;
                font-size: 0.875rem;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s;
                width: fit-content;
            }
            .btn-back:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">{{ $company->nama_company }}</div>
            <div class="page-header-sub">Manajemen struktur departemen di perusahaan ini.</div>
        </div>
        <div class="page-header-actions">
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div class="relative w-full sm:w-80">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchDept" oninput="filterDepts()"
                placeholder="Cari nama departemen.."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
        </div>
        <button onclick="openAddDeptModal()"
            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-[#0f172a] hover:bg-[#1f2937] rounded-xl transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Departemen
        </button>
    </div>

    {{-- Main Card --}}
    <div class="prem-card p-8 w-full mb-10">
        <h3 class="text-lg font-bold text-[#0f172a] mb-6">Daftar Departemen</h3>

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

    {{-- Bottom Actions --}}
    <div class="flex justify-start mb-10">
        <a href="{{ route('pdc_admin.company_management') }}" class="btn-prem btn-dark px-4 inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali
        </a>
    </div>

    {{-- Modals --}}
    {{-- Add Modal --}}
    <div id="addDeptModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
            <h3 class="text-xl font-black text-[#0f172a] mb-1">Tambah Departemen</h3>
            <p class="text-sm text-gray-400 mb-6">Masukkan nama departemen baru</p>
            <form method="POST" action="{{ route('pdc_admin.department.store') }}">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">
                <input type="text" name="nama_department" placeholder="Nama departemen"
                    class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#0f172a] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-6">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('addDeptModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editDeptModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
            <h3 class="text-xl font-black text-[#0f172a] mb-1">Edit Departemen</h3>
            <p class="text-sm text-gray-400 mb-6">Ganti nama departemen</p>
            <form method="POST" id="editDeptForm" action="">
                @csrf
                @method('PUT')
                <input type="text" name="nama_department" id="editDeptInput" placeholder="Nama departemen"
                    class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#0f172a] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-6">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('editDeptModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm">
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
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
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
