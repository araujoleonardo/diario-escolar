@extends('layouts.dashboard.app')

@section('title', 'Registrar Aula')

@section('content-top')
    <h1 class="col-12">Registrar Aula</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <!-- Formulário -->
            <form action="{{ route('aulas.registrar-aula') }}" method="post">
                @csrf
                <div class="col-12">
                    <div class="card shadow-sm border-0 bg-white rounded-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title h4">Preencha os dados corretamente</h3>

                            </div>

                            <div class="mb-3 col-12 col-md-4">
                                <label for="turma_id" class="form-label">Turma</label>
                                <select class="form-select @error('turma_id') is-invalid @enderror" name="turma_id"
                                    id="turma_id" required>
                                    <option value="" selected>...</option>
                                    @foreach (Auth::user()->professor->turmas as $turma)
                                        <option value="{{ $turma->turma->id }}"
                                            @if (old('turma_id') == $turma->turma->id) selected @endif>
                                            {{ $turma->turma->nome }},
                                            {{ $turma->turma->turno }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('turma_id')
                                    <div class="small fw-bold invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-12 col-md-4">
                                <label for="disciplina_id" class="form-label">Disciplina</label>
                                <select class="form-select @error('disciplina_id') is-invalid @enderror" name="disciplina_id" id="disciplina_id" required>
                                    <option value="" selected>...</option>
                                    @foreach (Auth::user()->professor->disciplinas as $disciplina)
                                        <option value="{{ $disciplina->disciplina->id }}"
                                            @if (old('disciplina_id') == $disciplina->disciplina->id) selected @endif>
                                            {{ $disciplina->disciplina->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('disciplina_id')
                                    <div class="small fw-bold invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label for="nome" class="form-label">Horário da Aula</label>
                                <div class="row px-2">
                                    <div class="col-4 @error('horario_inicio') col-5 @enderror px-1">
                                        <input type="time"
                                            class="form-control @error('horario_inicio') is-invalid @enderror"
                                            name="horario_inicio" id="horario_inicio" value="{{ old('horario_inicio') }}"
                                            required>
                                        @error('horario_inicio')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-1 text-truncate px-0 text-center pt-1">às</div>

                                    <div class="col-4 @error('horario_final') col-5 @enderror px-1">
                                        <input type="time"
                                            class="form-control @error('horario_final') is-invalid @enderror"
                                            name="horario_final" id="horario_final" value="{{ old('horario_final') }}"
                                            required>
                                        @error('horario_final')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success">
                                    Prosseguir
                                    <i class="fa-solid fa-arrow-right fa-sm"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection


@section('js')

    <script>
        // Somar +45min no horário final ao mudar o horário inicial
        document.querySelector('#horario_inicio').onchange = function() {

            let hora = parseInt(this.value.split(':')[0])
            let minutos = parseInt(this.value.split(':')[1])

            let data = new Date();
            data.setHours(hora);
            data.setMinutes(minutos + 45);

            let hora_final = (data.getHours() < 10 ? '0' + data.getHours() : data.getHours())
            let minuto_final = (data.getMinutes() < 10 ? '0' + data.getMinutes() : data.getMinutes())

            let horario_final = (hora_final + ':' + minuto_final)

            document.querySelector('#horario_final').value = horario_final
        }
    </script>

@endsection
