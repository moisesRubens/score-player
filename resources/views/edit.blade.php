<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Player</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #d9d9d9; /* cor creme */
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 text-center">Editar Player</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Form de edição -->
                    <form action="{{ route('update', $player->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nick</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $player->name }}" required>
                        </div>

                        <!-- Score -->
                        <div class="mb-3">
                            <label for="score" class="form-label">MDMs jogados</label>
                            <input type="number" class="form-control" id="score" name="score" value="{{ $player->score }}" min="0" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
