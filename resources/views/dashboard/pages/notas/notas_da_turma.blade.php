@extends('layouts.dashboard.app')

@section('title')
    Notas da turma: {{ $turma->nome }}, {{ $turma->turno }}
@endsection

@section('content-top')
    <h1 class="col-12 col-lg-9">Notas da turma: {{ $turma->nome }}, {{ $turma->turno }}</h1>
    <div class="col-12 col-lg-3 text-lg-end">
        <a href="{{ route('notas.exportar-notas', [$turma->id, $disciplina->id]) }}" class="btn btn-light">
            <i class="fa-regular fa-file-excel text-muted"></i> Exportar
        </a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h3 mb-3">{{ $disciplina->nome }}</h3>
                        </div>

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Aluno</th>
                                        @foreach ($periodos as $periodo)
                                            <th class="text-truncate">{{ $periodo->nome }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turma->alunos as $aluno)
                                        <tr>
                                            <td class="text-truncate">
                                                {{ $aluno->user->name }}
                                                <a href="{{ route('alunos.visualizar', $aluno->id) }}" target="_blank"
                                                    class="text-secondary" title="Visualizar">
                                                    <i class="fa-solid fa-square-arrow-up-right"></i>
                                                </a>
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
                        </div>

                        @empty($turma->alunos->toArray())
                            <div class="alert alert-danger" role="alert">
                                <strong>Não tem alunos para a turma selecionada.</strong>
                            </div>
                        @endempty

                        @empty(!$professoresResponsaveisPelaAplicacao->toArray())
                            <div class=" mt-3">
                                <h3 class="h5">Professores responsáveis pela aplicação das notas</h3>
                                <ul class="">
                                    @foreach ($professoresResponsaveisPelaAplicacao as $notasPorProfessor)
                                        <li class="">{{ $notasPorProfessor->first()->professor->user->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endempty

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
