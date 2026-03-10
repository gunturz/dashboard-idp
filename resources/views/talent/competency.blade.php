<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competency – Individual Development Plan</title>
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
    </style>
</head>

<body class="bg-dark-slate text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="px-6 py-3 border-b border-gray-100 flex items-center">
            <!-- Left Logo & Title -->
            <div class="flex items-center space-x-4">
                <img src="{{ asset('asset/Gambar%20TS.png') }}" alt="Tiga Serangkai Logo" class="h-10 object-contain">
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Individual Development Plan</h1>
                
                <div class="h-8 w-px bg-gray-300 mx-2"></div>
                
                <h2 class="text-xl text-gray-500 font-medium">Competency</h2>
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
        <div class="w-full bg-white rounded-full flex shadow-md overflow-hidden p-1 max-w-6xl mb-6">
            <button id="tab-core" class="flex-1 text-center py-3 font-semibold text-white bg-teal-primary rounded-full transition shadow-sm">
                Core Competencies
            </button>
            <button id="tab-managerial" class="flex-1 text-center py-3 font-semibold text-gray-600 hover:bg-gray-50 rounded-full transition">
                Managerial Competencies
            </button>
        </div>

        <!-- Sub Categories -->
        <div class="w-full bg-white rounded-full shadow-md px-2 py-2 flex justify-between items-center max-w-6xl mb-8">
            <button id="cat-0" class="px-6 py-2 text-sm font-semibold text-white bg-teal-primary rounded-full shadow-sm transition text-center">
                Integrity
            </button>
            <button id="cat-1" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-teal-primary hover:bg-teal-50 rounded-full transition text-center">
                Communication
            </button>
            <button id="cat-2" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-teal-primary hover:bg-teal-50 rounded-full transition text-center">
                Innovation &amp; Creativity
            </button>
            <button id="cat-3" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-teal-primary hover:bg-teal-50 rounded-full transition text-center">
                Customer Orientation
            </button>
            <button id="cat-4" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-teal-primary hover:bg-teal-50 rounded-full transition text-center">
                Teamwork
            </button>
        </div>

        <!-- Main Card Block -->
        <form id="assessment-form" method="POST" action="{{ route('talent.competency.store') }}">
            @csrf
            <!-- Hidden inputs akan ditambahkan via JS -->
            <div id="hidden-inputs-container"></div>
            
            <div id="card-block" class="w-full max-w-6xl bg-white rounded-2xl shadow-xl p-10 flex flex-col animate-[slideUp_0.5s_ease-out]">
                <h3 id="level-title" class="text-2xl font-bold text-slate-800 mb-6 tracking-tight">Level 1</h3>
            
            <p id="level-desc" class="text-gray-600 leading-relaxed mb-12 text-[15px] font-medium text-justify">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ornare ante sapien, vitae volutpat felis pellentesque a. In mi tellus, feugiat ut tempor eget, convallis mollis orci. Curabitur laoreet ac purus ac lacinia. Nulla ut aliquam odio, at dapibus felis. Nunc ac efficitur nisi. Integer sit amet vehicula augue. Mauris congue mauris id quam facilisis porta. Vestibulum eros urna, aliquet ac viverra quis, blandit at tellus. Maecenas non nunc a velit posuere hendrerit sit amet et metus. Vivamus sit amet turpis pulvinar, vehicula leo sit amet, pulvinar turpis. Nulla tristique neque quis metus dapibus commodo.
            </p>

                <div class="flex items-center justify-between mt-auto">
                    {{-- Action Left --}}
                    <button type="button" onclick="handleRaguRagu()" class="px-8 py-2.5 bg-[#f59e0b] hover:bg-[#d97706] text-white font-semibold rounded-lg shadow-sm transition transform hover:-translate-y-0.5">
                        Ragu - ragu
                    </button>
                    
                    {{-- Action Right --}}
                    <button type="button" onclick="handleSudahKompeten()" class="px-8 py-2.5 bg-[#16a34a] hover:bg-[#15803d] text-white font-semibold rounded-lg shadow-sm transition transform hover:-translate-y-0.5">
                        Sudah Kompeten
                    </button>
                </div>
            </div>
        </form>

    </main>

    <script>
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

        // Kelas utility untuk tab
        const activeTabClass = "px-6 py-2 text-sm font-semibold text-white bg-teal-primary rounded-full shadow-sm transition text-center";
        const inactiveTabClass = "px-4 py-2 text-sm font-medium text-gray-600 hover:text-teal-primary hover:bg-teal-50 rounded-full transition text-center";

        const activeTopTabClass = "flex-1 text-center py-3 font-semibold text-white bg-teal-primary rounded-full transition shadow-sm";
        const inactiveTopTabClass = "flex-1 text-center py-3 font-semibold text-gray-600 hover:bg-gray-50 rounded-full transition";

        function updateUI() {
            // Update Top Level Tab Styling
            const coreTab = document.getElementById('tab-core');
            const managerialTab = document.getElementById('tab-managerial');
            
            if (currentTopLevel === 'core') {
                coreTab.className = activeTopTabClass;
                managerialTab.className = inactiveTopTabClass;
            } else {
                coreTab.className = inactiveTopTabClass;
                managerialTab.className = activeTopTabClass;
            }

            // Update Categories Text & Styling
            const currentCatList = topTabs[currentTopLevel].categories;
            categoryIds.forEach((id, index) => {
                const btn = document.getElementById(id);
                btn.textContent = currentCatList[index].name;
                if (index === currentCategoryIndex) {
                    btn.className = activeTabClass;
                } else {
                    btn.className = inactiveTabClass;
                }
            });

            // Update Text Title
            document.getElementById('level-title').textContent = 'Level ' + currentLevel;

            // Update Deskripsi (opsional sementara, untuk membuktikan pergantian level & kategori)
            const soalDummy = [
                "Pertanyaan level 1: Bagaimana Anda berhadapan dengan situasi kerja saat ini...",
                "Pertanyaan level 2: Jika Anda dipercayakan tugas yang lebih berat...",
                "Pertanyaan level 3: Mengelola konflik dalam tim di skala menengah...",
                "Pertanyaan level 4: Menentukan arah dan visi taktis pada lingkup departemen...",
                "Pertanyaan level 5: Merumuskan strategi besar yang berimbas pada kebijakan korporat..."
            ];
            const currentCatName = currentCatList[currentCategoryIndex].name;
            document.getElementById('level-desc').innerHTML = `<strong>Kategori: ${currentCatName}</strong><br><br>${soalDummy[currentLevel - 1]}<br><br><em>(Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ornare ante sapien, vitae volutpat felis pellentesque a. In mi tellus, feugiat ut tempor eget, convallis mollis orci.)</em>`;

            // Trigger animasi CSS supaya tidak kaku saat ganti soal
            const cardBlock = document.getElementById('card-block');
            cardBlock.style.animation = 'none';
            cardBlock.offsetHeight; // trigger reflow
            cardBlock.style.animation = 'slideUp 0.3s ease-out';
        }

        function handleSudahKompeten() {
            if (currentLevel < maxLevel) {
                // Lanjut ke level berikutnya di kompetensi yang sama
                currentLevel++;
                updateUI();
            } else {
                // Kalau sudah Level 5 dan Kompeten
                // Score penuh 5
                saveScore(5);
                nextCategory();
            }
        }

        function handleRaguRagu() {
            // Ragu-ragu = score berhenti di (currentLevel - 1)
            // Misalnya jika masih level 1 terpotong ragu-ragu = skor 1
            const scoreToSave = (currentLevel === 1) ? 1 : (currentLevel - 1);
            saveScore(scoreToSave);
            nextCategory();
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
                    // Selesai Semua (Managerial -> Strategic Thinking terpenuhi)
                    submitAssessment();
                }
            }
        }

        function submitAssessment() {
            const container = document.getElementById('hidden-inputs-container');
            container.innerHTML = ''; // bersihkan form
            
            // Loop data object menjadi hidden inputs
            for (const [compId, score] of Object.entries(userScores)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `scores[${compId}]`;
                input.value = score;
                container.appendChild(input);
            }

            // Submit formulir
            document.getElementById('assessment-form').submit();
        }
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
