<!Doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Login Admin</title>

        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;

                display: flex;
                justify-content: center;
                align-items: center;

                padding: 30px 16px;

                background: #f8ead9;
                color: #4d2027;

                font-family: Arial, sans-serif;
            }

            .login-card {
                width: 100%;
                max-width: 500px;

                padding:42px 40px;

                background: #fff3af;
                border: 1px solid #e2bb7c;
                border-radius: 20px;

                box-shadow: 0 12px 35px rgba(92, 37, 45, 0.10);
            }

            .header {
                margin-bottom: 32px;
                text-align: center;
            }

            .header h1 {
                margin: 0 0 10px;

                color: #821f35;
                font-family: Georgia, serif;
                font-size: 38px;
            }

            .header p {
                margin: 0;

                color: #8a6468;
                font-size: 14px;
            }

            .field {
                margin-bottom: 20px;
            }

            .field label {
                display: block;
                margin-bottom: 8px;

                font-size: 14px;
                font-weight: bold;
            }

            .field input {
                display: block;
                width: 100%;

                padding: 13px 14px;

                border: 1px solid #dbb98c;
                border-radius: 10px;

                background: white;
                color: #4d2027;

                font-size: 14px;
            }

            .field input:focus {
                outline: none;
                border-color: #821f35;
            }

            .login-button {
                width: 100%;

                margin-top: 5px;
                padding: 14px;

                border: 1px solid #821f35;
                border-radius: 10px;

                background: #821f35;
                color: white;

                cursor: pointer;
                font-size: 14px;
                font-weight: bold;
            }

            .error-message {
                margin-bottom: 20px;
                padding: 12px;

                background: #fdecec;
                border: 1px solid #df9a9a;
                border-radius: 10px;

                color: #9b1c31;
                font-size: 13px;
                text-align: center;
            }

        </style>
    </head>

    <body>
        
    <div class="login-card">
            <div class="header">
                <h1>Admin Login</h1>
                <p>Wedding Guest Check-in</p>
            </div>

            @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
            @endif

            <form 
            action="{{ route('admin.login') }}"
            method="POST"
            >
                @csrf

                <div class="field">
                    <label for="email">Email</label>

                    <input 
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@gmail.com"
                    required
                    autofocus
                    
                    >
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan Password"
                    required
                    
                    >
                </div>

                <button
                type="submit"
                class="login-button"
                >
                    Login
                </button>

            </form>

    </div>
    </body>
    </html>