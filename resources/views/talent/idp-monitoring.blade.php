<x-talent.layout title="IDP Monitoring – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ── Form Items ── */
            .form-input, .form-textarea { width: 100%; padding: 0.55rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 0.875rem; outline: none; transition: border-color 0.2s; background-color: #ffffff; }
            .form-input:focus, .form-textarea:focus { border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12); }
            /* ── Tab bar ── */
            .tab-bar { display: flex; background: #e2e8f0; border-radius: 9999px; padding: 5px; gap: 4px; width: fit-content; margin-bottom: 1.5rem; }
            .tab-btn { padding: 0.55rem 1.75rem; font-weight: 600; font-size: 0.9rem; border-radius: 9999px; cursor: pointer; transition: all 0.2s; text-decoration: none; color: #64748b; background: transparent; white-space: nowrap; }
            .tab-active { background-color: #2e3746; color: #ffffff; box-shadow: 0 2px 12px rgba(46,55,70,0.22); }
            .tab-inactive { background: transparent; color: #64748b; }
            .tab-inactive:hover { background-color: #cbd5e1; color: #2e3746; }
            .upload-btn { border: 1.5px solid #cbd5e1; padding: 0.4rem 1.2rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; color: #2e3746; cursor: pointer; transition: all 0.2s; font-weight: 500; background-color: white; }
            .upload-btn:hover { background-color: #f0fdf4; color: #16a34a; border-color: #22c55e; }
            .submit-btn { background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 600; padding: 0.5rem 2.5rem; border-radius: 10px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); font-size: 0.875rem; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
            .submit-btn:hover { background: linear-gradient(135deg, #16a34a, #15803d); box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5); transform: translateY(-1px); }
            .submit-btn:active { transform: translateY(0); box-shadow: 0 3px 10px rgba(34, 197, 94, 0.3); }
            /* Main Gray Container matches the image */
            .wrapper-bg { background-color: #f3f4f6; }
            .form-bg { background-color: #ffffff; border-radius: 10px; }
        </style>
    </x-slot>

    <div class="w-full max-w-5xl mx-auto px-6 pt-10 pb-12 flex-grow fade-up fade-up-2">


        {{-- Back Link --}}
        <div class="px-2 mb-4">
            <a href="{{ route('talent.dashboard') }}"
                class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#0d9488] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Custom Title --}}
        <div class="flex items-center gap-2.5 px-2 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20"
                fill="currentColor">
                <path
                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            <h2 class="text-xl font-bold text-[#2e3746] animate-title">IDP Monitoring</h2>
        </div>

        {{-- Main Gray Container Background (Wrapper) --}}
        @if(session('success'))
            <div id="successPopup" class="mb-5" style="
                opacity: 0; transform: translateY(-10px);
                background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
                padding: 0.75rem 1.25rem;
                animation: popupIn 0.35s ease 0.1s forwards;
            ">
                <p style="font-size: 0.85rem; color: #15803d; margin: 0;">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </p>
            </div>
            <style>
                @keyframes popupIn {
                    from { opacity: 0; transform: translateY(-10px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
                @keyframes popupOut {
                    from { opacity: 1; transform: translateY(0); }
                    to   { opacity: 0; transform: translateY(-10px); }
                }
            </style>
            <script>
                function closePopup() {
                    const el = document.getElementById('successPopup');
                    if (el) { el.style.animation = 'popupOut 0.3s ease forwards'; setTimeout(() => el.remove(), 300); }
                }
                setTimeout(closePopup, 4000);
            </script>
        @endif

        <div class="wrapper-bg rounded-[16px] shadow-sm p-6 border border-gray-200">

            {{-- Tabs --}}
            <div class="tab-bar">
                <a href="{{ route('talent.idp_monitoring', 'exposure') }}"
                    class="tab-btn {{ $tab == 'exposure' ? 'tab-active' : 'tab-inactive' }}">Exposure</a>
                <a href="{{ route('talent.idp_monitoring', 'mentoring') }}"
                    class="tab-btn {{ $tab == 'mentoring' ? 'tab-active' : 'tab-inactive' }}">Mentoring</a>
                <a href="{{ route('talent.idp_monitoring', 'learning') }}"
                    class="tab-btn {{ $tab == 'learning' ? 'tab-active' : 'tab-inactive' }}">Learning</a>
            </div>

            {{-- White Form Content --}}
            <div class="form-bg p-8 relative z-20 -mt-2 shadow-sm">
                <form action="{{ isset($editMode) ? route('talent.idp_monitoring.update', $activity->id) : route('talent.idp_monitoring.store', ['tab' => $tab]) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @if(isset($editMode))
                        @method('PUT')
                    @endif

                    @if ($tab == 'learning')
                        <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                            <label class="text-sm font-semibold text-gray-800">Sumber</label>
                            <input type="text" name="activity" class="form-input" placeholder="" value="{{ old('activity', $activity->activity ?? '') }}" required>
                        </div>
                    @else
                        <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                            <label class="text-sm font-semibold text-gray-800">Mentor</label>
                            <input type="text" name="mentor_name" list="mentor-list" class="form-input"
                                placeholder="Ketik nama mentor..." value="{{ old('mentor_name', $activity->verifier->nama ?? '') }}" required>
                            <datalist id="mentor-list">
                                @foreach ($mentors as $m)
                                    <option value="{{ $m->nama }}">
                                @endforeach
                            </datalist>
                        </div>
                    @endif

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                        <label class="text-sm font-semibold text-gray-800">Tema</label>
                        <input type="text" name="theme" class="form-input" placeholder="" value="{{ old('theme', $activity->theme ?? '') }}" required>
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                        <label class="text-sm font-semibold text-gray-800">Tanggal</label>
                        <input type="date" name="activity_date" class="form-input" value="{{ old('activity_date', isset($activity) ? \Carbon\Carbon::parse($activity->activity_date)->format('Y-m-d') : '') }}" required>
                    </div>

                    @if ($tab == 'learning')
                        <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                            <label class="text-sm font-semibold text-gray-800">Platform</label>
                            <input type="text" name="platform" class="form-input" placeholder="" value="{{ old('platform', $activity->platform ?? '') }}" required>
                        </div>
                    @else
                        <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                            <label class="text-sm font-semibold text-gray-800">Lokasi</label>
                            <input type="text" name="location" class="form-input" placeholder="" value="{{ old('location', $activity->location ?? '') }}" required>
                        </div>
                    @endif

                    @if ($tab == 'mentoring')
                        <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-1">
                            <label class="text-sm font-semibold text-gray-800 pt-3">Deskripsi</label>
                            <textarea name="description" class="form-textarea h-24" placeholder="" required>{{ old('description', $activity->description ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-1">
                            <label class="text-sm font-semibold text-gray-800 pt-3">Action Plan</label>
                            <textarea name="action_plan" class="form-textarea h-24" placeholder="" required>{{ old('action_plan', $activity->action_plan ?? '') }}</textarea>
                        </div>
                    @else
                        @if ($tab == 'exposure')
                            <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-1">
                                <label class="text-sm font-semibold text-gray-800 pt-3">Aktivitas</label>
                                <textarea name="activity" class="form-textarea h-24" placeholder="" required>{{ old('activity', $activity->activity ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-1">
                                <label class="text-sm font-semibold text-gray-800 pt-3">Deskripsi</label>
                                <textarea name="description" class="form-textarea h-24" placeholder="" required>{{ old('description', $activity->description ?? '') }}</textarea>
                            </div>
                        @endif
                    @endif

                    <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-2">
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
