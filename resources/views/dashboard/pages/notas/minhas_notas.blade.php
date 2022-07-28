@extends('layouts.dashboard.app')

@section('title')
    Minhas Notas
@endsection

@section('content-top')
    <h1 class="col-12">Minhas Notas</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h3 mb-3">{{ Auth::user()->name }}</h3>
                        </div>

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover text-truncate">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Disciplina</th>
                                        @foreach ($periodos as $periodo)
                                            <th class="text-truncate]">{{ $periodo->nome }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notas as $nota)
                                        <tr>
                                            <td>{{ $nota->first()->disciplina->nome }}</td>
                                            <!-- Nota por período -->
                                            @foreach ($periodos as $periodo)
                                                <td class="">
                                                    @isset($nota->where('escola_periodo_id', $periodo->id)->first()->nota)
                                                        {{ number_format($nota->where('escola_periodo_id', $periodo->id)->first()->nota, 2, ',', '.') }}
                                                    @endisset
                                                </td>
                                            @endforeach

                                            <!-- Nota Total -->
                                            <td class="" style="font-weight: 600">
                                                {{ number_format($nota->sum('nota'), 2, ',', '.') }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @empty($notas->toArray())
                            <div class="alert alert-danger" role="alert">
                                <strong>Não tem notas registradas.</strong>
                            </div>
                        @endempty

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
