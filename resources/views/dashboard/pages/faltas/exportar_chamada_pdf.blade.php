<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de chamada</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .text-gray {
            color: rgb(64, 66, 69)
        }

        .table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 100%
        }

        .table th,
        .table td {
            padding: 5px 10px;
            text-align: left
        }

        .btn {
            border-radius: 25px;

            padding: 0.25rem 0.8rem;
            font-size: .875rem;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-success {
            color: #fff;
            background-color: #198754;
            border-color: #198754;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table thead {
            background-color: #212529;
            color: #FFF;
        }
    </style>
</head>

<body>
    <!-- Título -->
    <h1 style="text-align: center; margin-bottom: 5px; padding: 0">Diário Escolar</h1>
    <div class="" style="border-bottom: 1px solid #000; width: 80px; margin: 0 auto"></div>

    <h2 style="text-align: center">
        Registro de chamada da turma: {{ $turma->nome }}, {{ ucfirst($turma->turno) }}
    </h2>

    <h3 style="margin-bottom: 5px">
        Data: {{ date('d/m/Y', strtotime($data)) }}
    </h3>

    <!-- Lista de alunos -->
    <table class="table table-striped table-inverse table-responsive mt-3">
        <thead class="thead-inverse">
            <tr class="table-dark">
                <th>#</th>
                <th>Nome do Aluno</th>
                <th>Presença</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registroDeChamada as $registro)
                <tr>
                    <td>{{ $registro->aluno->id }}</td>
                    <td>{{ $registro->aluno->user->name }}</td>
                    <td>
                        @if ($registro->falta)
                            <button type="button"
                                class="btn btn-danger btn-sm shadow-none rounded-pill px-3 fw-bold active"
                                style="cursor: default">Não</button>
                        @else
                            <button type="button"
                                class="btn btn-success btn-sm shadow-none rounded-pill px-3 fw-bold active"
                                style="cursor: default">Sim</button>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Dados do registro -->
    <div class="mt-5" style="margin-top: 30px">
        <table class="table">
            <thead>
                <tr class="table-dark">
                    <th>Professor Responsável</th>
                    <th>Total de Faltas</th>
                    <th>Total de Presenças</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #f2f2f2;">
                    <td>{{ $registroDeChamada->first()->professor->user->name }}</td>
                    <td>{{ $registroDeChamada->where('falta', true)->count() }}</td>
                    <td>{{ $registroDeChamada->where('falta', false)->count() }}</td>
                </tr>


            </tbody>
        </table>

    </div>


</body>

</html>
