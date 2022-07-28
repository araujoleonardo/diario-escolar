@extends('layouts.front.app')

@section('title', 'Entrar')

@section('style')
    <style>
        body {
            background: #cff4ff
        }
    </style>
@endsection

@section('content')
    <div class="container pb-5 pb-lg-2">
        <div class=" row justify-content-center">
            <div class="col-12 col-lg-4 pt-5" style="max-width: 350px">
                <!-- card -->
                <div class="card shadow border-0" style="border-radius: 30px">
                    <div class="card-body p-4">

                        <div class="rounded-pill shadow d-flex"
                            style="background:#f2f2f2; width: 90px; height: 90px; position: absolute; top: -45px; left: calc(50% - 45px)">
                            <i class="fa-solid fa-user fa-3x m-auto text-white"></i>
                        </div>

                        <div class="text-center fs-4 text-muted mb-3 pt-4">
                            <div class="pt-2">
                                {{ __('Login') }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class=" mb-3">
                                <label for="email"
                                    class=" col-form-label visually-hidden">{{ __('Email Address') }}</label>

                                <div class="">
                                    <input id="email" type="email"
                                        class="rounded-pill form-control px-3 py-2 bg-light @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="password"
                                    class=" col-form-label visually-hidden ">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="rounded-pill form-control px-3 py-2 bg-light @error('password') is-invalid @enderror"
                                        name="password" placeholder="Senha" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="visually-hidden">
                                <div class=" ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            checked>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class=" mb-0">
                                <div class=" ">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                        {{ __('Login') }}
                                    </button>

                                    <div class="text-center mt-2">
                                        @if (Route::has('password.request'))
                                            <a class="text-muted" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Login com redes sociais -->
                <div class="shadow px-4 pb-2 pt-1 bg-white mx-auto text-center"
                    style="max-width: 200px; border-bottom-left-radius: 30px; border-bottom-right-radius: 30px">
                    <div class="text-muted mb-1" style="font-size: 11px">Ou entrar com:</div>
                    <div class="">
                        <a href="{{ route('oauth.redirect', 'facebook') }}"
                            class="text-dark text-decoration-none hover-scale" title="Facebook">
                            <i class="fa-brands fa-facebook fs-4"></i>
                        </a>
                        <a href="{{ route('oauth.redirect', 'google') }}"
                            class="text-dark text-decoration-none hover-scale" title="Google">
                            <i class="fa-brands fa-google fs-4"></i>
                        </a>
                        <a href="{{ route('oauth.redirect', 'github') }}"
                            class="text-dark text-decoration-none hover-scale" title="Github">
                            <i class="fa-brands fa-github fs-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
