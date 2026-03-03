<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandidat Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- <div class="py-12"> -->
        <div class="w-full (width: 100%)">


        <!-- =====  NAVBAR DI SINI ===== -->
        <!-- Breadcrumb Text Datar -->
        <!-- Container Navbar -->
        <div class="bg-[#4a5a6a] rounded-b-2xl shadow-md px-6 py-4 flex items-center justify-between mb-8">
            
            <!-- Kolom Kiri: Judul -->
            <div class="flex-1">
                <h1 class="text-white text-2xl font-bold tracking-wide">Individual Development Plan</h1>
            </div>

            <!-- Kolom Tengah: Menu Navigasi -->
            <div class="flex justify-center space-x-10 text-white text-[15px] font-medium">
                <a href="#" class="hover:text-gray-300 transition-colors">Kompetensi</a>
                <a href="#" class="hover:text-gray-300 transition-colors">IDP</a>
                <a href="#" class="hover:text-gray-300 transition-colors">LogBook</a>
            </div>

            <!-- Kolom Kanan: Ikon -->
            <div class="flex-1 flex justify-end items-center space-x-4">
                <!-- Ikon Notifikasi -->
                <button type="button" class="bg-white text-gray-800 p-2 rounded-full shadow hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                </button>
                
                <!-- Ikon Profil -->
                <button type="button" class="bg-white text-gray-800 p-2 rounded-full shadow hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- ===== AKHIR KODE NAVBAR ===== -->











        <!-- PROFILE SECTION -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <!-- PROFILE SECTION -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-start gap-6">
                        <!-- Profile Avatar Placeholder -->
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-32 w-32 rounded-lg bg-gray-200">
                                <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-grow">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $user->nama }}</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Perusahaan</p>
                                    <p class="text-gray-900">{{ $user->perusahaan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Departemen</p>
                                    <p class="text-gray-900">{{ $user->departemen }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Jabatan Target</p>
                                    <p class="text-gray-900">{{ $user->jabatan_target ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Role</p>
                                    <p class="text-gray-900">{{ ucfirst($user->role) }}</p>
                                </div>
                                @if($user->mentor_id)
                                    <div>
                                        <p class="text-sm font-semibold text-gray-600">Mentor</p>
                                        <p class="text-gray-900">{{ $user->mentor->nama ?? '-' }}</p>
                                    </div>
                                @endif
                                @if($user->atasan_id)
                                    <div>
                                        <p class="text-sm font-semibold text-gray-600">Atasan</p>
                                        <p class="text-gray-900">{{ $user->atasan->nama ?? '-' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOMPETENSI SECTION -->
            @if ($kompetensi)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Kompetensi Anda</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-11/12 xl:w-4/5 mx-auto">
                            <!-- Kompetensi List -->
                            <div>
                                <div class="space-y-3">
                                    <div class="space-y-4 inline-block transform w-full px-6">
                                        <!-- Integrity -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Integrity</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->integrity / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->integrity / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Communication -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Communication</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->communication / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->communication / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Innovation & Creativity -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Innovation & Creativity</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->innovation_creativity / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->innovation_creativity / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Customer Orientation -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Customer Orientation</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->customer_orientation / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->customer_orientation / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Teamwork -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Teamwork</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->teamwork / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->teamwork / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Leadership -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Leadership</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->leadership / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->leadership / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Business Acumen -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Business Acumen</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->business_acumen / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->business_acumen / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Problem Solving -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Problem Solving & Decision Making</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->problem_solving / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->problem_solving / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Achievement Orientation -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Achievement Orientation</span>
                                            <div class="flex h-5 w-full">
                                                <div class="rounded-l bg-[#4c5c74]" style="width: {{ ($kompetensi->achievement_orientation / 5) * 100 }}%"></div>
                                                <div class="rounded-r bg-[#a49c8c]" style="width: {{ 100 - (($kompetensi->achievement_orientation / 5) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Strategic Thinking -->
                                        <div class="grid grid-cols-2 items-center w-full">
                                            <span class="text-[13px] text-gray-800 pr-4">Strategic Thinking</span>
                                            <div class="flex h-5 w-full">
                                                <!-- Strategic thinking dibatasi mentok width nya di contoh gambar-->
                                                <div class="rounded bg-[#4c5c74]" style="width: {{ ($kompetensi->strategic_thinking / 5) * 100 }}%"></div>
                                                <div class="bg-transparent" style="width: {{ 100 - (($kompetensi->strategic_thinking / 5) * 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kompetensi Summary -->
                            <div>
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-4">Ringkasan Kompetensi</h4>
                                    <?php
                                        $values = [
                                            $kompetensi->integrity,
                                            $kompetensi->communication,
                                            $kompetensi->innovation_creativity,
                                            $kompetensi->customer_orientation,
                                            $kompetensi->teamwork,
                                            $kompetensi->leadership,
                                            $kompetensi->business_acumen,
                                            $kompetensi->problem_solving,
                                            $kompetensi->achievement_orientation,
                                            $kompetensi->strategic_thinking,
                                        ];
                                        $average = array_sum($values) / count($values);
                                        $maxValue = max($values);
                                        $minValue = min($values);
                                    ?>

                                    <div class="space-y-4">
                                        <div class="border-b pb-3">
                                            <p class="text-sm text-gray-600">Rata-rata Kompetensi</p>
                                            <p class="text-3xl font-bold text-blue-600">{{ round($average, 2) }}/5</p>
                                        </div>
                                        <div class="border-b pb-3">
                                            <p class="text-sm text-gray-600">Kompetensi Tertinggi</p>
                                            <p class="text-2xl font-bold text-green-600">{{ $maxValue }}/5</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Kompetensi Terendah</p>
                                            <p class="text-2xl font-bold text-orange-600">{{ $minValue }}/5</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="text-gray-500">Belum ada data kompetensi. Silakan hubungi admin.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- TOMBOL KELUAR (FIXED POJOK KIRI BAWAH) -->
    <div class="fixed bottom-6 left-6 z-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full shadow-lg transition-all transform hover:scale-105 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</body>
</html>
