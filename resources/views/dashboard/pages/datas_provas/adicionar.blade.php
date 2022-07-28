@extends('layouts.dashboard.app')

@section('title', 'Adicionar data de prova')

@section('content-top')
    <h1 class="col-12">Adicionar data de prova</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="">
                            <h3 class="card-title h4">Disciplina: {{ $disciplina->nome }}</h3>

                            <form action="{{ route('datas-de-provas.adicionar', [$turma->id, $disciplina->id]) }}"
                                method="post">
                                @csrf
                                <div class="row flex-column">

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="data" class="form-label">Data</label>
                                        <input type="date" class="form-control @error('data') is-invalid @enderror"
                                            name="data" id="data" value="{{ old('data') }}" required>
                                        @error('data')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="dia" class="form-label">Dia</label>
                                        <input type="text" class="form-control @error('dia') is-invalid @enderror"
                                            name="dia" id="dia" value="{{ old('dia') }}"
                                            placeholder="Segunda-feira" required>
                                        @error('dia')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-2 mb-3">
                                        <label for="horario" class="form-label">Horário da Prova</label>
                                        <input type="time" class="form-control @error('horario') is-invalid @enderror"
                                            name="horario" id="horario" value="{{ old('horario') }}" required>
                                        @error('horario')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button type="submit" class="btn btn-success">Adicionar</button>

                                    </div>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')

@endsection
