<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="{{ url('/') }}">
                Diário Escolar
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto text-center text-lg-start">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item me-lg-3">
                                <a class="nav-link text-primary " style="font-weight: 600"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class=" btn btn-primary px-3 rounded-3" style="font-weight: 600"
                                    href="{{ route('register') }}">Cadastre-se</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <div class="d-flex align-items-center " style="margin-left: -3px">
                                        <span class="material-symbols-outlined fs-5 me-1">
                                            dashboard
                                        </span>
                                        Painel
                                    </div>
                                </a>
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
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
