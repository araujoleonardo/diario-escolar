<!doctype html>
<html lang="pt-BR">

<head>
    <title>@yield('title') - Diário Escolar</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('style')

</head>

<body class="dashboard">
    <main>
        <div class="d-flex">
            <!-- Barra Lateral -->
            @include('layouts.dashboard.parts.sidebar')

            <div class="cabecalho-e-conteudo" style="">
                <!-- Cabeçalho -->
                @include('layouts.dashboard.parts.header')

                <!-- Alerta de sucesso útilizando session() do Laravel -->
                @include('layouts.dashboard.parts.bootstrap_alert_success')

                <!-- Alerta de erro útilizando session() do Laravel -->
                @include('layouts.dashboard.parts.bootstrap_alert_erro')

                <!-- Conteúdo do topo, título, botão... -->
                <div class="bg-green-light p-3 pt-4 mt-0 mt-lg-4 text-white "
                    style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px">
                    <div class="container">
                        <div class="row justify-content-lg-between align-items-center">
                            @yield('content-top')
                        </div>
                    </div>
                    <div class="py-4 mt-2"></div>
                </div>

                <!-- Conteúdo -->
                <div class="px-3 pb-5" style="margin-top: -60px">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <!-- JS -->
    @yield('js')
</body>

</html>
