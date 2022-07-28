@extends('layouts.dashboard.app')

@section('title', 'Meus Dados')

@section('content-top')
    <h1 class="col-12">Meus Dados</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Editar Meus Dados</h3>
                        </div>

                        @can('sec_academica')
                            <!-- Formulário para secretaria acadêmica -->
                            <form action="{{ route('meus-dados.atualizar', ['perfil' => 'sec_academica']) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row flex-column">

                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                            required>
                                        @error('name')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <small class="d-block text-muted lh-sm">
                                            Você pode fazer login com o Facebook, Google ou Github que estiver usando esse mesmo
                                            e-mail.
                                        </small>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                            required>
                                        @error('email')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                    </div>

                                </div>
                            </form>
                        @endcan

                        @can('professor')
                            <!-- Formulário para professor -->
                            <form action="{{ route('meus-dados.atualizar', ['perfil' => 'professor']) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row flex-column">

                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                            required>
                                        @error('name')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                            name="telefone" id="telefone"
                                            value="{{ old('telefone', Auth::user()->professor->telefone) }}" required>
                                        @error('telefone')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <small class="d-block text-muted lh-sm">
                                            Você pode fazer login com o Facebook, Google ou Github que estiver usando esse mesmo
                                            e-mail.
                                        </small>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                            required>
                                        @error('email')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                    </div>

                                </div>
                            </form>
                        @endcan

                        @can('aluno')
                            <!-- Formulário para aluno -->
                            <form action="{{ route('meus-dados.atualizar', ['perfil' => 'aluno']) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row flex-column">

                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                            required>
                                        @error('name')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="dt_nascimento" class="form-label">Data de nascimento</label>
                                        <input type="date" class="form-control @error('dt_nascimento') is-invalid @enderror"
                                            name="dt_nascimento" id="dt_nascimento"
                                            value="{{ old('dt_nascimento', Auth::user()->aluno->dt_nascimento) }}" required>
                                        @error('dt_nascimento')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                            name="telefone" id="telefone"
                                            value="{{ old('telefone', Auth::user()->aluno->telefone) }}" required>
                                        @error('telefone')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <small class="d-block text-muted lh-sm">
                                            Você pode fazer login com o Facebook, Google ou Github que estiver usando esse mesmo
                                            e-mail.
                                        </small>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                            required>
                                        @error('email')
                                            <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                    </div>

                                </div>
                            </form>
                        @endcan

                        <!-- Modificar Senha -->
                        <form action="{{ route('meus-dados.modificar-senha') }}" class="pt-1" method="post">
                            @method('PUT')
                            @csrf
                            <h5 class="mt-4">Modificar Senha</h5>

                            <div class="row flex-column">
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="current_password" class="form-label">Senha Atual</label>
                                    <input type="password"
                                        class="form-control  bg-white rounded-3 @error('current_password') is-invalid @enderror"
                                        name="current_password" id="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" value="{{ old('password') }}" required>
                                    @error('password')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" id="password_confirmation"
                                        value="{{ old('password_confirmation') }}" required>
                                    @error('password_confirmation')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="">
                                    <button type="submit" class="btn btn-success">Salvar nova senha</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')

    <!-- Jquery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Jquery Mask CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Config Jquery Mask para inputs -->
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
        });
    </script>

@endsection
