@extends('layouts.dashboard.app')

@section('title', 'Turmas')

@section('content-top')
    <h1 class="col-12 col-lg-6">Turmas</h1>
    <div class="col-12 col-lg-6 text-lg-end">
        <a name="" id="" class="btn btn-light" href="{{ route('turmas.adicionar') }}" role="button">
            <i class="fa-solid fa-plus fa-sm text-muted"></i>
            Adicionar Turma
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
                            <h3 class="card-title h4">Tumas Adicionadas</h3>
                            <div class="d-flex align-items-center">
                                <span class="text-muted text-truncate me-2 text-uppercase small"
                                    style="font-weight: 600"><strong>{{ $turmas->total() }}</strong>
                                    Turmas</span>
                            </div>
                        </div>

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse ">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th class="text-truncate" style="">Série/Abecedário</th>
                                        <th style="">Turno</th>
                                        <th style="">Alunos</th>
                                        <th style="">Professores</th>
                                        <th style=""></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turmas as $turma)
                                        <tr>
                                            <td class="text-truncate" style="width: 180px">{{ $turma->nome }}</td>
                                            <td style="width: 150px"> {{ ucfirst($turma->turno) }} </td>
                                            <td style="width: 150px"> {{ $turma->alunos->count() }} </td>
                                            <td style="width: 150px"> {{ $turma->alocacao_professor_turma->count() }} </td>
                                            <td class="" style="">
                                                <div class="d-flex gap-1">
                                                    <div class="">
                                                        <a href="{{ route('turmas.editar', $turma->id) }}"
                                                            class="btn btn-warning btn-sm"
                                                            title="Editar dados do professor">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </a>
                                                    </div>

                                                    <div class="">
                                                        <a href="{{ route('turmas.deletar', $turma->id) }}"
                                                            class="btn btn-danger btn-sm" title="Deletar registro">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="">
                            {{ $turmas->links() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
