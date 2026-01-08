<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Jogadores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #e6e6e6;
        /* cor creme */
    }

    .navbar-brand {
        padding-left: 0;
        padding-right: 0;
    }

    .navbar-brand span {
        color: white;
        font-weight: bold;
        margin-left: 6px;
    }

    .navbar {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        max-height: 70px;
    }

    .navbar-logo {
        height: 60px;
        /* LOGO MAIOR */
        width: auto;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .navbar-logo {
            height: 60px;
            margin: 0 auto;
        }

        .navbar {
            padding-left: 0;
        }

        .a {
            margin: 0 auto;
            text-align: center;
        }

        table {
            font-size: 12px;
        }

        th,
        td {
            padding: 6px 4px;
            white-space: normal;
        }

        .btn {
            padding: 2px 6px;
            font-size: 11px;
        }
    }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/img.png') }}" alt="Logo" class="navbar-logo">
            </a>
        </div>
    </nav>


    <div class="container py-5">

        @php
            $message = session('error') ?? session('warn');
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

        @if($performance->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Jogador</th>
                        <th>Kills</th>
                        <th>Média de Kills</th>
                        <th>Média de Sobrevivência</th>
                        <th>Partidas</th>
                    </tr>
                </thead>
                <tbody>
@foreach($performance as $player)
<tr>
    <td>{{ $player->name }}</td>

    <td>{{ $player->kills }}</td>

    <td>
        {{ $player->matches_amount > 0
            ? number_format($player->kills / $player->matches_amount, 2)
            : 0 }}
    </td>

    <td>{{ number_format($player->average_survive, 2) }}</td>

    <td>{{ $player->matches_amount }}</td>
</tr>
@endforeach
</tbody>

            </table>
        </div>
        @else
        <p class="text-center mt-4">Nenhum jogador cadastrado ainda.</p>
        @endif
        <div class="mb-3 text-center">
            <a href="{{ route('partidas.create') }}" class="btn btn-primary">Adicionar</a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>