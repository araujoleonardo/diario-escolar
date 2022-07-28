@extends('layouts.dashboard.app')

@section('title')
    Visualzar chamada da turma: {{ $turma->nome }}, {{ ucfirst($turma->turno) }}
@endsection
@section('content-top')
    <h1 class="col-12">Visualzar chamada da turma: {{ $turma->nome }}, {{ ucfirst($turma->turno) }}</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4"><i class="fa-solid fa-calendar-days fa-sm"></i>
                                {{ date('d/m/Y', strtotime($data)) }}</h3>
                            <div class="">
                                @if ($registroDeChamada->count() != 0)
                                    <a href="{{ route('faltas.exportar-chamada', [$turma->id, $data]) }}"
                                        class="btn btn-outline-dark rounded-pill px-3 btn-sm">
                                        <i class="fa-solid fa-file-export"></i> Exportar PDF
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if ($registroDeChamada->count() == 0)
                            <div class="alert alert-danger mt-4" role="alert">
                                <strong>Não existe registros para a data informada!</strong>
                            </div>
                        @else
                            <div class="">
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
                                        {{-- @foreach ($turma->alunos as $aluno) --}}
                                        @foreach ($registroDeChamada as $registro)
                                            <tr>
                                                <td>{{ $registro->aluno->id }}</td>
                                                <td>{{ $registro->aluno->user->name }}</td>
                                                <td>
                                                    @if ($registro->falta)
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm shadow-none rounded-pill px-3 fw-bold active"
                                                            style="cursor: default">Não</button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-outline-success btn-sm shadow-none rounded-pill px-3 fw-bold active"
                                                            style="cursor: default">Sim</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <!-- Dados do registro -->
                            <div class="mt-5">
                                <table class="table">
                                    <thead>
                                        <tr class="table-dark">
                                            <th>Professor Responsável</th>
                                            <th>Total de Faltas</th>
                                            <th>Total de Presenças</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $registroDeChamada->first()->professor->user->name }}</td>
                                            <td>{{ $registroDeChamada->where('falta', true)->count() }}</td>
                                            <td>{{ $registroDeChamada->where('falta', false)->count() }}</td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
