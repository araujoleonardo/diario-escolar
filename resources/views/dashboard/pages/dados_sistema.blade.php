@extends('layouts.dashboard.app')

@section('title', 'Dados do Sistema')

@section('content-top')
    <h1 class="col-12">Dados do Sistema</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <!-- Cadastro nos últimos meses -->
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="">Cadastro de alunos nos meses de {{ date('Y') }}</h4>
                        <div class="chartjs-wrapper">
                            <canvas id="cadastro-alunos-ultimos-meses"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faltas e presenças nos meses do ano corrente -->
            <div class="col-12 ">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="mb-3">Faltas e presenças nos meses de {{ date('Y') }}</h3>
                            <div class="chartjs-wrapper">
                                <canvas id="faltas-e-presencas-nos-meses-do-ano"></canvas>
                            </div>
                    </div>
                </div>
            </div>

            <!-- Faltas e presenças no último mês -->
            <div class="col-12 col-lg-6 ">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="mb-3">Faltas e presenças no último mês</h4>
                        <div class="chartjs-wrapper">
                            <canvas id="faltas-e-presencas-ultimo-mes"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faltas e presenças nos últimos 7 dias -->
            <div class="col-12 col-lg-6 ">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="mb-3">Faltas e presenças nos últimos 7 dias</h4>
                        <div class="chartjs-wrapper">
                            <canvas id="faltas-e-presencas-7dias"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de alunos por turno -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="card-title">Alunos por turno</h4>
                        <canvas id="total-alunos-por-turno"></canvas>
                    </div>
                </div>
            </div>

            <!-- Total de alunos por sexo -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="card-title">Alunos por sexo</h4>
                        <canvas id="total-alunos-por-sexo"></canvas>
                    </div>
                </div>
            </div>

            <!-- Total de alunos por idade -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body">
                        <h4 class="card-title">Alunos por idade</h4>
                        <canvas id="total-alunos-por-idade"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
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

        /* ==== Faltas e presenças nos meses do ano corrente  ==== */
        var area = document.getElementById("faltas-e-presencas-nos-meses-do-ano").getContext("2d");
        var urChart = new Chart(area, {
            type: 'line',
            data: {
                labels: JSON.parse(`{!! json_encode($faltasPresencasAnoAtual['meses']) !!}`),
                datasets: [{
                    label: "Faltas",
                    pointRadius: 3,
                    fill: true,
                    backgroundColor: 'rgba(253, 197, 6, 0.6)',
                    borderColor: 'rgba(253, 197, 6, 0.6)',
                    data: JSON.parse(`{!! json_encode($faltasPresencasAnoAtual['dadosFaltas']) !!}`)
                }, {
                    label: "Presenças",
                    pointRadius: 3,
                    fill: true,
                    backgroundColor: 'rgba(76, 132, 255, 0.6)',
                    borderColor: 'rgba(76, 132, 255, 0.6)',
                    data: JSON.parse(`{!! json_encode($faltasPresencasAnoAtual['dadosPresencas']) !!}`),
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false
                        },
                        ticks: {
                            display: false, // hide main x-axis line
                            beginAtZero: true
                        },
                        barPercentage: 1.8,
                        categoryPercentage: 0.2
                    }],
                    yAxes: [{
                        gridLines: {
                            drawBorder: false, // hide main y-axis line
                            display: false
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true
                        },
                    }]
                },
                tooltips: {
                    enabled: false
                }
            }
        });

        /* ==== Faltas e presenças no últimos mês ==== */
        var dual = document.getElementById("faltas-e-presencas-ultimo-mes").getContext("2d");
        var urChart = new Chart(dual, {
            type: 'line',
            data: {
                labels: JSON.parse(`{!! json_encode($faltasPresencasUltimoMes['dias']) !!}`),
                datasets: [{
                    label: "Faltas",
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255,255,255,1)',
                    pointBorderWidth: 2,
                    fill: false,
                    backgroundColor: 'transparent',
                    borderColor: '#fdc506',
                    data: JSON.parse(`{!! json_encode($faltasPresencasUltimoMes['dadosFaltas']) !!}`),
                }, {
                    label: "Presenças",
                    fill: false,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255,255,255,1)',
                    pointBorderWidth: 2,
                    backgroundColor: 'transparent',
                    borderColor: '#4c84ff',
                    data: JSON.parse(`{!! json_encode($faltasPresencasUltimoMes['dadosPresencas']) !!}`),
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false
                        },
                        ticks: {
                            display: false, // hide main x-axis line
                            beginAtZero: true
                        },
                        barPercentage: 1.8,
                        categoryPercentage: 0.2
                    }],
                    yAxes: [{
                        gridLines: {
                            drawBorder: false, // hide main y-axis line
                            display: false
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true
                        },
                    }]
                },
                tooltips: {
                    enabled: false
                }
            }
        });

        /* ==== Faltas e presenças nos últimos 7 dias ==== */
        var dual = document.getElementById("faltas-e-presencas-7dias").getContext("2d");
        var urChart = new Chart(dual, {
            type: 'line',
            data: {
                labels: JSON.parse(`{!! json_encode($faltasPresencasUltimosSeteDias['dias']) !!}`),
                datasets: [{
                    label: "Faltas",
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255,255,255,1)',
                    pointBorderWidth: 2,
                    fill: false,
                    backgroundColor: 'transparent',
                    borderColor: '#fdc506',
                    data: JSON.parse(`{!! json_encode($faltasPresencasUltimosSeteDias['dadosFaltas']) !!}`),
                }, {
                    label: "Presenças",
                    fill: false,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255,255,255,1)',
                    pointBorderWidth: 2,
                    backgroundColor: 'transparent',
                    borderColor: '#4c84ff',
                    data: JSON.parse(`{!! json_encode($faltasPresencasUltimosSeteDias['dadosPresencas']) !!}`),
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false
                        },
                        ticks: {
                            display: false, // hide main x-axis line
                            beginAtZero: true
                        },
                        barPercentage: 1.8,
                        categoryPercentage: 0.2
                    }],
                    yAxes: [{
                        gridLines: {
                            drawBorder: false, // hide main y-axis line
                            display: false
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true
                        },
                    }]
                },
                tooltips: {
                    enabled: false
                }
            }
        });

        /* ==== Alunos por turno ==== */
        var totalAlTurno = new Chart(
            document.getElementById('total-alunos-por-turno'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Manhã',
                        'Tarde',
                        'Noite',
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [
                            JSON.parse(`{!! json_encode($alunosPorTurno['manha']) !!}`),
                            JSON.parse(`{!! json_encode($alunosPorTurno['tarde']) !!}`),
                            JSON.parse(`{!! json_encode($alunosPorTurno['noite']) !!}`),
                        ],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {}
            }
        );

        /* ==== Alunos por sexo ==== */
        var totalAlSexo = new Chart(
            document.getElementById('total-alunos-por-sexo'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Masculino',
                        'Feminino',
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [
                            JSON.parse(`{!! json_encode($alunosPorSexo['masculino']) !!}`),
                            JSON.parse(`{!! json_encode($alunosPorSexo['feminino']) !!}`),
                        ],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {}
            }
        );

        /* ==== Alunos por idade ==== */
        var totalAlSexo = new Chart(
            document.getElementById('total-alunos-por-idade'), {
                type: 'doughnut',
                data: {
                    labels: [
                        'Entre 1 e 10 anos',
                        'Entre 10 e 20 anos',
                        'Entre 20 e 30+ anos',
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [
                            JSON.parse(`{!! json_encode($alunosPorIdade['entre1e10']) !!}`),
                            JSON.parse(`{!! json_encode($alunosPorIdade['entre10e20']) !!}`),
                            JSON.parse(`{!! json_encode($alunosPorIdade['entre20e30mais']) !!}`),
                        ],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {}
            }
        );
    </script>


@endsection
