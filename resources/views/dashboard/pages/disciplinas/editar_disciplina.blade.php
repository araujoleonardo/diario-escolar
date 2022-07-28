@extends('layouts.dashboard.app')

@section('title', 'Editar Disciplina')

@section('content-top')
    <h1 class="col-12">Editar Disciplina</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">

                        <!-- Formulário add disciplina -->
                        <form action="{{ route('disciplinas.update', $disciplina->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title h4">Disciplina: {{ $disciplina->nome }}</h3>
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        name="nome" id="nome" value="{{ old('nome', $disciplina->nome) }}"
                                        placeholder="Português">
                                    @error('nome')
                                        <div class="invalid-feedback small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')
@endsection
