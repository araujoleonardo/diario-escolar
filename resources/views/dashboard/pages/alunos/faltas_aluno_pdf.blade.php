<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faltas</title>
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
    </style>
</head>

<body>
    <!-- Título -->
    <h1 style="text-align: center; margin-bottom: 5px; padding: 0">Diário Escolar</h1>
    <div class="" style="border-bottom: 1px solid #000; width: 80px; margin: 0 auto"></div>

    <!-- Dados do aluno -->
    <h2 style="margin-bottom: 0">Dados do aluno</h2>
    <div class="text-gray" style="font-size: 1em; margin: 7px 0">
        Aluno:
        <span style="text-decoration: underline">{{ $aluno->user->name }}</span>
    </div>
    <div class="text-gray" style="font-size: 1em; margin: 7px 0">
        Turma:
        <span style="text-decoration: underline">{{ $aluno->turma->nome }}, {{ $aluno->turma->turno }}</span>
    </div>
    <div class="text-gray" style="font-size: 1em; margin: 7px 0">
        Email:
        <span style="text-decoration: underline">{{ $aluno->user->email }}</span>
    </div>
    <div class="text-gray" style="font-size: 1em; margin: 7px 0">
        Telefone:
        <span style="text-decoration: underline">{{ $aluno->telefone }}</span>
    </div>
    <div class="text-gray" style="font-size: 1em; margin: 7px 0">
        Data de nascimento:
        <span style="text-decoration: underline">{{ date('d/m/Y', strtotime($aluno->dt_nascimento)) }}</span>
    </div>

    <!-- Registro de faltas -->
    <h2 style="margin-bottom: 0">Registro de faltas</h2>
    <div class="text-gray" style="font-size: 1.1em; margin: 7px 0">
        Total de faltas:
        <span style="text-decoration: underline">{{ $aluno->faltas->where('falta', true)->count() }}</span>
    </div>

    <!-- Tabelas -->
    @php
        $mesPT = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    @endphp
    @foreach ($periodos as $periodo)
        <table class="table" border="1">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center">
                        {{ $periodo->nome }}, De {{ date('d', strtotime($periodo->data_inicio)) }} de
                        {{ $mesPT[date('n', strtotime($periodo->data_inicio))] }}
                        a
                        {{ date('d', strtotime($periodo->data_final)) }} de
                        {{ $mesPT[date('n', strtotime($periodo->data_final))] }}
                    </th>
                </tr>
                <tr>
                    <th>Data de registro da falta</th>
                    <th>Professor responsável pela aplicação</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $faltasAluno = $aluno
                        ->faltas()
                        ->orderBy('created_at', 'asc')
                        ->where('falta', true)
                        ->whereBetween('created_at', [$periodo->data_inicio, $periodo->data_final])
                        ->get();
                @endphp
                @foreach ($faltasAluno as $falta)
                    <tr>
                        <td>{{ $falta->created_at->format('d/m/Y') }}</td>
                        <td>{{ $falta->professor->user->name }} {{ $falta->professor->user->id }}</td>
                    </tr>
                @endforeach

                @empty($faltasAluno->toArray())
                    <tr>
                        <td colspan="2">Sem registros</td>
                    </tr>
                @endempty
            </tbody>
        </table>
    @endforeach

</body>

</html>
