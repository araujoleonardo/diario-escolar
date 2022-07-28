@extends('layouts.dashboard.app')

@section('title', 'Visualizar dados do aluno')

@section('content-top')
    <h1 class="col-12">Visualizar dados do aluno</h1>

@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">

                        <!-- Lista com dados do aluno -->
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="">Nome do aluno:</div>
                                <div class="fs-4 fw-bold">{{ $aluno->user->name }}</div>
                            </li>

                            <li class="list-group-item">
                                <div class="">Turma:</div>
                                <div class="fs-4 fw-bold">{{ $aluno->turma->nome }}, {{ $aluno->turma->turno }}</div>
                            </li>

                            <li class="list-group-item">
                                <div class="">Data de nascimento:</div>
                                <div class="fs-4 fw-bold">{{ date('d/m/Y', strtotime($aluno->dt_nascimento)) }}</div>
                            </li>
                            <li class="list-group-item">
                                <div class="">Idade:</div>
                                <div class="fs-4 fw-bold">{{ idade($aluno->dt_nascimento) }} anos</div>
                            </li>
                            <li class="list-group-item">
                                <div class="">Email:</div>
                                <div class="fs-4 fw-bold">{{ $aluno->user->email }}</div>
                            </li>

                            <li class="list-group-item">
                                <div class="">Telefone:</div>
                                <div class="fs-4 fw-bold">{{ $aluno->telefone }}</div>
                            </li>

                            <li class="list-group-item">
                                <div class="">Sexo:</div>
                                <div class="fs-4 fw-bold">{{ ucfirst($aluno->sexo) }}</div>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
