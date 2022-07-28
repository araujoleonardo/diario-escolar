@extends('layouts.dashboard.app')

@section('title', 'Adicionar Turma')

@section('content-top')
    <h1 class="col-12">Adicionar Turma</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Preenchar todos os campos do formulário</h3>
                        </div>

                        <!-- Formulário -->
                        <form action="{{ route('turmas.adicionar') }}" method="post">
                            @csrf
                            <div class="row flex-column">

                                <div class="col-12 col-md-5 mb-3">
                                    <label for="nome" class="form-label">Série/Abecedário</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        name="nome" id="nome" value="{{ old('nome') }}" placeholder="1º ano A"
                                        required>
                                    @error('nome')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-5 mb-3">
                                    <div for="" class="form-label">Turno</div>
                                    <div class="form-check">
                                        <input class="form-check-input  @error('turno') is-invalid @enderror" type="radio"
                                            name="turno" value="manhã" id="flexRadioDefault1" required="required"
                                            {{ old('turno') == 'manhã' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Manhã
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input  @error('turno') is-invalid @enderror" type="radio"
                                            name="turno" value="tarde" id="flexRadioDefault2"
                                            {{ old('turno') == 'tarde' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Tarde
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input  @error('turno') is-invalid @enderror" type="radio"
                                            name="turno" value="noite" id="flexRadioDefault3"
                                            {{ old('turno') == 'noite' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            Noite
                                        </label>
                                    </div>
                                        @error('turno')
                                            <small class="invalid-feedback d-block fw-bold">{{ $message }}</small>
                                        @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Adicionar Turma</button>
                                </div>

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
