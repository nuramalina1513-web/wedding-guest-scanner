<!Doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Dashboard Tamu</title>

        <style>
            *{
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                padding: 40px 20px;

                background: #f8ead9;
                color: #4d2027;

                font-family: Arial, sans-serif;
            }

            .container {
                width: 100%;
                max-width: 1000px;
                margin: 0 auto;
            }

            .header {
                text-align: center;
                margin-bottom: 30px;
            }

            .header h1 {
                margin: 0 0 8px;

                color: #821f35;
                font-family: Georgia, serif;
                font-size: 40px;
            }

            .header p{
                margin: 0;
                color: #8a6468;
                font-size: 16px;
            }

            .actions {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;

                margin-bottom: 30px;
            }

            .action-button {
                padding: 11px 18px;

                border: 1px solid #821f35;
                border-radius: 10px;

                background: #821f35;
                color: white;

                text-decoration: none;
                font-size: 13px;
            }

            .action-button.secondary {
                background: transparent;
                color: #821f35;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .stat-card {
                padding: 24px;

                background: #fffaf3;
                border: 1px solid #e2bb7c;
                border-radius: 18px;

                box-shadow: 0 10px 30px rgba(92, 37, 45, 0.08);
            }

            .stat-label {
                margin-bottom: 10px;

                color: #8a6468;
                font-size: 13px;
            }

            .stat-number {
                margin: 0;

                color: #821f35;
                font-family: Georgia, serif;
                font-size: 32px;
                font-weight: bold;
            }

            .stat-unit {
                margin-top: 6px;

                color: #70585c;
                font-size: 12px;
            }

            .success-card .stat-number {
                color: #287a43;
            }

            .waiting-card .stat-number {
                color: #a46a13;
            }

            .vip-card .stat-number {
                color: #821f35;
            }

            @media (max-width: 500px) {
                body {
                    padding: 25px 14px;
                }

                .stats-grid {
                    grid-template-columns: 1fr; 
                }

                .action-form {
                    margin: 0;
                }
            }
        </style>
    </head>

    <body>

    <div class="container">
        <div class="header">
            <h1>Dashboard Tamu</h1>
            <p>Ringkasan Kehadiran Tamu Undangan Arifa & Nahrudin</p>
        </div>

        <div class="actions">
            <a 
            href="{{ route('admin.guests.index') }}"
            class="action-button"
            >
            Daftar Tamu
        </a>

        <a 
        href="{{ route('admin.guests.create') }}"
        class="action-button secondary"
        >
            + Tambah Tamu
        </a>

        <a 
        href="{{ route('admin.scan') }}"
        class="action-button secondary"
        >
            Scan Tamu
        </a>

        <form 
        action="{{ route('admin.logout') }}"
        method="POST"
        >
            @csrf

            <button 
            type="submit"
            class="action-button secondary"
            >
                Logout
            </button>
        </form>

        </div>

        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-label">Total Undangan</div>
                <p class="stat-number">{{ $totalGuests }}</p>
                <div class="stat-unit">Undangan</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Kuota</div>
                <p class="stat-number">{{ $totalInvitation }}</p>
                <div clas="stat-unit">orang</div>

            </div>

            <div class="stat-card success-card">
                <div class="stat-label">Sudah Check-in</div>
                <p class="stat-number">{{ $checkedIn }}</p>
                <div class="stat-unit">Undangan</div>

            </div>

            <div class="stat-card waiting-card">
                <div class="stat-label">Belum check-in</div>
                <p class="stat-number">{{ $notCheckedIn }}</p>
                <div class="stat-unit">Undangan</div>

            </div>

            <div class="stat-card success-card">
                <div class="stat-label">Total Hadir</div>
                <p class="stat-number">{{ $totalAttended }}</p>
                <div class="stat-unit">orang</div>
            </div>

            <div class="stat-card vip-card">
                <div class="stat-label">Tamu Vip</div>
                <p class="stat-number">{{ $totalVip }}</p>
                <div class="stat-unit">Undangan</div>
            </div>

            <div class="stat-card reguler-card">
                <div class="stat-label">Tamu Reguler</div>
                <p class="stat-number">{{ $totalReguler }}</p>
                <div class="stat-unit">Undangan</div>
            </div>

        </div>
    </div>

    
    </body>
    </html>