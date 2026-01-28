<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Jogadores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* GENERAL FIXES */
        body {
            min-height: 100vh;
        }

        .container {
            max-width: 100%;
            padding-left: 16px;
            padding-right: 16px;
        }

        /* NAVBAR */
        .vz-navbar {
            padding: 0.75rem 1rem;
        }

        .navbar-logo {
            max-height: 45px;
            width: auto;
        }

        /* LOGIN FORM */
        form {
            display: flex;
            justify-content: center;
        }

        form .mb-3 {
            width: 100%;
            max-width: 360px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            /* prevents zoom on mobile */
            border-radius: 6px;
            margin-bottom: 12px;
        }

        button.btn {
            width: 100%;
        }

        /* ALERT */
        .alert {
            width: 100%;
            max-width: 360px;
            margin: 0 auto 16px auto;
            font-size: 14px;
        }

        /* SMALL DEVICES */
        @media (max-width: 576px) {
            .container {
                padding-top: 2rem;
            }

            .navbar-logo {
                max-height: 38px;
            }

            .alert {
                font-size: 13px;
            }
        }

        /* TABLE SAFETY (future-proof) */
        @media (max-width: 768px) {
            table {
                font-size: 14px;
                overflow-x: auto;
                display: block;
            }
        }
    </style>

</head>

<body>

    <header>
        <nav class="vz-navbar navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid d-flex align-items-center">

                <a class="navbar-brand" href="#">
                    <img src="{{ asset('img/vz_logo.png') }}" alt="Logo" class="navbar-logo">
                </a>
            </div>
        </nav>
    </header>


    <div class="container py-5">

        @php
            $message = session('warning');
        @endphp

        @if($message)

            <div class="alert alert-danger d-inline-flex align-items-center" role="alert">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                    aria-label="Warning:">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    {{ $message }}
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3 mt-4 text-center">
                <input type="text" name="nick" required>
                <input type="password" name="password" required>
                <button class="strong-text btn button btn-primary">Login</button>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>