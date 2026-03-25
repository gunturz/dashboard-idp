<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kompetensi – Individual Development Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Base backgrounds */
        .bg-dark-slate {
            background-color: #334155;
        }
        .bg-teal-primary {
            background-color: #0f766e;
        }

        /* Sub-category progress bar wrapper */
        .subcategory-bar {
            position: relative;
            width: 100%;
            max-width: 72rem;
            background-color: #ffffff;
            border-radius: 9999px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -2px rgba(0,0,0,.1);
            padding: 0;
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        /* The teal fill that grows from left */
        .subcategory-fill {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            background-color: #0f766e;
            border-radius: 9999px;
            transition: width 0.45s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        /* Each label button sits above the fill */
        .subcategory-btn {
            position: relative;
            z-index: 1;
            flex: 1;
            text-align: center;
            padding: 10px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.3s ease;
            cursor: default;
            white-space: nowrap;
        }

        .subcategory-btn.active {
            font-weight: 700;
        }

        .subcategory-btn.filled {
            color: #ffffff;
        }

        .subcategory-btn.unfilled {
            color: #4b5563;
        }

        /* ===== Result Modal ===== */
        .result-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .result-modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }
        .result-modal {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 780px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: scale(0.92) translateY(20px);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .result-modal-header {
            padding: 2rem 2.5rem 1.25rem;
            flex-shrink: 0;
        }
        .result-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 0 2.5rem;
        }
        .result-modal-footer {
            padding: 1.25rem 2.5rem 2rem;
            flex-shrink: 0;
            border-top: 1px solid #f1f5f9;
        }
        .result-modal-overlay.open .result-modal {
            transform: scale(1) translateY(0);
        }
        .score-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .score-1 { color:#1e293b; }
        .score-2 { color:#1e293b; }
        .score-3 { color:#1e293b; }
        .score-4 { color:#1e293b; }
        .score-5 { color:#1e293b; }
        .edit-row-btn {
            padding: 5px 16px;
            border-radius: 8px;
            border: none;
            color: #fff;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            background: #1e293b;
            transition: all 0.2s;
            transform: translateY(0);
        }
        .edit-row-btn:hover {
            background: #0f172a;
            transform: translateY(-1px);
        }

        /* ===== Confirmation Popup ===== */
        .confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(3px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }
        .confirm-overlay.open {
            opacity: 1;
            pointer-events: all;
        }
        .confirm-box {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            padding: 2rem 2.25rem;
            width: 100%;
            max-width: 440px;
            transform: scale(0.9) translateY(16px);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .confirm-overlay.open .confirm-box {
            transform: scale(1) translateY(0);
        }
    </style>
</head>

<body class="bg-dark-slate text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="px-6 py-3 border-b border-gray-100 flex items-center">
            <!-- Left Logo & Title -->
            <div class="flex items-center space-x-4">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Tiga Serangkai Logo" class="h-10 object-contain">
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Individual Development Plan</h1>
                
                <div class="h-8 w-px bg-gray-300 mx-2"></div>
                
                <h2 class="text-xl text-gray-500 font-medium">Kompetensi</h2>
            </div>
            
            <!-- (Optional) Right side Profile / Home Link -->
            <div class="ml-auto flex items-center">
                <!-- Fitur ke dashboard dihapus -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex flex-col items-center">

        <!-- Top Level Categories: Core / Managerial -->
        <div class="w-full bg-white rounded-full flex shadow-md overflow-hidden max-w-6xl mb-6" style="padding: 0;">
            <button id="tab-core" class="flex-1 text-center py-3 font-semibold text-white bg-teal-primary transition shadow-sm" style="border-radius: 9999px; margin: 0;">
                Core Competencies
            </button>
            <button id="tab-managerial" class="flex-1 text-center py-3 font-semibold text-gray-600 hover:bg-gray-50 transition" style="border-radius: 9999px; margin: 0;">
                Managerial Competencies
            </button>
        </div>

        <!-- Sub Categories (Progress Bar Style) -->
        <div class="subcategory-bar" id="subcategory-bar">
            <!-- Teal fill layer -->
            <div class="subcategory-fill" id="subcategory-fill"></div>
            <!-- Buttons -->
            <span id="cat-0" class="subcategory-btn filled active">Integrity</span>
            <span id="cat-1" class="subcategory-btn unfilled">Communication</span>
            <span id="cat-2" class="subcategory-btn unfilled">Innovation &amp; Creativity</span>
            <span id="cat-3" class="subcategory-btn unfilled">Customer Orientation</span>
            <span id="cat-4" class="subcategory-btn unfilled">Teamwork</span>
        </div>

        <!-- Main Card Block -->
        <form id="assessment-form" method="POST" action="{{ route('talent.competency.store') }}">
            @csrf
            <!-- Hidden inputs akan ditambahkan via JS -->
            <div id="hidden-inputs-container"></div>
            
            <div id="card-block" class="w-full max-w-6xl bg-white rounded-2xl shadow-xl p-10 flex flex-col animate-[slideUp_0.5s_ease-out]">
                <h3 id="level-title" class="text-2xl font-bold text-slate-800 mb-6 tracking-tight">Level 1</h3>
            
            <p id="level-desc" class="text-gray-600 leading-relaxed mb-12 text-[15px] font-medium text-justify">
                Memuat data pertanyaan...
            </p>

                <div class="flex items-center justify-end mt-auto">
                    {{-- Action Right: Ragu-ragu + Sudah Kompeten --}}
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="handleRaguRagu()"
                            class="px-8 py-2.5 bg-[#f59e0b] hover:bg-[#d97706] text-white font-semibold rounded-lg shadow-sm transition transform hover:-translate-y-0.5">
                            Ragu - ragu
                        </button>
                        <button type="button" onclick="handleSudahKompeten()"
                            class="px-8 py-2.5 bg-[#16a34a] hover:bg-[#15803d] text-white font-semibold rounded-lg shadow-sm transition transform hover:-translate-y-0.5">
                            Sudah Kompeten
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- ===== Confirmation Popup ===== -->
        <div id="confirm-overlay" class="confirm-overlay" role="dialog" aria-modal="true">
            <div class="confirm-box">
                <!-- Icon -->
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background:#f0fdfa">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="#0f766e" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <!-- Text -->
                <p id="confirm-message" class="text-center text-slate-700 font-medium text-[15px] leading-relaxed mb-6"></p>
                <!-- Buttons: Mode Normal -->
                <div class="flex gap-3" id="confirm-btns-normal">
                    <button id="confirm-btn-no" onclick="confirmNo()"
                        class="flex-1 py-2.5 rounded-lg font-semibold text-slate-700 transition hover:-translate-y-0.5"
                        style="background:#f1f5f9; border:none; cursor:pointer;">
                        Kembali
                    </button>
                    <button id="confirm-btn-yes" onclick="confirmYes()"
                        class="flex-1 py-2.5 rounded-lg font-semibold text-white transition hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #0f766e, #0d9488); border:none; cursor:pointer;">
                        Lanjutkan
                    </button>
                </div>
                <!-- Buttons: Mode Edit -->
                <div class="flex gap-3" id="confirm-btns-edit" style="display:none;">
                    <button id="confirm-btn-batal" onclick="editBatal()"
                        class="flex-1 py-2.5 rounded-lg font-semibold text-slate-700 transition hover:-translate-y-0.5"
                        style="background:#f1f5f9; border:none; cursor:pointer;">
                        Batal
                    </button>
                    <button id="confirm-btn-simpan" onclick="editSimpan()"
                        class="flex-1 py-2.5 rounded-lg font-semibold text-white transition hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #0f766e, #0d9488); border:none; cursor:pointer;">
                        Simpan
                    </button>
                </div>
            </div>
        </div>

        <div id="result-modal-overlay" class="result-modal-overlay" role="dialog" aria-modal="true">
            <div class="result-modal">

                <!-- Modal Header (fixed, tidak scroll) -->
                <div class="result-modal-header flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Hasil Penilaian Kompetensi</h2>
                        <p class="text-sm text-gray-500 mt-1">Periksa hasil assessment Anda sebelum submit. Klik <strong>Edit</strong> untuk mengubah nilai.</p>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:#f0fdfa;flex-shrink:0;margin-left:1rem">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="#0f766e" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Modal Body (hanya bagian ini yang scroll) -->
                <div class="result-modal-body">

                    <!-- Core Section -->
                    <div class="mb-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-3 h-3 rounded-full inline-block" style="background:#0f766e"></span>
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Core Competencies</h3>
                        </div>
                        <div class="overflow-hidden rounded-xl border border-gray-100">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-xs text-gray-400 uppercase tracking-wider" style="background:#f8fafc">
                                        <th class="px-5 py-3 text-left font-semibold">Kompetensi</th>
                                        <th class="py-3 text-center font-semibold" style="width:120px">Level</th>
                                        <th class="px-5 py-3 text-right font-semibold" style="width:90px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="result-table-core" class="divide-y divide-gray-50"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Managerial Section -->
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-3 h-3 rounded-full inline-block" style="background:#6366f1"></span>
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Managerial Competencies</h3>
                        </div>
                        <div class="overflow-hidden rounded-xl border border-gray-100">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-xs text-gray-400 uppercase tracking-wider" style="background:#f8fafc">
                                        <th class="px-5 py-3 text-left font-semibold">Kompetensi</th>
                                        <th class="py-3 text-center font-semibold" style="width:120px">Level</th>
                                        <th class="px-5 py-3 text-right font-semibold" style="width:90px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="result-table-managerial" class="divide-y divide-gray-50"></tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer (fixed, tidak scroll) -->
                <div class="result-modal-footer flex items-center justify-between">
                    <p class="text-xs text-gray-400">Total: <strong id="result-total-filled" class="text-slate-700">0</strong> kompetensi dinilai</p>
                    <button onclick="showSubmitPopup()"
                        class="px-10 py-3 text-white font-bold rounded-xl shadow-md transition transform hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #0f766e, #0d9488);">
                        ✓ &nbsp;Submit Assessment
                    </button>
                </div>

            </div>
        </div>

        <!-- ===== Submit Confirmation Popup ===== -->
        <div id="submit-overlay" class="confirm-overlay" role="dialog" aria-modal="true">
            <div class="confirm-box" style="max-width:400px; text-align:center;">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background:linear-gradient(135deg,#f0fdfa,#ccfbf1)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="#0f766e" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Kirim Assessment?</h3>
                <p class="text-sm text-gray-500 mb-6">Pastikan semua jawaban sudah benar.<br>Data tidak dapat diubah setelah dikirim.</p>
                <div class="flex gap-3">
                    <button onclick="document.getElementById('submit-overlay').classList.remove('open'); document.getElementById('result-modal-overlay').classList.add('open')"
                        class="flex-1 py-2.5 rounded-lg font-semibold text-slate-700"
                        style="background:#f1f5f9; border:none; cursor:pointer;">
                        Batal
                    </button>
                    <button onclick="doSubmitAssessment()"
                        class="flex-1 py-2.5 rounded-lg font-semibold text-white"
                        style="background:linear-gradient(135deg,#0f766e,#0d9488); border:none; cursor:pointer;">
                        Kirim
                    </button>
                </div>
            </div>
        </div>

    </main>

    <script>
        // Data dari database
        const competenciesData = @json($competencies->keyBy('id'));

        const topTabs = {
            core: {
                id: 'tab-core',
                name: 'Core Competencies',
                categories: [
                    { name: 'Integrity', id: 1 },
                    { name: 'Communication', id: 2 },
                    { name: 'Innovation & Creativity', id: 3 },
                    { name: 'Customer Orientation', id: 4 },
                    { name: 'Teamwork', id: 5 }
                ]
            },
            managerial: {
                id: 'tab-managerial',
                name: 'Managerial Competencies',
                categories: [
                    { name: 'Leadership', id: 6 },
                    { name: 'Business Acumen', id: 7 },
                    { name: 'Problem Solving & Decission Making', id: 8 },
                    { name: 'Acievement Orientation', id: 9 },
                    { name: 'Strategic Thinking', id: 10 }
                ]
            }
        };

        const categoryIds = ['cat-0', 'cat-1', 'cat-2', 'cat-3', 'cat-4'];
        
        // Simpan nilai score user
        let userScores = {};

        let currentTopLevel = 'core';
        let currentCategoryIndex = 0;
        let currentLevel = 1;
        const maxLevel = 5;

        const activeTopTabClass = "flex-1 text-center py-3 font-semibold text-white bg-teal-primary rounded-full transition shadow-sm";
        const inactiveTopTabClass = "flex-1 text-center py-3 font-semibold text-gray-600 hover:bg-gray-50 rounded-full transition";

        function updateSubcategoryFill() {
            const bar = document.getElementById('subcategory-bar');
            const fill = document.getElementById('subcategory-fill');
            const buttons = categoryIds.map(id => document.getElementById(id));
            const lastIndex = buttons.length - 1;

            if (currentCategoryIndex === lastIndex) {
                // Tab terakhir aktif: fill penuh sampai tepi kanan
                fill.style.width = '100%';
            } else {
                // Hitung lebar fill: dari kiri bar sampai ujung kanan tombol aktif
                const barRect = bar.getBoundingClientRect();
                const activeBtn = buttons[currentCategoryIndex];
                const activeBtnRect = activeBtn.getBoundingClientRect();
                const fillWidth = (activeBtnRect.right - barRect.left);
                fill.style.width = fillWidth + 'px';
            }

            // Update warna teks setiap tombol
            buttons.forEach((btn, index) => {
                btn.classList.remove('filled', 'unfilled', 'active');
                if (index <= currentCategoryIndex) {
                    btn.classList.add('filled');
                } else {
                    btn.classList.add('unfilled');
                }
                if (index === currentCategoryIndex) {
                    btn.classList.add('active');
                }
            });
        }

        function updateUI() {
            // Update Top Level Tab Styling
            const coreTab = document.getElementById('tab-core');
            const managerialTab = document.getElementById('tab-managerial');
            
            if (currentTopLevel === 'core') {
                coreTab.className = 'flex-1 text-center py-3 font-semibold text-white bg-teal-primary transition shadow-sm';
                coreTab.style.borderRadius = '9999px';
                managerialTab.className = 'flex-1 text-center py-3 font-semibold text-gray-600 hover:bg-gray-50 transition';
                managerialTab.style.borderRadius = '9999px';
            } else {
                coreTab.className = 'flex-1 text-center py-3 font-semibold text-gray-600 hover:bg-gray-50 transition';
                coreTab.style.borderRadius = '9999px';
                managerialTab.className = 'flex-1 text-center py-3 font-semibold text-white bg-teal-primary transition shadow-sm';
                managerialTab.style.borderRadius = '9999px';
            }

            // Update Categories Text
            const currentCatList = topTabs[currentTopLevel].categories;
            categoryIds.forEach((id, index) => {
                const btn = document.getElementById(id);
                btn.textContent = currentCatList[index].name;
            });

            // Update Text Title
            document.getElementById('level-title').textContent = 'Level ' + currentLevel;

            // Update Deskripsi dengan pertanyaan dari database
            const currentCat = currentCatList[currentCategoryIndex];
            const compData = competenciesData[currentCat.id];
            
            let questionText = "Belum ada pertanyaan untuk level ini.";
            if (compData && compData.questions) {
                const q = compData.questions.find(q => parseInt(q.level) === currentLevel);
                if (q && q.question_text) {
                    questionText = q.question_text;
                }
            }
            
            document.getElementById('level-desc').innerHTML = `<strong>Kategori: ${currentCat.name}</strong><br><br>${questionText}`;

            // Trigger animasi CSS supaya tidak kaku saat ganti soal
            const cardBlock = document.getElementById('card-block');
            cardBlock.style.animation = 'none';
            cardBlock.offsetHeight; // trigger reflow
            cardBlock.style.animation = 'slideUp 0.3s ease-out';

            // Update subcategory progress fill
            updateSubcategoryFill();

            // Update state tombol Level Sebelumnya
            updatePrevBtn();
        }

        // State variabel
        let pendingScore = null;
        let isEditMode = false;
        let editOriginalScore = null;

        function showConfirmPopup(score) {
            pendingScore = score;
            const catName = topTabs[currentTopLevel].categories[currentCategoryIndex].name;

            if (isEditMode) {
                // Mode Edit: tampilkan konfirmasi simpan edit
                const msg = `Apakah Anda yakin mengedit kompetensi<br><strong>${catName}</strong>?`;
                document.getElementById('confirm-message').innerHTML = msg;
                document.getElementById('confirm-btns-normal').style.display = 'none';
                document.getElementById('confirm-btns-edit').style.display = '';
            } else {
                // Mode Normal: konfirmasi sebelum pindah kompetensi
                const msg = ` Terima kasih sudah mengisi kompetensi <strong>${catName}</strong>.<br>Apakah Anda yakin dengan jawaban Anda?`;
                document.getElementById('confirm-message').innerHTML = msg;
                document.getElementById('confirm-btns-normal').style.display = '';
                document.getElementById('confirm-btns-edit').style.display = 'none';
            }
            document.getElementById('confirm-overlay').classList.add('open');
        }

        function confirmYes() {
            // Mode normal: tutup popup, simpan skor, lanjut kategori berikutnya
            document.getElementById('confirm-overlay').classList.remove('open');
            saveScore(pendingScore);
            pendingScore = null;
            nextCategory();
        }

        function confirmNo() {
            // Mode normal: tutup popup, ulangi dari Level 1
            document.getElementById('confirm-overlay').classList.remove('open');
            pendingScore = null;
            currentLevel = 1;
            updateUI();
        }

        function editSimpan() {
            // Mode edit: simpan skor baru, kembali ke result modal
            document.getElementById('confirm-overlay').classList.remove('open');
            saveScore(pendingScore);
            pendingScore = null;
            editOriginalScore = null;
            isEditMode = false;
            showResultModal();
        }

        function editBatal() {
            // Mode edit: batalkan → restore skor asli, kembali ke result modal
            document.getElementById('confirm-overlay').classList.remove('open');
            if (editOriginalScore !== null) {
                const currentCat = topTabs[currentTopLevel].categories[currentCategoryIndex];
                userScores[currentCat.id] = editOriginalScore;
            }
            pendingScore = null;
            editOriginalScore = null;
            isEditMode = false;
            showResultModal();
        }

        function handleSudahKompeten() {
            if (currentLevel < maxLevel) {
                // Masih ada level berikutnya → lanjut level
                currentLevel++;
                updateUI();
            } else {
                // Level 5 selesai → tampilkan konfirmasi dengan skor 5
                showConfirmPopup(5);
            }
        }

        function handleRaguRagu() {
            // Ragu-ragu → skor berhenti di level sebelumnya
            // Jika di Level 1 dan ragu → skor 0 (belum kompeten di level apapun)
            // Jika di Level 2+ dan ragu → skor level sebelumnya (currentLevel - 1)
            const scoreToSave = (currentLevel === 1) ? 0 : (currentLevel - 1);
            showConfirmPopup(scoreToSave);
        }

        function handleLevelSebelumnya() {
            if (currentLevel > 1) {
                // Masih ada level sebelumnya di kategori ini → mundur satu level
                currentLevel--;
                updateUI();
            } else if (currentCategoryIndex > 0) {
                // Sudah di Level 1, tapi masih ada kategori sebelumnya → kembali ke kategori sebelumnya
                currentCategoryIndex--;
                currentLevel = 1;
                updateUI();
            } else if (currentTopLevel === 'managerial') {
                // Sudah di Level 1 kategori pertama Managerial → kembali ke Core (kategori terakhir)
                currentTopLevel = 'core';
                currentCategoryIndex = topTabs.core.categories.length - 1;
                currentLevel = 1;
                updateUI();
            }
            // Jika sudah di posisi paling awal (Core, Integrity, Level 1) → tidak ada aksi
        }

        function updatePrevBtn() {
            const btn = document.getElementById('btn-prev-level');
            if (btn) {
                btn.disabled = (currentLevel === 1 && currentCategoryIndex === 0 && currentTopLevel === 'core');
            }
        }

        function saveScore(score) {
            const currentCat = topTabs[currentTopLevel].categories[currentCategoryIndex];
            userScores[currentCat.id] = score;
        }

        function nextCategory() {
            const currentCatList = topTabs[currentTopLevel].categories;
            if (currentCategoryIndex < currentCatList.length - 1) {
                // Lanjut ke sub-kategori selanjutnya di Top Level yang sama
                currentCategoryIndex++;
                currentLevel = 1; // Ulangi dari level 1
                updateUI();
            } else {
                // Habis (mencapai sub-kategori terakhir di Top Level ini)
                if (currentTopLevel === 'core') {
                    // Pindah ke Managerial Competencies
                    currentTopLevel = 'managerial';
                    currentCategoryIndex = 0;
                    currentLevel = 1;
                    updateUI();
                } else {
                    // Selesai Semua → tampilkan popup hasil
                    showResultModal();
                }
            }
        }

        function showResultModal() {
            // Bangun baris tabel untuk tiap kategori
            const scoreLabels = ['', 'Sangat Rendah', 'Rendah', 'Cukup', 'Baik', 'Sangat Baik'];

            function buildRows(tableId, categories, topLevelKey) {
                const tbody = document.getElementById(tableId);
                tbody.innerHTML = '';
                categories.forEach((cat, idx) => {
                    const score = userScores[cat.id] ?? '-';
                    const scoreNum = parseInt(score);
                    const stars = isNaN(scoreNum) ? '-' : '★'.repeat(scoreNum) + '☆'.repeat(5 - scoreNum);
                    const label = isNaN(scoreNum) ? 'Belum dinilai' : scoreLabels[scoreNum];
                    const badgeClass = isNaN(scoreNum) ? 'score-1' : `score-${scoreNum}`;

                    const tr = document.createElement('tr');
                    tr.style.background = idx % 2 === 0 ? '#fff' : '#fafafa';
                    tr.innerHTML = `
                        <td class="px-5 py-3.5 font-medium text-slate-700">${cat.name}</td>
                        <td class="py-3.5 text-center" style="width:120px">
                            <span class="score-badge ${badgeClass}">${isNaN(scoreNum) ? '?' : scoreNum}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right" style="width:90px">
                            <button class="edit-row-btn" onclick="editCategory('${topLevelKey}', ${idx})">
                                Edit
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            buildRows('result-table-core', topTabs.core.categories, 'core');
            buildRows('result-table-managerial', topTabs.managerial.categories, 'managerial');
            document.getElementById('result-total-filled').textContent = Object.keys(userScores).length;

            // Tampilkan modal
            document.getElementById('result-modal-overlay').classList.add('open');
        }

        function editCategory(topLevelKey, catIdx) {
            // Tutup result modal
            document.getElementById('result-modal-overlay').classList.remove('open');
            // Simpan skor asli sebelum diedit (untuk fitur Batal)
            const cat = topTabs[topLevelKey].categories[catIdx];
            editOriginalScore = userScores[cat.id] ?? null;
            // Aktifkan mode edit
            isEditMode = true;
            // Navigasi ke kategori yang dipilih
            currentTopLevel = topLevelKey;
            currentCategoryIndex = catIdx;
            currentLevel = 1;
            updateUI();
        }

        function showSubmitPopup() {
            // Tutup result modal dulu agar tidak overlap
            document.getElementById('result-modal-overlay').classList.remove('open');
            document.getElementById('submit-overlay').classList.add('open');
        }

        function doSubmitAssessment() {
            const container = document.getElementById('hidden-inputs-container');
            container.innerHTML = '';
            for (const [compId, score] of Object.entries(userScores)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `scores[${compId}]`;
                input.value = score;
                container.appendChild(input);
            }
            document.getElementById('assessment-form').submit();
        }

        // Inisialisasi fill saat halaman pertama kali load
        window.addEventListener('load', function() {
            updateUI();
        });
    </script>

    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>
