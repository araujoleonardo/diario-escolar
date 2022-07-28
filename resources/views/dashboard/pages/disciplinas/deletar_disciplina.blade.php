<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Deletar Disciplina - Diário Escolar</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <div class="card rounded-3">
                    <div class="card-body text-center py-5">


                        <div class="text-center text-danger">
                            <i class="fa-solid fa-triangle-exclamation fa-3x"></i>
                        </div>
                        <h1 class="h3 text-danger">
                            Deletar disciplina <strong class="text-danger">{{ $disciplina->nome }}</strong>?
                        </h1>

                        <p class="text-danger">
                            Cuidado, quando você excluir um registro de disciplina, ele também excluirá todos os
                            registros associados, como notas...
                        </p>

                        <form action="{{ route('disciplinas.deletar', $disciplina->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <div class="mt-3">
                                <button type="submit" class="btn btn-danger">Sim</button>
                                <a href="{{ route('disciplinas.index') }}" class="btn btn-secondary">Não</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
