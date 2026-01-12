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
        }

        /* NAVBAR */
        .navbar {
            padding: 0.5rem 0.75rem;
        }

        .navbar-logo {
            height: 56px;
            width: auto;
        }

        /* TABLE */
        table {
            font-size: 14px;
        }

        .btn {
            width: 200px;
        }

        .report-card .card-body {
            padding: 0.4rem;
        }

        /* remove default dropdown arrow */
        .dropdown-toggle::after {
            display: none !important;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .navbar-logo {
                height: 42px;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 6px 4px;
                white-space: nowrap;
            }

            .btn {
                font-size: 12px;
                padding: 6px 10px;
                display: block;
                width: 50%;
                margin: 0 auto;
            }

            .mb-3.text-center {
                display: grid;
                gap: 8px;
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

        {{-- Display session messages --}}
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
                <select class="form-select"
                        id="filtro-mapa"
                        name="map"
                        onchange="this.form.submit()">
                    <option value="erangel" {{ ($mapa ?? '') == 'erangel' ? 'selected' : '' }}>Erangel</option>
                    <option value="miramar" {{ ($mapa ?? '') == 'miramar' ? 'selected' : '' }}>Miramar</option>
                    <option value="rondo" {{ ($mapa ?? '') == 'rondo' ? 'selected' : '' }}>Rondo</option>
                    <option value="todos" {{ ($mapa ?? '') == 'todos' ? 'selected' : '' }}>Todos</option>
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

            {{-- Player Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Nick</th>
                            <th>Partidas</th>
                            <th>Kills</th>
                            <th>Média Kills</th>
                            <th>Média Sobrevivência</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                            @php
                                $playerPerformances = $team->where('player.id', $player->id);
                                $totalMatches = $playerPerformances->count();
                                $totalKills = $playerPerformances->sum('individual_kills');
                                $avgKills = $totalMatches > 0 ? number_format($totalKills / $totalMatches, 1) : 0;
                                $avgSurvival = 0;
                                if ($totalMatches > 0) {
                                    $avgSurvival = number_format($playerPerformances->avg('individual_survive'), 1);
                                }
                            @endphp
                            <tr>
                                <td>{{ $player->name }}</td>
                                <td>{{ $totalMatches }}</td>
                                <td>{{ $totalKills }}</td>
                                <td>{{ $avgKills }}</td>
                                <td>{{ $avgSurvival }}</td>
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
            <a href="{{ route('players.index') }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
