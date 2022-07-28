<!doctype html>
<html lang="pt-BR">

<head>
    <title>Completar Pefil</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <!-- Conteúdo Principal -->
    <main class="py-4">
        <div class="container py-5 mx-auto col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Complete seu perifl</h4>

                    <!-- Formulário -->
                    <form action="{{ route('completar-perfil.salvar-dados') }}" method="post">
                        @csrf
                        <div class="row flex-column">

                            <div class="col-12 col-md-8 mb-3">
                                <label for="turma" class="form-label">Turma</label>
                                <select class="form-select @error('turma') is-invalid @enderror" name="turma"
                                    id="turma" required>
                                    <option value="" selected>Selecione uma turma</option>
                                    @foreach ($turmas as $turma)
                                        <option value="{{ $turma->id }}"
                                            @if (old('turma') == $turma->id) selected @endif>
                                            {{ $turma->nome }}, {{ $turma->turno }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('turma')
                                    <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label for="dt_nascimento" class="form-label">Data de nascimento</label>
                                <input type="date" class="form-control @error('dt_nascimento') is-invalid @enderror"
                                    name="dt_nascimento" id="dt_nascimento" value="{{ old('dt_nascimento') }}"
                                    required>
                                @error('dt_nascimento')
                                    <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-5 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                    name="telefone" id="telefone" value="{{ old('telefone') }}" required>
                                @error('telefone')
                                    <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-5 mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-select @error('sexo') is-invalid @enderror" name="sexo"
                                    id="sexo">
                                    <option value="" selected>Selecione um sexo</option>
                                    <option value="masculino" @if (old('sexo') == 'masculino') selected @endif>
                                        Maculino
                                    </option>
                                    <option value="feminino" @if (old('sexo') == 'feminino') selected @endif>
                                        Feminino
                                    </option>
                                </select>
                                @error('sexo')
                                    <small class="invalid-feedback fw-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

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
</body>

</html>
