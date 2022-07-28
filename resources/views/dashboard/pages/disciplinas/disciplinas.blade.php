@extends('layouts.dashboard.app')

@section('title', 'Disciplinas')

@section('content-top')
    <h1 class="col-12">Disciplinas</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">

                        <!-- Formulário add disciplina -->
                        <form action="{{ route('disciplinas.store') }}" method="post">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title h4">Adicionar Disciplina</h3>
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        name="nome" id="nome" value="{{ old('nome') }}" placeholder="Português">
                                    @error('nome')
                                        <div class="invalid-feedback small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success">Adicionar</button>
                            </div>

                        </form>

                        <hr class="my-4">

                        <!-- Tabela -->
                        <h5 class="mt-3">Lista de disciplinas</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Nome</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($disciplinas as $disciplina)
                                        <tr>
                                            <td>{{ $disciplina->nome }}</td>
                                            <td class="d-flex gap-1">
                                                <div class="">
                                                    <a name="" id="" class="btn btn-warning btn-sm"
                                                        href="{{ route('disciplinas.editar', $disciplina->id) }}"
                                                        role="button" title="Editar">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                </div>
                                                <div class="">
                                                    <a href="{{ route('disciplinas.deletar', $disciplina->id) }}"
                                                        class="btn btn-danger btn-sm" title="Deletar">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="">
                            {{ $disciplinas->links() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')

@endsection
