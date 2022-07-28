@extends('layouts.dashboard.app')

@section('title')
    Aplicar notas da turma: {{ $turma->nome }}
@endsection

@section('content-top')
    <h1 class="col-12">Aplicar notas da turma: {{ $turma->nome }}, {{ $turma->turno }}</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h3 class="card-title h4">
                                {{ $disciplina->nome }} - {{ $periodo->nome }}
                            </h3>
                        </div>

                        <!-- Tabela aplicar notas -->
                        <div class="table-responsive">
                            <table
                                class="table table-striped table-borderded table-sm table-inverse table-responsive table-hover text-truncate">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Aluno</th>
                                        <th class="text-truncate]">Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turma->alunos as $aluno)
                                        <tr>
                                            <td style="width: 300px">
                                                {{ $aluno->user->name }}
                                                <a href="{{ route('alunos.visualizar', $aluno->id) }}" target="_blank"
                                                    class="text-secondary"><i
                                                        class="fa-solid fa-square-arrow-up-right"></i></a>
                                            </td>

                                            <td>
                                                <!-- Formulário add nota do aluno -->
                                                <form class="d-flex gap-2 align-items-center"
                                                    action="{{ route('notas.salvar-nota-aluno') }}" method="post">
                                                    @csrf
                                                    <div class="" style="min-width: 60px">
                                                        <!-- Valor da nota -->
                                                        <label for="nota{{ $aluno->id }}" class="visually-hidden">
                                                            Valor da nota
                                                        </label>
                                                        <input type="text" id="nota{{ $aluno->id }}"
                                                            class="form-control input-nota @error('nota') @if (old('aluno_id') == $aluno->id) is-invalid @endif @enderror"
                                                            name="nota" placeholder="0,00" style="max-width: 100px"
                                                            value="@php 
                                                            // Verificar se o valor old() é o mesma o aluno
                                                            if(old('aluno_id') == $aluno->id) {
                                                                echo old('nota');
                                                            } else {
                                                                // Se não existir valor old(), tenta localizar se este aluno já tem nota
                                                                $notaAluno= $aluno->notas
                                                                    ->where('disciplina_id', $disciplina->id)
                                                                    ->where('turma_id', $turma->id)
                                                                    ->where('escola_periodo_id', $periodo->id)
                                                                    ->first();

                                                                // Exibe a nota se já tiver
                                                                if(isset($notaAluno->nota)) {
                                                                    echo $notaAluno->nota;
                                                                }
                                                            }
                                                            @endphp"
                                                            required>
                                                        @error('nota')
                                                            <div class="invalid-feedback small fw-bold">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="d-flex gap-2 align-items-center btn-sm">
                                                        <!-- ID da turma -->
                                                        <input type="hidden" name="turma_id" value="{{ $turma->id }}">
                                                        <!-- ID da disciplina -->
                                                        <input type="hidden" name="disciplina_id"
                                                            value="{{ $disciplina->id }}">
                                                        <!-- ID do período escolar -->
                                                        <input type="hidden" name="escola_periodo_id"
                                                            value="{{ $periodo->id }}">
                                                        <!-- ID do aluno -->
                                                        <input type="hidden" value="{{ $aluno->id }}" name="aluno_id">
                                                        <button type="submit" class="btn btn-success shadow-none px-3">
                                                            Aplicar
                                                        </button>
                                                        @php
                                                            $seJaExisteNota = $aluno->notas
                                                                ->where('disciplina_id', $disciplina->id)
                                                                ->where('turma_id', $turma->id)
                                                                ->where('escola_periodo_id', $periodo->id)
                                                                ->first();
                                                        @endphp
                                                        @isset($seJaExisteNota->nota)
                                                            <i class="fa-solid fa-circle-check text-success fa-lg"></i>
                                                        @endisset
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @empty($turma->alunos->toArray())
                            <div class="alert alert-danger" role="alert">
                                <strong>Não tem alunos para a turma selecionada.</strong>
                            </div>
                        @endempty

                        @empty(!$professoresResponsaveisPelaAplicacao->toArray())
                            <div class=" mt-5">
                                <h3 class="h5">Professores responsáveis pela aplicação das notas</h3>
                                <ul class="">
                                    @foreach ($professoresResponsaveisPelaAplicacao as $notasPorProfessor)
                                        <li class="">{{ $notasPorProfessor->first()->professor->user->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endempty

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <!-- Jquery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Jquery Mask CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Config Jquery Mask para inputs -->
    <script>
        $(document).ready(function() {
            $('.input-nota').mask('00,00', ['0,00', '00,00']);
        });
    </script>
@endsection
