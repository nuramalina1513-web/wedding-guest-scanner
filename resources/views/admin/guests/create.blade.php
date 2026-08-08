<!Doctype html>
<html lang ="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> Tambah Tamu</title>

        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: #f8ead9;
                font-family: Arial, sans-serif;
                color: #4d2027;

                display: flex;
                justify-align: center;
                align-items: center;

                padding: 30px 16px;
            }

            .guest.card {
                width: 100%;
                max-width: 520px;

                background: #fffaf3;
                border: 1px solid #e2bb7c;
                border-radius: 24px;

                padding: 32px;

                box-shadow: 0 12px 35px rgba(92, 37, 45, 0.12);
            }

            .header {
                text-align: center;
                margin-bottom: 30px;
            }

            .header h1 {
                margin: 0 0 8px;
                font-family: Georgia, serif;
                color: #821f35;
                font-size: 30px;
            }

            .header p {
                margin: 0;
                color: #8a6468;
                font-size: 14px;
                line-height: 1.5;
            }

            .field {
                margin-bottom: 20px;
            }

            .field label {
                dipslay: block;
                margin-bottom: 8px;

                font-weight: bold;
                font-size: 14px;
            }

            .field input,
            .field select {
                width: 100%;
                padding 13px 14px;

                border: 1px solid #dbb98c;
                border-radius: 12px;

                background: white;
                color: #4d2027;

                font-size: 15px;
                outline: none;
            }

            .field input:focus,
            .field select:focus {
                border-color: #821f35;
                box-shadow: 0 0 0 3px rgba(130, 31, 53, 0.08);
            }

            .hint {
                margin-top: 7px;
                color: #98767a;
                font-size: 12px;
            }

            .submit-button {
                width: 100%;
                border: none;
                border-radius: 12px;

                padding: 14px;

                background: #821f35;
                color: white;

                font-size: 15px;
                font-weight: bold;

                cursor: pointer;
            }

            .submit-button:hover {
                background: #681829;
            }

            .back-button {
                display: block;
                width: 100%;

                margin-top: 12px;
                padding: 12px;

                text-align: center;
                text-content: none;

                border: 1px solid #821f35;
                border-radius: 12px;

                color: #821f35;
                background: transparent;

                font-size: 14px;
            }

            .back-button:hover {
                background: #f7e5e8;
            }

            body {
                display: flex;
                justify-content: center;
                align-item: center;
            }

            .guest-card {
                width: 100%;
                max-width: 520px;
                margin: 0 auto;
            }

            .success-message {
                margin: 15 0 20px;
                padding: 14px 16px;
                background: #edf8ef;
                boder: 1px solid #9cccaa;
                boder-radius: 12px;
                color: #246437;
                text-align: center;
                font-size: 14px;
                font-weight: bold;

            }

            .qr-result {
                margin: 20px;
                padding:22px;

                background: #fffaf3;
                border: 1px solid #e2bb7c;
                border-radius: 18px;

                text-align: center;
            }

            .qr-result h3 {
                margin: 0 0 16px;
                color: #821f35;
                font-family: Georgia, serif;
            }

            .qr-box {
                display: flex;
                justify-content: center;
                margin-buttom: 10px;
            }

            .guest-code {
                margin-buttom: 12px;

                color: #821f35;
                font-weight: bold;
                font-size: 14px;
            }

            .guest-link-input {
                width: 100%;
                padding: 11px 12px;

                border: 1px solid #dbb98c;
                border-radius: 10px;

                text-align: center;
                font-size: 12px;
            }

            .qr-actions {
                display: flex;
                gap: 10px;
                margin-top: 12px;
            }

            .copy-button,
            .download-button,
            .open-button {
                flex: 1;
                padding: 11px;

                border-radius: 10px;
                font-size: 13px;
                cursor: pointer;
            }

            .copy-button {
                border: none;
                background: #821f35;
                color: white;
            }

            .open-button {
                border: 1px solid #821f35;
                color: #821f35;
                text-decoration: none;
            }

            .download-button {
                border: 1px solid #821f35;
                background: white;
                color: #821f35;
            }

            </style>
    </head>

    <body>

    <div class="guest-card">
        <div class="header"> 
    <h1>Tambah Tamu</h1>

    <p>
        Masukkan data tamu undangan <br>
        kode QR akan dibuat otomatis oleh sistem
    </p>

    @if (session('success'))
    <div class="success-message">
        {{ session ('success') }}
</div>
@endif

@if (session('guest_code'))
<div class="qr-result">
    <h3>QR Tamu </h3>

    {!! QrCode::size(180)->generate(
        route('guest.show', session('guest_code'))
    ) !!}

    <div class ="guest-code">
        {{ session('guest_code') }}
    </div>

        <input
        type="text"
        id="guest-link"
        class="guest-link-input"
        value="{{ route('guest.show', session('guest_code')) }}"
        readonly
        >

        <div class="qr-actions">
            <button
                type="button"
                class="copy-button"
                onclick="copyGuestLink(this)"
                >
                Salin Link
            </button>

            <button
                type="button"
                class="download-button"
                onclick="downloadGuestQr()"
            >
            Download Qr
            </button>

    <a href="{{route ('guest.show', session('guest_code')) }}"
    target="_blank"
    class="open-button"
    >
    Buka Undangan Tamu
</a>
</div>
</div>
@endif

    <form action="{{ route('admin.guests.store') }}" method="POST">
        @csrf

        <div class="field">
            <label for="name">Nama Tamu</label>
            <input 
            type="text"
            id="name"
            name="name"
            placeholder="contoh: Nur Amalina"
            required
            >
        </div>

        <div class="field">
            <label for="guest_type">Tipe Tamu</label>
            <select 
            id="guest_type" 
            name="guest_type" 
            required
            >
                <option value="">--Pilih tipe tamu --</option>
                <option value="reguler">Reguler</option>
                <option value="vip">VIP</option>
            </select>
        </div>

        <div class="field">
            <label for="invitation_limit">Batas Undangan</label>
            <input 
            type="number"
            id="invitation_limit"
            name="invitation_limit"
            min="1"
            value="1"
            required
            >
        </div>

        <div class="hint">
            Jumlah maksimal orang yang boleh hadir dengan undangan ini.
        </div>
</div>
        
        <button 
        type="submit"
        class="submit-button"
        >
            + Tambah Tamu
        </button>

        <a 
        href="{{ route('admin.scan') }}"
        class="back-button"
        >
        <- kembali ke scanner
</a>
</form>
</div>

<script>
    function copyGuestLink(button) {
        const guestLink = document.getElementById('guest-link');

        navigator.clipboard.writeText(guestLink.value);

        button.textContent= '✓ Tersalin';

        setTimeOut(function () {
            button.textContent ='salin link';
        }, 2000);
    }

    function downloadGuestQr (){
        const qrSvg = document.querySelector('.qr-result svg');
        const guestCode = document.querySelector('.guest-code').textContent.trim();

        const svgData = new XMLSerializer().serializeToString(qrSvg);
        const blob = new Blob([svgData],{ type: '/image/svg+xml' });

        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.download = guestCode + '-Qr.svg';

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);
    }
</script>

    </body>
    </html>