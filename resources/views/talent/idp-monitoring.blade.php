<x-talent.layout title="IDP Monitoring – Individual Development Plan" :user="$user ?? auth()->user()" :notifications="$notifications ?? collect([])" :mobileCollapsible="true">
    <x-slot name="styles">
        <style>
            /* ── Form Items ── */
            .form-input,
            .form-textarea {
                width: 100%;
                padding: 0.55rem 1rem;
                border: 1.5px solid #cbd5e1;
                border-radius: 6px;
                font-size: 0.875rem;
                outline: none;
                transition: border-color 0.2s;
                background-color: #ffffff;
            }

            .form-input:focus,
            .form-textarea:focus {
                border-color: #22c55e;
                box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12);
            }

            /* ── Tab bar ── */
            .tab-bar {
                display: flex;
                background: #e2e8f0;
                border-radius: 9999px;
                padding: 5px;
                gap: 4px;
                width: fit-content;
                margin-bottom: 1.5rem;
            }

            .tab-btn {
                padding: 0.55rem 1.75rem;
                font-weight: 600;
                font-size: 0.9rem;
                border-radius: 9999px;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                color: #64748b;
                background: transparent;
                white-space: nowrap;
            }

            .tab-active {
                background-color: #2e3746;
                color: #ffffff;
                box-shadow: 0 2px 12px rgba(46,55,70,0.22);
            }

            .tab-inactive {
                background: transparent;
                color: #64748b;
            }

            .tab-inactive:hover {
                background-color: #cbd5e1;
                color: #2e3746;
            }

            .upload-btn {
                border: 1.5px solid #cbd5e1;
                padding: 0.4rem 1.2rem;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                font-size: 0.875rem;
                color: #2e3746;
                cursor: pointer;
                transition: all 0.2s;
                font-weight: 500;
                background-color: white;
            }

            .upload-btn:hover {
                background-color: #f0fdf4;
                color: #16a34a;
                border-color: #22c55e;
            }

            .submit-btn {
                background: linear-gradient(135deg, #10b981, #059669);
                color: white;
                font-weight: 600;
                padding: 0.5rem 2.5rem;
                border-radius: 10px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-size: 0.875rem;
                box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
            }

            .submit-btn:hover {
                background: linear-gradient(135deg, #16a34a, #15803d);
                box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5);
                transform: translateY(-1px);
            }

            .submit-btn:active {
                transform: translateY(0);
                box-shadow: 0 3px 10px rgba(34, 197, 94, 0.3);
            }

            /* Main Gray Container matches the image */
            .wrapper-bg {
                background-color: #f3f4f6;
            }

            .form-bg {
                background-color: #ffffff;
                border-radius: 10px;
            }

            /* ── Responsive Tab Bar ── */
            @media (max-width: 640px) {
                .tab-bar {
                    width: 100%;
                    justify-content: space-between;
                    padding: 4px;
                    margin-bottom: 1.25rem;
                }
                .tab-btn {
                    padding: 0.45rem 0.25rem;
                    font-size: 0.75rem;
                    flex: 1;
                    text-align: center;
                }
            }
        </style>
    </x-slot>

    {{-- ══════════════════════════════ FORM AREA ══════════════════════════════ --}}
    <div class="w-full max-w-5xl mx-auto px-4 md:px-6 pt-6 md:pt-10 pb-12 flex-grow fade-up fade-up-2">

        {{-- Back Link --}}
        <div class="px-2 mb-4">
            <a href="{{ route('talent.dashboard') }}"
                class="px-4 py-2 border border-[#e2e8f0] rounded-lg bg-white text-[#475569] font-medium text-[0.875rem] flex items-center gap-2 transition-all duration-200 hover:bg-[#f8fafc] hover:border-[#cbd5e1] w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span class="text-[#2e3746]">Kembali</span>
            </a>
        </div>

        {{-- Custom Title --}}
        <div class="page-header animate-title">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">IDP Monitoring</div>
                <div class="page-header-sub">Kelola progres rencana pengembangan individu Anda</div>
            </div>
        </div>

        {{-- Main Gray Container Background (Wrapper) --}}
        @if(session('success'))
            <div id="successPopup" class="mb-5" style="
                opacity: 0; transform: translateY(-10px);
                background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
                padding: 0.75rem 1.25rem;
                animation: popupIn 0.35s ease 0.1s forwards;
            ">
                <p style="font-size: 0.85rem; color: #166534; margin: 0;">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </p>
            </div>
            <style>
                @keyframes popupIn {
                    from { opacity: 0; transform: translateY(-10px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
            </style>
            <script>
                setTimeout(function() {
                    var el = document.getElementById('successPopup');
                    el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(function() { el.remove(); }, 400);
                }, 4000);
            </script>
        @endif

        <div class="wrapper-bg rounded-[16px] shadow-sm p-4 md:p-6 border border-gray-200">

            {{-- Tabs --}}
            <div class="tab-bar">
                <button type="button" onclick="switchIdpTab('exposure')" id="tab-btn-exposure"
                    class="tab-btn {{ $tab == 'exposure' ? 'tab-active' : 'tab-inactive' }}">Exposure</button>
                <button type="button" onclick="switchIdpTab('mentoring')" id="tab-btn-mentoring"
                    class="tab-btn {{ $tab == 'mentoring' ? 'tab-active' : 'tab-inactive' }}">Mentoring</button>
                <button type="button" onclick="switchIdpTab('learning')" id="tab-btn-learning"
                    class="tab-btn {{ $tab == 'learning' ? 'tab-active' : 'tab-inactive' }}">Learning</button>
            </div>

            {{-- White Form Content --}}
            <div class="form-bg p-4 md:p-8 relative z-20 -mt-2 shadow-sm">
                <form id="idp-form" action="{{ isset($editMode) ? route('talent.idp_monitoring.update', $activity->id) : route('talent.idp_monitoring.store', ['tab' => $tab]) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @if(isset($editMode))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="tab_type" id="tab_type" value="{{ old('tab_type', $tab) }}">

                    {{-- Common fields: Theme & Date --}}
                    <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-center gap-4 md:gap-6">
                        <label class="text-sm font-semibold text-gray-800">Tema</label>
                        <input type="text" name="theme" class="form-input" placeholder="" value="{{ old('theme', $activity->theme ?? '') }}" required>
                    </div>

                    <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-center gap-4 md:gap-6">
                        <label class="text-sm font-semibold text-gray-800">Tanggal</label>
                        <input type="date" name="activity_date" class="form-input" value="{{ old('activity_date', isset($activity) ? \Carbon\Carbon::parse($activity->activity_date)->format('Y-m-d') : '') }}" required>
                    </div>

                    {{-- Fields for Exposure & Mentoring --}}
                    <div id="fields-exp-men" class="{{ $tab == 'learning' ? 'hidden' : '' }} space-y-4">
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-center gap-4 md:gap-6">
                            <label class="text-sm font-semibold text-gray-800">Mentor</label>
                            <select name="mentor_name" class="form-input" {{ $tab != 'learning' ? 'required' : '' }}>
                                <option value="" disabled selected>Pilih mentor...</option>
                                @foreach ($mentors as $m)
                                    <option value="{{ $m->nama }}" {{ old('mentor_name', $activity->verifier->nama ?? '') == $m->nama ? 'selected' : '' }}>
                                        {{ $m->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-center gap-4 md:gap-6">
                            <label class="text-sm font-semibold text-gray-800">Lokasi</label>
                            <input type="text" name="location" class="form-input" placeholder="" value="{{ old('location', $activity->location ?? '') }}" {{ $tab != 'learning' ? 'required' : '' }}>
                        </div>
                    </div>

                    {{-- Fields for Learning --}}
                    <div id="fields-learning" class="{{ $tab != 'learning' ? 'hidden' : '' }} space-y-4">
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-center gap-4 md:gap-6">
                            <label class="text-sm font-semibold text-gray-800">Sumber</label>
                            <input type="text" name="activity_learning" id="activity_learning" class="form-input" placeholder="" value="{{ old('activity_learning', ($tab == 'learning' ? ($activity->activity ?? '') : '')) }}" {{ $tab == 'learning' ? 'required' : '' }}>
                        </div>
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-center gap-4 md:gap-6">
                            <label class="text-sm font-semibold text-gray-800">Platform</label>
                            <input type="text" name="platform" class="form-input" placeholder="" value="{{ old('platform', $activity->platform ?? '') }}" {{ $tab == 'learning' ? 'required' : '' }}>
                        </div>
                    </div>

                    {{-- Specific fields for Mentoring --}}
                    <div id="fields-mentoring" class="{{ $tab != 'mentoring' ? 'hidden' : '' }} space-y-4">
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-start gap-4 md:gap-6 pt-1">
                            <label class="text-sm font-semibold text-gray-800 pt-3">Deskripsi</label>
                            <textarea name="description_mentoring" id="description_mentoring" class="form-textarea h-24" placeholder="" {{ $tab == 'mentoring' ? 'required' : '' }}>{{ old('description_mentoring', ($tab == 'mentoring' ? ($activity->description ?? '') : '')) }}</textarea>
                        </div>
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-start gap-4 md:gap-6 pt-1">
                            <label class="text-sm font-semibold text-gray-800 pt-3">Action Plan</label>
                            <textarea name="action_plan" class="form-textarea h-24" placeholder="" {{ $tab == 'mentoring' ? 'required' : '' }}>{{ old('action_plan', $activity->action_plan ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Specific fields for Exposure --}}
                    <div id="fields-exposure" class="{{ $tab != 'exposure' ? 'hidden' : '' }} space-y-4">
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-start gap-4 md:gap-6 pt-1">
                            <label class="text-sm font-semibold text-gray-800 pt-3">Aktivitas</label>
                            <textarea name="activity_exposure" id="activity_exposure" class="form-textarea h-24" placeholder="" {{ $tab == 'exposure' ? 'required' : '' }}>{{ old('activity_exposure', ($tab == 'exposure' ? ($activity->activity ?? '') : '')) }}</textarea>
                        </div>
                        <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-start gap-4 md:gap-6 pt-1">
                            <label class="text-sm font-semibold text-gray-800 pt-3">Deskripsi</label>
                            <textarea name="description_exposure" id="description_exposure" class="form-textarea h-24" placeholder="" {{ $tab == 'exposure' ? 'required' : '' }}>{{ old('description_exposure', ($tab == 'exposure' ? ($activity->description ?? '') : '')) }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-[100px_1fr] md:grid-cols-[140px_1fr] items-start gap-4 md:gap-6 pt-2">
                        <label class="text-sm font-semibold text-gray-800 mt-2">Dokumentasi</label>
                        <div class="flex flex-col gap-3">
                            {{-- Tampilkan File Sebelumnya Jika Edit Mode --}}
                            @if(isset($editMode) && $activity->document_path)
                                @php
                                    $paths = [];
                                    $names = [];
                                    if(str_starts_with($activity->document_path, '["')) {
                                        $paths = json_decode($activity->document_path, true);
                                        $names = explode(', ', $activity->file_name);
                                    } else {
                                        $paths = [$activity->document_path];
                                        $names = [$activity->file_name];
                                    }
                                @endphp
                                <div class="mb-2" id="existingFilesContainer">
                                    <p class="text-[13px] text-gray-500 font-semibold mb-2">Dokumen Terlampir Saat Ini:</p>
                                    <div class="flex flex-col gap-2 max-w-lg">
                                        @foreach($paths as $index => $path)
                                        <div class="flex items-center gap-3 p-2.5 bg-gray-50 border border-gray-200 rounded-[10px]" data-existing-file>
                                            <input type="hidden" name="existing_documents_paths[]" value="{{ $path }}">
                                            <input type="hidden" name="existing_documents_names[]" value="{{ $names[$index] ?? 'Dokumen' }}">
                                            <div class="w-10 h-10 shrink-0 rounded overflow-hidden flex items-center justify-center bg-gray-200 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                                <div>
                                                    <a href="{{ asset('storage/'.$path) }}" target="_blank" class="text-sm font-bold text-teal-600 hover:text-teal-800 hover:underline truncate block max-w-[250px]" title="{{ $names[$index] ?? 'Dokumen' }}">{{ $names[$index] ?? 'Dokumen' }}</a>
                                                </div>
                                                <button type="button" class="shrink-0 p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition" title="Hapus File Ini" onclick="this.closest('[data-existing-file]').remove();">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Tombol Upload / Ganti / Tambah --}}
                            <div class="flex items-center gap-2 flex-wrap" id="uploadActionContainer">
                                {{-- Tombol utama: Upload File / Ganti Semua File --}}
                                <label class="upload-btn" id="uploadBtnLabel">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span id="uploadLabelText">Upload File</span>
                                    <input type="file" name="documents[]" id="documentInput" class="hidden" {{ isset($editMode) ? '' : 'required' }}
                                        multiple accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx">
                                </label>
                            </div>

                            {{-- Preview List: satu card per file --}}
                            <div id="filePreviewContainer" class="hidden flex flex-col gap-2 max-w-lg">
                                <div id="fileListWrapper" class="flex flex-col gap-2"></div>
                            </div>

                            {{-- Peringatan validasi --}}
                            <div id="uploadWarning" class="hidden flex items-start gap-2 p-3 bg-amber-50 border border-amber-200 rounded-[10px] max-w-lg text-sm text-amber-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 mt-0.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                <span id="uploadWarningText"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-5">
                        <button type="submit" class="submit-btn text-white font-semibold">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function switchIdpTab(tab) {
                // 1. Update Buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('tab-active');
                    btn.classList.add('tab-inactive');
                });
                document.getElementById('tab-btn-' + tab).classList.remove('tab-inactive');
                document.getElementById('tab-btn-' + tab).classList.add('tab-active');

                // 2. Hide all field groups
                document.getElementById('fields-exp-men').classList.add('hidden');
                document.getElementById('fields-learning').classList.add('hidden');
                document.getElementById('fields-mentoring').classList.add('hidden');
                document.getElementById('fields-exposure').classList.add('hidden');

                // 3. Show relevant field groups & update required attributes
                const form = document.getElementById('idp-form');
                const tabTypeInput = document.getElementById('tab_type');
                tabTypeInput.value = tab;

                // Reset all required
                form.querySelectorAll('[required]').forEach(el => {
                    if (!['theme', 'activity_date'].includes(el.name)) {
                        el.removeAttribute('required');
                    }
                });

                if (tab === 'learning') {
                    document.getElementById('fields-learning').classList.remove('hidden');
                    form.querySelector('[name="activity_learning"]').setAttribute('required', '');
                    form.querySelector('[name="platform"]').setAttribute('required', '');
                } else {
                    document.getElementById('fields-exp-men').classList.remove('hidden');
                    form.querySelector('[name="mentor_name"]').setAttribute('required', '');
                    form.querySelector('[name="location"]').setAttribute('required', '');

                    if (tab === 'mentoring') {
                        document.getElementById('fields-mentoring').classList.remove('hidden');
                        form.querySelector('[name="description_mentoring"]').setAttribute('required', '');
                        form.querySelector('[name="action_plan"]').setAttribute('required', '');
                    } else if (tab === 'exposure') {
                        document.getElementById('fields-exposure').classList.remove('hidden');
                        form.querySelector('[name="activity_exposure"]').setAttribute('required', '');
                        form.querySelector('[name="description_exposure"]').setAttribute('required', '');
                    }
                }

                // 4. Update Form Action (for store)
                @if(!isset($editMode))
                    let baseUrl = "{{ route('talent.idp_monitoring.store', ['tab' => 'TAB_PLACEHOLDER']) }}";
                    form.action = baseUrl.replace('TAB_PLACEHOLDER', tab);
                @endif
            }

            document.addEventListener('DOMContentLoaded', function() {
                const initialTab = document.getElementById('tab_type').value;
                switchIdpTab(initialTab);
            });

            (function() {
                // File Upload Preview Logic
                const documentInput      = document.getElementById('documentInput');
                const filePreviewContainer = document.getElementById('filePreviewContainer');
                const fileListWrapper    = document.getElementById('fileListWrapper');
                const uploadLabelText    = document.getElementById('uploadLabelText');

                // Semua file yang dipilih
                let allFiles = [];

                function formatSize(bytes) {
                    const kb = Math.round(bytes / 1024);
                    return kb > 1024 ? (kb / 1024).toFixed(2) + ' MB' : kb + ' KB';
                }

                function getFileIconSvg() {
                    return `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>`;
                }

                function renderFileCards() {
                    fileListWrapper.innerHTML = '';

                    if (allFiles.length === 0) {
                        filePreviewContainer.classList.add('hidden');
                        uploadLabelText.textContent = 'Upload File';
                        return;
                    }

                    filePreviewContainer.classList.remove('hidden');
                    uploadLabelText.textContent = 'Upload';

                    allFiles.forEach((file, index) => {
                        const card = document.createElement('div');
                        card.className = 'flex items-center gap-3 p-3 bg-teal-50 border border-teal-100 rounded-[10px] shadow-sm';

                        // Thumbnail / icon
                        const thumbWrapper = document.createElement('div');
                        thumbWrapper.className = 'w-12 h-12 shrink-0 rounded overflow-hidden border flex items-center justify-center';

                        if (file.type.startsWith('image/')) {
                            thumbWrapper.className += ' bg-gray-200 border-gray-300';
                            const img = document.createElement('img');
                            img.alt = file.name;
                            img.className = 'w-full h-full object-cover';
                            const reader = new FileReader();
                            reader.onload = e => { img.src = e.target.result; };
                            reader.readAsDataURL(file);
                            thumbWrapper.appendChild(img);
                        } else {
                            thumbWrapper.className += ' bg-teal-100 border-teal-200 text-teal-600';
                            thumbWrapper.innerHTML = getFileIconSvg();
                        }

                        // Info teks
                        const info = document.createElement('div');
                        info.className = 'flex-1 min-w-0';
                        info.innerHTML = `
                            <p class="text-sm font-bold text-gray-800 truncate" title="${file.name}">${file.name}</p>
                            <p class="text-xs text-gray-500">${formatSize(file.size)}</p>
                        `;

                        // Tombol hapus per file
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.title = 'Hapus File';
                        removeBtn.className = 'shrink-0 p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition';
                        removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>`;
                        removeBtn.addEventListener('click', () => {
                            allFiles.splice(index, 1);
                            syncInput();
                            renderFileCards();
                        });

                        card.appendChild(thumbWrapper);
                        card.appendChild(info);
                        card.appendChild(removeBtn);
                        fileListWrapper.appendChild(card);
                    });

                    syncInput();
                }

                function syncInput() {
                    const dt = new DataTransfer();
                    allFiles.forEach(f => dt.items.add(f));
                    documentInput.files = dt.files;
                }

                function showWarning(msg) {
                    const box  = document.getElementById('uploadWarning');
                    const text = document.getElementById('uploadWarningText');
                    text.textContent = msg;
                    box.classList.remove('hidden');
                    // Auto-hide setelah 5 detik
                    clearTimeout(box._timer);
                    box._timer = setTimeout(() => box.classList.add('hidden'), 5000);
                }

                function hideWarning() {
                    document.getElementById('uploadWarning').classList.add('hidden');
                }

                const MAX_FILES   = 5;
                const MAX_SIZE_MB = 5;
                const MAX_BYTES   = MAX_SIZE_MB * 1024 * 1024;

                function addFiles(newFiles) {
                    const warnings = [];

                    newFiles.forEach(f => {
                        // Cek ukuran file
                        if (f.size > MAX_BYTES) {
                            warnings.push(`"${f.name}" melebihi batas ${MAX_SIZE_MB} MB (ukuran: ${formatSize(f.size)}).`);
                            return; // lewati file ini
                        }

                        // Cek duplikat
                        if (allFiles.some(e => e.name === f.name && e.size === f.size)) {
                            return; // lewati duplikat
                        }

                        // Cek batas jumlah file
                        if (allFiles.length >= MAX_FILES) {
                            warnings.push(`Maksimal ${MAX_FILES} file. "${f.name}" tidak ditambahkan.`);
                            return;
                        }

                        allFiles.push(f);
                    });

                    if (warnings.length > 0) {
                        showWarning(warnings.join(' '));
                    } else {
                        hideWarning();
                    }

                    renderFileCards();
                }

                if (documentInput) {
                    // Pilih file
                    documentInput.addEventListener('change', function() {
                        // Jangan reset array agar file baru bertambah (append) bukan menggantikan pilihan sebelumnya di UI
                        addFiles(Array.from(this.files));
                    });
                }
            })();
        </script>
    </x-slot>
</x-talent.layout>
