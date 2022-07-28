@extends('layouts.dashboard.app')

@section('title')
    Visualizar datas de provas
@endsection

@section('content-top')
    <h1 class="col-12 col-md-8">
        Visualizar datas de provas
    </h1>
    @canany(['sec_academica', 'professor'])
        <div class="col-12 col-md-4 text-md-end">
            <a name="" id="" class="btn btn-light"
                href="{{ route('datas-de-provas.adicionar', [$turma->id, $disciplina->id]) }}" role="button">
                <i class="fa-solid fa-plus fa-sm text-muted"></i>
                Adicionar Data
            </a>
        </div>
    @endcanany
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Turma: {{ $turma->nome }}, {{ $turma->turno }}</h3>
                        </div>

                        <!-- Tabelas -->
                        @foreach ($datasProvas as $prova)
                            <div class="table-responsive">
                                <table class="table table-bordered text-truncate">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Disciplina</th>
                                            <th>Data</th>
                                            <th>Dia</th>
                                            <th>Horário da Prova</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $prova->disciplina->nome }}</td>
                                            <td>{{ date('d/m/Y', strtotime($prova->data)) }}</td>
                                            <td>{{ $prova->dia }}</td>
                                            <td>{{ date('H\\hi', strtotime($prova->horario)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-4">
                                @canany(['sec_academica', 'professor'])
                                    <form action="{{ route('datas-de-provas.deletar', $prova->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                    </form>
                                @endcanany
                            </div>
                        @endforeach

                        @if (empty($datasProvas->toArray()))
                            <div class="alert alert-danger mt-3" role="alert">
                                <strong>Não existe registros.</strong>
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
