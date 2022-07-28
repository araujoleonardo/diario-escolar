@extends('layouts.dashboard.app')

@section('title')
    Aulas do {{ $turma->nome }}, {{ ucfirst($turma->turno) }}
@endsection

@section('content-top')
    <h1 class="col-12">Aulas do {{ $turma->nome }}, {{ ucfirst($turma->turno) }}</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Tabelas com todas as aulas registradas</h3>
                        </div>

                        <!-- Tabelas com registros de aulas -->
                        @foreach ($aulasDivididasPorData as $key => $aulasData)
                            <h5 class="h3 mt-4"><i class="fa-solid fa-calendar-days fa-sm"></i> {{ $key }}</h5>
                            <!-- Tabela -->
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse text-truncate">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Professor</th>
                                            <th>Disciplina</th>
                                            <th>Horário da Aula</th>
                                            <th>Data do registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aulasData as $aula)
                                            <tr>
                                                <td>{{ $aula->professor->user->name }}</td>
                                                <td>{{ $aula->disciplina->nome }}</td>
                                                {{-- <td>07h às 07h45</td> --}}
                                                <td>
                                                    {{ date('H\\hi', strtotime(date('Y-m-d ' . $aula->horario_inicio))) }}
                                                    às
                                                    {{ date('H\\hi', strtotime(date('Y-m-d ' . $aula->horario_final))) }}
                                                </td>
                                                <td>
                                                    {{ $aula->created_at->format('d/m/Y à\\s H:i') }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="">
                                <a href="{{ route('faltas.visualizar-chamada', [$turma->id, date('Y-m-d', strtotime(str_replace('/', '-', $key)))]) }}"
                                    class="btn btn-success btn-sm"">
                                    Registro de Chamada
                                </a>
                            </div>
                        @endforeach

                        <!-- Paginação -->
                        {{ $aulasDivididasPorData->withQueryString()->links() }}

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
