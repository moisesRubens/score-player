<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Jogadores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cdnjs.cloudflare.com">
    <style>
    body {
        background-color: #e6e6e6;
    }

    .navbar {
        padding: 0.25rem 0.75rem;
        max-height: 70px;
    }

    .navbar-logo {
        height: 60px;
        width: auto;
    }

    .menu-icon {
        height: 36px;
        width: auto;
    }

    .dropdown-toggle::after {
        display: none;
    }

    

    /* MOBILE */
    @media (max-width: 768px) {
        .navbar-logo {
            height: 42px;
        }

        .menu-icon {
            height: 30px;
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
            font-size: 11px;
            padding: 4px 6px;
        }
    }
    </style>

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid d-flex align-items-center">

                <!-- Left logo -->
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('img/img.png') }}" alt="Logo" class="navbar-logo">
                </a>

                <!-- Right menu icon -->
                <div class="dropdown ms-auto">
                    <button class="btn p-0 border-0 bg-transparent dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="{{ asset('img/menu_white_36dp.svg') }}" alt="Menu" class="menu-icon">
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('partidas.index') }}">
                                Time
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

    </header>


    <div class="container py-5">
        <h1 class="ranking-title text-center mb-4">Ranking de Jogadores</h1>

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

        @if($players->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nick</th>
                        <th>MDMs jogados</th>
                        <th>Adicionar Ponto</th>
                        <th>Editar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($players as $player)
                    <tr>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->score }}</td>

                        <!-- Botão adicionar ponto -->
                        <td>
                            <form onsubmit="clickSound()" action="{{ route('players.addPoint', $player->id) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">MDM +1</button>
                            </form>
                        </td>

                        <!-- Botão editar -->
                        <td>
                            <a href="{{ route('players.edit', $player->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        </td>

                        <!-- Botão deletar -->
                        <td>
                            <form action="{{ route('players.destroy', $player->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center mt-4">Nenhum jogador cadastrado ainda.</p>
        @endif
        <!-- Botão para registrar novo player -->
        <div class="mb-3 text-center">
            <a href="{{ route('players.create') }}" class="btn btn-primary">Registrar-se</a>
        </div>
    </div>

    <audio id="audio" src="{{ asset('audio/click_sound.mp3') }}" preload="auto"></audio>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function clickSound() {
        const audio = document.getElementById('audio');
        audio.play();
    }

    /*Função MenuShow()*/
    function menuShow() {
        let menuMobile = document.querySelector(".mobile-menu");

        if (menuMobile.classList.contains('open')) {
            menuMobile.classList.remove('open');
            document.querySelector(".icon-menu").src = "img/menu_white_36dp.svg";

        } else {
            menuMobile.classList.add('open');
            document.querySelector(".icon-menu").src = "img/close_white_36dp.svg";
        }
    }
    </script>
</body>

</html>