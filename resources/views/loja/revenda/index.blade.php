@extends('loja.layout.vitrine')

@section('content')


<style>
/* Estilização da Seção Hero do Alcecar */
#top_hero {
    position: relative;
    /* Ajuste de altura: 40vh garante que não ocupe a tela toda, mas tenha presença */
    padding: 120px 0 80px 0; 
    /* Lógica dinâmica para o Background */
    @if(isset($revenda) && $revenda->background)
        background: url('{{ asset("storage/" . $revenda->background) }}') no-repeat center center;
    @else
        background: url('{{ asset("frontend/images/hero_bg_alcecar.jpg") }}') no-repeat center center;
    @endif
    background-size: cover;
    background-attachment: fixed; /* Efeito Parallax suave */
    min-height: 350px;
    display: flex;
    align-items: center;
}

/* Camada escura para dar leitura ao texto */
#top_hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6); /* Ajuste a opacidade conforme necessário */
    z-index: 1;
}

/* Garante que o conteúdo fique acima do overlay */
#top_hero .container {
    position: relative;
    z-index: 2;
}

#top_hero h2 {
    font-size: 2.8rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

#top_hero p {
    font-size: 1.2rem;
    opacity: 0.9;
}
</style>

<section id="top_hero" class="top_hero section dark-background">
  <div class="container d-flex flex-column align-items-center text-center">
    
    <h2 data-aos="fade-up" data-aos-delay="100">{{ $revenda->nome }}</h2>

    {{-- Aqui você pode inserir seu formulário de busca futuramente --}}

  </div>
</section>

 <section id="courses" class="courses section">
    <div class="container section-title">
        <h2>LOJA</h2>
        <p>{{ $revenda->nome }}</p>
    </div>

    <div class="container">
        <div class="row">
           

            <div class="col-lg-9">
    <div class="row gy-4">
        
        {{-- LISTAGEM DE VEÍCULOS --}}
@include('loja.components.card-veiculos')
    </div>

    {{-- PAGINAÇÃO --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $veiculos->appends(request()->query())->links() }}
    </div>
</div>

        </div>
    </div>
    
</section>

@endsection