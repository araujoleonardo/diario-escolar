@extends('layouts.dashboard.app')

@section('title', 'Professores')

@section('content-top')
    <h1 class="col-12 col-lg-8">Professores</h1>
    <div class="col-12 col-lg-4 text-lg-end">
        <a name="" id="" class="btn btn-light" href="{{ route('professores.cadastrar') }}" role="button">
            <i class="fa-solid fa-plus fa-sm text-muted"></i>
            Cadastrar Professor
        </a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap">
                            <h3 class="card-title h4">
                                @if (request()->get('q'))
                                    {{ $professores->total() }}
                                    Resultado{{ $professores->total() > 1 ? 's' : '' }}
                                    para &quot;{{ request()->get('q') }}&quot;
                                @else
                                    Professores cadastrados
                                @endif
                            </h3>
                            <div class="d-flex align-items-center">
                                @if (!request()->get('q'))
                                    <span class="text-muted text-truncate me-2 text-uppercase small"
                                        style="font-weight: 600"><strong>{{ $professores->total() }}</strong>
                                        Cadastros</span>
                                @endif

                                <!-- Pesquisar professor -->
                                <div class="">
                                    <form action="{{ route('professores.index') }}" method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control " placeholder="Buscar Professor"
                                                name="q" value="{{ request()->get('q') }}">
                                            <button class="btn btn-light shadow-none border" type="submit">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- Tabela Professores -->
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse text-truncate">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th class="text-truncate">Nome do professor</th>
                                        <th>Disciplina(s) </th>
                                        <th>Turmas</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professores as $professor)
                                        <tr>
                                            <td class="text-truncate">{{ $professor->user->name }}</td>
                                            <td>
                                                @foreach ($professor->disciplinas as $key => $disciplinas)
                                                    {{ $disciplinas->disciplina->nome . (array_key_last($professor->disciplinas->toArray()) != $key ? ',' : '') }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($professor->turmas as $key => $turmas)
                                                    {{ $turmas->turma->nome }}
                                                    {{ array_key_last($professor->turmas->toArray()) != $key ? '|' : '' }}
                                                @endforeach
                                            </td>
                                            <td class="text-truncate">{{ $professor->telefone }}</td>
                                            <td>{{ $professor->user->email }}</td>
                                            <td class="">
                                                <div class="d-flex gap-1">
                                                    <div class="">
                                                        <a href="{{ route('professores.editar', $professor->id) }}"
                                                            class="btn btn-warning btn-sm"
                                                            title="Editar dados do professor">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </a>
                                                    </div>

                                                    <div class="">
                                                        <a href="{{ route('professores.deletar', $professor->id) }}"
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
                            {{ $professores->withQueryString()->links() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
