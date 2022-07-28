@extends('layouts.dashboard.app')

@section('title', 'Período Escolar')

@section('content-top')
    <h1 class="col-12">Período Escolar</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Adicionar Período</h3>
                        </div>

                        <div class="col-12 col-sm-7 col-xl-5 mb-3">
                            <!-- Formulário para cadastro de períodos -->
                            <form action="{{ route('periodo-escolar.store') }}" method="post">
                                @csrf

                                <!-- Nome -->
                                <div class="mb-3 col-12 col-lg-8">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        name="nome" id="nome" value="{{ old('nome') }}" placeholder="1º Bimestre"
                                        required>
                                    @error('nome')
                                        <div class="invalid-feedback small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Datas -->
                                <label for="nome" class="form-label">Datas do período</label>
                                <div class="row px-2">
                                    <div class="col-1 text-truncate px-0 text-center pt-2">De </div>
                                    <div class="col-5 px-1">
                                        <input type="date"
                                            class="form-control @error('data_inicio') is-invalid @enderror"
                                            name="data_inicio" id="data_inicio" value="{{ old('data_inicio') }}" required>
                                        @error('data_inicio')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-1 text-truncate px-0 text-center pt-2">até </div>
                                    <div class="col-5 px-1">
                                        <input type="date" class="form-control @error('data_final') is-invalid @enderror"
                                            name="data_final" id="data_final" value="{{ old('data_final') }}" required>
                                        @error('data_final')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">Adicionar</button>
                                </div>
                            </form>
                        </div>

                        <hr class="my-4">

                        <!-- Tabela com registros de períodos -->
                        <h5 class="mt-3">Registros</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover text-truncate">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Período</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periodos as $periodo)
                                        <tr>
                                            <td>{{ $periodo->nome }}</td>
                                            <td>De <strong>{{ date('d/m/Y', strtotime($periodo->data_inicio)) }}</strong>
                                                até <strong>{{ date('d/m/Y', strtotime($periodo->data_final)) }}</strong>
                                            </td>
                                            <td class="d-flex gap-1">
                                                <div class="">
                                                    <a class="btn btn-warning btn-sm"
                                                        href="{{ route('periodo-escolar.editar', $periodo->id) }}"
                                                        title="Editar">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                </div>
                                                <div class="">
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('periodo-escolar.deletar', $periodo->id) }}"
                                                        title="Deletar">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Paginação -->
                        {{ $periodos->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
@endsection
