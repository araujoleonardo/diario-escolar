@extends('layouts.dashboard.app')

@section('title', 'Editar dados do aluno')

@section('content-top')
    <h1 class="col-12">Editar dados do aluno</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Preenchar o formulário e salve os dados do aluno</h3>
                        </div>

                        <!-- Formulário para atualizar dados do aluno -->
                        <form action="{{ route('alunos.atualizar', $aluno->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row flex-column">

                                <div class="col-12 col-md-5 mb-3">
                                    <label for="nome" class="form-label">Nome do aluno</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        name="nome" id="nome" value="{{ old('nome', $aluno->user->name) }}"
                                        required>
                                    @error('nome')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-5 mb-3">
                                    <label for="turma_id" class="form-label">Turma</label>
                                    <select class="form-select @error('turma_id') is-invalid @enderror" name="turma_id"
                                        id="turma_id">
                                        <option value="" selected>Selecione uma turma</option>
                                        @foreach ($turmas as $turma)
                                            <option value="{{ $turma->id }}"
                                                @if (old('turma_id', $aluno->turma->id) == $turma->id) selected @endif>
                                                {{ $turma->nome }}, {{ $turma->turno }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('turma_id')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="dt_nascimento" class="form-label">Data de nascimento</label>
                                    <input type="date" class="form-control @error('dt_nascimento') is-invalid @enderror"
                                        name="dt_nascimento" id="dt_nascimento"
                                        value="{{ old('dt_nascimento', $aluno->dt_nascimento) }}" required>
                                    @error('dt_nascimento')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                        name="telefone" id="telefone" value="{{ old('telefone', $aluno->telefone) }}"
                                        required>
                                    @error('telefone')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <select class="form-select @error('sexo') is-invalid @enderror" name="sexo"
                                        id="sexo" required>
                                        <option value="" selected>Selecione um sexo</option>
                                        <option value="masculino" @if (old('sexo', $aluno->sexo) == 'masculino') selected @endif>
                                            Maculino
                                        </option>
                                        <option value="feminino" @if (old('sexo', $aluno->sexo) == 'feminino') selected @endif>
                                            Feminino
                                        </option>
                                    </select>
                                    @error('sexo')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-5 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <small class="d-block text-muted lh-sm">O aluno pode fazer login com o Facebook, Google
                                        ou Github que estiver usando esse mesmo e-mail.</small>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email', $aluno->user->email) }}"
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

                        <!-- Formulário para modificar senha -->
                        <form action="{{ route('alunos.modificar-senha', $aluno->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <h5 class="mt-4">Modificar Senha</h5>

                            <div class="row flex-column">
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <input type="text" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" value="{{ old('password') }}" required>
                                    @error('password')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input type="text"
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
