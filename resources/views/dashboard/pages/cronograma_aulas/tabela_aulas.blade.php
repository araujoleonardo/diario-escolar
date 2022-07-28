@extends('layouts.dashboard.app')

@section('title')
    Tabela de aulas da turma: {{ $turma->nome }}, {{ $turma->turno }}
@endsection

@section('content-top')
    <h1 class="col-12">Tabela de aulas da turma: {{ $turma->nome }}, {{ $turma->turno }}</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Aulas</h3>
                        </div>

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse text-truncate text-center table-bordered">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Horário</th>
                                        <th>Segunda</th>
                                        <th>Terça</th>
                                        <th>Quarta</th>
                                        <th>Quinta</th>
                                        <th>Sexta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turma->cronograma_aulas as $item)
                                        <tr>
                                            <td>
                                                {{ date('H\\hi', strtotime($item->hora_inicio)) }}
                                                ás
                                                {{ date('H\\hi', strtotime($item->hora_final)) }}
                                            </td>
                                            <td>{{ $item->segunda }}</td>
                                            <td>{{ $item->terca }}</td>
                                            <td>{{ $item->quarta }}</td>
                                            <td>{{ $item->quinta }}</td>
                                            <td>{{ $item->sexta }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (empty($turma->cronograma_aulas->toArray()))
                            <div class="alert alert-danger" role="alert">
                                <strong>Não existe registros.</strong>
                            </div>
                        @endif

                        @can('sec_academica_e_professor')
                            <div class="text-end">
                                <a href="{{ route('cronograma-de-aulas.editar', $turma->id) }}" id=""
                                    class="btn btn-success mt-2">
                                    Editar ou adicionar
                                </a>
                            </div>
                        @endcan

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
