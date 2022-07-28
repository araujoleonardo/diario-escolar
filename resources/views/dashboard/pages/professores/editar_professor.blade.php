@extends('layouts.dashboard.app')

@section('title', 'Editar Professor')

@section('content-top')
    <h1 class="col-12">Editar Professor</h1>

@endsection

@section('content')
    <div class="container">
        <div class="row gy-3">

            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title h4">Preenchar o formulário e salve os dados do professor</h3>
                        </div>

                        <!-- Formulário -->
                        <form action="{{ route('professores.atualizar', $professor->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="row flex-column">

                                <div class="col-12 col-md-5 mb-3">
                                    <label for="nome" class="form-label">Nome do Professor</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        name="nome" id="nome" value="{{ old('nome', $professor->user->name) }}"
                                        required>
                                    @error('nome')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-5 mb-3">
                                    <div for="" class="form-label">Disciplinas</div>
                                    @foreach ($disciplinas as $key => $disciplina)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $disciplina->id }}"
                                                id="disciplina{{ $key }}" name="disciplinas[]"
                                                @if (is_array(old('disciplinas', $professor->disciplinas->pluck('disciplina_id')->toArray())) && in_array($disciplina->id, old('disciplinas', $professor->disciplinas->pluck('disciplina_id')->toArray()))) checked @endif>
                                            <label class="form-check-label" for="disciplina{{ $key }}">
                                                {{ $disciplina->nome }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @empty($disciplinas->toArray())
                                        <div class="fw-bold text-danger small">Não há cadastros de disciplinas</div>
                                    @endempty


                                </div>
                                <div class="col-12 col-md-5 mb-3">
                                    <div for="" class="form-label">Turmas</div>
                                    @foreach ($turmas as $key => $turma)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $turma->id }}"
                                                id="turma{{ $key }}" name="turmas[]"
                                                @if (is_array(old('turmas', $professor->turmas->pluck('turma_id')->toArray())) && in_array($turma->id, old('turmas', $professor->turmas->pluck('turma_id')->toArray()))) checked @endif>
                                            <label class="form-check-label" for="turma{{ $key }}">
                                                {{ $turma->nome }}, {{ $turma->turno }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @empty($turmas->toArray())
                                        <div class="fw-bold text-danger small">Não há cadastros de turmas</div>
                                    @endempty

                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                        name="telefone" id="telefone"
                                        value="{{ old('telefone', $professor->telefone) }}" required>
                                    @error('telefone')
                                        <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-5 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <small class="d-block text-muted lh-sm">O aluno pode fazer login com o Facebook, Google
                                        ou Github que estiver usando esse mesmo e-mail.</small>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email', $professor->user->email) }}"
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
                        <form action="{{ route('professores.modificar-senha', $professor->id) }}" method="post">
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
