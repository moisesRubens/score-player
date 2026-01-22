<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ranking de Jogadores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        table {
            font-size: 14px;
        }

        .report-card .card-body {
            padding: 0.4rem;
        }

        table tbody tr:first-child td{
            background: linear-gradient(to top, rgba(228, 167, 0, 0.637), white);
            font-weight: 500;
        }

    </style>
</head>

<body>

    <header>
        <nav class="vz-navbar navbar navbar-expand-lg navbar-dark">

            <div class="container-fluid d-flex align-items-center">

                <a class="navbar-brand" href="{{ route('players.index') }}">
                    <img src="{{ asset('img/vz_logo.png') }}" alt="Logo" class="navbar-logo">
                </a>

                <div class="dropdown ms-auto">
                    <button class="btn p-0 border-0 bg-transparent dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="{{ asset('img/menu_white_36dp.svg') }}" alt="Menu" class="menu-icon">
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('players.index') }}">
                                Página inicial
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

        </nav>


    </header>

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
                <div>{{ $message }}</div>
            </div>
        @endif

        {{-- Map Filter --}}
        <form method="get" action="{{ route('partidas.filterResultsByMap') }}">
            <div class="row-md-4 mb-4">
                <label for="filtro-mapa" class="form-label fw-bold">Mapa</label>
                <select class="form-select" id="filtro-mapa" name="map" onchange="this.form.submit()">
                    <option value="erangel" {{ ($map ?? '') == 'erangel' ? 'selected' : '' }}>Erangel</option>
                    <option value="miramar" {{ ($map ?? '') == 'miramar' ? 'selected' : '' }}>Miramar</option>
                    <option value="rondo" {{ ($map ?? '') == 'rondo' ? 'selected' : '' }}>Rondo</option>
                    <option value="todos" {{ ($map ?? '') == 'todos' ? 'selected' : '' }}>Todos</option>

                </select>
            </div>
        </form>

        @if($team->isNotEmpty())

            @php
                $totalMatches = count($battles);
                $totalKills = $team->sum('individual_kills');
                $avgKills = $totalMatches > 0 ? number_format($totalKills / $totalMatches, 1) : 0;
                $avgSurvival = 6;
                if ($totalMatches > 0) {
                    $avgSurvival = number_format($battles->avg('survive_time'), 1);
                }
            @endphp

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card report-card" style="border-left:5px solid #0d6efd;">
                        <div class="card-body">
                            <h5>Número de Partidas</h5>
                            <p>{{ $totalMatches }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card report-card" style="border-left:5px solid #0d6efd;">
                        <div class="card-body">
                            <h5>Média de Kills</h5>
                            <p>{{ $avgKills }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card report-card" style="border-left:5px solid #0d6efd;">
                        <div class="card-body">
                            <h5>Média de Sobrevivência</h5>
                            <p>{{ $avgSurvival }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h2 style="text-align: center; margin-bottom: 30px;" >Ranking KD</h2>

            <table class="table table-responsive custom-shadow rounded align-middle text-center ">
                <thead>
                    <tr>
                        <th>Nick</th>
                        <th>Partidas</th>
                        <th>Kills</th>
                        <th>Média Kills</th>
                        <th>Média Sobrevivência</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($playersStatus as $data)
                        <tr>
                            <td>{{ $data['player']->name }}</td>
                            <td>{{ $data['matches'] }}</td>
                            <td>{{ $data['kills'] }}</td>
                            <td>{{ $data['kills_avg'] }}</td>
                            <td>{{ $data['survival_avg'] }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        @else
            <p class="text-center mt-4">Nenhum jogador cadastrado ainda.</p>
        @endif

        <div class="mb-3 text-center">
            <a href="{{ route('partidas.create') }}" class="strong-text btn button btn-primary">Adicionar</a>
            <a href="{{ route('players.index') }}" class="strong-text btn button btn-primary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>