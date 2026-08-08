<!Doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Wedding Scanner</title>

        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                padding: 28px 18px;
                font-family: Arial, sans-serif;
                background:
                radial-gradient(circle at top,  #fff8ec 0%, #f2dfc9 100%);
                color: #4a1822
            }

            .container {
                width: 100%;
                max-width: 620px;
                margin: 0 auto;
            }

            .header {
                margin-bottom: 24px;
                text-align: center;
            }

            .small-title {
                margin: 0 0 8px;
                color: #a77d35;
                font-family: Georgia, serif;
                font-size: 13px;
                letter-spacing: 4px;
                text-transform: uppercase;
            }

            h1 {
                margin: 0;
                color: #741f32;
                font-family: Georgia, serif;
                font-size: 34px;
                font-weight: normal;
            }

            .subtitle {
                margin: 10px 0 0;
                color: #76535b;
                font-size: 14px;
                line-height: 1.6;
            }

            .card {
                margin-bottom: 20px;
                padding: 24px;
                background: rgba(255, 253, 247, 0.97);
                border: 1px solid #d5b575;
                border-radius: 24px;
                box-shadow: 0 16px 40px rgba(81, 20, 35, 0.13);
            }

            .card-title {
                margin: 0 0 18px;
                color: #741f32;
                font-family: Georgia, serif;
                font-size: 21px;
            }

            #reader {
                overflow: hidden;
                width: 100%;
                background: #ffffff;
                border-radius: 16px;
            }

            #reader video {
                border-radius: 12px;
            }

            .divider {
                display: flex;
                align-items: center;
                gap: 12px;
                margin: 22px 0;
                color: #a98b7d;
                font-size: 12px;
                text-transform: uppercase;
            }

            .divider::before,
            .divider::after {
                content: "";
                flex: 1;
                height: 1px;
                background: #e0ccb0;
            }

            .manual-form {
                display: flex;
                gap: 10px;
            }

            input, 
            select {
                width: 100%;
                padding: 13px 14px;
                color: #4a1822;
                background: #ffffff;
                border: 1px solid #d7bea0;
                border-radius: 12px;
                outline: none;
            }

            input:focus,
            select:focus {
                padding: 13px 18px;
                color: #ffffff;
                font-size: 14px;
                font-weight: bold;
                background: #741f32;
                border: 0;
                border-radius: 12px;
                cursor: pointer;
            }

            button:hover {
                background: #5d1727;
            }

            button:disabled {
                cursor: not-allowed;
                opacity: 0.6;
            }

            .secondary-button {
                color: #741f32;
                background: #f5e6d4;
            }

            .secondary-button:hover {
                background: #ead4ba;
            }

            .status {
                display: none;
                margin-bottom: 20px;
                padding: 15px 17px;
                font-size: 14px;
                line-height: 1.6;
                border-radius: 14px;
            }

            .status.loading {
                display: block;
                color: #6c531f;
                background: #fff5d9;
                border: 1px solid #e9ccd7;
            }

            .status.error {
                display: block;
                color: #87283c;
                background: #fff0f2;
                border: 1px solid #dda3ad;
            }

            .status.success {
                display: block;
                color: #27631a;
                background: #edf9f0;
                border: 1px solid #9fd0aa;
            }

            #result-card {
                display: none;
            }

            .guest-name {
                margin: 0 0 18px;
                color: #4a1822;
                font-family: Georgia, serif;
                font-size:20px;
            }

            .guest-information {
                margin-bottom: 20px;
                overflow: hidden;
                border: 1px solid #ead9c1;
                border-radius: 15px;
            }

            .information-row {
                display: flex;
                justify-content: space-between;
                gap: 15px;
                padding: 13px 15px;
                font-size: 14px;
                border-bottom: 1px solid #f0e3d2;
            }

            .information-row:last-child {
                border-bottom: 0;
            }

            .information-label {
                color: #866873
            }

            .information-value {
                color: #4a1822;
                font-weight: bold;
                text-align: right;
            }

            .field-label {
                display: block;
                margin-bottom: 8px;
                color: #76535b;
                font-size: 13px;
                font-weight: bold;
            }

            .button-group {
                display: flex;
                gap: 10%;
                margin-top: 18px;
            }

            .button-group button {
                flex: 1;
            }

            .success-box {
                padding: 22px 18px;
                text-align: center;
                background: #edf9f0;
                border: 1px solid #9fd0aa;
            }

            .success-box h2 {
                margin: 0 0 10px;
                color: #27613a;
                font-family: Georgia, serif;
            }

            .success-box p {
                margin: 0;
                color: #52705b;
                line-height: 1.6;
            }

            @media (max-width: 520px) {
                .manual-form,
                .button-group {
                    flex-direction: column;
                }

                h1 {
                    font-size: 29px;
                }

                .card {
                    padding: 20px;
                }
            }

        </style>
    </head>

    <body>
        <main class="container">
            <header class="header">
                <p class="subtitle">
                    Scan Qr code tamu, pilih jumlah yang hadir, 
                    kemudian konfirmasi kedatangannya.
                </p>
</header> 

<div id="status-message" class="status"></div>

<section class="card">
    <h2 class="card-title">Scan Code QR</h2>
    <div id="reader">Atau masukkan code</div>

    <div class="manual-form">
        <input
        type="text"
        id="manual-code"
        placeholder="contoh: WED-ARIFA-001"
        autocomplete="off"
        >

        <button type="button" id="search-button">
            Cari tamu
</button>
    </div>
</section>

<section class="card" id="result-card">
    <h2 class="card-title">Data Tamu</h2>

    <h3 class="guest-name" id="guest-name">-</h3>

    <div class="guest-information">
        <div class="information-row">
            <span class="information-label">kode QR</span>
            <span class="information-value" id="guest-code">-</span>
</div>

<div class="information-row">
<span class="information-label">Tipe Tamu</span>
<span class="information-value" id="guest-type">-</span>
</div>

<div class="information-row">
    <span class="information-label">Batas Undangan</span>
    <span class="information-value" id="guest-limit">-</span>
</div>

<div class="information-row">
    <span class="information-label">status</span>
    <span class="information-value" id="guest-status">
        Belum Check-in 
</span>
</div>
</div>

<div id="confirmation-area">
    <label class="field-label" for="attended-count">
        Pilih jumlah tamu yang datang
</label>

<select id="attended-count"></select>

<div class="button-group">
    <button type="button" id="confirm-button">
    Konfirmasi kehadiran
</button>

<button 
type="button"
id="reset-button"
class="secondary-button">

Scan ulang

</button>
</div>
</div>
</section>
</main>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

    const statusMessage = document.getElementById('status-message');
    const resultCard = document.getElementById('result-card');
    const guestName = document.getElementById('guest-name');
    const guestCode = document.getElementById('guest-code');
    const guestType = document.getElementById('guest-type');
    const guestLimit = document.getElementById('guest-limit');
    const guestStatus = document.getElementById('guest-status');
    const attendedCount = document.getElementById('attended-count')
    const confirmationArea = document.getElementById('confirmation-area');

    const manualCode = document.getElementById('manual-code');
    const searchButton = document.getElementById('search-button');
    const confirmButton = document.getElementById('confirm-button');
    const resetButton = document.getElementById('reset-button');

    let currentCode = null;
    let scannerLocked = false;

    function showStatus(message, type) {
        statusMessage.textContent = message;
        statusMessage.className = `status ${type}`
    }

    function hideStatus () {
        statusMessage.textContent = "";
        statusMessage.className = 'status';
    }

    function normalizeCode(value) {
        const text = value.trim();

        if (!text) {
            return '';
        }

        try {
            const url = new URL(text);
            const pathParts = url.pathname.split('/').filter(Boolean);

            return decodeURIComponent(
            pathParts[pathParts.length -1] || text
            );
        } catch (error) {
            return text;
        }
    }

    function fillAttendanceOptions(limit) {
        attendedCount.innerHTML = '';

        for (let number =1; number <= limit; number++) {
            const option = document.createElement('option');

            option.value = number;
            option.textContent = `${number} orang`;

            attendedCount.appendChild(option);
        }
    }

    function displayGuest(guest) {
        currentCode = guest.code;

        guestName.textContent = guest.name;
        guestCode.textContent = guest.code;
        guestType.textContent = guest.guest_type
        ? guest.guest_type.toUpperCase()
        : '-';

        guestLimit.textContent = `${guest.invitation_limit} orang`;
        guestStatus.textContent = 'Belum check-in';

         fillAttendanceOptions(guest.invitation_limit);

        confirmationArea.style.display = 'block';
        resultCard.style.display = 'block';

        showStatus('Data tamu berhasil ditemukan.', 'success');
    }

    function displayAlreadyScanned(guest, message) {
        currentCode = null;
    

    guestName.textContent = guest?.name ?? 'Tamu';
    guestCode.textContent = guest?.code ?? '-';
    guestType.textContent = guest?.guest_type
    ? guest.guest_type.toUpperCase()
    : '-';
    guestLimit.textContent =guest?.invitation_limit
    ? `${guest.invitation_limit} orang`
    : '-';

        guestStatus.textContent = 'Sudah Check-in';
        confirmationArea.style.display ='none';
        resultCard.style.display = 'block';

        showStatus(message, 'error');

}

async function findGuest(rawCode) {
    if (scannerLocked) {
        return;
    }

    const code = normalizeCode(rawCode);

    if (!code) {
        showStatus('Masukkan atau scan code tamu terlebih dahulu.', 'error');
        return;
    }

    scannerLocked =true;
    showStatus('Sedang mencari data tamu...', 'loading');

    try {
        const response = await fetch(  
            `/admin/guest/${encodeURIComponent(code)}`,
            {
            headers: { 
                'Accept': 'application/json'
        }
}
        );

        const data = await response.json();

        if (response.status === 409) {
            displayAlreadyScanned(
                data.guest,
                 data.message
);
            return;
        }

        if (!response.ok) {
            showStatus(
                data.message ?? 'Data tamu tidak ditemukan.',
                'error'
);

                scannerLocked = false;
                return;
}

            displayGuest(data.guest);
        } catch (error) {
            showStatus(
                'Gagal menghubungi server. silahkan coba kembali',
                'error'
            );

            scannerLocked = false;
}
        }

        async function confirmAttendance() {
            if (!currentCode) {
                showStatus('Data tamu belum di pilih.', 'error');
                return;
            }

            confirmButton.disabled = true;
            showStatus('Menyimpan kehadiran tamu...', 'loading');

            try {
                const response = await fetch(
                    `/admin/guest/${encodeURlComponent(currentCode)}/confirm`, 
                    {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        body:JSON.stringify({
                            attended_count: Number(attendedCount.value)
                        })
                    }
);
const data = await response.json();

if (!response.ok) {
    showStatus(
        data.message ?? 'kehadiran gagal dikonfirmasi.',
        'error'
    );

    confirmButton.disabled = false;
    return;
}

    confirmationArea.innerHTML = `
    <div class ="success-box">
    <h2>Check-in berhasil</h2>

    <p> 
    ${data.guest.name} tercatat hadir sebanyak
    ${data.guest.attended_count} orang.
    </p>
    
    <div class ="button-group">
    <button 
    type="button"
    class="secondary-button"
    onclick="window.location.reload()"
    >

    Scan Tamu Berikutnya

                </button>

        </div>

    </div>
`;   

guestStatus.textContent = 'sudah check-in';

showStatus(
    data.message ?? 'kehadiran berhasil di konfirmasi.',
    'success'
);
} catch (error) {
    showStatus(
        'Gagal menyimpan kehadiran, silahkan coba lagi.',
        'error'
    );

    confirmButton.disabled = false;
}
        }

        function resetScanner () {
            currentCode = null;
            scannerLocked = false;

            manualCode.value= '';
            resultCard.style.display= 'none';

            hideStatus();
        }

        function onScanSuccess(decodedText) {
            findGuest(decodedText);
        }

        const scanner = new Html5QrcodeScanner(
            'reader',
            {
                fps: 10,
                qrbox : {
                    width: 240,
                    height: 240
                },

                rememberLastUsedCamera: true
            },
            false
        );

        scanner.render(onScanSuccess);

        searchButton.addEventListener('click', function () {
            findGuest(manualCode.value);
        });

        manualCode.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                findGuest(manualCode.value);
            }

        });

        confirmButton.addEventListener('click', confirmAttendance);
        resetButton.addEventListener('click', resetScanner);

</script> 
    </body>
    </html>