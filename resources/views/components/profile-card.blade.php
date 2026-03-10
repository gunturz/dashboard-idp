<!-- Tombol trigger (ikon user di navbar) -->
<div class="relative" x-data="{ open: false }">
    <!-- Tombol ikon user -->
    <button @click="open = !open"
        class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-600 hover:bg-gray-500 focus:outline-none transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A8.966 8.966 0 0112 15c2.21 0 4.232.798 5.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </button>

    <!-- Popup Card (gambar 2) -->
    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-4 z-50">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Foto + Nama + Link -->
            <div class="flex items-center gap-4 p-4">

                <!-- Foto -->
                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-200">
                    @if (auth()->user()->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Nama + Lihat Profil -->
                <div>
                    <p class="text-xs text-gray-400 font-medium">Selamat Datang!</p>
                    <p class="text-base font-bold text-gray-700 leading-tight">
                        {{ auth()->user()->nama }}
                    </p>
                    <a href="{{ route('profile.edit') }}"
                        class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-800 mt-1 transition">
                        Lihat Profil
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

            </div>

        </div>
