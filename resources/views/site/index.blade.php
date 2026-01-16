@extends('site.layout.app')

@section('title', 'Veículos')

@section('content')

<section id="hero" class="hero section dark-background">

      <img src="{{ url('assets/site_alcecar/img/background_home.svg') }}" alt="" data-aos="fade-in">

      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">Encontre o carro ideal,<br>dirija seu futuro</h2>
        <p data-aos="fade-up" data-aos-delay="200">Somos especialistas em veículos seminovos e zero km com qualidade, <br>confiança e os melhores preços do mercado.</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
            <a href="/estoque" class="btn-get-started">Ver Estoque</a>
        </div>
    </div>


    </section>

@endsection