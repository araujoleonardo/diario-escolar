@extends('layouts.dashboard.app')

@section('title', 'Aplicar Notas')

@section('content-top')
    <h1 class="col-12">Aplicar Notas</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Selecione a turma, a disciplina e o período escolar</h3>
                        </div>
                        <form action="{{ route('notas.aplicar-notas-alunos') }}" method="get">
                            <div class="mb-3 col-12 col-md-4">
                                <label for="turma" class="form-label">Turma</label>
                                <select class="form-select @error('turma') is-invalid @enderror" name="turma"
                                    id="turma">
                                    @foreach ($turmas as $turma)
                                        <option value="{{ $turma->id }}"
                                            @if (old('turma') == $turma->id) selected @endif>{{ $turma->nome }},
                                            {{ $turma->turno }}</option>
                                    @endforeach
                                </select>
                                @error('turma')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label for="disciplina" class="form-label">Disciplina</label>
                                <select class="form-select @error('disciplina') is-invalid @enderror" name="disciplina"
                                    id="disciplina">
                                    @foreach ($disciplinas as $disciplina)
                                        <option value="{{ $disciplina->id }}"
                                            @if (old('disciplina') == $disciplina->id) selected @endif>{{ $disciplina->nome }}
                                    @endforeach
                                </select>
                                @error('disciplina')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label for="periodo" class="form-label">Período Escolar</label>
                                <select class="form-select @error('periodo') is-invalid @enderror" name="periodo"
                                    id="periodo">
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}"
                                            @if (old('periodo') == $periodo->id) selected @endif>{{ $periodo->nome }}
                                    @endforeach
                                </select>
                                @error('periodo')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success">
                                    Prosseguir
                                    <i class="fa-solid fa-arrow-right fa-sm"></i>
                                </button>
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
