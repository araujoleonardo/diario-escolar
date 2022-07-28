<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notas</title>
</head>

<body>

    <!-- Turma -->
    <table class="table">
        <thead>
            <tr>
                <th style="background-color: #026f1c; color: #FFFFFF">
                    <strong>Turma</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $turma->nome }}, {{ $turma->turno }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Disciplina -->
    <table class="table">
        <thead>
            <tr>
                <th style="background-color: #026f1c; color: #FFFFFF">
                    <strong>Disciplina</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $disciplina->nome }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Professores responsáveis pela aplicação -->
    <table class="table">
        <thead>
            <tr>
                <th style="background-color: #026f1c; color: #FFFFFF">
                    <strong>Professores responsáveis pela aplicação das notas</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professoresResponsaveisPelaAplicacao as $notasPorProfessor)
                <tr>
                    <td>
                        {{ $notasPorProfessor->first()->professor->user->name }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Notas de alunos -->
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-inverse">
            <tr>
                <th style="background-color: #026f1c; color: #FFFFFF">
                    <strong>Aluno</strong>
                </th>
                @foreach ($periodos as $periodo)
                    <th class="text-truncate" style="background-color: #026f1c; color: #FFFFFF">
                        <strong>{{ $periodo->nome }}</strong>
                    </th>
                @endforeach
                <th style="background-color: #026f1c; color: #FFFFFF">
                    <strong>Total</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($turma->alunos as $aluno)
                <tr>
                    <td class="text-truncate">
                        {{ $aluno->user->name }}
                    </td>
                    @php
                        $notasAluno = $aluno->notas->where('disciplina_id', $disciplina->id)->where('turma_id', $turma->id);
                    @endphp
                    <!-- Nota por período -->
                    @foreach ($periodos as $periodo)
                        <td class="">
                            @isset($notasAluno->where('escola_periodo_id', $periodo->id)->first()->nota)
                                {{ number_format($notasAluno->where('escola_periodo_id', $periodo->id)->first()->nota, 2, ',', '.') }}
                            @endisset
                        </td>
                    @endforeach
                    <!-- Nota Total -->
                    <td class="" style="font-weight: 600">
                        {{ number_format($notasAluno->sum('nota'), 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
