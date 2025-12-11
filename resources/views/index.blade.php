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
            background-color: #d9d9d9; /* cor creme */
        }
        .navbar-brand span {
            color: white;
            font-weight: bold;
        }
        
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="height: 70px;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo.tmp') }}" alt="Logo" width="200" height="150">
            <span>VZ ESPORTS</span>
        </a>
    </div>
</nav>

<div class="container py-5">
    <h1 class="ranking-title text-center mb-4">Ranking de Jogadores</h1>

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
                                <form action="{{ route('addPoint', $player->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">MDM +1</button>
                                </form>
                            </td>

                            <!-- Botão editar -->
                            <td>
                                <a href="{{ route('edit', $player->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            </td>

                            <!-- Botão deletar -->
                            <td>
                                <form action="{{ route('destroy', $player->id) }}" method="POST">
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
        <a href="{{ route('create') }}" class="btn btn-primary">Registrar-se</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
