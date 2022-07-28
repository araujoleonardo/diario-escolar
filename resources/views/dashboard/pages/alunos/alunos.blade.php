@extends('layouts.dashboard.app')

@section('title', 'Alunos')

@section('content-top')
    <h1 class="col-12 col-md-8">
        Alunos
    </h1>
    <div class="col-12 col-md-4 text-lg-end">
        <a name="" id="" class="btn btn-light" href="{{ route('alunos.cadastrar') }}" role="button">
            <i class="fa-solid fa-plus fa-sm text-muted"></i>
            Cadastrar Aluno
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
                            <h3 class="card-title h4">
                                @if (request()->get('nome'))
                                    {{ $alunos->total() }}
                                    Resultado{{ $alunos->total() > 1 ? 's' : '' }}
                                    para &quot;{{ request()->get('nome') }}&quot;
                                @else
                                    Alunos cadastrados
                                @endif
                            </h3>
                            <span class="text-muted text-uppercase small"
                                style="font-weight: 600"><strong>{{ $alunos->total() }}</strong>
                                Cadastros</span>
                        </div>

                        <!-- Tabela com alunos -->
                        <div class=" table-responsive">
                            <table class="table table-striped table-inverse text-truncate">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Nome do aluno</th>
                                        <th>Turma</th>
                                        <th>Idade</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alunos as $aluno)
                                        <tr>
                                            <td>{{ $aluno->user->name }}</td>
                                            <td>{{ $aluno->turma->nome }}, {{ $aluno->turma->turno }}</td>
                                            <td>{{ idade($aluno->dt_nascimento) }} anos</td>
                                            <td>{{ $aluno->user->email }}</td>
                                            <td>{{ $aluno->telefone }}</td>
                                            <td class="">
                                                <div class="d-flex gap-1">
                                                    <div class="">
                                                        <a href="{{ route('alunos.visualizar', $aluno->id) }}"
                                                            class="btn btn-success btn-sm"
                                                            title="Visualizar dados do aluno">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="">
                                                        <a href="{{ route('alunos.editar', $aluno->id) }}"
                                                            class="btn btn-warning btn-sm" title="Editar dados do aluno">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </a>
                                                    </div>
                                                    <div class="">
                                                        <a href="{{ route('alunos.faltas-aluno', $aluno->id) }}"
                                                            class="btn btn-info btn-sm " title="Visualizar faltas">
                                                            <span class="material-symbols-outlined fs-6"> do_not_touch
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="">
                                                        <a href="{{ route('alunos.deletar', $aluno->id) }}"
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
                            {{ $alunos->withQueryString()->links() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
