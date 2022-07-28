@extends('layouts.front.app')

@section('title', 'Cadastre-se')

@section('style')
    <style>
        body {
            background: #cff4ff
        }
        .navbar {
            display: none
        }
    </style>
@endsection

@section('content')
    <div class="container pb-5 pb-lg-2 mt-4">
        
        <div class="row justify-content-center pt-5">
            <div class="col-12 col-lg-4 pt-2 pb-4" style="max-width: 370px">
                <div class="card shadow border-0 pb-2" style="border-radius: 30px;">

                    <div class="card-body p-4 ">

                        <div class="text-center">
                            <h1 class="h5 fw-bold mb-4">Cadastro de Sec. Academica</h1>
                        </div>

                        <form method="POST" action="{{ route('registro-sec-academica') }}">
                            @csrf

                            <div class=" mb-3">
                                <label for="name"
                                    class=" col-form-label visually-hidden text-md-end">{{ __('Name') }}</label>

                                <div class="">
                                    <input id="name" type="text"
                                        class="rounded-pill form-control px-3 py-2 bg-light @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name"
                                        placeholder="Nome" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="email"
                                    class=" col-form-label visually-hidden text-md-end">{{ __('Email Address') }}</label>

                                <div class="">
                                    <input id="email" type="email"
                                        class="rounded-pill form-control px-3 py-2 bg-light @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Email" required
                                        autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="password"
                                    class=" col-form-label visually-hidden text-md-end">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="rounded-pill form-control px-3 py-2 bg-light @error('password') is-invalid @enderror"
                                        placeholder="Senha" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="password-confirm"
                                    class=" col-form-label visually-hidden text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="">
                                    <input id="password-confirm" type="password"
                                        class="rounded-pill form-control px-3 py-2 bg-light" name="password_confirmation"
                                        placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class=" mb-0">
                                <div class=" ">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
