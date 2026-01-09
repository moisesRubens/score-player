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
            background-color: #eeeeee;
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


    <div class="container my-5">
        <div class="card shadow mx-auto" style="max-width: 800px;">
            <div class="card-header bg-primary text-white fw-semibold">
                Cadastro de Partidas
            </div>

            <div class="card-body">
                
                <form method="post" action="{{ route('partidas.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pontuação final</label>
                            <input type="text" name="score" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Colocação</label>
                            <input type="text" name="placing" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mapa</label>
                        <select class="form-select" name="map">
                            <option selected disabled>Mapa</option>
                            <option>Erangel</option>
                            <option>Miramar</option>
                            <option>Rondo</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Jogador</th>
                                    <th>Kills</th>
                                    <th>Tempo de Sobrevivência</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($players as $player)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $player->name }}
                                        <input type="hidden" name="players[{{ $player->id }}][id]" value="{{ $player->id }}">
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control form-control-sm text-center"
                                            name="players[{{ $player->id }}][kills]"
                                            placeholder="0">
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            min="0"
                                            step="1"
                                            class="form-control form-control-sm text-center"
                                            name="players[{{ $player->id }}][survival_minutes]"
                                            placeholder="Minutos">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Adicionar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>