<div class="barra-lateral fixed-top" id="barra-lateral">
    <!-- btn toggle -->
    <button type="button" class="btn btn-light bg-white btn-fechar-menu d-inline-block d-lg-none"
        onclick="document.getElementById('barra-lateral').classList.toggle('show')">
        <i class="fa-solid fa-angles-left text-muted"></i>
    </button>
    <aside>
        <div class="p-4">
            <a href="/" class="fs-5 fw-bold text-decoration-none text-dark">Diário Escolar</a>
        </div>

        <div class="menu-links">
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('home') }}"
                        class="{{ !Route::Is('home') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                        <span class="material-symbols-outlined fs-5 me-2">
                            dashboard
                        </span>
                        Painel
                    </a>
                </li>
                @canany(['professor', 'sec_academica'])
                    <li>
                        <a class="menu-link d-inline-block px-4 py-2 d-flex align-items-center" data-bs-toggle="collapse"
                            href="#submenu-alunos" role="button" aria-expanded="false" aria-controls="submenu-alunos">
                            <span class="material-symbols-outlined fs-5 me-2"> groups </span>
                            Alunos
                            <i class="fa-solid fa-angle-down ms-auto" style="font-size: 11px"></i>
                        </a>
                        <!-- Submenu alunos -->
                        <div class="collapse {{ !Route::Is('alunos.*') ?: 'show' }}" id="submenu-alunos">
                            <div class="border-bottom border-top bg-light">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{ route('alunos.index') }}"
                                            class="{{ !Route::Is('alunos.index') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                            <span class="material-symbols-outlined fs-5 me-2 ms-3"> list_alt </span>
                                            Todos
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('alunos.cadastrar') }}"
                                            class="{{ !Route::Is('alunos.cadastrar') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                            <span class="material-symbols-outlined fs-5 me-2 ms-3"> person_add </span>
                                            Cadastrar Aluno
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endcanany

                @can('sec_academica')
                    <li>
                        <a class="menu-link d-inline-block px-4 py-2 d-flex align-items-center" data-bs-toggle="collapse"
                            href="#submenu-professores" role="button" aria-expanded="false"
                            aria-controls="submenu-professores">
                            <span class="material-symbols-outlined fs-5 me-2"> group </span>
                            Professores
                            <i class="fa-solid fa-angle-down ms-auto" style="font-size: 11px"></i>
                        </a>
                        <!-- Submenu professores -->
                        <div class="collapse {{ !Route::Is('professores.*') ?: 'show' }} " id="submenu-professores">
                            <div class="border-bottom border-top bg-light">
                                <a href="{{ route('professores.index') }}"
                                    class="{{ !Route::Is('professores.index') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                    <span class="material-symbols-outlined fs-5 me-2 ms-3"> list_alt </span>
                                    Todos
                                </a>
                                <a href="{{ route('professores.cadastrar') }}"
                                    class="{{ !Route::Is('professores.cadastrar') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                    <span class="material-symbols-outlined fs-5 me-2 ms-3"> person_add </span>
                                    Cadastrar Professor
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('turmas.index') }}"
                            class="{{ !Route::Is('turmas.*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> group_work </span>
                            Turmas
                        </a>
                    </li>
                @endcan
                @canany(['professor', 'sec_academica'])
                    <li>
                        @can('sec_academica')
                            <a class="{{ !Route::Is('aulas.*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center"
                                href="{{ route('aulas.index') }}">
                                <span class="material-symbols-outlined fs-5 me-2"> library_books </span>
                                Consultar Aulas
                            </a>
                        @endcan
                        @can('professor')
                            <a class="menu-link d-inline-block px-4 py-2 d-flex align-items-center" data-bs-toggle="collapse"
                                href="#submenu-aulas" role="button" aria-expanded="false" aria-controls="submenu-aulas">
                                <span class="material-symbols-outlined fs-5 me-2"> library_books </span>
                                Aulas
                                <i class="fa-solid fa-angle-down ms-auto" style="font-size: 11px"></i>
                            </a>
                            <!-- Submenu aulas -->
                            <div class="collapse {{ !Route::Is('aulas.*') ?: 'show' }} " id="submenu-aulas">
                                <div class="border-bottom border-top bg-light">
                                    <a href="{{ route('aulas.index') }}"
                                        class="{{ !Route::Is('aulas.index') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-5 me-2 ms-3"> library_books </span>
                                        Consultar Aulas
                                    </a>

                                    <a href="{{ route('aulas.registrar-aula') }}"
                                        class="{{ !Route::Is('aulas.registrar-aula') ?: 'active' }}  menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-5 me-2 ms-3"> edit_note </span>
                                        Registrar Aula
                                    </a>
                                </div>
                            </div>
                        @endcan

                    </li>
                    <li>
                        <a href="{{ route('faltas.index') }}"
                            class="{{ !Route::Is('faltas.*') ?: Route::Is('faltas.registrar-chamada') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> do_not_touch </span>
                            Faltas
                        </a>
                    </li>
                @endcanany
                @canany(['professor', 'sec_academica'])
                    <li>
                        @can('sec_academica')
                            <a href="{{ route('notas.consultar-notas') }}"
                                class="{{ !Route::Is('notas.consultar-nota*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                <span class="material-symbols-outlined fs-5 me-2"> list_alt </span>
                                Consultar Nota
                            </a>
                        @endcan
                        @can('professor')
                            <a class=" menu-link d-inline-block px-4 py-2 d-flex align-items-center" data-bs-toggle="collapse"
                                href="#submenu-notas" role="button" aria-expanded="false" aria-controls="submenu-notas">
                                <span class="material-symbols-outlined fs-5 me-2"> note_alt </span>
                                Notas
                                <i class="fa-solid fa-angle-down ms-auto" style="font-size: 11px"></i>
                            </a>
                            <!-- Submenu professores -->
                            <div class="collapse {{ !Route::Is('notas.*') ?: 'show' }} " id="submenu-notas">
                                <div class="border-bottom border-top bg-light">
                                    <a href="{{ route('notas.consultar-notas') }}"
                                        class="{{ !Route::Is('notas.consultar-nota*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-5 me-2 ms-3"> list_alt </span>
                                        Consultar Nota
                                    </a>
                                    <a href="{{ route('notas.aplicar-notas') }}"
                                        class="{{ !Route::Is('notas.aplicar-nota*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-5 me-2 ms-3"> list_alt </span>
                                        Aplicar Nota
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </li>
                @endcanany
                @can('sec_academica')
                    <li>
                        <a href="{{ route('periodo-escolar') }}"
                            class="{{ !Route::Is('periodo-escola*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> date_range </span>
                            Período Escolar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('disciplinas.index') }}"
                            class="{{ !Route::Is('disciplinas.*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> collections_bookmark </span>
                            Disciplinas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dados-do-sistema') }}"
                            class="{{ !Route::Is('dados-do-sistema') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> leaderboard </span>
                            Dados do Sistema
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="{{ route('cronograma-de-aulas.selecionar-turma') }}"
                        class="{{ !Route::Is('cronograma-de-aulas.*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                        <span class="material-symbols-outlined fs-5 me-2"> table </span>
                        Cronograma de Aulas
                    </a>
                </li>

                <li>
                    <a href="{{ route('datas-de-provas.selecionar-turma-disciplina') }}"
                        class="{{ !Route::Is('datas-de-provas.*') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                        <span class="material-symbols-outlined fs-5 me-2"> event </span>
                        Datas de Provas
                    </a>
                </li>
                @can('aluno')
                    <li>
                        <a href="{{ route('alunos.faltas-aluno', Auth::user()->aluno->id) }}"
                            class="{{ !Route::Is('alunos.faltas-aluno') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> do_not_touch </span>
                            Minhas Faltas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notas.minhas-notas') }}"
                            class="{{ !Route::Is('notas.minhas-notas') ?: 'active' }} menu-link d-inline-block px-4 py-2 d-flex align-items-center">
                            <span class="material-symbols-outlined fs-5 me-2"> list_alt </span>
                            Minhas Notas
                        </a>
                    </li>
                @endcan

            </ul>
        </div>

    </aside>
</div>
