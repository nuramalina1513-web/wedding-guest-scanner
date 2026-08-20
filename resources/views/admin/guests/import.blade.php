<!Doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            Import Tamu
        </title>
            <style>
                * {
                    box-sizing: border-box;
                }

                body {
                    margin: 0;
                    min-height: 100hv;
                    padding: 40px 20px;

                    background: #f8ead9;
                    color: #4d2027;

                    font-family: Arial, sans-serif;

                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .import-card {
                    width: 100%;
                    max-width: 520px;

                    padding: 30px;

                    background: #fffaf3;
                    border: 1px solid #e2bb7c;
                    border-radius: 18px;

                    box-shadow: 0 10px 30px rgba(92, 37, 45, 0.08);
                }

                .header {
                    text-align: center;
                    margin-bottom: 25px;
                }

                .header h1 {
                    margin: 0 0 8px;
                    color: #821f25;
                    font-family: Georgia, serif;
                }

                .header p {
                    margin: 0;

                    color: #8a6468;
                    font-size: 13px;
                }

                .field {
                    margin-bottom: 20px;
                }

                .field label {
                    display: block;
                    margin-bottom: 8px;

                    font-siza: 13px;
                    font-weight: bold;
                }

                .field input {
                    width: 100%;
                    padding: 12px;

                    border: 1px solid #dbb98c;
                    border-radius: 10px;
                    background: white;
                }

                .hint {
                    margin-top: 8px;

                    color: #8a6448;
                    font-size: 12px;
                    line-height: 1.5;
                }

                .submit-buttom {
                    width: 100%;
                    padding: 12px;

                    border: none;
                    border-radius: 10px;

                    background: #821f35;
                    color: white;
                    
                    cursor: pointer;
                    font-weigh:bold;
                }

                .back-button {
                    display: block;

                    margin-top: 12px;
                    padding: 11px;

                    border: 1px solid #821f35;
                    border-radius: 10px;

                    color: #821f36;
                    text-align: center;
                    text-decoration: none;

                    font-size: 13px;

                @media (max-width: 600px;){

                    body {
                        padding: 25px 12px;
                    } 

                    .header h1 {
                        font-size: 28px;
                    }

                    .actions {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 8px;
                    }

                    .action-button {
                        text-align: center;
                        padding: 10px 8px;
                        font-size: 12px;
                    }

                    .filter {
                        flex-direction: column;
                        gap: 7px;
                    }

                    .filters-input,
                    .filters-select {
                        width: 100%;
                    }

                    .table-card {
                        overflow-x: auto;
                    }

                    table {
                        min-width: 780px;
                    }

                    th,
                    td {
                        padding: 12px 10px;
                        white-space: nowrap;
                    }
                }
}
            </style>
    </head>

    <body>
        
    <div class="import-card">
        <div class="header">
            <h1>Import Tamu</h1>
            <p>Tambahkan banyak tamu sekaligus melalui file CSV.</p>
        </div>

        <form action="{{ route('admin.guests.import.store') }}"
        method="POST"
        enctype="multipart/form-data"
        >

        @csrf

        <div class="field">
            <label for="csv_file">File CSV</label>
                <input 
                type="file",
                id="csv_file",
                name="csv_file".
                accept=".csv",
                required
                >

                <div class="hint">
                    Format kolom: name, guest_type, invitation_limit
                </div>
        </div>

        <button
        type="submit",
        class="submit-button"
        >
            Import Tamu
        </button>

        </form>

        <a 
        href="{{ route('admin.guests.index') }}"
        class="back-button"
        >
            <- kembali ke daftar tamu
        </a>

    </div>
    </body>
    </html>