<header>
    <nav class="navbar navbar-light pt-lg-4 px-lg-2 ">
        <div class="container d-flex flex-nowrap">
            <button class="navbar-toggler d-lg-none border-0" type="button"
                onclick="document.getElementById('barra-lateral').classList.toggle('show')"
                aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class=" d-flex justify-content-between w-100" id="collapsibleNavId">
                @canany(['sec_academica', 'professor'])
                    <!-- Pesquisar -->
                    <div class="d-none d-lg-block">
                        <form action="{{ route('alunos.index') }}" method="get">
                            <div class="input-group border rounded-pill div-pesquisar bg-light">
                                <input type="text" value="{{ request()->get('nome') }}"
                                    class="form-control ps-3 bg-light border-0 rounded-pill input-pesquisar"
                                    placeholder="Buscar aluno" aria-label="Buscar aluno" name="nome">
                                <button type="submit" class="btn btn-light rounded-pill shadow-none px-3">
                                    <span class="visually-hidden">Pesquisar</span>
                                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Pesquisa para celulares... -->
                    <div class="fixed-top bg-white py-4 px-3 border-bottom shadow d-flex d-none d-lg-none"
                        id="pesquisa-mobile" style="display: none">


                        <form action="{{ route('alunos.index') }}" class="d-block w-100" method="get">
                            <div class="d-flex justify-content-center w-100">
                                <button type="button" class="btn btn-none shadow-none"
                                    onclick="document.getElementById('pesquisa-mobile').classList.toggle('d-none')">
                                    <span class="visually-hidden">Fechar pesquisa</span>
                                    <i class="fa-solid fa-xmark fa-lg"></i>
                                </button>

                                <div class="input-group border rounded-pill div-pesquisar bg-light">

                                    <input type="text" value="{{ request()->get('nome') }}"
                                        class="form-control ps-3 bg-light border-0 rounded-pill input-pesquisar"
                                        placeholder="Buscar aluno" aria-label="Buscar aluno" name="nome">
                                    <button type="submit" class="btn btn-light rounded-pill shadow-none px-3">
                                        <span class="visually-hidden">Pesquisar</span>
                                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                @endcanany

                <!-- Lista navbar -->
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <!-- Dropdow Usuários -->
                    <li class="nav-item dropdown d-flex flex-nowrap align-items-center d-lg-inline-block">

                        @canany(['sec_academica', 'professor'])
                            <!-- btn para abrir pesquisa -->
                            <button type="button" class="nav-link px-3 d-block btn btn-none shadow-none d-lg-none"
                                onclick="document.getElementById('pesquisa-mobile').classList.toggle('d-none')">
                                <span class="visually-hidden">Pesquisar</span>
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </button>
                        @endcanany

                        <a id="navbarDropdown" class="nav-link d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <span class="img-thumbnail d-flex me-1 rounded-pill" style="width: 30px; height:30px;">
                                <i class="m-auto fa-solid fa-user text-muted"></i>
                            </span>
                            {{ Auth::user()->name }}

                            <i class="fa-solid fa-angle-down ms-1" style="font-size: 11px"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-user dropdown-menu-end pt-0 border-0 shadow"
                            aria-labelledby="navbarDropdown">
                            <div class="dropdown-header bg-neptune text-white pb-3 ">
                                {{ Auth::user()->meuPerfil() }}
                                <div class="fs-5">
                                    {{ Auth::user()->name }}
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('meus-dados') }}">
                                <i class="fa-regular fa-user fa-sm"></i>
                                Meus dados
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket fa-sm"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
