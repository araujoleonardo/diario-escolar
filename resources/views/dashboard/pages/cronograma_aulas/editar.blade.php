@extends('layouts.dashboard.app')

@section('title')
    Editar tabela de aulas da turma: {{ $turma->nome }}, {{ $turma->turno }}
@endsection

@section('content-top')
    <h1 class="col-12">Editar tabela de aulas da turma: {{ $turma->nome }}, {{ $turma->turno }}</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Aulas</h3>
                        </div>

                        @if ($errors->any())
                            <!-- Erros -->
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse text-truncate text-center table-bordered">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Horário</th>
                                        <th>Segunda</th>
                                        <th>Terça</th>
                                        <th>Quarta</th>
                                        <th>Quinta</th>
                                        <th>Sexta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Editar -->
                                    @foreach ($turma->cronograma_aulas as $item)
                                        <form action="{{ route('cronograma-de-aulas.criar-ou-atualizar', $turma->id) }}"
                                            method="post">
                                            @csrf

                                            <input type="hidden" name="cronograma_aula_id" value="{{ $item->id }}"
                                                required>
                                            <input type="hidden" name="turma_id" value="{{ $turma->id }}" required>
                                            <tr>
                                                <td class="">
                                                    <div class="d-flex gap-1">
                                                        <input type="time"
                                                            class="form-control form-control-sm rounded-pill text-center"
                                                            name="hora_inicio"
                                                            value="{{ date('H:i', strtotime($item->hora_inicio)) }}"
                                                            required>
                                                        ás
                                                        <input type="time"
                                                            class="form-control form-control-sm rounded-pill text-center"
                                                            name="hora_final"
                                                            value="{{ date('H:i', strtotime($item->hora_final)) }}"
                                                            required>
                                                    </div>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="segunda" value="{{ $item->segunda }}" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="terca" value="{{ $item->terca }}" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="quarta" value="{{ $item->quarta }}" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="quinta" value="{{ $item->quinta }}" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="sexta" value="{{ $item->sexta }}" required>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach

                                    <!-- Add -->
                                    @foreach ([1] as $item)
                                        <form action="{{ route('cronograma-de-aulas.criar-ou-atualizar', $turma->id) }}"
                                            method="post">
                                            @csrf

                                            <input type="hidden" name="cronograma_aula_id" value="">
                                            <input type="hidden" name="turma_id" value="{{ $turma->id }}" required>
                                            <tr>
                                                <td class="">
                                                    <div class="d-flex gap-1">
                                                        <input type="time"
                                                            class="form-control form-control-sm rounded-pill text-center"
                                                            name="hora_inicio" required>
                                                        ás
                                                        <input type="time"
                                                            class="form-control form-control-sm rounded-pill text-center"
                                                            name="hora_final" required>
                                                    </div>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="segunda" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="terca" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="quarta" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="quinta" required>
                                                </td>
                                                <td style="min-width: 140px">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        name="sexta" required>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-sm">Adicionar</button>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
