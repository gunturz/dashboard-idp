<x-guest-layout>
    <div
        style="padding: 2.5rem; max-width: 420px; margin: 4rem auto; background: #fff; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);">

        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #111827; text-align: center;">
            Cek Email Anda
        </h2>

        <div style="margin-bottom: 1.5rem; font-size: 0.875rem; color: #4B5563; text-align: center; line-height: 1.5;">
            Demi keamanan, sistem telah mengirimkan kode sandi <b>6 angka acak</b> baru ke kotak masuk Email Anda:
            <br />
            <strong style="color:#111827;">{{ auth()->user()->email }}</strong>
        </div>

        @if(session('status'))
            <div
                style="margin-bottom: 1.5rem; padding: 0.75rem; border-radius: 6px; background-color: #D1FAE5; color: #065F46; font-size: 0.875rem; font-weight: 500; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div
                style="margin-bottom: 1.5rem; padding: 0.75rem; border-radius: 6px; background-color: #FEE2E2; color: #B91C1C; font-size: 0.875rem; font-weight: 500; text-align: center;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label for="one_time_password"
                    style="display: block; font-weight: 600; font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem;">Kode
                    OTP Email</label>
                <input id="one_time_password" type="text" name="one_time_password" required autofocus autocomplete="off"
                    placeholder="Contoh: 123456"
                    style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem; outline: none; transition: border-color 0.15s ease-in-out;"
                    onfocus="this.style.borderColor='#3B82F6';" onblur="this.style.borderColor='#D1D5DB';">
            </div>

            <div style="margin-bottom: 1.5rem; text-align: right; font-size: 0.875rem;">
                @php
                    $lastResend = session('last_resend_time', 0);
                    // Hitung durasi tersisa (dari 60 detik)
                    $timeLeft = max(0, 60 - (time() - $lastResend));
                @endphp

                <span id="resend-timer-text"
                    style="color: #6B7280; font-weight: 500; display: {{ $timeLeft > 0 ? 'inline' : 'none' }};">
                    Tunggu <span id="resend-countdown">{{ $timeLeft }}</span> detik untuk kirim ulang
                </span>

                <a href="{{ route('2fa.resend') }}" id="resend-link"
                    style="color: #2563EB; text-decoration: none; font-weight: 500; display: {{ $timeLeft > 0 ? 'none' : 'inline' }};"
                    onclick="this.style.pointerEvents='none'; this.style.color='#9CA3AF'; this.innerText='Memproses...';">Tidak
                    terima email? Kirim ulang</a>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let timeLeft = {{ $timeLeft }};
                    if (timeLeft > 0) {
                        const countdownEl = document.getElementById('resend-countdown');
                        const textEl = document.getElementById('resend-timer-text');
                        const linkEl = document.getElementById('resend-link');

                        const timer = setInterval(() => {
                            timeLeft--;
                            if (timeLeft <= 0) {
                                clearInterval(timer);
                                // Sembunyikan timer, tampilkan tombol kembali.
                                textEl.style.display = 'none';
                                linkEl.style.display = 'inline';
                                linkEl.style.pointerEvents = 'auto';
                                linkEl.style.color = '#2563EB';
                                linkEl.innerText = 'Tidak terima email? Kirim ulang';
                            } else {
                                countdownEl.innerText = timeLeft;
                            }
                        }, 1000);
                    }
                });
            </script>

            <button type="submit"
                style="width: 100%; display: flex; justify-content: center; align-items: center; padding: 0.75rem; background-color: #2563EB; color: #ffffff; font-weight: 600; font-size: 1rem; border: none; border-radius: 8px; cursor: pointer; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                onmouseover="this.style.backgroundColor='#1D4ED8'" onmouseout="this.style.backgroundColor='#2563EB'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                Masuk Dashboard
            </button>
        </form>
    </div>
</x-guest-layout>