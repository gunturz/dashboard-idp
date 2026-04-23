<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">Pilih Akses Menu</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Akun Anda memiliki lebih dari satu Role. Silakan pilih akses mana yang ingin digunakan saat ini.</p>
    </div>

    <!-- Session Status -->
    @if ($errors->any())
        <div style="background-color: #fee2e2; border-left: 4px solid #ef4444; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            <p style="color: #b91c1c; font-size: 0.875rem; margin: 0;">{{ $errors->first() }}</p>
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 1rem;">
        @foreach($roles as $role)
            <form method="POST" action="{{ route('role.set') }}" style="width: 100%;">
                @csrf
                <input type="hidden" name="role_name" value="{{ $role->role_name }}">
                <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background-color: white; border: 1px solid #e2e8f0; border-radius: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); color: #0f172a; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.2s; text-transform: capitalize;" onmouseover="this.style.borderColor='#14b8a6'; this.style.backgroundColor='#f0fdfa';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.backgroundColor='white';">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Masuk sebagai {{ $role->role_name }}
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </form>
        @endforeach
    </div>
    
    <div style="margin-top: 2rem; text-align: center;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 0.875rem; font-weight: 500; cursor: pointer; text-decoration: underline;">
                Batalkan dan Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
