@extends('layouts.front.app')

@section('title', 'Diário Escolar')

@section('content')
    <div class="container">
        <div class=" row align-items-center">
            <div class="col-12 col-lg-5 order-1 order-lg-0">
                <h1 class=" fw-bold text-primary titulo-inicio">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                </h1>
                <div
                    style="height: 5px;width: 150px; background: #f88081; border-bottom-left-radius:10px; border-top-right-radius:10px">
                </div>
                <p class=" text-muted mt-3">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum voluptatem ea atque praesentium, hic
                    nobis
                    enim fugit commodi vero. Rerum non necessitatibus, repudiandae sint neque at unde soluta cupiditate
                    quia!
                </p>
                @guest
                    <div class="mt-4">
                        <a name="" id="" class="btn btn-primary px-3 rounded-3" href="{{ route('register') }}"
                            role="button">Iniciar Cadastro</a>
                    </div>
                @endguest
            </div>
            <div class="col-12 col-lg-7 order-0 order-lg-1">
                <img src="{{ asset('img/Illustration.jpg') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
@endsection
