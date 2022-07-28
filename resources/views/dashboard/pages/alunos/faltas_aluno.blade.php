@extends('layouts.dashboard.app')

@section('title', 'Faltas do aluno')

@section('content-top')
    <h1 class="col-12 col-md-8">Faltas do aluno</h1>

    <div class="col-12 col-lg-4 text-lg-end">
        <a href="{{ route('alunos.expotar-faltas-aluno', $aluno->id) }}" class="btn btn-light">
            <i class="fa-solid fa-download fa-sm text-muted"></i>
            Baixar Relatório
        </a>
    </div>

@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">


            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">
                                {{ $aluno->user->name }}
                                @can('sec_academica_e_professor')
                                    <a href="{{ route('alunos.visualizar', $aluno->id) }}" target="_blank" class=""><i
                                            class="fa-solid fa-square-arrow-up-right fa-sm text-success"></i></a>
                                @endcan
                            </h3>
                        </div>
                        @php
                            $mesPT = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                        @endphp
                        {{-- <h1>{{date('m n N  -- M')}} --- {{$mesPT[date('n')]}}</h1> --}}
                        @foreach ($periodos as $periodo)
                            <div class="mt-3">
                                <div class="">
                                    <div class="fs-5">
                                        {{ $periodo->nome }}, De {{ date('d', strtotime($periodo->data_inicio)) }} de
                                        {{ $mesPT[date('n', strtotime($periodo->data_inicio))] }}
                                        a
                                        {{ date('d', strtotime($periodo->data_final)) }} de
                                        {{ $mesPT[date('n', strtotime($periodo->data_final))] }}
                                    </div>
                                    <div class="fs-4 fw-bold">
                                        {{ $aluno->faltas->where('falta', true)->whereBetween('created_at', [$periodo->data_inicio, $periodo->data_final])->count() }}
                                        Faltas
                                    </div>
                                </div>
                                <div class="col-2 border-top border-secondary mt-2"></div>
                            </div>
                        @endforeach

                        @if (empty($periodos->toArray()))
                            <div class="alert alert-danger" role="alert">
                                <strong>Não existe período escolar registrado.</strong>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
