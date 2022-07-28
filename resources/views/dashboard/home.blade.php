@extends('layouts.dashboard.app')

@section('title', 'Painel')

@section('content-top')
    <h1 class="col-12">Painel</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">
            @canany(['sec_academica', 'professor'])
                <!-- Cadastro de alunos -->
                <div class="col-12 col-lg-8 ">
                    <div class="card shadow-sm border-0 bg-white rounded-3 h-100">
                        <div class="card-body">
                            <h2 class="h4">Cadastro de alunos nos meses de {{ date('Y') }}</h2>
                            <div class="chartjs-wrapper">
                                <canvas id="cadastro-alunos-ultimos-meses"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endcanany

            @can('aluno')
                <!-- Cadastro de alunos -->
                <div class="col-12 col-lg-8 ">
                    <div class="card shadow-sm border-0 bg-white rounded-3">
                        <div class="card-body">
                            <h1 class="mb-4">Olá, seja bem-vindo!</h1>
                            <div class="row gy-3">

                                <!-- Meus dados -->
                                <div class="col-12 col-lg-6">
                                    <div class="text-white text-center shadow-sm py-4 px-3"
                                        style="background-color: #41a7f4; border-radius: 12px">
                                        <div class="py-1">
                                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                                Meus Dados
                                            </h2>
                                            <a href="{{ route('meus-dados') }}"
                                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                                <i class="fa-regular fa-user mx-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Datas de provas -->
                                <div class="col-12 col-lg-6">
                                    <div class="text-white text-center shadow-sm py-4 px-3"
                                        style="background-color: #f9c04e; border-radius: 12px">
                                        <div class="py-1">
                                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                                Datas de provas
                                            </h2>
                                            <a href="{{ route('datas-de-provas.selecionar-turma-disciplina') }}"
                                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                                <i class="fa-regular fa-calendar-check mx-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Minhas Faltas -->
                                <div class="col-12 col-lg-6">
                                    <div class="text-white text-center shadow-sm py-4 px-3"
                                        style="background-color: #8870d9; border-radius: 12px">
                                        <div class="py-1">
                                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                                Minhas Faltas
                                            </h2>
                                            <a href="{{ route('alunos.faltas-aluno', Auth::user()->aluno->id) }}"
                                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                                <i class="fa-solid fa-ban mx-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Minhas Notas -->
                                <div class="col-12 col-lg-6">
                                    <div class="text-white text-center shadow-sm py-4 px-3"
                                        style="background-color: #2ccdc9; border-radius: 12px">
                                        <div class="py-1">
                                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                                Minhas Notas
                                            </h2>
                                            <a href="{{ route('notas.minhas-notas') }}"
                                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                                <i class="fa-solid fa-list-check mx-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- Dias que faltam para finalizar o período escolar -->
            <div class="col-12 col-lg-4 ">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <h2 class="card-title h5">
                            Dias que faltam para finalizar o:
                            {{ $diasParaFinalizarPeriodoEscolar ? $diasParaFinalizarPeriodoEscolar['periodoAtual']->nome : 'XXX' }}.
                        </h2>
                        <div id="canvas-holder" style="width:100%;">
                            <canvas id="chart-area"></canvas>
                        </div>
                        <div class="text-muted text-center mt-1" title="Data de encerramento do período.">
                            <i class="fa-regular fa-calendar-days fa-sm"></i>
                            {{ $diasParaFinalizarPeriodoEscolar ? date('d/m/Y', strtotime($diasParaFinalizarPeriodoEscolar['periodoAtual']->data_final)) : 'X/X/X' }}
                        </div>
                    </div>
                </div>
            </div>

            @canany(['professor', 'sec_academica'])
                <!-- Cadastrar Aluno -->
                <div class="col-12 col-lg-4">
                    <div class="text-white text-center shadow-sm py-4 px-3"
                        style="background-color: #41a7f4; border-radius: 12px">
                        <div class="py-1">
                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                Cadastrar Aluno
                            </h2>
                            <a href="{{ route('alunos.cadastrar') }}"
                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                <i class="fa-solid fa-user-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endcanany
            @can('sec_academica')
                <!-- Cadastrar Professor -->
                <div class="col-12 col-lg-4">
                    <div class="text-white text-center shadow-sm py-4 px-3"
                        style="background-color: #f9c04e; border-radius: 12px">
                        <div class="py-1">
                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                Cadastrar Professor
                            </h2>
                            <a href="{{ route('professores.cadastrar') }}"
                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                <i class="fa-solid fa-user-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Adicionar Turma -->
                <div class="col-12 col-lg-4">
                    <div class="text-white text-center shadow-sm py-4 px-3"
                        style="background-color: #8870d9; border-radius: 12px">
                        <div class="py-1">
                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                Adicionar Turma
                            </h2>
                            <a href="{{ route('turmas.adicionar') }}"
                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                <i class="fa-solid fa-square-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            @can('professor')
                <!-- Registrar Aula -->
                <div class="col-12 col-lg-4">
                    <div class="text-white text-center shadow-sm py-4 px-3"
                        style="background-color: #f9c04e; border-radius: 12px">
                        <div class="py-1">
                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                Registrar Aula
                            </h2>
                            <a href="{{ route('aulas.registrar-aula') }}"
                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                <i class="fa-solid fa-file-pen"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Aplicar Nota -->
                <div class="col-12 col-lg-4">
                    <div class="text-white text-center shadow-sm py-4 px-3"
                        style="background-color: #8870d9; border-radius: 12px">
                        <div class="py-1">
                            <h2 class="h4 mb-3 text-uppercase lh-sm">
                                Aplicar Nota
                            </h2>
                            <a href="{{ route('notas.aplicar-notas') }}"
                                class="btn btn-outline-light btn-lg rounded-pill px-4 border-2">
                                <i class="fa-solid fa-file-signature"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            @canany(['sec_academica', 'professor'])
                <!-- Tabela alunos -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 bg-white rounded-3">
                        <div class="card-body">
                            <h3 class="card-title h4">Últimos alunos cadastrados</h3>

                            <!-- Tabela com alunos -->
                            <div class=" table-responsive">
                                <table class="table table-striped table-inverse text-truncate">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Nome do aluno</th>
                                            <th>Turma</th>
                                            <th>Idade</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ultimosAlunosCadastrados as $aluno)
                                            <tr>
                                                <td>{{ $aluno->user->name }}</td>
                                                <td>{{ $aluno->turma->nome }}, {{ $aluno->turma->turno }}</td>
                                                <td>{{ idade($aluno->dt_nascimento) }} anos</td>
                                                <td>{{ $aluno->user->email }}</td>
                                                <td>{{ $aluno->telefone }}</td>
                                                <td class="">
                                                    <div class="d-flex gap-1">
                                                        <div class="">
                                                            <a href="{{ route('alunos.visualizar', $aluno->id) }}"
                                                                class="btn btn-success btn-sm"
                                                                title="Visualizar dados do aluno">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        <div class="">
                                                            <a href="{{ route('alunos.editar', $aluno->id) }}"
                                                                class="btn btn-warning btn-sm" title="Editar dados do aluno">
                                                                <i class="fa-solid fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="">
                                                            <a href="{{ route('alunos.faltas-aluno', $aluno->id) }}"
                                                                class="btn btn-info btn-sm " title="Visualizar faltas">
                                                                <span class="material-symbols-outlined fs-6"> do_not_touch
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="">
                                                            <a href="{{ route('alunos.deletar', $aluno->id) }}"
                                                                class="btn btn-danger btn-sm" title="Deletar registro">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @empty($ultimosAlunosCadastrados->toArray())
                                <div class="">
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Não existe registros.</strong>
                                    </div>
                                </div>
                            @else
                                <div class="">
                                    <a name="" id="" class="btn btn-success btn-sm rounded-pill px-4"
                                        href="{{ route('alunos.index') }}" role="button">
                                        <i class="fa-solid fa-people-group fa-sm me-1"></i>
                                        Exibir Todos
                                    </a>
                                </div>
                            @endempty

                        </div>
                    </div>
                </div>
            @endcanany

        </div>
    </div>
@endsection

@section('js')

    @canany(['sec_academica', 'professor'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            /*===== Cadastro de alunos nos útlimos meses =====*/
            var barX = document.getElementById("cadastro-alunos-ultimos-meses").getContext('2d');
            var myChart = new Chart(barX, {
                type: 'bar',
                data: {
                    labels: JSON.parse(`{!! json_encode($cadastroDeAlunosAnoAtual['meses']) !!}`),
                    datasets: [{
                        label: '',
                        data: JSON.parse(`{!! json_encode($cadastroDeAlunosAnoAtual['dados']) !!}`),
                        backgroundColor: '#64c5b1',
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false
                            },
                            ticks: {
                                color: '#6c757d'
                            },
                            barPercentage: 1.8,
                            categoryPercentage: 0.2
                        },
                        y: {
                            grid: {
                                drawBorder: false, // hide main y-axis line
                                display: false,
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        }
                    },
                    tooltips: {
                        enabled: false
                    }
                }
            });
        </script>
    @endcanany

    <script type="module">
        // js radial
        import chartjsChartRadialGauge from "https://cdn.skypack.dev/chartjs-chart-radial-gauge@1.1.0";
        Chart.defaults.global.defaultFontFamily = "Verdana";

        var ctx = document.getElementById("chart-area").getContext("2d");
        var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, "#64c5b1");
        gradientStroke.addColorStop(1, "#4c84ff");

        var config = {
            type: "radialGauge",
            data: {
                labels: ["Dias corridos"],
                datasets: [{
                    data: [{!! $diasParaFinalizarPeriodoEscolar ? $diasParaFinalizarPeriodoEscolar['totalDiasCorridosAteAgora'] : 0 !!}],
                    backgroundColor: [gradientStroke],
                    borderWidth: 0,
                    label: "Score",
                }]
            },
            options: {
                responsive: true,
                legend: {},
                domain: [0, {!! $diasParaFinalizarPeriodoEscolar ? $diasParaFinalizarPeriodoEscolar['totalDias'] : 0 !!}],
                title: {
                    display: false,
                    text: "Radial gauge chart"
                },
                centerArea: {
                    text: "{!! $diasParaFinalizarPeriodoEscolar ? $diasParaFinalizarPeriodoEscolar['diasFaltam'] : 0 !!}",
                    subText: 'Dias que faltam',
                    fontSize: 25,
                },
                centerPercentage: 77
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("chart-area").getContext("2d");
            window.myRadialGauge = new Chart(ctx, config);
        };
    </script>

@endsection
