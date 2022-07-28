@extends('layouts.dashboard.app')

@section('title', 'Faltas')

@section('content-top')
    <h1 class="col-12">Faltas</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Selecione uma turma</h3>
                        </div>

                        <form action="{{ route('faltas.consultar-faltas') }}" method="get">
                            <div class="">
                                <div class="mb-3 col-12 col-md-4">
                                    <label for="turma_id" class="form-label">Turma</label>
                                    <select class="form-select" name="turma" id="turma_id">
                                        @foreach ($turmas as $turma)
                                            <option value="{{ $turma->id }}">
                                                {{ $turma->nome }},
                                                {{ $turma->turno }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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
