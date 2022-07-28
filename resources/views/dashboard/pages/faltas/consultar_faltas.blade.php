@extends('layouts.dashboard.app')

@section('title')
    Consultar Faltas da turma: {{ $turmaSelecionada->nome }}, {{ ucfirst($turmaSelecionada->turno) }}
@endsection

@section('content-top')
    <h1 class="col-12">Faltas da turma: {{ $turmaSelecionada->nome }}, {{ ucfirst($turmaSelecionada->turno) }}</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Tabela com faltas e registro de chamadas</h3>
                        </div>

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse text-truncate">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Data</th>
                                        <th>Faltas</th>
                                        <th>Presenças</th>
                                        <th>Professor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turma as $key => $data)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $data->where('falta', true)->count() }}</td>
                                            <td>{{ $data->where('falta', false)->count() }}</td>
                                            <td>{{ $data->first()->professor->user->name }}</td>
                                            <td>
                                                @php
                                                    $turmaId = $turma->first()[0]->turma_id;
                                                    $dataRegistro = $data->first()->created_at->format('Y-m-d');
                                                @endphp
                                                <a href="{{ route('faltas.visualizar-chamada', [$turmaId, $dataRegistro]) }}"
                                                    class="btn btn-success btn-sm"">
                                                    Registro de Chamada
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        {{ $turma->withQueryString()->links() }}

                        @if ($turma->count() == 0)
                            <div class="alert alert-danger" role="alert">
                                <strong>Não existe registros para a turma selecionada!</strong>
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
