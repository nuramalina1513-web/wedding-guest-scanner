<!Doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Daftar Tamu</title>

        <style>
            *{
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                padding: 35px 20px;

                background: #f8ead9;
                color: #4d2027;

                font-family: Arial, sans-serif;
            }

            .container {
                width: 100%;
                max-width: 1100px;
                margin: 0 auto;
            }

            .header {
                margin-bottom: 25px;
                text-align: center;
            }

            .header h1 {
                margin-bottom: 8px;

                color: #821f35;
                font-family: Georgia, serif;
                font-size: 32px;
            }

            .header p {
                margin: 0;
                color: #8a6468;
                font-size: 14px;
            }

            .actions {
                display: flex;
                justify-content: center;
                gap: 10px;

                margin-bottom: 22px;
            }

            .action-button {
                padding: 11px 18px;

                border: 1px solid #821f35;
                border-radius: 10px;

                text-decoration: none;
                font-size: 14px;
            }

            .add-button {
                background: #821f35;
                color: white;
            }

            .scan-button {
                background: transparent;
                color: #821f35;
            }

            .table-card {
                overflow-x: auto;

                background: #fffaf3;

                border: 1px solid #e2bb7c;
                border-radius: 18px;

                box-shadow: 0 10px 30px rgba(92, 37, 45,0.08);
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, 
            td {
                padding: 14px 16px;
                text-align: left;
                border-bottom: 1 px solid #eedcc5;
                white-space: nowrap:
            }

            th {
                background: #821f35;
                color: white;

                font-size: 13px;
            }

            td {
                font-size: 13px;
            }

            tr:last-child td {
                border-bottom: none;
            }

            .vip {
                font-weight: bold;
                color: #821f35;
            }

            .reguler{
            color: #70585c;
            }

            .status-success {
                color: #287a43;
                font-weight: bold;
            }

            .status-waiting {
                color: #a46a13;
                font-weight: bold;
            }

            .view-button {
                display: inline-block;

                padding: 7px 10px;

                border: 1px solid #821f35;
                border-radius: 8px;

                color: #821f35;
                text-decoration: none;
                font-size: 12px;
            }

            .empty {
                padding: 35px;
                text-align: center;
                color: #8a6468;
            }

            .filters {
                display: flex;
                gap: 10px;
                margin-button: 18px;
            }

            .filters input,
            .filters select {
                padding: 11px 12px;

                border: 1px solid #dbb98c;
                border-radius:10px;

                background: #fffaf3;
                color: #4d2027;

                font-size: 13px;
            }

            .filters input {
                flex: 1;
            }

            .filters select {
                min-width: 160px;
            }

            .action-links {
                display: flex;
                gap: 7px;
                align-items: center;
            }

            .edit-button {
                display: inline-block;
                padding: 7px 10px;

                background: #821f35;
                border: 1px solid #821f35;
                border-radius: 8px;

                color: white;
                text-decoration: none;
                font-size: 12px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1>Daftar Tamu</h1>
                <p>Kelola dan pantau seluruh tamu undangan</p>
            </div>

            <div class="actions">

            <a
             href="{{ route('admin.guests.create') }}"
             class="action-button add-button"
            >
                + Tambah Tamu
</a>
            <a
             href="{{ route('admin.scan') }}"
             class="action-button add-button"
             >
             Scan Tamu
</a>
</div>

<div class="filter">
    <input
     type="text"
     id="guest-search"
     placeholder="Cari nama atau Qr ..."
     >

     <select id="type-filter">
     <option value="all">Semua Tipe</option>
     <option value="vip">VIP</option>
     <option value="reguler">Reguler</option>
     </select>

    <select id="status-filter">
        <option value="all">Semua Status</option>
        <option value="checked-in">Sudah Check-in</option>
        <option value="waiting">Belum Check-in</option>
    </select>
</div>

<div class="table-card">

@if ($guests->count() > 0)

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kode Qr</th>
                <th>Tipe</th>
                <th>Batas</th>
                <th>Hadir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody> 

        @foreach ($guests as $guest)

        <tr 
            class="guest-row"
            data-type="{{ $guest->guest_type }}"
            data-status="{{ $guest->scanned_at ? 'checked-in' : 'waiting' }}"
            >
            <td>
                {{ $guest->name }}
            </td>

            <td>
                {{ $guest->code }}
            </td>

            <td>
                <span class="{{ $guest->guest_type }}">
                    {{ strtoupper($guest->guest_type ?? '-') }}
                </span>
            </td>

            <td>
                {{ $guest->invitation_limit }} orang
            </td>

            <td>
                {{ $guest->attended_count }} orang
            </td>

            <td>
                @if ($guest->scanned_at)

                <span class="status-success">
                    Sudah Check-in
                </span>

                @else

                <span class="status-waiting">
                    Belum check-in
                </span>

                @endif
            </td>

            <td>
                <div class="action-links">
                    <a href="{{ route('guest.show', $guest->code) }}"
                target="_blank"
                class="view-button"
                >
                    Lihat undangan
                </a>
                <a 
                href="{{ route('admin.guests.edit', $guest) }}"
                class="edit-button"
                >
                    Edit
                </a>
                </div>
                
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    @else

    <div class="empty">
        Belum ada Tamu yang ditambahkan.
    </div>

    @endif

            </div>
        </div>

        <script>
            const guestSearch = document.getElementById('guest-search');
            const typeFilter = document.getElementById('type-filter');
            const statusFilter = document.getElementById('status-filter');
            const guestRows = document.querySelectorAll('.guest-row');

            function filterGuests() {
                const searchValue = guestSearch.value.toLowerCase();
                const typeValue = typeFilter.value;
                const statusValue = statusFilter.value;

                guestRows.forEach(function (row) {
                    const rowText = row.textContent.toLowerCase();
                    const rowType = row.dataset.type;
                    const rowStatus = row.dataset.status;

                    const matchSearch = rowText.includes(searchValue);

                    const matchType =
                    typeValue === 'all' ||
                    rowType === typeValue;

                    const matchStatus = 
                    statusValue === 'all' ||
                    rowStatus === statusValue;

                    if (matchSearch && matchType && matchStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

            }

            guestSearch.addEventListener('input', filterGuests);
            typeFilter.addEventListener('change', filterGuests);
            statusFilter.addEventListener('change', filterGuests);
        </script>
    </body>
    </html>