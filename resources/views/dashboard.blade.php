<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>






     <!-- PROFILE SECTION (dari registrasi awal) -->
    <div class="profile-card">
        <h3>{{ $user->nama }}</h3>
        <p>Perusahaan: {{ $user->perusahaan }}</p>
        <p>Departemen: {{ $user->departemen }}</p>
        <p>Role Target: {{ $user->jabatan_target }}</p>
        <p>Mentor: {{ $user->mentor_id ? $user->mentor->nama : '-' }}</p>
        <p>Atasan: {{ $user->atasan_id ? $user->atasan->nama : '-' }}</p>
    </div>

    <!-- Kompetensi CHART SECTION (dari kompetensi yang diisi) -->
    <div class="kompetensi-card">
        @if ($kompetensi)
            <!-- Gunakan library Chart.js / ApexCharts / Recharts -->
            <canvas id="competencyChart"></canvas>
            
            <script>
                const data = {
                    integrity: {{ $kompetensi->integrity }},
                    communication: {{ $kompetensi->communication }},
                    leadership: {{ $kompetensi->leadership }},
                    // ... semua kompetensi lainnya
                };
                // Render chart dengan data
            </script>
        @else
            <p>Belum ada data kompetensi</p>
        @endif
    </div>
</x-app-layout>
