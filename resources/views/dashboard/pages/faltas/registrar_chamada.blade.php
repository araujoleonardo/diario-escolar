@extends('layouts.dashboard.app')

@section('title', 'Registrar Chamada')

@section('content-top')
    <h1 class="col-12">Registrar Chamada</h1>
@endsection

@section('content')
    <div class="container">

        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="h2">Turma: {{ $turma->nome }}, {{ ucfirst($turma->turno) }}</div>

                        @if ($registroChamadaHoje)

                            <div class="alert alert-primary rounded-3 mt-3" role="alert">
                                <h5 class="mb-3 mt-3">
                                    Registro de chamada feita pelo(a) professor(a)
                                    <strong>{{ $registroChamadaHoje->professor->user->name }} </strong>
                                </h5>
                                <a href="{{ route('faltas.visualizar-chamada', [$turma->id, date('Y-m-d')]) }}"
                                    class="mb-3 btn btn-success rounded-pill px-4">Visualzar</a>
                            </div>
                        @else
                            <div class="h6 mb-4 text-muted">Professor: {{ Auth::user()->name }}</div>
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title h4"><i class="fa-solid fa-calendar-days fa-sm"></i>
                                    {{ date('d/m/Y') }}
                                </h3>
                            </div>

                            <!-- Formulário para salvar faltas dos alunos -->
                            <form action="{{ route('faltas.registrar-faltas', $turma->id) }}" method="post">
                                @csrf
                                <!-- Lista de alunos -->
                                <table class="table table-striped table-inverse table-responsive table-hover">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>#</th>
                                            <th>Nome</th>
                                            <th>Presença</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($turma->alunos as $aluno)
                                            <tr class="@if ($errors->first('alunos') == $aluno->id) alert-danger @endif">
                                                <td>{{ $aluno->id }}</td>
                                                <td>{{ $aluno->user->name }}</td>
                                                <td>
                                                    <input type="radio" class="btn-check"
                                                        name="alunos[{{ $aluno->id }}]" value="sim"
                                                        id="success-outlined{{ $aluno->id }}"
                                                        @if (isset(old('alunos')[$aluno->id]) && old('alunos')[$aluno->id] == 'sim') checked @endif autocomplete="off"
                                                        required>
                                                    <label
                                                        class="btn btn-outline-success btn-sm shadow-none rounded-pill px-3 fw-bold"
                                                        for="success-outlined{{ $aluno->id }}">Sim</label>

                                                    <input type="radio" class="btn-check"
                                                        name="alunos[{{ $aluno->id }}]" value="não"
                                                        id="danger-outlined{{ $aluno->id }}"
                                                        @if (isset(old('alunos')[$aluno->id]) && old('alunos')[$aluno->id] == 'não') checked @endif autocomplete="off">
                                                    <label
                                                        class="btn btn-outline-danger btn-sm shadow-none rounded-pill px-3 fw-bold"
                                                        for="danger-outlined{{ $aluno->id }}">Não</label>

                                                    @if ($errors->first('alunos') == $aluno->id)
                                                        <span class="fw-bold text-danger small ms-2">
                                                            <i class="fa-solid fa-triangle-exclamation fa-sm "></i>
                                                            É necessáro selecionar uma opção.
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                @if ($turma->alunos->count() == 0)
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Não há alunos na turma!</strong>
                                    </div>
                                @endif

                                <div class="">
                                    <button type="submit" class="btn btn-success"
                                        @if ($turma->alunos->count() == 0) disabled @endif>
                                        Salvar Chamada
                                    </button>
                                </div>
                            </form>

                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
