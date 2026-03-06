<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDP Monitoring – Individual Development Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        /* ── Title Animation ── */
        @keyframes titleReveal {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-title {
            animation: titleReveal 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        /* ── Smooth entrance ── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeSlideUp 0.5s ease both;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.12s;
        }

        /* ── Navbar outer wrapper ── */
        .navbar-outer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            width: 100%;
            display: flex;
            align-items: center;
            background: #2e3746;
            padding: 1rem 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-outer.nav-hidden {
            transform: translateY(-110%);
        }

        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 9px;
            height: 9px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid white;
        }

        .nav-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
            color: #2e3746;
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.15s;
            position: relative;
        }

        .nav-icon-btn:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
            transform: translateY(-1px);
        }

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

        /* Fix to match the design border radius and colors */
        .tab-btn {
            padding: 0.8rem 2.5rem;
            font-weight: 600;
            font-size: 1rem;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-active {
            background-color: #e5e7eb;
            /* Light grayish */
            color: #2e3746;
            /* Dark gray text */
        }

        .tab-inactive {
            background-color: #2e3746;
            /* Dark slate */
            color: white;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tab-inactive:hover {
            background-color: #2e3746;
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
            /* Gray 100 */
        }

        .form-bg {
            background-color: #ffffff;
            /* White Form Box */
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex flex-col pt-[80px]">

    {{-- ══════════════════════════════ NAVBAR ══════════════════════════════ --}}
    <div class="navbar-outer">
        <div class="flex items-center gap-4 flex-shrink-0">
            <div class="bg-white p-2 rounded-[10px] shadow-sm flex items-center justify-center w-14 h-14">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo TS" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white text-xl font-bold tracking-wide whitespace-nowrap">
                Individual Development Plan
            </h1>
        </div>

        <div class="flex items-center space-x-14 text-white text-sm font-medium ml-auto pr-6">
            <a href="{{ route('kandidat.dashboard') }}#Kompetensi"
                class="hover:text-blue-200 transition-colors duration-150">Kompetensi</a>
            <a href="{{ route('kandidat.dashboard') }}#IDP Monitoring"
                class="hover:text-blue-200 transition-colors duration-150">IDP</a>
            <a href="{{ route('kandidat.dashboard') }}#Project Improvement"
                class="hover:text-blue-200 transition-colors duration-150">Project Improvement</a>
            <a href="{{ route('kandidat.dashboard') }}#LogBook"
                class="hover:text-blue-200 transition-colors duration-150">LogBook</a>
        </div>

        <div class="flex items-center space-x-3 pl-4 border-l border-white/20">
            <a href="{{ route('kandidat.notifikasi') }}" class="nav-icon-btn" aria-label="Notifikasi">
                <span class="notif-badge"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                </svg>
            </a>
            <button class="nav-icon-btn" aria-label="Profil">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════ PROFILE CARD ══════════════════════════════ --}}
    <div class="bg-[#2e3746] shadow-md py-6 fade-up fade-up-1">
        <div class="flex items-stretch divide-x divide-white/20">

            <div class="flex items-center gap-5 px-10 flex-shrink-0 w-1/3 justify-center py-2">
                <div class="flex-shrink-0">
                    @if ($user->foto ?? false)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                            class="w-24 h-24 rounded-[10px] object-cover border-2 border-white/30">
                    @else
                        <div
                            class="w-24 h-24 rounded-[10px] bg-white/20 flex items-center justify-center border-2 border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/70" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-white font-bold text-base leading-tight">{{ $user->nama ?? $user->name }}</p>
                    <p class="text-white/60 text-xs mt-1">
                        {{ $user->role === 'kandidat' ? 'Talent' : ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="px-10 w-1/3 flex flex-col pt-3 space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Perusahaan</span>
                    <span class="text-white">{{ $user->perusahaan ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Departemen</span>
                    <span class="text-white">{{ $user->departemen ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Jabatan yang Dituju</span>
                    <span class="text-white">{{ $user->jabatan_target ?? '-' }}</span>
                </div>
            </div>

            <div class="px-10 w-1/3 flex flex-col pt-3 space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-20 flex-shrink-0">Mentor</span>
                    <span class="text-white">{{ $user->mentor->nama ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-20 flex-shrink-0">Atasan</span>
                    <span class="text-white">{{ $user->atasan->nama ?? '-' }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════ FORM AREA ══════════════════════════════ --}}
    <div class="w-full max-w-5xl mx-auto px-6 pt-10 pb-12 flex-grow fade-up fade-up-2">

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
        <div class="wrapper-bg rounded-[16px] shadow-sm p-6 border border-gray-200">

            {{-- Tabs --}}
            <div class="flex space-x-0 relative z-10 w-full pl-2">
                <div class="tab-btn tab-active pb-[1.1rem]">Exposure</div>
                <div class="tab-btn tab-inactive pb-[1.1rem]">Mentoring</div>
                <div class="tab-btn tab-inactive pb-[1.1rem]">Learning</div>
            </div>

            {{-- White Form Content --}}
            <div class="form-bg p-8 relative z-20 -mt-2 shadow-sm">
                <form action="#" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                        <label class="text-sm font-semibold text-gray-800">Mentor</label>
                        <input type="text" class="form-input" placeholder="">
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                        <label class="text-sm font-semibold text-gray-800">Tema</label>
                        <input type="text" class="form-input" placeholder="">
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                        <label class="text-sm font-semibold text-gray-800">Tanggal</label>
                        <input type="text" class="form-input" placeholder="">
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6">
                        <label class="text-sm font-semibold text-gray-800">Lokasi</label>
                        <input type="text" class="form-input" placeholder="">
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-1">
                        <label class="text-sm font-semibold text-gray-800 pt-3">Aktivitas</label>
                        <textarea class="form-textarea h-24" placeholder=""></textarea>
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-start gap-6 pt-1">
                        <label class="text-sm font-semibold text-gray-800 pt-3">Deskripsi</label>
                        <textarea class="form-textarea h-24" placeholder=""></textarea>
                    </div>

                    <div class="grid grid-cols-[140px_1fr] items-center gap-6 pt-2">
                        <label class="text-sm font-semibold text-gray-800">Dokumentasi</label>
                        <div>
                            <label class="upload-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Upload
                                <input type="file" class="hidden">
                            </label>
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

    {{-- FOOTER --}}
    <footer class="mt-auto bg-[#2e3746] py-5 text-center w-full">
        <span class="text-white text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} PT. Tiga Serangkai Inti Corpora
        </span>
    </footer>

    <script>
        (function() {
            const navbar = document.querySelector('.navbar-outer');
            let lastScrollY = window.scrollY;
            let ticking = false;

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        const currentScrollY = window.scrollY;
                        if (currentScrollY > lastScrollY && currentScrollY > 80) {
                            navbar.classList.add('nav-hidden');
                        } else {
                            navbar.classList.remove('nav-hidden');
                        }
                        lastScrollY = currentScrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        })();
    </script>
</body>

</html>
