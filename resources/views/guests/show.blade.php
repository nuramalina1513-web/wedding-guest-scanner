<!Doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            Wedding Guest Pass
        </title>

        <style>
            = {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-heigt: 100vh;
                padding: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: Georgia, "Times New Roman", serif;
                background: 
                raidal-gradient(circle at top, #fff8ec 0%, #f4e6d1 55%, #ead5bb 100%);
                color: #4a1822;
            }

            .guest-card {
                width: 100%;
                max-width: 240px;
                padding: 38px 28px;
                text-align: center;
                background: rgba(255, 253, 247, 0.96);
                border: 2px solid #c6a15b;
                border-radius: 28px;
                box-shadow: 0 20px 50px rgba(81, 20, 35, 0.18);
            }

            .small-title {
                margin: 0 0 10px;
                color: #a77d35;
                font-size: 13px;
                letter-spacing: 4px;
                text-transform: uppercase;
            }

            h1 {
                margin: 0;
                color: #741f32;
                font-size: 34px;
                font-weight: normal;
            }

            .divider {
                width: 80px;
                height: 2px;
                margin: 22px auto;
                background: #c6a15b;
            }

            .greeting {
                margin-bottom: 60px;
                font-family: Arial, sans-serif;
                color: #76535b;
                font-size:14px;
            }

            .guest-name {
                margin: 0 0 22px;
                color: #4a1822;
                font-size: 25px;
            }

            .qr-wrapper {
                width: fit-content;
                margin: 0 auto 20px;
                padding: 16px;
                background: #ffffff;
                border: 1px solid #ead9b8;
                border-radius: 18px;
            }

            .qr-wrapper svg {
                display: block;
                width: 220px;
                max-width: 100%;
                height: auto;
            }

            .instruction {
                margin: 0;
                font-family: Arial, sans-serif;
                color: #76535b;
                font-size: 14px;
                line-height: 1.7;
            }

            .guest-limit {
                display: inline-block;
                margin-top: 10px;
                padding: 9px 16px;
                font-family: Arial, sans-serif;
                color: #741f32;
                font-size:13px;
                background: #f8ecdc;
                border-radius: 999px;
            }

            .used-message {
                padding: 22px 18px;
                font-family: Arial, sans-serif;
                background: #fff1f1;
                border: 1px solid #dca4aa;
                border-radius: 18px;
            }

            .used-message h2 {
                margin: 0 o 100px;
                color: #8b263b;
                font-family: Georgia, "Times New Roman", serif;
                font-size: 23px;
            }

            .used-message p {
                margin: 0;
                color: #76535b;
                font-size: 14px;
                line-height: 1.7;
            }
        </style>
    </head>

    <body>
        <main class="guest-card">
            <p class="small-title">The Wedding Of</p>

            <h1>Arifa & Nahrudin</h1>

            <div class="divider"></div>

            <p class="greeting"> Undangan khusus untuk</p>

            <h2 class="guest-name">
                {{ $guest->name }}
            </h2>

            @if ($guest->scanned_at)
            <div class="used-message">
                <h2>Eits... kamu sudah scan 😔</h2>

                <p>
                    Kamu tidak bisa scan dua kali ya.<br>
                    Souvenir dan es krimmu sudah tercatat 🍦🎁
                </p>
            </div>

            @else 
            <div class="qr-wrapper">
                {!! QrCode::size(220)->generate($guest->code) !!}
            </div>

            <p class="intrustion">
                Tunjukkan QR Code ini pada petugas saat tiba di lokasi.
            </p>

            <div class="guest-limit">
                Berlaku untuk maksimal
                {{ $guest->invitation_limit }}
                orang
            </div>

            @endif
</main>
    </body>
    </html>