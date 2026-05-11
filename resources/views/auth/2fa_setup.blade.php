<x-guest-layout>
    <div
        style="padding: 2.5rem; max-width: 450px; margin: 4rem auto; background: #fff; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);">

        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: #111827; text-align: center;">
            Setup Google Authenticator
        </h2>

        <div style="margin-bottom: 1.5rem; font-size: 0.875rem; color: #4B5563; text-align: center; line-height: 1.5;">
            Karena role Anda berisiko tinggi, Anda diwajibkan untuk menghubungkan akun ini dengan <b>Aplikasi
                Authenticator</b> (Misal: Google Authenticator atau Authy) di ponsel Anda.
        </div>

        <div
            style="display: flex; justify-content: center; margin-bottom: 1.5rem; padding: 1rem; background: #f3f4f6; border-radius: 8px;">
            <!-- Menggunakan API publik QRServer untuk render URL jadi gambar barcode agar mudah disalin -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}"
                alt="QR Code 2FA">
        </div>

        <div style="margin-bottom: 1.5rem; text-align: center; font-size: 0.875rem; color: #6B7280;">
            Atau masukkan kunci manual berikut:<br>
            <strong style="letter-spacing: 2px; color: #374151; font-size: 1.1rem;">{{ $secret }}</strong>
        </div>

        <div style="margin-top: 1.5rem;">
            <a href="{{ route('2fa.index') }}"
                style="width: 100%; display: flex; justify-content: center; align-items: center; padding: 0.75rem; background-color: #2563EB; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 1rem; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.15s ease-in-out; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                onmouseover="this.style.backgroundColor='#1D4ED8'" onmouseout="this.style.backgroundColor='#2563EB'">
                Saya Telah Men-scan QR
            </a>
        </div>
    </div>
</x-guest-layout>